<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view any orders.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view a specific order.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->isAdmin() || $order->user_id === $user->id;
    }

    /**
     * Determine whether the user can create orders.
     * (Normal customers can create orders, so true for everyone logged in.)
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update an order.
     * (Only admins can update order status.)
     */
    public function update(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete an order.
     * (Optional: usually only admins.)
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }

    /**
     * Restore (not typically needed).
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }

    /**
     * Permanently delete (not typically needed).
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }
}
