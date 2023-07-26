<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderInvoice extends Model
{
    use HasFactory;
    protected $table = 'hinvoice';

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
