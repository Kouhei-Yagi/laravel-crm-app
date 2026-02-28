<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
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
        // 顧客名の選択肢
        $customers = Customer::orderBy('kana')->get();

        // ステータスの選択肢
        $statuses = Project::STATUSES;

        // 案件一覧取得用のクエリを準備
        $query = Project::query();

        // キーワードが入力されている場合のみ検索条件を追加（空検索では全件表示にするため）
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where('title', 'like', "%{$keyword}%");
        }

        // 顧客名が選択されている場合のみ検索条件を追加（空検索では全件表示にするため）
        if ($request->filled('customer_id')) {
            $query->where('customer_id', '=', $request->customer_id);
        }

        // ステータスが選択されている場合のみ検索条件を追加（空検索では全件表示にするため）
        if ($request->filled('status')) {
            $query->where('status', '=', $request->status);
        }

        // 作成日の新しい順に並べて20件ずつ取得
        $projects = $query->orderBy('created_at', 'desc')->paginate(20);

        // projectsテーブルのデータをindexビューに渡す
        return view('projects.index', compact('statuses', 'customers', 'projects'));
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
