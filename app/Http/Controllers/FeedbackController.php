<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MongoFeedback;

class FeedbackController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        MongoFeedback::create([
            'product_id' => (int) $productId,   
            'user_id'    => auth()->id(),
            'rating'     => (int) $request->rating,
            'comment'    => $request->comment,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }

    public function show($productId)
    {
        $reviews = MongoFeedback::where('product_id', (int) $productId) 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('products.feedback', compact('reviews', 'productId'));
    }
}
