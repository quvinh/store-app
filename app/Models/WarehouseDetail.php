<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'shelf_id',
    ];

    public $timestamps = false;

    public function Warehouse() {
        $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function Shelf() {
        $this->belongsTo(Shelf::class, 'shelf_id', 'id');
    }
}
