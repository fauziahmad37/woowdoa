<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ReportTransactionController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


    // santri
Route::get('/santri/import', [SantriController::class,'importForm'])->name('santri.import.form');
Route::post('/santri/import', [SantriController::class,'import'])->name('santri.import');

Route::resource('santri', SantriController::class);
// parent
Route::resource('parent', ParentController::class);

// report transaksi santri
Route::get('/transaksi_santri', [ReportTransactionController::class,'index'])
    ->name('report.transaksi_santri');
Route::middleware('auth')->group(function () {

Route::get('/transaksi/detail/{id}', [ReportTransactionController::class, 'detail'])
    ->name('transaksi.detail');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // logout



Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

});


require __DIR__.'/auth.php';

