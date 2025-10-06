<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController, CartController, CheckoutController, OrderController, ProfileController
};
use App\Http\Controllers\Admin\{
    ProductAdminController, OrderAdminController
};

// 1) Halaman umum (katalog / home + detail)
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// 2) Route untuk kategori
Route::get('/T-Shirts', [ProductController::class, 'kemeja'])->name('kemeja');
Route::get('/Shirts', [ProductController::class, 'kaos'])->name('kaos');
Route::get('/Pants', [ProductController::class, 'pants'])->name('pants');
Route::get('/Outerwear', [ProductController::class, 'jaket'])->name('jaket');
Route::get('/shirt', [ProductController::class, 'shirt'])->name('shirt');
Route::get('/dress', [ProductController::class, 'dress'])->name('dress');

// 2) Rute PEMBELI SAJA (admin ditolak oleh middleware 'useronly')
Route::middleware(['auth','useronly'])->group(function () {
    Route::get('/cart', [CartController::class,'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class,'add'])->name('cart.add');
    Route::patch('/cart/item/{item}', [CartController::class,'updateQty'])->name('cart.update');
    Route::delete('/cart/item/{item}', [CartController::class,'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class,'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class,'show'])->name('orders.show');
});

// 3) Rute ADMIN
Route::prefix('admin')->middleware(['auth','can:admin'])->name('admin.')->group(function () {
    Route::get('/products', [ProductAdminController::class,'index'])->name('products.index');
    Route::post('/products', [ProductAdminController::class,'store'])->name('products.store');
    Route::patch('/products/{product}', [ProductAdminController::class,'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductAdminController::class,'destroy'])->name('products.destroy');
    Route::get('/orders', [OrderAdminController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderAdminController::class,'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderAdminController::class,'updateStatus'])->name('orders.status');
});

Route::get('/dashboard', function () {
    $u = auth()->user();
    return $u && $u->role === 'admin'
        ? redirect()->route('admin.products.index')
        : redirect()->route('home');
})->middleware('auth')->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
