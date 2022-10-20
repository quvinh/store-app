<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;

    protected $fillable = [
        'notify_title',
        'notify_content',
        'notify_summary',
        'notify_sendto',
        'notify_status',
        'created_by',
    ];
}
