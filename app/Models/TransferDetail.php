<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        'item_id',
        'item_quantity',
        'shelf_from',
        'floor_from',
        'cell_from',
        'shelf_to',
        'floor_to',
        'cell_to',
    ];

    public $timestamps = false;
}
