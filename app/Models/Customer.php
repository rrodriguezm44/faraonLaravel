<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'nit',
        'address',
        'zone',
        'phone',
        'level',
        'is_active',
    ];
}
