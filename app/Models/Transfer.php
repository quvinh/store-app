<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transfer_code',
        'transfer_status',
        'transfer_quanlity',
        'transfer_note',
        'warehouse_from',
        'warehouse_to',
        'created_by',
    ];
}
