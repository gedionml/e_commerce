@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Bulk Product Import/Export (CSV)</h1>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-2">Export Products</h2>
        <a href="{{ route('admin.products.exportCsv') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Download CSV</a>
    </div>
    <div>
        <h2 class="text-lg font-semibold mb-2">Import Products</h2>
        <form action="{{ route('admin.products.importCsv') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv" accept=".csv,text/csv" class="border rounded px-3 py-2 mb-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Import CSV</button>
        </form>
        <p class="text-xs text-gray-500 mt-2">CSV columns: id (optional), name, category, price, description, quantity</p>
    </div>
</div>
@endsection
