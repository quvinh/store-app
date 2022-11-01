<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'inventory_code',
        'inventory_status',
        'inventory_note',
        'invoice_id',
        'created_by',
        'warehouse_id',
        'participants',
    ];
}
