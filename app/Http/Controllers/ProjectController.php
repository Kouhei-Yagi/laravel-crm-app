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

        // 案件一覧取得用のクエリを準備
        $query = Project::query();

        // ＜検索条件処理＞
        // 案件名キーワード検索
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where('title', 'like', "%{$keyword}%");
        }

        // 顧客名検索
        if ($request->filled('customer_id')) {
            $query->where('customer_id', '=', $request->customer_id);
        }

        // ステータス検索
        if ($request->filled('status')) {
            $query->where('status', '=', $request->status);
        }

        // 担当者検索
        if ($request->filled('assigned_user_id')) {
            $query->where('assigned_user_id', '=', $request->assigned_user_id);
        }

        // 税抜金額検索
        $min = $request->amount_min;
        $max = $request->amount_max;
        // 検索範囲の最高金額と最低金額を入れ替える処理
        if ($min && $max && $min > $max) {
            [$min, $max] = [$max, $min];
        }
        // 税抜金額検索の追加
        if ($min) {
            $query->where('amount', '>=', $min);
        }
        if ($max) {
            $query->where('amount', '<=', $max);
        }

        // 期間検索
        $start_from = $request->start_from;
        $end_to = $request->end_to;
        // 検索範囲の終了日と開始日を入れ替える処理
        if ($start_from && $end_to && $start_from > $end_to) {
            [$start_from, $end_to] = [$end_to, $start_from];
        }
        // 期間検索の追加
        if ($start_from) {
            $query->whereDate('end_date', '>=', $start_from);
        }
        if ($end_to) {
            $query->whereDate('start_date', '<=', $end_to);
        }

        // 作成日検索
        $created_from = $request->created_from;
        $created_to = $request->created_to;
        // 検索範囲の終了日と開始日を入れ替える処理
        if ($created_from && $created_to && $created_from > $created_to) {
            [$created_from, $created_to] = [$created_to, $created_from];
        }
        // 作成日検索の追加
        if ($created_from) {
            $query->whereDate('created_at', '>=', $created_from);
        }
        if ($created_to) {
            $query->whereDate('created_at', '<=', $created_to);
        }

        // ＜ソート処理＞
        // ソート対象カラム一覧（ホワイトリスト、SQL インジェクション対策）
        $sortable = ['title', 'amount', 'created_at'];

        // クエリパラメータの値を取得（値がなければデフォルト値を使用）
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        // ソート対象カラムの場合、クエリにソート処理の追加
        if (in_array($sort, $sortable, true)) {
            $query->orderBy($sort, $direction);
        }

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
