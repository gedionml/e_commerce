@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-8 mt-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Your Shopping Cart</h1>
    @if(empty($cart))
        <p class="text-center text-gray-500">Your cart is empty.</p>
    @else
        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($cart as $id => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>@if($item['image'])<img src="{{ asset('storage/'.$item['image']) }}" width="60">@endif</td>
                    <td>${{ $item['price'] }}</td>
                    <td>
                        <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width:60px">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-3">
            <strong>Total: ${{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}</strong>
        </div>
        <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
        <form action="{{ route('cart.clear') }}" method="POST" style="display:inline-block">
            @csrf
            <button type="submit" class="btn btn-warning">Clear Cart</button>
        </form>
    @endif
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Continue Shopping</a>
</div>
@endsection
