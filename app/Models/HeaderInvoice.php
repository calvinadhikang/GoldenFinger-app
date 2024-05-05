<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderInvoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'hinvoice';
    public $timestamps = ['jatuh_tempo', 'recieved_at', 'paid_at'];
    protected $fillable = ['status', 'snap_token'];

    public function customer(){
        return $this->hasOne(
            Customer::class,
            'id',
            'customer_id'
        );
    }

    public function details(){
        return $this->hasMany(
            DetailInvoice::class,
            'hinvoice_id',
            'id'
        );
    }
}
