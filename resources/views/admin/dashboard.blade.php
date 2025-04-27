@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>
    <div class="mb-6">
        <a href="{{ route('admin.products.csv') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded shadow">Bulk Product Import/Export (CSV)</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-2xl font-bold text-blue-700 mb-2">${{ number_format($totalSales, 2) }}</div>
            <div class="text-gray-700">Total Sales</div>
        </div>
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-2xl font-bold text-blue-700 mb-2">{{ $ordersCount }}</div>
            <div class="text-gray-700">Orders</div>
        </div>
        <div class="bg-white rounded shadow p-6 text-center">
            <div class="text-2xl font-bold text-blue-700 mb-2">{{ $usersCount }}</div>
            <div class="text-gray-700">Users</div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Top Rated Products</h2>
            <ul>
                @foreach($topProducts as $product)
                    <li class="mb-2 flex items-center justify-between">
                        <span>{{ $product->name }}</span>
                        <span class="text-yellow-500 font-bold">&#9733; {{ number_format($product->reviews->avg('rating'), 1) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
            <ul>
                @foreach($recentOrders as $order)
                    <li class="mb-2 flex items-center justify-between">
                        <span>#{{ $order->id }} - ${{ number_format($order->total, 2) }}</span>
                        <span class="text-gray-500 text-xs">{{ $order->created_at->format('Y-m-d') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="bg-white rounded shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-red-700">Low Inventory Alerts</h2>
        @if($lowInventory->count())
            <ul>
                @foreach($lowInventory as $product)
                    <li class="mb-2 flex items-center justify-between">
                        <span>{{ $product->name }}</span>
                        <span class="font-bold text-red-600">{{ $product->quantity }} left</span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-green-700">All products have sufficient stock.</div>
        @endif
    </div>
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-semibold mb-4">User Management</h2>
        <table class="min-w-full text-left">
            <thead>
                <tr>
                    <th class="py-2 px-3">Name</th>
                    <th class="py-2 px-3">Email</th>
                    <th class="py-2 px-3">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach(App\Models\User::all() as $user)
                    <tr>
                        <td class="py-2 px-3">{{ $user->name }}</td>
                        <td class="py-2 px-3">{{ $user->email }}</td>
                        <td class="py-2 px-3">{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
