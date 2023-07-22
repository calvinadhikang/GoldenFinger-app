<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'alamat', 'telp', 'email'];

    public function vendor()
    {
        return $this->hasMany(
            HeaderInvoice::class,
            'customer_id',
            'id'
        );
    }
}
