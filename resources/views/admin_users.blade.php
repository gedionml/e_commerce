@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white rounded-xl shadow p-8">
    <h2 class="text-3xl font-bold mb-6 text-blue-700">All Users</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Is Admin</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                <td>
                    @if(!$user->is_admin)
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
