<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUSES = [
        'estimating' => '見積中',
        'proposing' => '提案中',
        'contracted' => '契約済み',
        'lost' => '失注',
        'on_hold' => '保留',
    ];

    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'status',
        'amount',
        'start_date',
        'end_date',
        'assigned_user_id',
        'memo',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class, 'project_id');
    }

    /**
     * 案件一覧の検索条件をまとめて適用するスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $request)
    {
        return $query
            ->keyword($request->keyword)
            ->customer($request->customer_id)
            ->status($request->status)
            ->assignedUser($request->assigned_user_id)
            ->amountRange($request->amount)
            ->period($request->start_from, $request->end_to)
            ->createdRange($request->created_from, $request->created_to);
    }

    /**
     * キーワード検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeKeyword($query, $keyword)
    {
        // 検索フォームにキーワード欄に入力がない場合は何もしない
        if (!$keyword) {
            return $query;
        }

        $keyword = trim($keyword);

        // 検索フォームに入力がある場合
        // キーワード検索の条件をクエリに追加
        return $query->where('title', 'like', "%{$keyword}%");
    }

    /**
     * 顧客名検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $customer_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCustomer($query, $customerId)
    {
        // 検索フォームの顧客名欄が「未選択」の場合は何もしない
        if (!$customerId) {
            return $query;
        }

        // 検索フォームの顧客名欄が「未選択」以外の場合
        // 顧客名検索の条件をクエリに追加
        return $query->where('customer_id', $customerId);
    }

    /**
     * ステータス検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        // 検索フォームのステータス欄が「未選択」の場合は何もしない
        if (!$status) {
            return $query;
        }

        // 検索フォームのステータス欄が「未選択」以外の場合
        // ステータス検索の条件をクエリに追加
        return $query->where('status', $status);
    }

    /**
     * 担当者検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAssignedUser($query, $userId)
    {
        // 検索フォームの担当者欄が「未選択」の場合は何もしない
        if (!$userId) {
            return $query;
        }

        // 検索フォームの担当者欄が「未選択」以外の場合
        // 担当者検索の条件をクエリに追加
        return $query->where('assigned_user_id', $userId);
    }

    /**
     * 税抜金額検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $amountMin
     * @param int|null $amountMax
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAmountRange($query, $amountMin, $amountMax)
    {
        // 検索フォームの税抜金額欄が未入力の場合は何もしない
        if (!$amountMin && !$amountMax) {
            return $query;
        }

        // 検索フォームの税抜金額欄に入力がある場合
        // 検索範囲の最高金額と最低金額を入れ替え処理
        if ($amountMin && $amountMax && $amountMin > $amountMax) {
            [$amountMin, $amountMax] = [$amountMax, $amountMin];
        }
        // 税抜金額の検索条件をクエリに追加
        if ($amountMin) {
            $query->where('amount', '>=', $amountMin);
        }
        if ($amountMax) {
            $query->where('amount', '<=', $amountMax);
        }
        return $query;
    }
}
