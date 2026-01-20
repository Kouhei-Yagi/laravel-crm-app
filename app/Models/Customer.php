<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
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
}
