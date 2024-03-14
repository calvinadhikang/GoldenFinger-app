<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeaderPaket extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'hpaket';

    public function details(){
        return $this->hasMany(DetailPaket::class, 'hpaket_id', 'id');
    }
}
