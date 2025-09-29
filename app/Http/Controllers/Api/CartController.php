<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        if (! $request->user()->tokenCan('cart:write')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'items' => ['required','array','min:1'],
            'items.*.product_id' => ['required','integer','exists:products,id'],
            'items.*.qty'        => ['required','integer','min:1','max:10'],
        ]);

        return response()->json([
            'message' => 'Cart updated',
            'payload' => $data,
        ], 201);
    }
}
