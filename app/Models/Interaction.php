<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TYPE = [
        'phone' => '電話',
        'email' => 'メール',
        'visit' => '訪問',
        'meeting' => '打合せ',
    ];

    protected $fillable = [
        'customer_id',
        'project_id',
        'assigned_user_id',
        'type',
        'content',
        'interacted_at',
        'memo',
    ];

    protected $casts = [
        'interacted_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * 案件履歴一覧の検索条件をまとめて適用するスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $request)
    {
        return $query
            ->interactedAtRange($request->interacted_from, $request->interacted_to)
            ->interactionType($request->type)
            ->content($request->content_keyword)
            ->projectTitle($request->project_keyword)
            ->customer($request->customer_id)
            ->assignedUser($request->assigned_user_id);
    }

    /**
     * 対応日時検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function interactedAtRange($query, $from, $to)
    {
        // 検索フォームの対応日時欄に入力がない場合は何もしない
        if (!$from && !$to) {
            return $query;
        }

        // 検索フォームの対応日時欄に入力がある場合
        // 検索範囲の終了日と開始日を入れ替える処理
        if ($from && $to && $from > $to) {
            [$from, $to] = [$to, $from];
        }
        // 対応日時の検索条件をクエリに追加
        if ($from) {
            $query->where('interacted_at', '>=', $from);
        }
        if ($to) {
            $query->where('interacted_at', '<=', $to);
        }
        return $query;
    }
}
