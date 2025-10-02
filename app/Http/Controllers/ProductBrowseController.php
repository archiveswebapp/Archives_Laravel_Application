<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class ProductBrowseController extends Controller
{
    public function show(Product $product): View
    {
        
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
