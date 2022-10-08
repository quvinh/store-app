<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_code',
        'category_name',
        'category_note',
        'category_status',
    ];

    public $timestamps = false;
}
