<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    /**
     * 案件履歴一覧を表示する
     *
     * @param mixed $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // 対応日時用バリデーション
        $request->validate([
            'interacted_from' => 'nullable|date',
            'interacted_to' => 'nullable|date',
        ]);

        // 対応種別の選択肢
        $types = Interaction::TYPE;

        // 顧客名の選択肢
        $customers = Customer::orderBy('kana')->get();

        // 担当者の選択肢
        $assignedUsers = User::orderBy('name')->get();

        // 案件履歴一覧取得用のクエリを準備
        $query = Interaction::query();

        // ＜検索条件処理＞
        // 対応日時検索
        $interacted_from = $request->interacted_from;
        $interacted_to = $request->interacted_to;
        // 検索範囲の終了日と開始日を入れ替える処理
        if ($interacted_from && $interacted_to && $interacted_from > $interacted_to) {
            [$interacted_from, $interacted_to] = [$interacted_to, $interacted_from];
        }
        // 対応日時検索を追加
        if ($interacted_from) {
            $query->where('interactions.interacted_at', '>=', $interacted_from);
        }
        if ($interacted_to) {
            $query->where('interactions.interacted_at', '<=', $interacted_to);
        }

        // 対応種別検索
        if ($request->filled('type')) {
            $query->where('interactions.type', '=', $request->type);
        }

        // 内容キーワード検索
        if ($request->filled('content_keyword')) {
            $content_keyword = trim($request->content_keyword);
            $query->where('interactions.content', 'like', "%{$content_keyword}%");
        }

        // 案件名キーワード検索
        if ($request->filled('project_keyword')) {
            $project_keyword = trim($request->project_keyword);
            $query->whereHas('interactions.project', function ($q) use ($project_keyword) {
                $q->where('title', 'like', "%{$project_keyword}%");
            });
        }

        // 顧客名検索
        if ($request->filled('customer_id')) {
            $query->where('interactions.customer_id', '=', $request->customer_id);
        }

        // 担当者検索
        if ($request->filled('assigned_user_id')) {
            $query->where('interactions.assigned_user_id', '=', $request->assigned_user_id);
        }

        // ＜ソート処理＞
        // クエリパラメータの値を取得（値がなければデフォルト値を使用）
        $sort = $request->get('sort', 'interacted_at');
        $direction = $request->get('direction', 'desc');

        // ソート対象カラムと direction のホワイトリスト（SQL インジェクション対策）
        $sortable = ['interacted_at', 'customer_kana'];
        $direction = $direction === 'asc' ? 'asc' : 'desc'; // asc と desc のみ許可

        // テーブル結合・取得カラム選択（外部テーブルのカラムでソートするため）
        if ($sort === 'customer_kana') {
            $query->leftJoin('customers', 'interactions.customer_id', '=', 'customers.id')
                ->select('interactions.*', 'customers.kana as customer_kana');
        }

        // ソート対象カラムの場合、クエリにソート処理の追加
        if (in_array($sort, $sortable, true)) {
            $query->orderBy($sort, $direction);
        }

        // 20件ずつ取得して、検索・ソート条件（クエリパラメーター）を保持
        $interactions = $query->paginate(20)->appends(request()->query());

        // interactionsテーブルのデータをindexビューに渡す
        return view('interactions.index', compact('types', 'customers', 'assignedUsers', 'interactions'));
    }

    /**
     * 案件履歴新規作成ページを表示する
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // 対応種別の選択肢
        $types = Interaction::TYPE;

        // 案件名の選択肢
        $projects = Project::where('id', auth()->id())->get();

        // 顧客名の選択肢をログインユーザーが担当している顧客のみにする
        $customers = Customer::where('assigned_user_id', auth()->id())->get();

        // 各選択肢の値を持ってcreateビューに遷移する
        return view('interactions.create', compact('types', 'projects', 'customers'));
    }

    /**
     * 案件履歴新規登録処理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 入力値をバリデーション処理
        $validated = $request->validate([
            'interacted_at' => 'required|date_format:Y-m-d\TH:i',
            'type' => 'required|in:' . implode(',', array_keys(Interaction::TYPE)),
            'content' => 'required|string|max:2000',
            'memo' => 'nullable|string|max:2000',
            'project_id' => 'nullable|integer|exists:projects,id',
            'customer_id' => 'required|integer|exists:customers,id',
        ]);
        // 担当者はログインユーザーに固定
        $validated['assigned_user_id'] = auth()->id();

        // バリデーションされたデータを取得して登録
        Interaction::create($validated);

        // indexビューにリダイレクト・フラッシュメッセージを送信
        return redirect()
            ->route('interactions.index')
            ->with('success', '登録しました。');
    }

    /**
     * 案件履歴の詳細を表示する
     *
     * @param Interaction $interaction
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Interaction $interaction)
    {
        // 選択されたinteractionsテーブルのデータをshowビューに渡す
        return view('interactions.show', compact('interaction'));
    }

    /**
     * 案件履歴編集ページを表示する
     *
     * @param Interaction $interaction
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Interaction $interaction)
    {
        // 対応種別の選択肢を渡す
        $types = Interaction::TYPE;

        // 各選択肢の値を持って選択されたinteractionsテーブルのレコードをeditビューに渡す
        return view('interactions.edit', compact('interaction', 'types'));
    }

    /**
     * 案件履歴更新処理
     *
     * @param Request $request
     * @param Interaction $interaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Interaction $interaction)
    {
        // 入力値をバリデーション処理
        $validated = $request->validate([
            'interacted_at' => 'required|date_format:Y-m-d\TH:i',
            'type' => 'required|in:' . implode(',', array_keys(Interaction::TYPE)),
            'content' => 'required|string|max:2000',
            'memo' => 'nullable|string|max:2000',
        ]);
        // 顧客ID・案件ID・担当者は変更不可
        $validated['customer_id'] = $interaction->customer_id;
        $validated['project_id'] = $interaction->project_id;
        $validated['assigned_user_id'] = $interaction->assigned_user_id;

        // バリデーションされたデータを取得して更新
        $interaction->update($validated);

        // showビューにリダイレクト・フラッシュメッセージを送信
        return redirect()
            ->route('interactions.show', $interaction)
            ->with('success', '更新しました。');
    }

    /**
     * 案件履歴削除処理（SoftDelete）
     *
     * @param Interaction $interaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Interaction $interaction)
    {
        // 削除処理（SoftDelete）
        $interaction->delete();

        // indexビューにリダイレクト・フラッシュメッセージを送信
        return redirect()
            ->route('interactions.index')
            ->with('success', '削除しました。');
    }
}
