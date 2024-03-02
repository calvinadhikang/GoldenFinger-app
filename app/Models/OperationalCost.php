<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationalCost extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'operational_cost';
    protected $primaryKey = 'id';
    protected $fillable = ['deskripsi', 'total'];
}
