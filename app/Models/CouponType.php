<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name',
        'type_short',
        'user_id',
    ];
}
