<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'customer';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'alamat', 'telp', 'email', 'kota', 'NPWP'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->limit = $model->limit ?? 50000000;
        });
    }

    public function invoice()
    {
        return $this->hasMany(
            HeaderInvoice::class,
            'customer_id',
            'id'
        );
    }
}
