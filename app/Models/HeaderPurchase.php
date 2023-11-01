<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderPurchase extends Model
{
    use HasFactory;
    protected $table = 'hpurchase';
    public $timestamps = ['jatuh_tempo', 'recieved_at', 'paid_at'];

    public function vendor(){
        return $this->hasOne(
            Vendor::class,
            'id',
            'vendor_id'
        );
    }

    public function details(){
        return $this->hasMany(
            DetailPurchase::class,
            'hpurchase_id',
            'id'
        );
    }
}
