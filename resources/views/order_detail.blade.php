@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto my-10 p-8 rounded-2xl shadow-xl backdrop-blur-lg bg-white/60 border border-gray-200">
    <div class="flex items-center mb-6">
        <img src="/logo.png" alt="Company Logo" class="h-14 w-14 mr-4 rounded-full shadow">
        <div>
            <div class="font-bold text-xl text-blue-800">Your Company Name</div>
            <div class="text-gray-600">123 Main Street, City, Country</div>
            <div class="text-gray-500 text-sm">info@yourcompany.com | +1234567890</div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-2">
        <div>
            <h2 class="text-2xl font-bold text-blue-700 mb-1">Order #{{ $order->id }}</h2>
            <p class="text-gray-700"><span class="font-semibold">Date:</span> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        </div>
        <div>
            <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold
                @if($order->status === 'completed') bg-green-100 text-green-700
                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
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
        <h3 class="font-semibold text-lg mb-2 text-blue-800">Customer Info</h3>
        <div class="bg-white/80 rounded-lg p-4 border border-gray-100 text-gray-700">
            <span class="font-medium">{{ $order->user->name ?? 'N/A' }}</span><br>
            <span class="text-gray-500 text-sm">{{ $order->user->email ?? 'N/A' }}</span>
        </div>
    </div>
    <h3 class="text-lg font-semibold mt-4 mb-2 text-blue-800">Products</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white/90 rounded-lg shadow divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Product</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Qty</th>
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
            <tfoot>
                <tr class="font-bold border-t bg-blue-50">
                    <td colspan="3" class="py-3 px-4 text-right">Total:</td>
                    <td class="py-3 px-4 text-blue-800 text-xl">${{ number_format($order->total, 2) }}</td>
                </tr>
        </tfoot>
    </table>
    <a href="{{ route('orders.invoice', $order) }}" class="inline-block mt-4 px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">Download Invoice (PDF)</a>
    <a href="{{ route('orders.mine') }}" class="ml-4 inline-block mt-4 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Back to My Orders</a>
</div>
@endsection
