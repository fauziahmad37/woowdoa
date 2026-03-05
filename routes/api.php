<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NotificationController;
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

        // Profile
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/profile', [UserController::class, 'profile']);
        Route::get('/users/profile_merchant', [UserController::class, 'profileMerchant']);
        Route::get('/users/profile_merchant_owner', [UserController::class, 'profileMerchantOwner']);
        Route::get('/users/profile_merchant_leader', [UserController::class, 'profileMerchantLeader']);
        Route::post('/users/reset-password', [UserController::class, 'resetPassword']);

        // Route::apiResource('projects', ProjectController::class);
        Route::apiResource('news', NewsController::class);
        Route::apiResource('events', EventsController::class);

        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::post('transactions/scan', [TransactionController::class, 'scan'])->name('transactions.scan');
        Route::post('transactions/pay', [TransactionController::class, 'pay'])->name('transactions.pay');
        Route::get('transactions/code/{code}', [TransactionController::class, 'showByCode'])->name('transactions.showByCode');
        Route::post('/bank/callback', [BankController::class, 'callback']);

        // Contacts
        Route::get('/contacts', [ChatController::class, 'contacts']);

        // Conversations
        Route::get('/conversations', [ChatController::class, 'conversations']);
        Route::post('/conversations', [ChatController::class, 'startConversation']);

        // Messages
        Route::get('/conversations/{conversation}', [ChatController::class, 'getMessages']);
        Route::post('/messages', [ChatController::class, 'sendMessage']);

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::patch('/notifications/{id}/status', [NotificationController::class, 'updateStatus']);
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
