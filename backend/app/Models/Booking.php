<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = [
        'user_id',
        'uuid',
        'device_id',
        'slot_type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'standard',
        'mobile',
        'address',
        'code',
        'state',
        'city',
        'zip',
        'country',
        'status',
        'mode',
        'description',
        'amount'
    ];

    public function device(){
        return $this->hasOne(Device::class,'id','device_id');

    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');

    }
}
