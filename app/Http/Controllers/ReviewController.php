<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Only allow users who purchased the product to review (simple check)
        $user = Auth::user();
        $hasOrdered = $user->orders()->whereHas('products', function($q) use ($product) {
            $q->where('product_id', $product->id);
        })->exists();
        if (!$hasOrdered) {
            return back()->with('error', 'You can only review products you have purchased.');
        }
        // Prevent duplicate reviews
        if ($product->reviews()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You have already reviewed this product.');
        }
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return back()->with('success', 'Thank you for your review!');
    }
}
