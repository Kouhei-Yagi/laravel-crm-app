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
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // projectsテーブルのデータを作成日順に20件ずつ表示
        $projects = Project::orderBy('created_at', 'desc')->paginate(20);

        // projectsテーブルのデータをindexビューに渡す
        return view('projects.index', compact('projects'));
    }

    /**
     * 案件新規作成ページを表示する
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // 顧客名の選択肢
        $customers = Customer::all();

        // ステータスの選択肢
        $statuses = Project::STATUSES;

        // 担当者の選択肢
        $assignedUsers = User::all();

        // 各選択肢の値を持ってcreateビューに遷移する
        return view('projects.create', compact('customers', 'statuses', 'assignedUsers'));
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
            'description' => 'nullable|string',
            'status' => 'required|in:estimating,proposing,contracted,lost,on_hold',
            'amount' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_user_id' => 'nullable|integer|exists:users,id',
            'memo' => 'nullable|string',
        ]);

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
        // 顧客名の選択肢
        $customers = Customer::all();

        // 案件ステータスの選択肢
        $statuses = Project::STATUSES;

        // 担当者の選択肢
        $assignedUsers = User::all();

        // 各選択肢の値を持って選択されたprojextsテーブルのレコードをeditビューに渡す
        return view('projects.edit', compact('project', 'customers', 'statuses', 'assignedUsers'));
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
            'customer_id' => 'required|integer|exists:customers,id',
            'description' => 'nullable|string',
            'status' => 'required|in:estimating,proposing,contracted,lost,on_hold',
            'amount' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_user_id' => 'nullable|integer|exists:users,id',
            'memo' => 'nullable|string',
        ]);

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
