<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExImport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exim_code',
        'exim_status',
        'exim_type',
        'invoice_id',
        'warehouse_id',
        'created_by',
    ];
}
