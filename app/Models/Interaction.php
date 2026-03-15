<?php

namespace App\Models;

use App\Traits\RangeNormalizer;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sortable;
    use RangeNormalizer;

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

    protected array $sortable = [
        'interacted_at',
        'customer_kana',
    ];

    protected string $defaultSort = 'interacted_at';
    protected string $defaultDirection = 'desc';

    protected array $sortableJoins = [
        'customer_kana' => [
            'table' => 'customers',
            'local_key' => 'interactions.customer_id',
            'foreign_key' => 'customers.id',
            'select' => ['interactions.*', 'customers.kana as customer_kana'],
        ]
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
     * 対応日時絞り込みスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $from
     * @param string|null $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInteractedAtRange($query, $from, $to)
    {
        // 対応日時欄がどちらも未入力の場合、絞り込み条件が成立しないため、そのまま返す
        if (!$from && !$to) {
            return $query;
        }

        // ユーザーが誤って「開始 > 終了」で入力した場合、正しく絞り込みできるように、Trait を活用して値を入れ替える
        [$from, $to] = $this->normalizeRange($from, $to);
        // 開始日が入力されている場合、その日以降の案件履歴に絞り込むための条件を追加
        if ($from) {
            $query->where('interacted_at', '>=', $from);
        }
        // 終了日が入力されている場合、その日以前の案件履歴に絞り込むための条件を追加
        if ($to) {
            $query->where('interacted_at', '<=', $to);
        }
        return $query;
    }

    /**
     * 対応種別絞り込みスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInteractionType($query, $type)
    {
        // 対応種別欄が「未選択」の場合、絞り込み条件が成立しないため、そのまま返す
        if (!$type) {
            return $query;
        }

        // 対応種別欄が「未選択」以外の場合、その対応種別に紐づく案件履歴に絞り込むための条件を追加
        return $query->where('type', $type);
    }

    /**
     * 内容検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeContent($query, $keyword)
    {
        // 内容欄が未入力の場合、検索条件が成立しないため、そのまま返す
        if (!$keyword) {
            return $query;
        }

        // 内容欄に入力がある場合、そのキーワードで部分一致検索を行うための条件を追加
        $keyword = trim($keyword);
        return $query->where('content', 'like', "%{$keyword}%");
    }

    /**
     * 案件名検索スコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProjectTitle($query, $keyword)
    {
        // 案件名欄が未入力の場合、検索条件が成立しないため、そのまま返す
        if (!$keyword) {
            return $query;
        }

        // 案件名欄に入力がある場合、入力されたキーワードで部分一致検索を行うための条件を追加
        $keyword = trim($keyword);
        return $query->where('title', 'like', "%{$keyword}%");
    }

    /**
     * 顧客絞り込みスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $customerId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCustomer($query, $customerId)
    {
        // 顧客名欄が「未選択」の場合、絞り込み条件が成立しないため、そのまま返す
        if (!$customerId) {
            return $query;
        }

        // 顧客名欄が「未選択」以外場合、その顧客に紐づく案件履歴に絞り込むための条件を追加
        return $query->where('customer_id', $customerId);
    }

    /**
     * 担当者絞り込みスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAssignedUser($query, $userId)
    {
        // 担当者欄が「未選択」の場合、絞り込み条件が成立しないため、そのまま返す
        if (!$userId) {
            return $query;
        }

        // 担当者欄が「未選択」以外の場合、その担当者に紐づく案件履歴に絞り込むための条件を追加
        return $query->where('assigned_user_id', $userId);
    }
}
