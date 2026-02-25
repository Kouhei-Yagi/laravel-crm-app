<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 顧客一覧を表示する
     *
     * @param mixed $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // 顧客一覧取得用のクエリを準備
        $query = Customer::query();

        // キーワードが入力されていれば部分一致検索を適用
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('phone', 'like', "%{$keyword}%")
                ->orWhere('company_name', 'like', "%{$keyword}%");
        }

        // 作成日の新しい順に並べて20件ずつ取得
        $customers = $query->orderBy('created_at', 'desc')->paginate(20);

        // $customers のデータをindexビューに渡す
        return view('customers.index', compact('customers'));
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 入力値をバリデーション処理
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kana' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|regex:/^[0-9\-]+$/|max:20',
            'company_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'postal_code' => 'nullable|digits:7',
            'address' => 'nullable|string|max:255',
            'address_detail' => 'nullable|string|max:255',
            'status' => 'required|in:' . implode(',', array_keys(Customer::STATUSES)),
            'rank' => 'required|in:' . implode(',', array_keys(Customer::RANKS)),
            'memo' => 'nullable|string|max:2000',
        ]);

        // 担当者はログインユーザーに固定
        $validated['assigned_user_id'] = auth()->id();

        // バリデーションされたデータを取得して登録
        Customer::create($validated);

        // indexビューにリダイレクト・フラッシュメッセージを送信
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
        // 選択されたcustomersテーブルのデータをshowビューに渡す
        return view('customers.show', compact('customer'));
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
     * @param Request $request
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Customer $customer)
    {
        // 入力値をバリデーション処理
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kana' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|regex:/^[0-9\-]+$/|max:20',
            'company_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'postal_code' => 'nullable|digits:7',
            'address' => 'nullable|string|max:255',
            'address_detail' => 'nullable|string|max:255',
            'status' => 'required|in:' . implode(',', array_keys(Customer::STATUSES)),
            'rank' => 'required|in:' . implode(',', array_keys(Customer::RANKS)),
            'memo' => 'nullable|string|max:2000',
        ]);

        // 担当者は変更不可
        $validated['assigned_user_id'] = $customer->assigned_user_id;

        // バリデーションされたデータを取得して更新
        $customer->update($validated);

        // showビューにリダイレクト・フラッシュメッセージを送信
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
}
