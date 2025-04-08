<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Define a route to get a random quote, secured with 'api.token' middleware
Route::middleware('api.token')->get('/quotes', [QuoteController::class, 'getRandomQuote']);
