<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerSearchRequest;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class, 'customer');
    }

    /**
     * 顧客一覧を表示する
     *
     * @param CustomerSearchRequest $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(CustomerSearchRequest $request)
    {
        // 画面で選択肢として表示するため、ステータス・担当者のデータを取得する
        $statuses = Customer::STATUSES;
        $assignedUsers = User::orderBy('name')->pluck('name', 'id');

        // コントローラの責務を軽くするために、検索・ソート条件をモデル・トレイト側に集約してスコープを適用する
        $query = Customer::query()
            ->filter($request)
            ->sort($request);

        // ページ移動時に検索条件が失われないよう、クエリパラメータを引き継いでページングする
        $customers = $query->paginate(20)->appends($request->query());

        return view('customers.index', compact('statuses', 'assignedUsers', 'customers'));
    }

    /**
     * 顧客新規作成ページを表示する
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // ステータスの選択肢
        $statuses = Customer::STATUSES;

        // ランクの選択肢
        $ranks = Customer::RANKS;

        // 各選択肢の値を持ってcreateビューに遷移する
        return view('customers.create', compact('statuses', 'ranks'));
    }

    /**
     * 顧客新規登録処理
     *
     * @param CustomerStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CustomerStoreRequest $request)
    {
        // 安全に登録するため、バリデーション済の値を取得
        $validated = $request->validated();

        // 担当者は必ずログインユーザーするため、担当者IDを固定
        $validated['assigned_user_id'] = auth()->id();

        // 登録処理
        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', '登録しました。');
    }

    /**
     * 顧客詳細ページを表示する
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Customer $customer)
    {
        // 顧客に紐づく案件一覧と対応履歴一覧を並び替えて読み込む（ N+1 防止）
        $customer->load([
            'projects' => fn($q) => $q->with('assignedUser')->orderByDesc('created_at'),
            'interactions' => fn($q) => $q->with('assignedUser', 'project')->orderByDesc('interacted_at'),
        ]);

        return view('customers.show', [
            'customer' => $customer,
            'projects' => $customer->projects,
            'interactions' => $customer->interactions,
        ]);
    }

    /**
     * 顧客編集ページを表示する
     *
     * @param Customer $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Customer $customer)
    {
        // ステータスの選択肢
        $statuses = Customer::STATUSES;

        // ランクの選択肢
        $ranks = Customer::RANKS;

        // 各選択肢の値を持って選択されたcustomersテーブルのレコードをeditビューに渡す
        return view('customers.edit', compact('customer', 'statuses', 'ranks'));
    }

    /**
     * 顧客更新処理
     *
     * @param CustomerUpdateRequest $request
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CustomerUpdateRequest $request, Customer $customer)
    {
        // 安全に更新するため、バリデーション済の値を取得
        $validated = $request->validated();

        // 担当者は必ずログインユーザーするため、担当者IDを固定
        $validated['assigned_user_id'] = $customer->assigned_user_id;

        // 更新処理
        $customer->update($validated);

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', '更新しました。');
    }

    /**
     * 顧客削除処理（SoftDelete）
     *
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Customer $customer)
    {
        // 削除処理（SoftDelete）
        $customer->delete();

        // indexビューにリダイレクト・フラッシュメッセージを送信
        return redirect()
            ->route('customers.index')
            ->with('success', '削除しました。');
    }

    /**
     * 顧客一覧を CSV でエクスポートする
     *
     * @param Request $request
     * @return void
     */
    public function export(Request $request)
    {
        // 検索条件を反映した顧客一覧を取得
        $customers = Customer::query()
            ->filter($request)
            ->sort($request)
            ->get();

        // CSV のヘッダー部分
        $csv = "name,email,phone,company_name,status,assigned_user,created_at\n";

        // データ部分
        foreach ($customers as $customer) {
            $csv .= implode(',', [
                $customer->name,
                $customer->email,
                $customer->phone,
                $customer->company_name,
                Customer::STATUSES[$customer->status],
                $customer->assignedUser->name,
                $customer->created_at->format('Y-m-d'),
            ]) . "\n";
        }

        // レスポンスを返す
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename=customers.csv');
    }
}
