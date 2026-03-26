<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\MerchantUserController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MerchantCategoryController;
use App\Http\Controllers\LimitBelanjaController;
use App\Http\Controllers\ShortcutNominalController;
use App\Http\Controllers\ReportTransactionController;
use App\Http\Controllers\ReportReconcileController;
use App\Http\Controllers\DashboardTransaksiSiswaController;

use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SettlementController;

//Card
use App\Http\Controllers\CardController;
use App\Http\Controllers\CardRequestController;
use App\Http\Controllers\CardDesignController;
use App\Http\Controllers\CardLossReportController;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



// Card Management
//Route::resource('card', CardController::class);
Route::resource('card', CardController::class)->except('show');
Route::resource('cardrequest', CardRequestController::class);
Route::resource('carddesign', CardDesignController::class);
Route::resource('cardlossreport', CardLossReportController::class);

Route::get('/search-student',[SantriController::class,'search'])->name('students.search');
Route::get('/student-card/{nis}',[CardRequestController::class,'getStudentCard']);

Route::post('/cardrequest/{id}/approve',[CardRequestController::class,'approve'])->name('cardrequest.approve');
Route::post('/cardrequest/{id}/reject',[CardRequestController::class,'reject'])->name('cardrequest.reject');

Route::get('/card-print/{id}',[CardController::class,'print'])->name('cards.print');
Route::get('/card/{id}/print-front',[CardController::class,'printFront'])->name('cards.printfront');
Route::get('/card/{id}/print-back',[CardController::class,'printBack'])->name('cards.printback');
Route::get('/card/report',[CardController::class,'report'])->name('cards.report');
Route::get('/card/export-excel',[CardController::class,'exportExcel'])->name('card.export.excel');
Route::get('/card/export-pdf',[CardController::class,'exportPdf'])->name('card.export.pdf');

Route::get('/card-design/{id}/preview',[CardDesignController::class,'preview'])->name('carddesign.preview');

// shortcut nominal
Route::resource('shortcutnominal', ShortcutNominalController::class);

// merchant category
Route::resource('merchantcategory', MerchantCategoryController::class); 

// merchant
Route::resource('merchant', MerchantController::class);
Route::get('/merchant/kota/{province_id}', [MerchantController::class, 'getKota']);
Route::get('/merchant/kecamatan/{regency_id}', [MerchantController::class, 'getKecamatan']);
Route::get('/merchant/kelurahan/{district_id}', [MerchantController::class, 'getKelurahan']);

//Limit Belanja
Route::resource('limitbelanja', LimitBelanjaController::class);

// merchantuser
Route::prefix('merchant-user')->name('merchant.user.')->group(function(){
	Route::get('/',[MerchantUserController::class,'index'])->name('index');
	Route::get('/create',[MerchantUserController::class,'create'])->name('create');
	Route::post('/store',[MerchantUserController::class,'store'])->name('store');
	Route::get('/edit/{id}',[MerchantUserController::class,'edit'])->name('edit');
	Route::put('/update/{id}',[MerchantUserController::class,'update'])->name('update');
	Route::delete('/delete/{id}',[MerchantUserController::class,'destroy'])->name('destroy');

	Route::get('/get-kota/{province_id}', [MerchantUserController::class,'getKota']);
	Route::get('/get-kecamatan/{regency_id}', [MerchantUserController::class,'getKecamatan']);
	Route::get('/get-kelurahan/{district_id}', [MerchantUserController::class,'getKelurahan']);
});



//school
Route::resource('school', SchoolController::class); 

// santri
Route::get('/santri/import', [SantriController::class,'importForm'])->name('santri.import.form');
Route::post('/santri/import', [SantriController::class,'import'])->name('santri.import');
Route::resource('santri', SantriController::class);
Route::get('/parent/check-nik/{nik}', [ParentController::class, 'checkNik']);

Route::get('/santri/kota/{province_id}', [SantriController::class, 'getKota']);
Route::get('/santri/kecamatan/{regency_id}', [SantriController::class, 'getKecamatan']);
Route::get('/santri/kelurahan/{district_id}', [SantriController::class, 'getKelurahan']);

// parent
Route::get('/parent/import', [ParentController::class,'importForm'])->name('parent.import.form');
Route::post('/parent/import', [ParentController::class,'import'])->name('parent.import');
Route::resource('parent', ParentController::class);

// report transaksi santri
Route::get('/transaksi_santri', [ReportTransactionController::class,'index'])
    ->name('report.transaksi_santri');
Route::get('/transaksi/detail/{id}', [ReportTransactionController::class, 'detail'])
    ->name('transaksi.detail');
Route::get('/transaksi_santri/export/excel', [ReportTransactionController::class,'exportExcel'])
    ->name('transaksi.export.excel');

Route::get('/transaksi_santri/export/pdf', [ReportTransactionController::class,'exportPdf'])
    ->name('transaksi.export.pdf');

    
    // report reconcile
Route::get('/reconcile', [ReportReconcileController::class,'index'])
    ->name('report.reconcile');

    Route::get('/report/reconcile/export/excel',[ReportReconcileController::class,'exportExcel'])
    ->name('reconcile.export.excel');

Route::get('/report/reconcile/export/pdf',[ReportReconcileController::class,'exportPdf'])
    ->name('reconcile.export.pdf');
// Route::get('/reconcile/{merchant}', [ReportReconcileController::class,'detail'])
//     ->name('report.reconcile.detail');


//settlement
Route::resource('settlement', SettlementController::class); 
Route::post('/settlement/{id}/approve',[SettlementController::class,'approve'])->name('settlement.approve');
Route::post('/settlement/{id}/reject',[SettlementController::class,'reject'])->name('settlement.reject');

Route::get(
    '/report/reconcile/detail/{merchantId}',
    [ReportReconcileController::class, 'detail']
)->name('report.reconcile.detail');

    // dashboard
Route::get('/dashboard-transaksi-siswa', [DashboardTransaksiSiswaController::class, 'index'])
    ->name('dashboard.transaksi.siswa');

Route::middleware('auth')->group(function () {



Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



//user  
Route::resource('user', UserController::class);

//user level
Route::resource('userlevel', UserLevelController::class);



// logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

});


require __DIR__.'/auth.php';
