<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_code',
        'warehouse_name',
        'warehouse_contact',
        'warehouse_street',
        'warehouse_status',
        'warehouse_image',
        'warehouse_note',
        'country_id',
        'city_id',
    ];
}
