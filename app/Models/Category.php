<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    /**
     * Mass assignable attributes.
     * image = relative path under /public/images (e.g. "categories/oil-paintings.jpg")
     */
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
    ];

    /**
     * Relationship: a category has many products.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Accessor: Capitalized display name.
     */
    public function getFormattedNameAttribute(): string
    {
        return ucfirst($this->name);
    }

    /**
     * Scope: filter by exact name.
     */
    public function scopeWithName($query, string $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Route model binding should use the slug instead of id.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Auto-generate a unique slug on save if missing.
     * Note: This runs only when saving via Eloquent (not raw SQL/phpMyAdmin).
     */
    protected static function booted(): void
    {
        static::saving(function (Category $cat) {
            if (empty($cat->slug) && !empty($cat->name)) {
                $base = Str::slug($cat->name);

                // Count existing slugs starting with $base (excluding current id)
                $exists = static::where('slug', 'LIKE', "{$base}%")
                    ->when($cat->exists, fn ($q) => $q->where('id', '<>', $cat->id))
                    ->count();

                $cat->slug = $exists ? "{$base}-" . ($exists + 1) : $base;
            }
        });
    }
}
