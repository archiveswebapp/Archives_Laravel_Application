<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderUpdateStatusRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();

        $orders = Order::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    /**
     * Display the specified order with its items and user.
     */
    public function show(Order $order)
    {
        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified order status.
     */
    public function update(OrderUpdateStatusRequest $request, Order $order)
    {
        $order->update($request->validated());

        return back()->with('success', 'Order status updated');
    }
}
