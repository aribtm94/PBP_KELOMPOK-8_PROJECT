<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController,
    CartController,
    CheckoutController,
    OrderController,
    ProfileController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    ProductAdminController,
    OrderAdminController
};

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::controller(ProductController::class)->group(function () {
    Route::get('/T-Shirts', 'kemeja')->name('kemeja');
    Route::get('/Shirts', 'kaos')->name('kaos');
    Route::get('/Pants', 'pants')->name('pants');
    Route::get('/Outerwear', 'jaket')->name('jaket');
    Route::get('/shirt', 'shirt')->name('shirt');
    Route::get('/dress', 'dress')->name('dress');
});

Route::middleware(['auth', 'useronly'])->group(function () {

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/item/{item}', [CartController::class, 'updateQty'])->name('cart.update');
    Route::delete('/cart/item/{item}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

Route::prefix('admin')
    ->middleware(['auth', 'can:admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::controller(ProductAdminController::class)->group(function () {
            Route::get('/products', 'index')->name('products.index');
            Route::post('/products', 'store')->name('products.store');
            Route::patch('/products/{product}', 'update')->name('products.update');
            Route::delete('/products/{product}', 'destroy')->name('products.destroy');
        });

        Route::controller(OrderAdminController::class)->group(function () {
            Route::get('/orders', 'index')->name('orders.index');
            Route::get('/orders/{order}', 'show')->name('orders.show');
            Route::patch('/orders/{order}/status', 'updateStatus')->name('orders.status');
        });
    });

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
