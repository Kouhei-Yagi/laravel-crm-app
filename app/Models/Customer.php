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

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'customer_id');
    }
}
