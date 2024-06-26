<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vendor';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'email', 'alamat', 'telp', 'kota', 'npwp'];

    public function barang(){
        return $this->belongsToMany(
            Barang::class,
            'barang_vendor',
            'vendor_id',
            'barang_id'
        );
    }

    public function contact_person(){
        return $this->hasMany(
            ContactPerson::class,
            'vendor_id',
            'id'
        );
    }
}
