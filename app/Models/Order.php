<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_price', 'status'];

    protected $casts = [
        'total_price' => 'decimal:2',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class); 
    }

    
    public function getItemCountAttribute(): int
    {
        return (int) $this->items()->sum('quantity');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
