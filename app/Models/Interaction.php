<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $fillable = [
        'customer_id',
        'project_id',
        'assigned_user_id',
        'type',
        'content',
        'interacted_at',
        'memo',
    ];
}
