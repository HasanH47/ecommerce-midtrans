<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/show/{slug}', [ProductController::class, 'show'])->name('product.show');

Auth::routes();

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('/carts', CartController::class);

    Route::get('/checkouts', [CheckoutController::class, 'index'])->name('checkouts.index');
    Route::get('/checkout/show/{order}', [CheckoutController::class, 'show'])->name('checkout.detail');
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkouts/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/waiting/{order}', [CheckoutController::class, 'showWaiting'])->name('checkout.waiting');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard.index');
        Route::get('/products', [ProductController::class, 'indexAdmin'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    });
});
