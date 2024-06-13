<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'invoice_payment';
    protected $fillable = [
        'invoice_id',
        'karyawan_id',
        'paid_method',
        'paid_code',
        'total',
    ];

    public function invoice()
    {
        return $this->belongsTo(HeaderInvoice::class, 'invoice_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
