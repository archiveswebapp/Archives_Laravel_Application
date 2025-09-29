<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    // Your table has timestamps (created_at/updated_at), so keep the default = true.

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity', // <-- matches your DB column
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Make computed "total" appear in API responses
    protected $appends = ['total'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Computed: price * quantity (no "total" column in DB)
    public function getTotalAttribute(): float
    {
        $qty = (int) ($this->quantity ?? 0);
        $price = (float) ($this->price ?? 0);
        return $qty * $price;
    }
}
