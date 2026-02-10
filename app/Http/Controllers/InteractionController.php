<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
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
        // createビューに遷移する
        return view('interactions.create');
    }

    /**
     * 案件履歴新規登録処理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 入力されたデータを取得・登録処理
        Interaction::create([
            'interacted_at' => $request->interacted_at,
            'type' => $request->type,
            'content' => $request->content,
            'memo' => $request->memo,
            'project_id' => $request->project_id,
            'customer_id' => $request->customer_id,
            'assigned_user_id' => $request->assigned_user_id,
        ]);

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
     * Show the form for editing the specified resource.
     */
    public function edit(Interaction $interaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interaction $interaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interaction $interaction)
    {
        //
    }
}
