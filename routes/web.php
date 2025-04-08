<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

// Routes for authentication (login, logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.submit'); // Handle login submission
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Handle logout

// Group routes that require password protection middleware
Route::middleware(['password.protection'])->group(function () {
    Route::get('/', [QuoteController::class, 'index'])->name('quote.index'); // Show random quote page
});
