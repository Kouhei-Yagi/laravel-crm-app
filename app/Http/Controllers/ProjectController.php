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
        // 不正な日付入力による検索エラーを防ぐため、対応日時の形式をチェックする
        $request->validate([
            'start_from' => 'nullable|date',
            'end_to' => 'nullable|date',
            'created_from' => 'nullable|date',
            'created_to' => 'nullable|date',
        ]);

        // 画面で選択肢として表示するため、顧客名・ステータス・担当者のデータを取得する
        $customers = Customer::orderBy('kana')->get();
        $statuses = Project::STATUSES;
        $users = User::orderBy('name')->get();

        // コントローラの責務を軽くするために、検索・ソート条件をモデル・トレイト側に集約してスコープを適用する
        $query = Project::query()
            ->filter($request)
            ->sort($request);

        // ページ移動時に検索条件が失われないよう、クエリパラメータを引き継いでページングする
        $projects = $query->paginate(20)->appends($request->query());

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
