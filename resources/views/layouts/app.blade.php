<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-100 to-blue-100 min-h-screen">
        <header class="sticky top-0 z-30 bg-white shadow-md">
            <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">
                <a href="/" class="flex items-center space-x-2">
                    <img src="/logo.png" alt="Logo" class="h-10 w-10 rounded-full bg-blue-200">
                    <span class="text-xl font-bold text-blue-700">{{ config('app.name', 'E-Shop') }}</span>
                </a>
                <nav class="space-x-6">
    <a href="/" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Products</a>
    @auth
    @if(!auth()->user()->is_admin)
        <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Cart</a>
        <a href="{{ route('orders.mine') }}" class="text-gray-700 hover:text-blue-600 font-medium">My Orders</a>
        <div x-data="{ open: false }" class="relative inline-block ml-4">
            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium focus:outline-none">
                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.486 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-2 z-50 border">
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50">Logout</button>
                </form>
            </div>
        </div>
    @else
        <a href="{{ route('admin.orders.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Manage Orders</a>
        <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Manage Users</a>

        <div x-data="{ open: false }" class="relative inline-block ml-4">
            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium focus:outline-none">
                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.486 0 4.847.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-2 z-50 border">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 font-semibold">Admin Dashboard</a>
                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50">Logout</button>
                </form>
            </div>
        </div>
    @endif

@else
    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Login</a>
    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Register</a>
@endauth
</nav>
            </div>
        </header>
        <main class="w-full px-2 py-4">
            @yield('content')
        </main>
    </body>
</html>
