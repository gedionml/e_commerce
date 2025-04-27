@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-10 p-8 rounded-2xl shadow-xl backdrop-blur-lg bg-white/60 border border-gray-200">
    <h2 class="text-3xl font-bold mb-8 text-blue-900 text-center">My Orders</h2>
    @if($orders->isEmpty())
        <p class="text-center text-gray-500">You have no orders yet.</p>
    @else
        <div class="overflow-x-auto">
        <table class="min-w-full bg-white/90 rounded-lg shadow divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Order #</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Products</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($orders as $order)
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-4 py-3">
                        <a href="{{ route('orders.detail', $order) }}" class="text-blue-700 font-bold underline">#{{ $order->id }}</a>
                    </td>
                    <td class="px-4 py-3 text-gray-700">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            @if($order->status === 'completed') bg-green-100 text-green-700
                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                            @else bg-gray-200 text-gray-700 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-blue-900 font-semibold">${{ number_format($order->total, 2) }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                        @foreach($order->products as $product)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full shadow-sm">
                                {{ $product->name }} <span class="font-semibold">x{{ $product->pivot->quantity }}</span>
                            </span>
                        @endforeach
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endif
</div>
@endsection
