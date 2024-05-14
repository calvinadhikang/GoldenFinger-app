<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPenawaran extends Model
{
    use HasFactory;
    protected $table = 'dpenawaran';
    public function barang(){
        return $this->belongsTo(Barang::class, 'part', 'part');
    }
}
