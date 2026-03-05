<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
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
        // 作成日検索用バリデーション
        $request->validate([
            'created_from' => 'nullable|date',
            'created_to' => 'nullable|date',
        ]);

        // ステータスの選択肢
        $statuses = Customer::STATUSES;

        // 担当者の選択肢
        $assignedUsers = User::all();

        // 顧客一覧取得用のクエリを準備
        $query = Customer::query();

        // ＜検索条件処理＞
        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%")
                    ->orWhere('company_name', 'like', "%{$keyword}%");
            });
        }

        // ステータス検索
        if ($request->filled('status')) {
            $query->where('status', '=', $request->status);
        }

        // 担当者検索
        if ($request->filled('assigned_user_id')) {
            $query->where('assigned_user_id', '=', $request->assigned_user_id);
        }

        // 作成日検索
        $from = $request->created_from;
        $to = $request->created_to;
        // 検索範囲の終了日と開始日を入れ替え処理
        if ($from && $to && $from > $to) {
            [$from, $to] = [$to, $from];
        }
        // 作成日検索追加
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        // ＜ソート処理＞
        // ソート可能なカラム一覧（ホワイトリスト）
        $sortable = ['name', 'email', 'company_name', 'created_at'];

        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        // ソート処理追加
        if (in_array($sort, $sortable, true)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('created_at', 'desc'); // デフォルト
        }

        // 20件ずつ取得して、検索・ソート条件（クエリパラメーター）を保持
        $customers = $query->paginate(20)->appends(request()->query());

        // 各種データをindexビューに渡す
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
