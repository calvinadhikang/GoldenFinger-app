<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VulkanisirService extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'service';
    protected $fillable = ['machine_id', 'customer_id', 'harga', 'cancel_reason', 'canceled_by', 'will_finish_at', 'taken_at', 'taken_by', 'handled_by'];

    public function customer(){
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function machine(){
        return $this->hasOne(VulkanisirMachine::class, 'id', 'machine_id');
    }

    public function teknisi(){
        return $this->hasOne(Karyawan::class, 'id', 'handled_by');
    }
}
