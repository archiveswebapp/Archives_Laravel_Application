<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;


// API Rate Limiters
// Fixes "Rate limiter [api] is not defined" and gives separate read/write buckets.
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('api-reads', function (Request $request) {
    return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('api-writes', function (Request $request) {
    return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
});


// API Routes

// PUBLIC (read-only)
Route::middleware(['throttle:api-reads'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']); // 👈 NEW: single product endpoint
});

// AUTHENTICATED (Sanctum)
Route::middleware(['auth:sanctum'])->group(function () {
    // Reads for the authenticated user
    Route::middleware('throttle:api-reads')->group(function () {
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
    });

    // Writes with fine-grained abilities + write limiter
    Route::middleware('throttle:api-writes')->group(function () {
        Route::middleware('abilities:cart:write')->post('/cart', [CartController::class, 'store']);
        Route::middleware('abilities:orders:write')->post('/orders', [OrderController::class, 'store']);
    });

    // Token revocation (delete the *current* access token)
    Route::post('/logout-tokens', function (Request $request) {
        $request->user()->currentAccessToken()?->delete();
        return response()->noContent(); // 204
    });

    // Optional: revoke *all* tokens for the user
    Route::delete('/tokens', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->noContent(); // 204
    });
});
