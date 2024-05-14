<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderPenawaran extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'hpenawaran';

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function details(){
        return $this->hasMany(DetailPenawaran::class, 'hpenawaran_id', 'id');
    }
}
