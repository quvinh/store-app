<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;

    protected $fillable = [
        'shelf_code',
        'shelf_name',
        'shelf_position',
        'shelf_status',
        'shelf_note',
    ];
}
