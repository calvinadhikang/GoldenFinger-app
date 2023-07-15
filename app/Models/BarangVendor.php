<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangVendor extends Model
{
    use HasFactory;
    protected $table = 'barang_vendor';
    protected $primaryKey = 'id';
}
