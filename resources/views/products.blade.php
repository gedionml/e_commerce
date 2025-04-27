@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Products</h1>
<form method="GET" action="{{ route('products.index') }}" class="max-w-3xl mx-auto mb-8 flex flex-wrap items-center gap-2 bg-white rounded-lg shadow p-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="flex-1 px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
    <select name="category" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">All Categories</option>
        @php $categories = $products->pluck('category')->filter()->unique(); @endphp
        @foreach($categories as $cat)
            <option value="{{ $cat }}" @if(request('category') === $cat) selected @endif>{{ $cat }}</option>
        @endforeach
    </select>
    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Price" min="0" step="0.01" class="w-28 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Price" min="0" step="0.01" class="w-28 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">Filter</button>
    @if(request('search') || request('category') || request('min_price') || request('max_price'))
        <a href="{{ route('products.index') }}" class="ml-2 text-gray-500 hover:text-red-600 text-sm">Clear</a>
    @endif
</form>
@if(auth()->check() && auth()->user()->is_admin && Route::currentRouteName() === 'products.index')
    <div class="flex justify-end mb-6">
        <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow transition">+ Add Product</a>
    </div>
@endif
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="rounded mb-4 h-48 w-full object-cover" alt="{{ $product->name }}">
                @endif
                <h5 class="font-semibold text-lg mb-1">{{ $product->name }}</h5>
                {{-- Average Rating --}}
                @php $avg = $product->reviews()->avg('rating'); $count = $product->reviews()->count(); @endphp
                <div class="mb-1">
                    @if($count)
                        <span class="text-yellow-500 mr-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($avg >= $i)
                                    <svg class="inline w-4 h-4 fill-current" viewBox="0 0 20 20"><polygon points="9.9,1.1 7.6,6.8 1.5,7.6 6.1,11.9 4.8,18 9.9,14.9 15,18 13.7,11.9 18.3,7.6 12.2,6.8 "/></svg>
                                @else
                                    <svg class="inline w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 20 20"><polygon points="9.9,1.1 7.6,6.8 1.5,7.6 6.1,11.9 4.8,18 9.9,14.9 15,18 13.7,11.9 18.3,7.6 12.2,6.8 "/></svg>
                                @endif
                            @endfor
                        </span>
                        <span class="text-gray-700 text-sm font-semibold">{{ number_format($avg, 1) }}/5</span>
                        <span class="text-gray-500 text-xs">({{ $count }})</span>
                    @else
                        <span class="text-gray-400 text-sm">No ratings yet</span>
                    @endif
                </div>
                <p class="text-gray-600 flex-1">{{ $product->description }}</p>
                <p class="text-xl font-bold text-blue-700 mt-2 mb-4">${{ $product->price }}</p>
                <div class="flex space-x-2 mt-auto">
                    <a href="{{ route('products.show', $product) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-center transition">View</a>
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded transition">Add to Cart</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
