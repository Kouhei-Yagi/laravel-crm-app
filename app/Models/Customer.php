<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUSES = [
        'prospect' => '見込み',
        'negotiation' => '商談中',
        'won' => '成約',
        'lost' => '失注',
        'inactive' => '休眠',
    ];

    public const RANKS = [
        'A' => 'Ａ（重要顧客）',
        'B' => 'Ｂ（通常顧客）',
        'C' => 'Ｃ（優先度低め顧客）',
    ];

    protected $fillable = [
        'name',
        'kana',
        'email',
        'phone',
        'company_name',
        'department',
        'position',
        'postal_code',
        'address',
        'address_detail',
        'status',
        'rank',
        'assigned_user_id',
        'memo',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'customer_id');
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class, 'customer_id');
    }

    /**
     * 顧客一覧の検索条件をまとめて適用するスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $request)
    {
        return $query
            ->keyword($request->keyword)
            ->status($request->status)
            ->assignedUser($request->assigned_user_id)
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
        // 検索フォームのキーワード欄が空の場合は何もしない
        if (!$keyword) {
            return $query;
        }

        $keyword = trim($keyword);

        // キーワード検索の条件をクエリに追加
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like',  "%{$keyword}%")
                ->orWhere('phone', 'like',  "%{$keyword}%")
                ->orWhere('company_name', 'like',  "%{$keyword}%");
        });
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

        // ステータス検索の条件をクエリに追加
        return $query->where('status', $status);
    }

    /**
     * 担当者検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAssignedUser($query, $userId)
    {
        // 検索フォームの担当者欄が「未選択」の場合は何もしない
        if (!$userId) {
            return $query;
        }

        // 担当者検索の条件をクエリに追加
        $query->where('assigned_user_id', $userId);
    }
}
