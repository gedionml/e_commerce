@extends('layouts.app')

@section('content')
<!-- Hero Section with Filled Picture and Overlay Text/Buttons -->
<div class="relative w-full h-[60vh] flex items-center justify-center bg-gray-900 overflow-hidden">
    <img src="/images/hero.jpg" alt="Shop Hero" class="absolute inset-0 w-full h-full object-cover object-center opacity-70" />
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/70 to-transparent"></div>
    <div class="relative z-10 text-center max-w-4xl mx-auto px-4">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white drop-shadow mb-4 whitespace-nowrap overflow-x-auto px-8 py-4">
            Discover <span class="bg-white/20 px-4 py-1 rounded-xl whitespace-nowrap">Amazing Deals</span>
        </h1>
        <p class="text-xl md:text-2xl text-white/90 mb-8 drop-shadow">
            Welcome to {{ config('app.name', 'Our Shop') }}<br class="hidden md:block" />Your destination for the best products and fast delivery.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-blue-500 to-blue-800 hover:from-blue-600 hover:to-blue-900 text-white font-bold px-10 py-4 rounded-full shadow-xl text-lg tracking-wide transition transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300">Shop Now</a>
            <a href="mailto:info@example.com" class="inline-block bg-white/80 hover:bg-white text-blue-900 font-bold px-10 py-4 rounded-full shadow-xl text-lg tracking-wide transition transform hover:scale-105 border-2 border-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Contact Us</a>
        </div>
    </div>
</div>

<!-- Product List Section -->
<div class="max-w-7xl mx-auto py-6 px-1">
    <h2 class="text-3xl font-bold text-blue-900 mb-8 text-center">All Products</h2>
    <form method="GET" action="{{ url('/') }}" class="max-w-3xl mx-auto mb-8 flex flex-wrap items-center gap-2 bg-white rounded-lg shadow p-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="flex-1 px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <select name="category" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">All Categories</option>
            @php $categories = \App\Models\Product::pluck('category')->filter()->unique(); @endphp
            @foreach($categories as $cat)
                <option value="{{ $cat }}" @if(request('category') === $cat) selected @endif>{{ $cat }}</option>
            @endforeach
        </select>
        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price" min="0" step="0.01" class="w-28 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" min="0" step="0.01" class="w-28 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">Filter</button>
        @if(request('search') || request('category') || request('min_price') || request('max_price'))
            <a href="{{ url('/') }}" class="ml-2 text-gray-500 hover:text-red-600 text-sm">Clear</a>
        @endif
    </form>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @php
            $products = \App\Models\Product::query();
            $search = request('search');
            $category = request('category');
            $min_price = request('min_price');
            $max_price = request('max_price');
            if ($search) {
                $products->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%");
                });
            }
            if ($category) {
                $products->where('category', $category);
            }
            if ($min_price !== null && $min_price !== '') {
                $products->where('price', '>=', $min_price);
            }
            if ($max_price !== null && $max_price !== '') {
                $products->where('price', '<=', $max_price);
            }
            $products = $products->get();
        @endphp
        @forelse($products as $product)
            <div class="bg-white/80 backdrop-blur rounded-2xl shadow-lg p-5 flex flex-col items-center hover:shadow-2xl transition">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="rounded-xl mb-4 h-40 w-full object-cover shadow" alt="{{ $product->name }}">
                @endif
                <h5 class="font-semibold text-lg mb-1 text-blue-900">{{ $product->name }}</h5>
                <p class="text-gray-600 text-sm flex-1">{{ Str::limit($product->description, 60) }}</p>
                <p class="text-xl font-bold text-blue-700 mt-2 mb-4">${{ $product->price }}</p>
                <a href="{{ route('products.show', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-semibold transition">View</a>
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">No products available.</div>
        @endforelse
    </div>
</div>
@endsection
