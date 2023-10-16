<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'part';
    protected $keyType = 'string';
    protected $fillable = ['part', 'nama', 'harga', 'stok', 'batas'];

    public function vendor()
    {
        return $this->belongsToMany(
            Vendor::class,
            'barang_vendor',
            'barang_id',
            'vendor_id'
        );
    }
}
