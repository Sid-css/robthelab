<?php

use App\Http\Controllers\ProfileController;
// UPDATE THIS LINE to the new folder:
use App\Http\Controllers\Booking\BookingController; 
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Booking Routes
Route::get('/', [BookingController::class, 'landing'])->name('landing');
Route::get('/book', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
// Add this new route for searching cities
Route::get('/cities/search', [BookingController::class, 'searchCities'])->name('cities.search');

require __DIR__.'/auth.php';