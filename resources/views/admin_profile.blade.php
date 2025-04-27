@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8 mt-10">
    <h2 class="text-3xl font-bold mb-6 text-blue-900">Admin Profile</h2>
    <div class="mb-6">
        <div class="mb-2"><span class="font-semibold">Name:</span> {{ $admin->name }}</div>
        <div class="mb-2"><span class="font-semibold">Email:</span> {{ $admin->email }}</div>
        <div class="mb-2"><span class="font-semibold">Role:</span> Admin</div>
        <div class="mb-2"><span class="font-semibold">Registered:</span> {{ $admin->created_at->format('Y-m-d') }}</div>
    </div>
    <a href="#" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded mb-4">Edit Profile (Coming Soon)</a>
</div>
@endsection
