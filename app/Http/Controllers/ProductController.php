<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\MongoFeedback;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // Fetch reviews only from MongoDB (no eager loading across DBs)
        $reviews = MongoFeedback::where('product_id', (int) $product->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('products.show', compact('product', 'reviews'));
    }
}
