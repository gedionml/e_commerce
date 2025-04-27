@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-12 px-6">
    <div class="backdrop-blur-lg bg-white/80 rounded-2xl shadow-2xl p-10 border border-blue-100">
        <h1 class="text-4xl font-extrabold mb-3 flex items-center gap-3 text-blue-700 drop-shadow">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h3m10 0h3a1 1 0 001-1V7a1 1 0 00-1-1h-3M6 17v2a1 1 0 001 1h10a1 1 0 001-1v-2M6 7V5a1 1 0 011-1h10a1 1 0 011 1v2" /></svg>
            Admin Dashboard
        </h1>
        <p class="mb-10 text-lg text-gray-600">Welcome, Admin! Manage your store using the options below.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <a href="{{ route('products.index') }}" class="block bg-white/90 rounded-xl shadow hover:shadow-xl p-8 text-center transition border border-green-100 hover:border-green-400">
                <div class="flex justify-center mb-3"><svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4" /></svg></div>
                <div class="font-semibold text-lg mb-2">Manage Products</div>
                <div class="text-sm text-gray-500">View, edit, or remove products in your store.</div>
            </a>
            <a href="{{ route('products.create') }}" class="block bg-white/90 rounded-xl shadow hover:shadow-xl p-8 text-center transition border border-blue-100 hover:border-blue-400">
                <div class="flex justify-center mb-3"><svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg></div>
                <div class="font-semibold text-lg mb-2">Add New Product</div>
                <div class="text-sm text-gray-500">Add a new product to your store.</div>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="block bg-white/90 rounded-xl shadow hover:shadow-xl p-8 text-center transition border border-yellow-100 hover:border-yellow-400">
                <div class="flex justify-center mb-3"><svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h3a4 4 0 014 4v2M9 17v2a2 2 0 002 2h6a2 2 0 002-2v-2" /></svg></div>
                <div class="font-semibold text-lg mb-2">Manage Orders</div>
                <div class="text-sm text-gray-500">View and process customer orders.</div>
            </a>
            <a href="{{ route('admin.users.index') }}" class="block bg-white/90 rounded-xl shadow hover:shadow-xl p-8 text-center transition border border-purple-100 hover:border-purple-400">
                <div class="flex justify-center mb-3"><svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75" /></svg></div>
                <div class="font-semibold text-lg mb-2">Manage Users</div>
                <div class="text-sm text-gray-500">View and manage user accounts.</div>
            </a>
        </div>
    </div>
</div>
@endsection
