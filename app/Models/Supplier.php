<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'razons',
        'contact_info',
        'address',
        'nit',
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}
