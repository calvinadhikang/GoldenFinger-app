<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInvoice extends Model
{
    use HasFactory;
    protected $table = 'dinvoice';
    public function header(){
        return $this->hasOne(
            HeaderInvoice::class,
            'id',
            'hinvoice_id'
        );
    }
}
