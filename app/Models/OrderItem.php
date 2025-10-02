<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity', 
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    
    protected $appends = ['total'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    
    public function getTotalAttribute(): float
    {
        $qty = (int) ($this->quantity ?? 0);
        $price = (float) ($this->price ?? 0);
        return $qty * $price;
    }
}
