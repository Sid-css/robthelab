<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Only keep Login routes for now
    Route::get('login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    // Keep Logout route
    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');
});