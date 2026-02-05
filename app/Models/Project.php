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

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class, 'project_id');
    }
}
