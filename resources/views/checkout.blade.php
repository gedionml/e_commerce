@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto my-10 bg-white rounded-xl shadow p-8">
    <h2 class="text-3xl font-bold mb-6 text-center">Checkout</h2>
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-2">Order Summary</h3>
        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 mb-2">
            <thead class="bg-gray-50">
                <tr class="text-left">
                    <th class="py-2 px-2 text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="py-2 px-2 text-xs font-medium text-gray-500 uppercase">Qty</th>
                    <th class="py-2 px-2 text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="py-2 px-2 text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td class="py-2 px-2">{{ $item['name'] }}</td>
                        <td class="py-2 px-2">{{ $item['quantity'] }}</td>
                        <td class="py-2 px-2">${{ number_format($item['price'], 2) }}</td>
                        <td class="py-2 px-2">${{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold border-t">
                    <td colspan="3" class="py-3 px-2 text-right">Total:</td>
                    <td class="py-3 px-2">${{ number_format($total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="address" class="block text-gray-700">Shipping Address</label>
            <input type="text" name="address" id="address" required class="w-full border rounded px-3 py-2 mt-1">
        </div>
        <div class="mb-4">
            <label for="note" class="block text-gray-700">Order Note (optional)</label>
            <textarea name="note" id="note" rows="2" class="w-full border rounded px-3 py-2 mt-1"></textarea>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Place Order</button>
    </form>
</div>
@endsection
