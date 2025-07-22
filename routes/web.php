<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\AdminRouteController;
use App\Http\Controllers\Admin\AdminScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/search/schedules', [SearchController::class, 'searchSchedulesWeb'])->name('search.schedules');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'indexWeb'])->name('orders.index');
    Route::get('/orders/create/{schedule}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'storeWeb'])->name('orders.store');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/upload-payment-proof', [OrderController::class, 'uploadPaymentProof'])->name('orders.upload-payment-proof');

    // Buses
    Route::get('/buses', [App\Http\Controllers\Web\WebBusController::class, 'index'])->name('buses.index');
    Route::get('/buses/{bus}', [App\Http\Controllers\Web\WebBusController::class, 'show'])->name('buses.show');

    // Reviews
    Route::get('/buses/{bus}/reviews', [App\Http\Controllers\Web\WebReviewController::class, 'index'])->name('reviews.index');
    Route::get('/buses/{bus}/reviews/create', [App\Http\Controllers\Web\WebReviewController::class, 'create'])->name('reviews.create');
    Route::post('/buses/{bus}/reviews', [App\Http\Controllers\Web\WebReviewController::class, 'store'])->name('reviews.store');
    Route::get('/buses/{bus}/reviews/edit', [App\Http\Controllers\Web\WebReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/buses/{bus}/reviews', [App\Http\Controllers\Web\WebReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/buses/{bus}/reviews', [App\Http\Controllers\Web\WebReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Authentication
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/payment-confirmations', [AdminController::class, 'paymentConfirmations'])->name('payment.confirmations');
        Route::post('/orders/{order}/confirm-payment', [AdminController::class, 'confirmPayment'])->name('orders.confirm-payment');
        Route::post('/orders/{order}/reject-payment', [AdminController::class, 'rejectPayment'])->name('orders.reject-payment');
        Route::get('/orders/{order}', [AdminController::class, 'viewOrder'])->name('orders.view');

        // Bus Management
        Route::resource('buses', BusController::class);

        // Route Management  
        Route::resource('routes', AdminRouteController::class);

        // Schedule Management
        Route::resource('schedules', AdminScheduleController::class);
    });
});

require __DIR__ . '/auth.php';
