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
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // interactionsテーブルのデータを対応日時順に20件ずつ表示
        $interactions = Interaction::orderBy('interacted_at', 'desc')->paginate(20);

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
        $projects = Project::all();

        // 顧客名の選択肢
        $customers = Customer::all();

        // 担当者の選択肢
        $assignedUsers = User::all();

        // 各選択肢の値を持ってcreateビューに遷移する
        return view('interactions.create', compact('types', 'projects', 'customers', 'assignedUsers'));
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
            'content' => 'nullable|string|max:2000',
            'memo' => 'nullable|string|max:2000',
            'project_id' => 'nullable|integer|exists:projects,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'assigned_user_id' => 'required|integer|exists:users,id',
        ]);

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

        // 案件名の選択肢を渡す
        $projects = Project::all();

        // 顧客名の選択肢を渡す
        $customers = Customer::all();

        // 担当者の選択肢を渡す
        $assignedUsers = User::all();

        // 各選択肢の値を持って選択されたinteractionsテーブルのレコードをeditビューに渡す
        return view('interactions.edit', compact('interaction', 'types', 'projects', 'customers', 'assignedUsers'));
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
            'content' => 'nullable|string|max:2000',
            'memo' => 'nullable|string|max:2000',
            'project_id' => 'nullable|integer|exists:projects,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'assigned_user_id' => 'required|integer|exists:users,id',
        ]);

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
