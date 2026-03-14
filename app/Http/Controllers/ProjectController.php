<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * 案件一覧を表示する
     *
     * @param mixed $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // 期間・作成日用検索バリデーション
        $request->validate([
            'start_from' => 'nullable|date',
            'end_to' => 'nullable|date',
            'created_from' => 'nullable|date',
            'created_to' => 'nullable|date',
        ]);

        // 顧客名の選択肢
        $customers = Customer::orderBy('kana')->get();

        // ステータスの選択肢
        $statuses = Project::STATUSES;

        // 担当者の選択肢
        $users = User::orderBy('name')->get();

        // 案件一覧取得用のクエリを準備して、検索条件（scope）を適用
        $query = Project::query()
            ->filter($request)
            ->sort($request);

        // // ＜ソート処理＞
        // // ソート対象カラム一覧（ホワイトリスト、SQL インジェクション対策）
        // $sortable = ['title', 'amount', 'created_at', 'customer_kana'];

        // // クエリパラメータの値を取得（値がなければデフォルト値を使用）
        // $sort = $request->get('sort', 'created_at');
        // $direction = $request->get('direction', 'desc');

        // // テーブル結合・取得カラム選択（外部テーブルのカラムでソートするため）
        // if ($sort === 'customer_kana') {
        //     $query->leftJoin('customers', 'projects.customer_id', '=', 'customers.id')
        //         ->select('projects.*', 'customers.kana as customer_kana');
        // }

        // // ソート対象カラムの場合、クエリにソート処理の追加
        // if (in_array($sort, $sortable, true)) {
        //     $query->orderBy($sort, $direction);
        // }

        // 20件ずつ取得して、検索・ソート条件（クエリパラメーター）を保持
        $projects = $query->paginate(20)->appends($request->query());

        // projectsテーブルのデータをindexビューに渡す
        return view('projects.index', compact('customers', 'statuses', 'users', 'projects'));
    }

    /**
     * 案件新規作成ページを表示する
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // 顧客名の選択肢をログインユーザーが担当している顧客のみにする
        $customers = Customer::where('assigned_user_id', auth()->id())->get();

        // ステータスの選択肢
        $statuses = Project::STATUSES;

        // 各選択肢の値を持ってcreateビューに遷移する
        return view('projects.create', compact('customers', 'statuses'));
    }

    /**
     * 案件新規登録処理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 入力値をバリデーション処理
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'customer_id' => 'required|integer|exists:customers,id',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:' . implode(',', array_keys(Project::STATUSES)),
            'amount' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'memo' => 'nullable|string|max:2000',
        ]);

        // 担当者はログインユーザーに固定
        $validated['assigned_user_id'] = auth()->id();

        // バリデーションされたデータを取得して登録
        Project::create($validated);

        // indexビューにリダイレクト・フラッシュメッセージを送信
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
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        // 入力値をバリデーション処理
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:' . implode(',', array_keys(Project::STATUSES)),
            'amount' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'memo' => 'nullable|string|max:2000',
        ]);

        // 顧客及び担当者は変更不可
        $validated['customer_id'] = $project->customer_id;
        $validated['assigned_user_id'] = $project->assigned_user_id;

        // バリデーションされたデータを取得して更新
        $project->update($validated);

        // showビューにリダイレクト・フラッシュメッセージを送信
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
}
