@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-8">
    <h1 class="text-2xl font-bold mb-6 text-blue-700">Edit Product</h1>
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative">
                <input type="text" id="name" name="name" required class="peer h-12 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none focus:border-blue-600" placeholder="Name" value="{{ old('name', $product->name) }}" />
                <label for="name" class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-blue-600 peer-focus:text-sm">Name *</label>
            </div>
            <div class="relative">
                <input type="text" id="category" name="category" class="peer h-12 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none focus:border-blue-600" placeholder="Category" value="{{ old('category', $product->category) }}" />
                <label for="category" class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-blue-600 peer-focus:text-sm">Category</label>
            </div>
            <div class="relative">
                <input type="number" step="0.01" id="price" name="price" required class="peer h-12 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none focus:border-blue-600" placeholder="Price" value="{{ old('price', $product->price) }}" />
                <label for="price" class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-blue-600 peer-focus:text-sm">Price *</label>
            </div>
            <div class="relative">
                <input type="number" id="quantity" name="quantity" min="0" required class="peer h-12 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none focus:border-blue-600" placeholder="Quantity" value="{{ old('quantity', $product->quantity) }}" />
                <label for="quantity" class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-blue-600 peer-focus:text-sm">Quantity *</label>
            </div>
        </div>
        <div class="relative">
            <textarea id="description" name="description" rows="3" class="peer w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none focus:border-blue-600 resize-none" placeholder="Description">{{ old('description', $product->description) }}</textarea>
            <label for="description" class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-3.5 peer-focus:text-blue-600 peer-focus:text-sm">Description</label>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="image" class="block text-gray-700 mb-2">Main Product Image (optional)</label>
                <input type="file" id="image" name="image" class="block w-full text-gray-700 file:bg-blue-600 file:text-white file:rounded file:px-4 file:py-2 file:border-none file:mr-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Main Image" class="rounded shadow mt-2 w-32 h-32 object-cover border">
                @endif
            </div>
            <div>
                <label for="images" class="block text-gray-700 mb-2">Upload Additional Images</label>
                <input type="file" id="images" name="images[]" multiple class="block w-full text-gray-700 file:bg-blue-600 file:text-white file:rounded file:px-4 file:py-2 file:border-none file:mr-4">
                <small class="text-gray-500">You can select and upload multiple images.</small>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Current Images</label>
            <div class="flex flex-wrap gap-3">
                @foreach($product->productImages as $img)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="Product Image" class="rounded shadow w-28 h-28 object-cover border">
                        <form action="{{ route('products.images.destroy', [$product, $img]) }}" method="POST" class="absolute top-1 right-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white rounded-full px-2 py-1 text-xs opacity-80 hover:opacity-100 transition" onclick="return confirm('Delete this image?')">&times;</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex space-x-4 mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">Update Product</button>
            <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2 rounded shadow">Cancel</a>
        </div>
    </form>
</div>
@endsection
