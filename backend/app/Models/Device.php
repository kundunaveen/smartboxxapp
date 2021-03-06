<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'device';
    protected $fillable = [
        "name",
        "description",
        "lat",
        "long",
        "status",
        'image',
        'address',
        'booking_cost',
        'company_id'
    ];

    public function images()
    {
        return $this->hasMany(DeviceImages::class, 'device_id', 'id');
    }
}
