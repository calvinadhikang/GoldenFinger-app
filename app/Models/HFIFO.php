<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HFIFO extends Model
{
    use HasFactory;
    protected $table = 'hfifo';
    protected $fillable = [
        'hpurchase_id',
        'dpurchase_id',
        'part',
        'harga_beli',
        'qty_max',
        'qty_used',
        'created_at',
        'updated_at',
    ];
}
