<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelfDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'shelf_id',
        'item_id',
        'item_quantity',
    ];

    public $timestamps = false;

    public function Item() {
        $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function Shelf() {
        $this->belongsTo(Shelf::class, 'shelf_id', 'id');
    }
}
