<?php
use App\Http\Controllers\SosController;
use App\Http\Controllers\Api\MitraProfileController;
use App\Http\Controllers\Api\MitraFotoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

// ================== SOS ==================
Route::get('/sos', [SosController::class, 'index']);              
Route::post('/sos/approve', [SosController::class, 'approve'])->name('sos.approve');
Route::post('/sos/assign', [SosController::class, 'assignTechnician']); 
Route::post('/proxy/teknisi', [SosController::class, 'proxyTeknisi']);
Route::post('/sos/teknisi-confirm', [SosController::class, 'teknisiConfirm'])->name('sos.teknisiConfirm');
Route::post('/mitra/profile', [MitraProfileController::class, 'show']);
Route::post('/mitra/foto-selfie', [MitraFotoController::class, 'update']);
