<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($r) => $r['price'] * $r['qty']);
        return view('checkout', compact('cart', 'total'));
    }

    public function place(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Cart is empty.');
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'zip'     => 'required|string|max:20',
            'payment' => 'required|string|in:cod,card,paypal',
        ]);

        DB::transaction(function () use ($cart, $request) {
            $total = collect($cart)->sum(fn($r) => $r['price'] * $r['qty']);

            $order = Order::create([
                'user_id'     => auth()->id(),
                'total_price' => $total,
                'status'      => 'pending',
                'payment'     => $request->payment, 
            ]);

            foreach ($cart as $row) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $row['id'],
                    'quantity'   => $row['qty'],
                    'price'      => $row['price'],
                ]);

                
                Product::where('id', $row['id'])->decrement('stock', $row['qty']);
            }
        });

        session()->forget('cart');

        return redirect()->route('checkout.success')
            ->with('success', 'Your order has been placed successfully!');
    }

    public function success()
    {
        return view('checkout-success');
    }
}
