<?php

use App\Http\Controllers\FrontendProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// ============================================
// SHOP ROUTES 
// ============================================
Route::domain('pleasing-sparkle-production-7b89.up.railway.app')->group(function () {
    Route::get('/', [FrontendProductController::class, 'index'])->name('shop.index');
    Route::get('/shop/{slug}', [FrontendProductController::class, 'show'])->name('shop.show');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');
});

// ============================================
// BLOG ROUTES 
// ============================================
Route::domain('innovative-miracle-production-2200.up.railway.app')->group(function () {
    Route::get('/', [BlogController::class, 'home'])->name('blog.index');
    Route::get('/all-posts', [BlogController::class, 'index'])->name('blog.all');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    // Add other blog routes here
});

// ============================================
// FALLBACK - For local development
// ============================================
if (app()->environment('local')) {
    // Blog routes for local development
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    // Shop routes for local development
    Route::get('/shop', [FrontendProductController::class, 'index'])->name('shop.index');
    Route::get('/shop/{slug}', [FrontendProductController::class, 'show'])->name('shop.show');

    // Cart routes for local development
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout routes for local development
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');
}

// Theme route (for dark mode)
Route::post('/set-theme', function (Request $request) {
    session(['theme' => $request->theme]);
    return response()->json(['success' => true]);
})->name('set-theme');