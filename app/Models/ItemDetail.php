<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'warehosue_id',
        'supplier_id',
    ];
    public $timestamps = false;
}
