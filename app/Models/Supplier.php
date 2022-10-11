<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_name',
        'supplier_code',
        'supplier_codetax',
        'supplier_phone',
        'supplier_email',
        'supplier_type',
        'supplier_status',
        'supplier_citizenid',
        'bank_id',
        'supplier_branch',
        'supplier_numbank',
        'supplier_ownerbank',
        'supplier_note',
    ];

    public function Bank() {
        $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
}
