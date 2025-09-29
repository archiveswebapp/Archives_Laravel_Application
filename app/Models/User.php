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

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the orders placed by this user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Accessor: Get the total amount this user has spent.
     */
    public function getTotalSpentAttribute(): float
    {
        return $this->orders->sum('total_price');
    }

    /**
     * Scope: Get users who have placed at least $minOrders orders.
     */
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
