<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(20);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ステータス欄選択肢
        $statuses = Customer::STATUSES;

        // ランク欄選択肢
        $ranks = Customer::RANKS;

        // 担当者欄選択肢
        $users = User::all();

        return view('customers.create', compact('statuses', 'ranks', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kana' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:7',
            'address' => 'nullable|string|max:255',
            'address_detail' => 'nullable|string|max:255',
            'status' => 'required|in:prospect,negotiation,won,lost,inactive',
            'rank' => 'nullable|in:A,B,C',
            'assigned_user_id' => 'nullable|integer|exists:users,id',
            'memo' => 'nullable|string',
        ]);

        // 新規登録処理
        Customer::create($validated);

        // リダイレクト・フラッシュメッセージ
        return redirect()
            ->route('customers.index')
            ->with('success', '登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        // ステータス選択肢
        $statuses = ['prospect', 'negotiation', 'won', 'lost', 'inactive'];

        // ランク選択肢
        $ranks = ['A', 'B', 'C'];

        // 担当者選択肢
        $users = User::all();

        return view('customers.edit', compact('customer', 'statuses', 'ranks', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kana' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:7',
            'address' => 'nullable|string|max:255',
            'address_detail' => 'nullable|string|max:255',
            'status' => 'required|in:prospect,negotiation,won,lost,inactive',
            'rank' => 'nullable|in:A,B,C',
            'assigned_user_id' => 'nullable|integer|exists:users,id',
            'memo' => 'nullable|string',
        ]);

        // 更新処理
        $customer->update($validated);

        // リダイレクト・フラッシュメッセージ
        return redirect()
            ->route('customers.show', $customer)
            ->with('success', '更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', '削除しました。');
    }
}
