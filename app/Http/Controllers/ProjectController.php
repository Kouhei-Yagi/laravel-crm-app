<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectSearchRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * 案件一覧を表示する
     *
     * @param  ProjectSearchRequest $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(ProjectSearchRequest $request)
    {
        // 画面で選択肢として表示するため、顧客名・ステータス・担当者のデータを取得する
        $customers = Customer::orderBy('kana')->pluck('name', 'id');
        $statuses = Project::STATUSES;
        $assignedUsers = User::orderBy('name')->pluck('name', 'id');

        // コントローラの責務を軽くするために、検索・ソート条件をモデル・トレイト側に集約してスコープを適用する
        $query = Project::query()
            ->filter($request)
            ->sort($request);

        // ページ移動時に検索条件が失われないよう、クエリパラメータを引き継いでページングする
        $projects = $query->paginate(20)->appends($request->query());

        return view('projects.index', compact('customers', 'statuses', 'assignedUsers', 'projects'));
    }

    /**
     * 案件新規作成ページを表示する
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // 画面で選択肢として表示するため、顧客名・ステータスのデータを取得する
        $customers = Customer::where('assigned_user_id', auth()->id())
            ->orderBy('kana')
            ->pluck('name', 'id');
        $statuses = Project::STATUSES;

        return view('projects.create', compact('customers', 'statuses'));
    }

    /**
     * 案件新規登録処理
     *
     * @param ProjectStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectStoreRequest $request)
    {
        // 安全に登録するため、バリデーション済の値を取得
        $validated = $request->validated();

        // 担当者は必ずログインユーザーにするため、担当者IDを固定
        $validated['assigned_user_id'] = auth()->id();

        // 登録処理
        Project::create($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', '登録しました。');
    }

    /**
     * 案件詳細ページを表示する
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Project $project)
    {
        // 選択されたprojectsテーブルのデータをshowビューに渡す
        return view('projects.show', compact('project'));
    }

    /**
     * 案件編集ページを表示する
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Project $project)
    {
        // 案件ステータスの選択肢
        $statuses = Project::STATUSES;

        // 各選択肢の値を持って選択されたprojextsテーブルのレコードをeditビューに渡す
        return view('projects.edit', compact('project', 'statuses'));
    }

    /**
     * 案件更新処理
     *
     * @param ProjectUpdateRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        // 安全に更新するために、バリデーション済の値を取得
        $validated = $request->validated();

        // 顧客・担当者は必ずログインユーザーに紐づくものだけにするため、顧客ID・担当者IDは固定
        $validated['customer_id'] = $project->customer_id;
        $validated['assigned_user_id'] = $project->assigned_user_id;

        // 更新処理
        $project->update($validated);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', '更新しました。');
    }

    /**
     * 案件削除処理（SoftDelete）
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        // 削除処理（SoftDelete）
        $project->delete();

        // indexビューにリダイレクト・フラッシュメッセージを送信
        return redirect()
            ->route('projects.index')
            ->with('success', '削除しました。');
    }

    /**
     * 案件一覧を CSV でエクスポートする
     *
     * @param Request $request
     * @return void
     */
    public function export(Request $request)
    {
        // 検索・ソート条件を反映した案件一覧を取得
        $projects = Project::query()
            ->filter($request)
            ->sort($request)
            ->get();

        // BOM の付与（Excel 文字化け対策）
        $csv = "\xEF\xBB\xBF";

        // ヘッダー行
        $csv .= "案件名,顧客名,ステータス,税抜金額,担当者,期間,作成日\n";

        // データ行
        foreach ($projects as $project) {
            $csv .= implode(',', [
                $project->title,
                $project->customer->name,
                Project::STATUSES[$project->status],
                $project?->amount,
                $project->assignedUser->name,
                $project->start_date?->format('Y-m-d') . '~' . $project->end_date?->format('Y-m-d'),
                $project->created_at->format('Y-m-d'),
            ]) . "\n";
        }

        // ヘッダー情報を付与し、レスポンスを返す
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=projects.csv');
    }
}
