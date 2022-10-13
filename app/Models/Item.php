<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_code',
        'item_barcode',
        'item_name',
        'item_unit',
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
        'item_date',
        'item_max',
        'item_min',
    ];
}
