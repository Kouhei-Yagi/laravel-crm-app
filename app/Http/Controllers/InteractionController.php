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
     * 案件履歴の一覧を表示する
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
     * 案件履歴新規作成ページを表示
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
        $users = User::all();

        // createビューに遷移する
        return view('interactions.create', compact('types', 'projects', 'customers', 'users'));
    }

    /**
     * 案件履歴新規登録処理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 入力値をバリデーション
        $validated = $request->validate([
            'interacted_at' => 'required|date',
            'type' => 'required|in:' . implode(',', array_keys(Interaction::TYPE)),
            'content' => 'nullable|string|max:2000',
            'memo' => 'nullable|string|max:2000',
            'project_id' => 'nullable|integer|exists:projects,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'assigned_user_id' => 'required|integer|exists:users,id',
        ]);

        // 登録処理
        Interaction::create($validated);

        // indexビューにリダイレクト・フラッシュメッセージ
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
        // 選択されたinteractionsテーブルをeditビューに渡す
        return view('interactions.edit', compact('interaction'));
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
        // 入力されたデータを取得・更新
        $interaction->update([
            'interacted_at' => $request->interacted_at,
            'type' => $request->type,
            'content' => $request->content,
            'memo' => $request->memo,
            'project_id' => $request->project_id,
            'customer_id' => $request->customer_id,
            'assigned_user_id' => $request->assigned_user_id,
        ]);

        // showビューにリダイレクト
        return redirect()->route('interactions.show', $interaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interaction $interaction)
    {
        //
    }
}
