@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8 mt-10 flex flex-col gap-8">
    {{-- Product Image Gallery --}}
    <div class="mb-4">
        @if($product->productImages->count())
            <div class="flex gap-2 overflow-x-auto">
                @foreach($product->productImages as $img)
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $product->name }}" class="rounded-lg max-h-72 object-contain border w-40">
                @endforeach
            </div>
        @elseif($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded-lg max-h-80 object-contain w-full border">
        @endif
    </div>
    <div class="flex-1 flex flex-col justify-between">
        <div>
            <h2 class="text-3xl font-bold mb-2">{{ $product->name }}</h2>
            {{-- Average Rating --}}
            @if(isset($averageRating))
                <div class="flex items-center mb-2">
                    <span class="text-yellow-500 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($averageRating >= $i)
                                <svg class="inline w-5 h-5 fill-current" viewBox="0 0 20 20"><polygon points="9.9,1.1 7.6,6.8 1.5,7.6 6.1,11.9 4.8,18 9.9,14.9 15,18 13.7,11.9 18.3,7.6 12.2,6.8 "/></svg>
                            @else
                                <svg class="inline w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 20 20"><polygon points="9.9,1.1 7.6,6.8 1.5,7.6 6.1,11.9 4.8,18 9.9,14.9 15,18 13.7,11.9 18.3,7.6 12.2,6.8 "/></svg>
                            @endif
                        @endfor
                    </span>
                    <span class="text-gray-700 font-semibold">{{ number_format($averageRating, 1) }}/5</span>
                    <span class="ml-2 text-gray-500 text-sm">({{ $product->reviews->count() }} reviews)</span>
                </div>
            @endif
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
            <div class="text-2xl font-bold text-blue-700 mb-6">${{ $product->price }}</div>
        </div>
        <div class="flex flex-wrap gap-3 mt-4">
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Add to Cart</button>
            </form>
            @auth
                @if(Auth::user() && Auth::user()->is_admin)
                    <a href="{{ route('products.edit', $product) }}" class="btn bg-yellow-500 text-white hover:bg-yellow-600">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn bg-red-600 text-white hover:bg-red-700">Delete</button>
                    </form>
                @endif
            @endauth
            <a href="{{ route('products.index') }}" class="btn bg-gray-300 text-gray-800 hover:bg-gray-400">Back to Products</a>
        </div>
    </div>
</div>
    </div>
</div>

@if(isset($relatedProducts) && $relatedProducts->count())
    <div class="max-w-4xl mx-auto mt-12">
        <h3 class="text-2xl font-bold mb-6 text-blue-900">Related Products</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center hover:shadow-lg transition">
                    @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="rounded-lg mb-3 h-32 w-full object-cover">
                    @endif
                    <div class="font-semibold text-blue-800 text-center mb-1">{{ $related->name }}</div>
                    <div class="text-blue-700 font-bold mb-2">${{ $related->price }}</div>
                    <a href="{{ route('products.show', $related) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm font-semibold transition">View</a>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- Product Reviews Section --}}
<div class="max-w-2xl mx-auto mt-10">
    <h3 class="text-xl font-bold mb-4 text-blue-800">Customer Reviews</h3>
    @if($product->reviews->count())
        <div class="space-y-6 mb-8">
            @foreach($product->reviews as $review)
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <div class="flex items-center mb-1">
                        <span class="font-semibold text-blue-900 mr-2">{{ $review->user->name }}</span>
                        <span class="text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                @if($review->rating >= $i)
                                    <svg class="inline w-4 h-4 fill-current" viewBox="0 0 20 20"><polygon points="9.9,1.1 7.6,6.8 1.5,7.6 6.1,11.9 4.8,18 9.9,14.9 15,18 13.7,11.9 18.3,7.6 12.2,6.8 "/></svg>
                                @else
                                    <svg class="inline w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 20 20"><polygon points="9.9,1.1 7.6,6.8 1.5,7.6 6.1,11.9 4.8,18 9.9,14.9 15,18 13.7,11.9 18.3,7.6 12.2,6.8 "/></svg>
                                @endif
                            @endfor
                        </span>
                    </div>
                    <div class="text-gray-800 mb-1">{{ $review->comment }}</div>
                    <div class="text-xs text-gray-500">{{ $review->created_at->format('Y-m-d') }}</div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-500 mb-8">No reviews yet. Be the first to review this product!</div>
    @endif

    {{-- Review Submission Form (Stub) --}}
    @auth
        @if(!auth()->user()->is_admin)
            <div class="bg-white p-6 rounded-lg shadow">
    <h4 class="font-semibold mb-2">Leave a Review</h4>
    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-2 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-2 p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-2 p-2 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('reviews.store', $product) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="rating" class="block font-medium">Rating</label>
                        <select name="rating" id="rating" class="border rounded px-2 py-1">
    <option value="">Select rating</option>
    @for($i = 5; $i >= 1; $i--)
        <option value="{{ $i }}" @if(old('rating') == $i) selected @endif>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
    @endfor
</select>
                    </div>
                    <div class="mb-2">
                        <label for="comment" class="block font-medium">Comment</label>
                        <textarea name="comment" id="comment" rows="3" class="border rounded w-full px-2 py-1">{{ old('comment') }}</textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Submit Review</button>
                </form>
            </div>
        @endif
    @endauth
</div>
@endsection
