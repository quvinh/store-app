<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExImportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'exim_id',
        'item_id',
        'itemdetail_id',
        'exim_item_status',
        'item_quantity',
        'item_price',
        'item_total',
        'item_vat',
        'supplier_id',
        'shelf_to',
        'floor_to',
        'cell_to',
    ];

    public $timestamps = false;
}
