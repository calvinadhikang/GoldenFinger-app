<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharesModel extends Model
{
    use HasFactory;
    protected $table = 'shares';
    protected $fillable = ['shares'];

    public function details(){
        return $this->hasOne(
            Karyawan::class,
            'id',
            'karyawan_id'
        );
    }
}
