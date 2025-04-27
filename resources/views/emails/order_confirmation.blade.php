<h2>Order Confirmation</h2>
<p>Thank you for your order, {{ $order->user->name ?? 'Customer' }}!</p>
<p>Order #{{ $order->id }} | Date: {{ $order->created_at->format('Y-m-d H:i') }}</p>
<p><strong>Shipping Address:</strong> {{ $order->address }}</p>
<table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr>
            <th align="left">Product</th>
            <th align="left">Qty</th>
            <th align="left">Price</th>
            <th align="left">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->pivot->quantity }}</td>
            <td>${{ number_format($product->pivot->price, 2) }}</td>
            <td>${{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" align="right"><strong>Total:</strong></td>
            <td>${{ number_format($order->total, 2) }}</td>
        </tr>
    </tfoot>
</table>
<p>Status: {{ ucfirst($order->status) }}</p>
