<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class ProductBrowseController extends Controller
{
    /**
     * Display a single product (slug-bound via route-model binding).
     *
     * Route example:
     *   Route::get('/products/{product}', [ProductBrowseController::class, 'show'])
     *        ->name('products.show');
     *
     * Ensure your Product model has:
     *   public function getRouteKeyName(): string { return 'slug'; }
     */
    public function show(Product $product): View
    {
        // Eager-load the category to avoid N+1 queries.
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
