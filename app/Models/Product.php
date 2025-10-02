<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $fillable = ['name', 'slug', 'description', 'price', 'category_id', 'image','stock'];

    
    protected $casts = [
        'price' => 'float',
        'created_at' => 'datetime',
    ];

    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
    //Accessor: Get formatted price like "$1,200.00"
     
    public function getFormattedPriceAttribute()
    {
        return 'Rs.' . number_format($this->price, 2);
    }

    
    //Mutator: Clean price input before saving to DB
     
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = floatval(str_replace(',', '', $value));
    }

    
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function getRouteKeyName() { return 'slug'; }

    protected static function booted()
    {
    static::saving(function ($p) {
        if (empty($p->slug)) {
            $base = \Str::slug($p->name);
            $exists = static::where('slug', 'LIKE', "$base%")
                ->where('id', '<>', $p->id)->count();
            $p->slug = $exists ? "{$base}-".($exists+1) : $base;
        }
    });
    }

}
