<?php


// Redirect root to shop
Route::get("/", function () {
    return redirect("/shop");
});
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendProductController;
use Illuminate\Support\Facades\Route;

//  Blog 
Route::get('/', [BlogController::class, 'home'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::post('/blog/{post:slug}/comment', [BlogController::class, 'storeComment'])->name('blog.comment');

// â”€â”€ Shop â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
Route::get('/shop', [FrontendProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [FrontendProductController::class, 'show'])->name('shop.show');
Route::get('/storage/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    return response()->file($fullPath);
})->where('path', '.*')->name('storage.serve');

//  Cart 
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// â”€â”€ Checkout â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/order/success', [CheckoutController::class, 'success'])->name('order.success');

Route::post('/set-theme', function (Request $request) {
    session(['theme' => $request->theme]);
    return response()->json(['success' => true]);
})->name('set-theme');

// SHOP ROUTES - For shop.[domain].com
// ============================================
Route::domain('shop.yourdomain.com')->group(function () {
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

// BLOG ROUTES - For blog.[domain].com
// ============================================
Route::domain('blog.yourdomain.com')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    });

// ============================================
// FALLBACK - For local development
// ============================================
if (app()->environment('local')) {
    // Your existing local routes
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/shop', [FrontendProductController::class, 'index'])->name('shop.index');
}

if (env('SERVICE_ROLE') === 'shop') {
    // Shop routes only
    Route::get('/{any}', [FrontendProductController::class, 'index'])->where('any', '.*');
} elseif (env('SERVICE_ROLE') === 'blog') {
    // Blog routes only
    Route::get('/{any}', [BlogController::class, 'index'])->where('any', '.*');
}