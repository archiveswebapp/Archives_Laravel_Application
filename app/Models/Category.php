<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
    ];

    
     //Relationship: a category has many products.
     
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    
    //Accessor: Capitalized display name.
    
    public function getFormattedNameAttribute(): string
    {
        return ucfirst($this->name);
    }

   //Filter by the exact name
    public function scopeWithName($query, string $name)
    {
        return $query->where('name', $name);
    }

    
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    
    protected static function booted(): void
    {
        static::saving(function (Category $cat) {
            if (empty($cat->slug) && !empty($cat->name)) {
                $base = Str::slug($cat->name);

                
                $exists = static::where('slug', 'LIKE', "{$base}%")
                    ->when($cat->exists, fn ($q) => $q->where('id', '<>', $cat->id))
                    ->count();

                $cat->slug = $exists ? "{$base}-" . ($exists + 1) : $base;
            }
        });
    }
}
