<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_street',
        'city_id',
        'country_id',
        'address_phone',
        'address_status',
    ];

    public $timestamps = false;
    public function User() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
