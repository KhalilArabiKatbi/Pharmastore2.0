<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can place an order.
     */
    public function placeOrder(User $user)
    {
        return $user->role === 'pharmacist';
    }

    /**
     * Determine whether the user can view their own orders.
     */
    public function viewOrders(User $user)
    {
        return $user->role === 'pharmacist';
    }

    /**
     * Determine whether the user can view all warehouse orders.
     */
    public function viewAllOrders(User $user)
    {
        return $user->role === 'warehouseowner';
    }

    /**
     * Determine whether the user can update the status of an order.
     */
    public function updateOrderStatus(User $user)
    {
        return $user->role === 'warehouseowner';
    }

    /**
     * Determine whether the user can update the billing status of an order.
     */
    public function updateBillingStatus(User $user)
    {
        return $user->role === 'warehouseowner';
    }
}
