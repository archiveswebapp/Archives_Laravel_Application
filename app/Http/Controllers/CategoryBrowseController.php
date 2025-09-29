<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryBrowseController extends Controller
{
     public function index()
    {
        $categories = Category::orderBy('name')->get(['id','name','slug','image']);
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category) // slug-bound
    {
        $products = $category->products()->latest()->paginate(12, ['id','name','slug','price','image','category_id']);
        return view('categories.show', compact('category','products'));
    }
}
