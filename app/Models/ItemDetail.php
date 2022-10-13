<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'warehouse_id',
        'supplier_id',
        'shelf_id',
        'floor_id',
        'cell_id',
        'item_quantity',
    ];
    public $timestamps = false;

    public function Item() {
        $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function Shelf() {
        $this->belongsTo(Shelf::class, 'shelf_id', 'id');
    }

    public function Warehouse() {
        $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function Supplier() {
        $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
