<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::sum('total');
        $ordersCount = Order::count();
        $usersCount = User::count();
        $topProducts = Product::withCount(['reviews'])
            ->orderByDesc('reviews_count')
            ->take(5)
            ->get();
        $recentOrders = Order::orderByDesc('created_at')->take(5)->get();
        $lowInventory = Product::where('quantity', '<', 5)->get();
        return view('admin.dashboard', compact('totalSales', 'ordersCount', 'usersCount', 'topProducts', 'recentOrders', 'lowInventory'));
    }
}
