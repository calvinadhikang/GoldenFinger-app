<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VulkanisirMachine extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vulkanisir_machine';
    protected $fillable = ['nama', 'service_id'];
}
