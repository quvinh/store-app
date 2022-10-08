<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'item_id',
        'item_difference',
    ];

    public $timestamps = false;
}
