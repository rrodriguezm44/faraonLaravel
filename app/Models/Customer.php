<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
