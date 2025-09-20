<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController, CartController, CheckoutController, OrderController
};
use App\Http\Controllers\Admin\{
    DashboardController, ProductAdminController, OrderAdminController
};

Route::get('/', [ProductController::class,'index'])->name('home');
Route::get('/products/{product}', [ProductController::class,'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class,'add'])->name('cart.add');
    Route::patch('/cart/item/{item}', [CartController::class,'updateQty'])->name('cart.update');
    Route::delete('/cart/item/{item}', [CartController::class,'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class,'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');

    // Orders (user)
    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class,'show'])->name('orders.show');
});

// Admin
Route::prefix('admin')->middleware(['auth','can:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/products', [ProductAdminController::class,'index'])->name('products.index');
    Route::post('/products', [ProductAdminController::class,'store'])->name('products.store');
    Route::patch('/products/{product}', [ProductAdminController::class,'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductAdminController::class,'destroy'])->name('products.destroy');

    Route::get('/orders', [OrderAdminController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderAdminController::class,'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderAdminController::class,'updateStatus'])->name('orders.status');
});

require __DIR__.'/auth.php'; // Breeze
