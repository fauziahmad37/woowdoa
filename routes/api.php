<?php

use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\WaqfTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// News routes
Route::apiResource('news', NewsController::class);

// Event routes
Route::apiResource('events', EventController::class);

// Waqf Transaction routes
Route::apiResource('waqf-transactions', WaqfTransactionController::class);
