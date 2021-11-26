<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class availability extends Model
{
    use HasFactory;

    protected $table = 'availability';
    protected $fillable = [
        'booking_id',
        'date',
        'start_time',
        'end_time',
        'standard',
        'status'
    ];
}
