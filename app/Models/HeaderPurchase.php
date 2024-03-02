<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderPurchase extends Model
{
    use HasFactory, SoftDeletes;
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
