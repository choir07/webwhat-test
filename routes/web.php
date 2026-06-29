<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Frontend Blog Routes
Route::get('/', [BlogController::class, 'home'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::post('/blog/{post:slug}/comment', [BlogController::class, 'storeComment'])->name('blog.comment');
// routes/web.php
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/cloudinary-test', [App\Http\Controllers\CloudinaryController::class, 'uploadImage']);