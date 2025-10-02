<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        
        $products   = Product::with('category')->latest()->take(8)->get(['id','name','slug','price','image','category_id']);
        $categories = Category::orderBy('name')->get(['id','name','slug','image']);

        return view('home', compact('products', 'categories'));
    }
}
