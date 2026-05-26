<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Override;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'summary',
    ];

    #[Override]
    protected static function booted()
    {
        static::creating(function($category){
            $category->slug = Str::slug($category->name);
        });
        
        static::updating(function($category){
            $category->slug = Str::slug($category->name);
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
}
