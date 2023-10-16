<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMutation extends Model
{
    use HasFactory;
    protected $table = 'stock_mutation';
    protected $primaryKey = 'id';
}
