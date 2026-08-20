<?php

use App\Http\Controllers\FrontendProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// ============================================
// SHOP ROUTES 
// ============================================
Route::domain('webwhat-shop-1gd8.onrender.com')->group(function () {
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
    Route::post('/billplz/callback', [CheckoutController::class, 'callback'])->name('billplz.callback');
    Route::get('/billplz/redirect', [CheckoutController::class, 'redirect'])->name('billplz.redirect');

    // Invoice routes
    Route::get('/order/{order_number}/invoice', [CheckoutController::class, 'invoice'])->name('order.invoice');
    Route::get('/order/{order_number}/invoice/download', [CheckoutController::class, 'invoiceDownload'])->name('order.invoice.download');
});

// ============================================
// BLOG ROUTES 
// ============================================
Route::domain('webwhat-blog.onrender.com')->group(function () {
    Route::get('/', [BlogController::class, 'home'])->name('blog.index');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.all');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    // Add other blog routes here
});

// ============================================
// FALLBACK - For local development
// ============================================
if (app()->environment('local')) {
   
    Route::get('/', [BlogController::class, 'index'])->name('local.blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('local.blog.show');

    Route::get('/shop', [FrontendProductController::class, 'index'])->name('local.shop.index');
    Route::get('/shop/{slug}', [FrontendProductController::class, 'show'])->name('local.shop.show');

    Route::get('/cart', [CartController::class, 'index'])->name('local.cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('local.cart.add');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('local.cart.remove');
    Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('local.cart.update');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('local.cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('local.checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('local.checkout.process');
    Route::get('/order/success', [CheckoutController::class, 'success'])->name('local.order.success');
    Route::post('/billplz/callback', [CheckoutController::class, 'callback'])->name('local.billplz.callback');
    Route::get('/billplz/redirect', [CheckoutController::class, 'redirect'])->name('local.billplz.redirect');

    Route::get('/order/{order_number}/invoice', [CheckoutController::class, 'invoice'])->name('local.order.invoice');
    Route::get('/order/{order_number}/invoice/download', [CheckoutController::class, 'invoiceDownload'])->name('local.order.invoice.download');
}


// Theme route (for dark mode)
Route::post('/set-theme', function (Request $request) {
    session(['theme' => $request->theme]);
    return response()->json(['success' => true]);
})->name('set-theme');