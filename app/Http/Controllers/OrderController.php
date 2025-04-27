<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Show checkout form
    public function checkoutForm()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        return view('checkout', compact('cart'));
    }

    // Process checkout
    public function processCheckout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        $total = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'status' => 'pending',
            'address' => $request->input('address'),
        ]);
        foreach ($cart as $productId => $item) {
            $order->products()->attach($productId, [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        session()->forget('cart');
        // Email confirmation
        try {
            \Mail::to(auth()->user()->email)->send(new \App\Mail\OrderConfirmation($order));
        } catch (\Exception $e) {
            // Log or ignore mail errors
        }
        return redirect()->route('products.index')->with('success', 'Order placed successfully!');
    }

    // Show user's past orders
    public function myOrders()
    {
        $orders = \App\Models\Order::with('products')->where('user_id', auth()->id())->orderByDesc('created_at')->get();
        return view('my_orders', compact('orders'));
    }

    // Show order detail page for user
    public function orderDetail($id)
    {
        $order = \App\Models\Order::with('products')->where('user_id', auth()->id())->findOrFail($id);
        return view('order_detail', compact('order'));
    }

    // Downloadable PDF invoice for user (only completed orders)
    public function downloadInvoice($id)
    {
        $order = \App\Models\Order::with('products')->where('user_id', auth()->id())->findOrFail($id);
        if ($order->status !== 'completed') {
            return redirect()->route('orders.detail', $order)->with('error', 'Invoice is only available for completed orders.');
        }
        $pdf = \PDF::loadView('order_detail', compact('order'));
        return $pdf->download('invoice_order_' . $order->id . '.pdf');
    }

    // Admin: Download/export invoice for any order
    public function adminInvoice($id)
    {
        $order = \App\Models\Order::with('products')->findOrFail($id);
        $pdf = \PDF::loadView('order_detail', compact('order'));
        return $pdf->download('invoice_order_' . $order->id . '.pdf');
    }

    // Payment integration placeholder
    public function payment(Request $request)
    {
        // Integrate Stripe/PayPal here
        return 'Payment integration coming soon!';
    }
    // Admin: List all orders
    public function index()
    {
        $orders = \App\Models\Order::with('user')->orderByDesc('created_at')->get();
        return view('admin_orders', compact('orders'));
    }

    // Admin: Show single order
    public function show(Order $order)
    {
        $order->load(['user', 'products']);
        return view('admin_order_show', compact('order'));
    }

    // Admin: Update order status
    public function update(Request $request, Order $order)
    {
        $order->status = $request->input('status', $order->status);
        $order->save();
        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated.');
    }


}
