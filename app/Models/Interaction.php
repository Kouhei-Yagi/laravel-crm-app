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
}
