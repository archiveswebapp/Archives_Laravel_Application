<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\CategoryBrowseController;
use App\Http\Controllers\ProductBrowseController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProductController;

use App\Livewire\Cart as CartComponent;

/*
|--------------------------------------------------------------------------
| Auth-gated Home (verified users only)
|--------------------------------------------------------------------------
| Guests hitting "/" will be redirected to the login page by the "auth"
| middleware. Users who are logged in but not verified will be sent
| to the email verification notice by the "verified" middleware.
*/
Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

/* Safety: normalize /home -> / */
Route::get('/home', fn () => redirect()->route('home'))->name('home.alias');

/*
|--------------------------------------------------------------------------
| Authenticated + Verified user routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout (requires login + verified email)
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Cart (requires login + verified email)
    Route::get('/cart', CartComponent::class)->name('cart');
});

/*
|--------------------------------------------------------------------------
| Google OAuth
|--------------------------------------------------------------------------
*/
Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('google.redirect');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

/*
|--------------------------------------------------------------------------
| Public browsing routes
|--------------------------------------------------------------------------
| Keep category/product browsing accessible to guests.
| Checkout and Cart remain protected above.
*/
Route::get('/categories', [CategoryBrowseController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryBrowseController::class, 'show'])->name('categories.show');
Route::get('/products/{product}', [ProductBrowseController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| Auth scaffolding (login, register, verify-email, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index','show','update']);
    Route::resource('users', AdminUserController::class)->only(['index','update']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/products/{id}/feedback', [FeedbackController::class, 'store'])
        ->name('feedback.store');
});

Route::get('/products/{id}/feedback', [FeedbackController::class, 'show'])
    ->name('feedback.show');

Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
