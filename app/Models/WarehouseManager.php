<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'user_id',
    ];
}
