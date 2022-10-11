<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'item_name',
        'item_importprice',
        'item_exportprice',
        'item_quantity',
        'item_error',
        'item_images',
        'item_weight',
        'item_weightuint',
        'item_long',
        'item_width',
        'item_height',
        'item_status',
        'item_note',
        'category_id',
        'warehouse_id',
        'supplier_id',
    ];
}
