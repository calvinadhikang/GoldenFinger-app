<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasePayment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'purchase_payment';
    protected $fillable = [
        'purchase_id',
        'karyawan_id',
        'method',
        'code',
        'total',
    ];

    public function invoice()
    {
        return $this->belongsTo(HeaderPurchase::class, 'purchase_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
