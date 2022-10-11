<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'exim_code',
        'exim_status',
        'invoice_id',
        'warehouse_id',
        'user_id',
    ];
}
