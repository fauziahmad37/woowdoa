<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::post('register', '\App\Http\Controllers\Api\AuthController@register');
Route::post('login', '\App\Http\Controllers\Api\AuthController@login');

Route::post('/forgot-password', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', '\App\Http\Controllers\Api\AuthController@logout');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')
    ->as('v1.')
    ->middleware(['auth:sanctum'])
    ->group(function () {

        // Route::get('/projects/search/{title}', [ProjectController::class, 'search'])
        //     ->name('projects.search');

        // Route::apiResource('projects', ProjectController::class);
        Route::apiResource('news', NewsController::class);
    });

Route::group(
    [
        'namespace' => '\App\Http\Controllers\Api\V1\Admin',
        'prefix' => 'v1/admin',
        'as' => 'v1.admin.',
        'middleware' => ['auth:api']
    ],
    function () {
        Route::get('/projects/search/{title}', 'ProjectController@search')->name('projects.search');
        Route::apiResource('projects', 'ProjectController');
    }
);
