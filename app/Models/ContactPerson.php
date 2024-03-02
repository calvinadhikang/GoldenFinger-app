<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactPerson extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'contact_person';
    protected $primaryKey = 'id';
    protected $fillable = ['vendor_id', 'nama', 'telp'];

    public function vendor()
    {
        return $this->belongsTo(
            Vendor::class,
            'vendor_id',
            'id'
        );
    }
}
