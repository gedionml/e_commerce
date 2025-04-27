@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto my-10 p-10 rounded-2xl shadow-2xl backdrop-blur-lg bg-white/70 border border-gray-200">
    <h2 class="text-3xl font-bold mb-8 text-blue-900 text-center">All Orders</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white/90 rounded-lg shadow divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">User</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Created</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @foreach($orders as $order)
            <tr class="hover:bg-blue-50 transition">
                <td class="px-4 py-3 font-bold text-blue-800">#{{ $order->id }}</td>
                <td class="px-4 py-3">
                    <div class="font-semibold text-gray-900">{{ $order->user->name ?? 'N/A' }}</div>
                </td>
                <td class="px-4 py-3 text-gray-600 text-sm">{{ $order->user->email ?? 'N/A' }}</td>
                <td class="px-4 py-3 text-blue-900 font-semibold">${{ number_format($order->total, 2) }}</td>
                <td class="px-4 py-3">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        @if($order->status === 'completed') bg-green-100 text-green-700
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                        @else bg-gray-200 text-gray-700 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-700">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-block px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 shadow text-xs font-semibold">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
