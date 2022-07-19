<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'contact_firstname',
        'contact_lastname',
        'street',
        'code',
        'state',
        'city',
        'zip',
        'country'
    ];

}
