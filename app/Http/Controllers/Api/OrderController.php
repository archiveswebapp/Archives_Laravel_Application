<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // ability check
        if (! $request->user()->tokenCan('orders:write')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Validate. Allow either "qty" or "quantity".
        $data = $request->validate([
            'items'                   => ['required', 'array', 'min:1'],
            'items.*.product_id'      => ['required', 'integer', 'exists:products,id'],
            'items.*.qty'             => ['required_without:items.*.quantity', 'integer', 'min:1', 'max:10'],
            'items.*.quantity'        => ['required_without:items.*.qty', 'integer', 'min:1', 'max:10'],
        ]);

        $user = $request->user();

        $order = DB::transaction(function () use ($user, $data) {
            // Create order with total_price initialized (prevents 1364)
            $order = Order::create([
                'user_id'     => $user->id,
                'status'      => 'placed',      // or 'pending' if you prefer
                'total_price' => 0,             // column exists and is NOT NULL
            ]);

            // Load all needed products once
            $productIds = collect($data['items'])->pluck('product_id')->all();
            $products   = Product::whereIn('id', $productIds)->get()->keyBy('id');

            $grandTotal = 0;
            $lineItems = [];

            foreach ($data['items'] as $row) {
                $product = $products[$row['product_id']];
                $qty = (int) ($row['quantity'] ?? $row['qty']); // normalize

                $lineTotal   = $product->price * $qty;
                $grandTotal += $lineTotal;

                // IMPORTANT: save to "quantity" (your DB column)
                $lineItems[] = [
                    'product_id' => $product->id,
                    'price'      => $product->price,
                    'quantity'   => $qty,
                ];
            }

            // Create items through the relation (order_id auto-filled)
            $order->items()->createMany($lineItems);

            // Update order total
            $order->update(['total_price' => $grandTotal]);

            // Return with items (+ their computed "total")
            return $order->load(['items']);
        });

        return response()->json($order, 201);
    }
    
public function index(Request $request)
{
    $orders = Order::where('user_id', $request->user()->id)
        ->with(['items.product'])
        ->latest('id')
        ->paginate(10);

    return response()->json($orders);
}

public function show(Request $request, Order $order)
{
    if ($order->user_id !== $request->user()->id) {
        return response()->json(['message' => 'Not found'], 404);
    }

    return response()->json($order->load(['items.product']));
}

}
