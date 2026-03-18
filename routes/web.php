<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// 1. Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// 2. Authenticated Routes (Admin/Profile actions)
Route::middleware('auth')->group(function () {
    
    // Profile Routes (Using ProfileController)
    Route::get('/profile',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Update Booking Status
    Route::post('/booking/status',[DashboardController::class, 'updateStatus'])
        ->name('booking.status');

    // Change Password Route (Using DashboardController, NOT UserController)
    Route::post('/change-password', [DashboardController::class, 'changePassword'])
        ->name('change.password');
});

// 3. Public Booking Routes
Route::get('/',[BookingController::class, 'landing'])->name('landing');
Route::get('/book',[BookingController::class, 'create'])->name('booking.create');
Route::post('/book',[BookingController::class, 'store'])->name('booking.store');

// 4. AJAX API Routes
Route::get('/cities/search',[BookingController::class, 'searchCities'])->name('cities.search');
Route::get('/api/shoot-types/{id}',[BookingController::class, 'getShootTypes'])->name('api.shoot-types');
Route::post('/api/check-status', [BookingController::class, 'checkStatus'])->name('api.check-status');

require __DIR__.'/auth.php';