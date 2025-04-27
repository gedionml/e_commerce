@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8 mt-10">
    <h2 class="text-3xl font-bold mb-6 text-blue-900">My Profile</h2>
    <div class="mb-6">
        <div class="mb-2"><span class="font-semibold">Name:</span> {{ Auth::user()->name }}</div>
        <div class="mb-2"><span class="font-semibold">Email:</span> {{ Auth::user()->email }}</div>
        <div class="mb-2"><span class="font-semibold">Registered:</span> {{ Auth::user()->created_at->format('Y-m-d') }}</div>
    </div>
    <a href="{{ route('profile.edit') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded mb-4">Edit Profile</a>
    <a href="{{ route('profile.edit') }}#password" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded mb-4 ml-2">Change Password</a>
    <hr class="my-6">
    <h3 class="text-xl font-bold mb-4 text-blue-800">My Orders</h3>
    @if($orders->count())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Order #</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Total</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $order->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b">${{ $order->total }}</td>
                            <td class="py-2 px-4 border-b">{{ ucfirst($order->status) }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('orders.detail', $order) }}" class="text-blue-700 hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-gray-500">You have no orders yet.</div>
    @endif
</div>
@endsection
