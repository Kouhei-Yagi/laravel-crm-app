<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Project;
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
        // 案件履歴一覧取得用のクエリを準備
        $query = Interaction::query();

        // キーワードが入力されている場合のみ検索条件を追加（空検索では全件表示にするため）
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where('content', 'like', "%{$keyword}%");
        }

        // 作成日の新しい順に並べて20件ずつ取得
        $interactions = $query->orderBy('interacted_at', 'desc')->paginate(20);

        // interactionsテーブルのデータをindexビューに渡す
        return view('interactions.index', compact('interactions'));
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
