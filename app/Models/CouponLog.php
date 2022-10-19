<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'coupon_name',
        'coupon_seo',
        'coupon_type',
        'created_by',
    ];
}
