<?php

namespace App\Http\Controllers;

use App\Http\Requests\InteractionSearchRequest;
use App\Http\Requests\InteractionStoreRequest;
use App\Http\Requests\InteractionUpdateRequest;
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
     * @param InteractionSearchRequest $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(InteractionSearchRequest $request)
    {
        // 画面で選択肢として表示するため、対応種別・顧客名・担当者のデータを取得する
        $types = Interaction::TYPE;
        $customers = Customer::orderBy('kana')->pluck('name', 'id');
        $assignedUsers = User::orderBy('name')->get();

        // 検索条件をモデル側に集約し、コントローラーの責務を軽くするためにスコープを適用する
        $query = Interaction::query()
            ->filter($request)
            ->sort($request);

        // ページ移動時に検索条件が失われないよう、クエリパラメータを引き継いでページングする
        $interactions = $query->paginate(20)->appends($request->query());

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
        $projects = Project::where('assigned_user_id', auth()->id())->pluck('title', 'id');

        // 顧客名の選択肢をログインユーザーが担当している顧客のみにする
        $customers = Customer::where('assigned_user_id', auth()->id())->pluck('name', 'id');

        // 各選択肢の値を持ってcreateビューに遷移する
        return view('interactions.create', compact('types', 'projects', 'customers'));
    }

    /**
     * 案件履歴新規登録処理
     *
     * @param InteractionStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InteractionStoreRequest $request)
    {
        // 安全に登録するために、バリデーション済の値を取得
        $validated = $request->validated();

        // 担当者は必ずログインユーザーにするため、担当者IDは固定
        $validated['assigned_user_id'] = auth()->id();

        // 登録処理
        Interaction::create($validated);

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
     * @param InteractionUpdateRequest $request
     * @param Interaction $interaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InteractionUpdateRequest $request, Interaction $interaction)
    {
        // 安全に更新するために、バリデーション済の値を取得
        $validated = $request->validated();

        // 顧客名・案件名・担当者は必ずログインユーザーに紐づくものだけにするため、顧客ID・案件ID・担当者IDは固定
        $validated['customer_id'] = $interaction->customer_id;
        $validated['project_id'] = $interaction->project_id;
        $validated['assigned_user_id'] = $interaction->assigned_user_id;

        // 更新処理
        $interaction->update($validated);

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
