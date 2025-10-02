<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    // List products (with pagination)
    public function index()
    {
        $products = Product::query()
            ->select(['id', 'name', 'price', 'image'])
            ->latest('id')
            ->paginate(12)
            ->through(function ($p) {
                return [
                    'id'        => $p->id,
                    'name'      => $p->name,
                    'price'     => (float) $p->price,
                    'image'     => $p->image,
                    'image_url' => $p->image ? url('images/'.$p->image) : null,
                ];
            });

        return response()->json($products, 200);
    }

    // Show a single product (safe against SQL Injection via Eloquent)
    public function show($id)
    {
        $product = Product::findOrFail($id); 
        return response()->json($product, 200);
    }
}
