<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Admin\DashboardController; // <--- Make sure this is imported
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// 1. Dashboard Route (Using the Controller we just made)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. THIS IS THE MISSING ROUTE causing the error
    Route::post('/booking/status', [DashboardController::class, 'updateStatus'])
        ->name('booking.status');
});

// Booking Routes
Route::get('/', [BookingController::class, 'landing'])->name('landing');
Route::get('/book', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::get('/cities/search', [BookingController::class, 'searchCities'])->name('cities.search');

// Change Password Route
// Route::post('/change-password', [UserController::class,'changePassword'])->name('change.password');
Route::post('/change-password', [UserController::class, 'changePassword'])
    ->middleware('auth')
    ->name('change.password');

Route::get('/api/shoot-types/{id}',[BookingController::class, 'getShootTypes'])->name('api.shoot-types');
    
require __DIR__.'/auth.php';