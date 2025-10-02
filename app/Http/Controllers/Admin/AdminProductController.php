<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;

class AdminProductController extends Controller
{
    
     //Display a listing of the resource.
     
    public function index()
    {
        $q = request()->string('q');
        $products = Product::with('category')
            ->when($q, fn ($query) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    
     //Show the form for creating a new product.
     
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', [
            'product'    => new Product(),
            'categories' => $categories,
        ]);
    }

    
     //Store a newly created product in storage.
     
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        
        $data['slug'] = Str::slug($data['name']);

        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public'); 
            
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    
      //Show the form for editing the specified product.
     
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    
     //Update the specified product in storage.
     
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->validated();

        
        $data['slug'] = Str::slug($data['name']);

        
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    
     //Remove the specified product from storage.
     
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully');
    }
}
