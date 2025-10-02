<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'role',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    
     //Accessor: Get the total amount this user has spent.
    
    public function getTotalSpentAttribute(): float
    {
        return $this->orders->sum('total_price');
    }

   
    public function scopeFrequentBuyers($query, $minOrders = 3)
    {
        return $query->whereHas('orders', function ($q) use ($minOrders) {
            $q->groupBy('user_id')->havingRaw('COUNT(*) >= ?', [$minOrders]);
        });
    }

    public function isAdmin(): bool
    {
    return $this->role === 'admin';
    }

}
