<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DFIFO extends Model
{
    use HasFactory;
    protected $table = 'dfifo';
    protected $fillable = [
        'hfifo_id',
        'hpurchase_id',
        'dpurchase_id',
        'hinvoice_id',
        'dinvoice_id',
        'part',
        'harga_beli',
        'harga_jual',
        'profit_each',
        'profit_total',
        'qty',
        'created_at',
        'updated_at',
    ];
}
