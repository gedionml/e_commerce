<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/dashboard', function () {
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Product routes
    Route::resource('products', ProductController::class)->except(['create', 'store', 'index', 'show']);

    // Product creation routes only for admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
        Route::post('products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    });

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

// Admin Dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin_dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/profile', [App\Http\Controllers\AdminProfileController::class, 'show'])->name('admin.profile');
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/products/{product}/images', [\App\Http\Controllers\ProductImageController::class, 'store'])->name('products.images.store');
    Route::delete('/products/{product}/images/{image}', [\App\Http\Controllers\ProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::get('/admin/products/export-csv', [\App\Http\Controllers\ProductCsvController::class, 'export'])->name('admin.products.exportCsv');
    Route::post('/admin/products/import-csv', [\App\Http\Controllers\ProductCsvController::class, 'import'])->name('admin.products.importCsv');

    Route::get('/admin/products/csv', function() {
        return view('admin.products_csv');
    })->name('admin.products.csv');
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}', [App\Http\Controllers\OrderController::class, 'update'])->name('admin.orders.update');
});

// Shopping Cart Routes
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [App\Http\Controllers\OrderController::class, 'checkoutForm'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/my-orders', [App\Http\Controllers\OrderController::class, 'myOrders'])->name('orders.mine');
    Route::get('/my-orders/{order}', [App\Http\Controllers\OrderController::class, 'orderDetail'])->name('orders.detail');
    Route::get('/my-orders/{order}/invoice', [App\Http\Controllers\OrderController::class, 'downloadInvoice'])->name('orders.invoice');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/orders/{order}/invoice', [App\Http\Controllers\OrderController::class, 'adminInvoice'])->name('admin.orders.invoice');
    Route::get('/payment', [App\Http\Controllers\OrderController::class, 'payment'])->name('payment');
});

require __DIR__.'/auth.php';
