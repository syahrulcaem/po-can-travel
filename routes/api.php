<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;

// Public routes
Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

// Search schedules (public)
Route::get('/search/schedules', [SearchController::class, 'searchSchedules']);

// Public bus and review data
Route::get('/buses', [BusController::class, 'index']);
Route::get('/buses/{bus}', [BusController::class, 'show']);
Route::get('/reviews', [ReviewController::class, 'index']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy']);

    // User orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel']);

    // User reviews
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::get('/reviews/{review}', [ReviewController::class, 'show']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
});

// Admin routes (will be implemented later with admin middleware)
Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('buses', BusController::class)->except(['index', 'show']);
    Route::apiResource('routes', RouteController::class);
    Route::apiResource('schedules', ScheduleController::class);
});
