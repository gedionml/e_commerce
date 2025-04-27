@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto my-10 p-8 rounded-2xl shadow-xl backdrop-blur-lg bg-white/70 border border-gray-200">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-2">
        <div>
            <h2 class="text-2xl font-bold text-blue-700 mb-2">Order #{{ $order->id }}</h2>
            <div class="text-gray-700">
                <span class="font-semibold">User:</span> {{ $order->user->name ?? 'N/A' }}<br>
                <span class="text-gray-500 text-sm">{{ $order->user->email ?? '' }}</span>
            </div>
        </div>
        <div>
            <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold
                @if($order->status === 'completed') bg-green-100 text-green-700
                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-700
                @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                @else bg-gray-200 text-gray-700 @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>
    <div class="mb-6">
        <h3 class="font-semibold text-lg mb-2 text-blue-800">Shipping Address</h3>
        <div class="bg-white/80 rounded-lg p-4 border border-gray-100 text-gray-700">
            {{ $order->address }}
        </div>
    </div>
    <div class="mb-6">
        <h3 class="font-semibold text-lg mb-2 text-blue-800">Order Total</h3>
        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100 text-blue-900 text-xl font-bold">
            ${{ number_format($order->total, 2) }}
        </div>
    </div>
    <h3 class="text-lg font-semibold mt-4 mb-2 text-blue-800">Products</h3>
    <div class="overflow-x-auto mb-8">
        <table class="min-w-full bg-white/90 rounded-lg shadow divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Quantity</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Price</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->products as $product)
                <tr>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ $product->pivot->quantity }}</td>
                    <td class="px-4 py-2">${{ number_format($product->pivot->price, 2) }}</td>
                    <td class="px-4 py-2">${{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex flex-col md:flex-row md:items-center gap-3 mt-6">
        @csrf
        @method('PUT')
        <label for="status" class="font-semibold text-blue-800">Update Status:</label>
        <select name="status" id="status" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
</div>
@endsection
