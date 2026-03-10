<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
      

        $schoolId = Auth::user()->school_id;
  //  dd(Carbon::now());
        // total transaksi
        $totalTransaksi = DB::table('transactions')
            ->join('students', 'students.id', '=', 'transactions.student_id')
            ->where('students.school_id', $schoolId)
            ->count();

        // total value transaksi
        $totalValue = DB::table('transaction_details')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('students', 'students.id', '=', 'transactions.student_id')
            ->where('students.school_id', $schoolId)
            ->sum('transaction_details.amount');

        // transaksi bulan ini
        $transaksiBulanIni = DB::table('transactions')
            ->join('students', 'students.id', '=', 'transactions.student_id')
            ->where('students.school_id', $schoolId)
            ->whereMonth('transactions.created_at', now()->month)
            ->whereYear('transactions.created_at', now()->year)
            ->count();

        // value transaksi bulan ini
        $valueBulanIni = DB::table('transactions')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('students', 'students.id', '=', 'transactions.student_id')
            ->where('students.school_id', $schoolId)
            ->whereMonth('transactions.created_at', now()->month)
            ->whereYear('transactions.created_at', now()->year)
            ->sum('transaction_details.amount');




     
// transaksi per hari (bulan berjalan)

$start = Carbon::now()->startOfMonth();
$end = Carbon::now()->endOfDay();
$transaksiPerHari = DB::table('transactions')
    ->join('students', 'students.id', '=', 'transactions.student_id')
    ->where('students.school_id', $schoolId)
    ->whereNotNull('transactions.paid_at')
    ->whereBetween('transactions.paid_at', [$start, $end])
    ->selectRaw('EXTRACT(DAY FROM transactions.paid_at)::int as hari, COUNT(*) as total')
    ->groupByRaw('EXTRACT(DAY FROM transactions.paid_at)')
    ->orderByRaw('EXTRACT(DAY FROM transactions.paid_at)')
    ->pluck('total','hari');

// dd($transaksiPerHari);
$days = [];
$jumlahPerHari = [];

$today = Carbon::now()->day;

for ($i = 1; $i <= $today; $i++) {
    $days[] = $i;
    $jumlahPerHari[] = $transaksiPerHari[$i] ?? 0;
}


// ======================
// SISWA TOPUP BULAN INI
// ======================

// total siswa
$totalSantri = DB::table('students')
    ->where('school_id', $schoolId)
    ->count();


// siswa yang sudah topup bulan ini
$santriTopup = DB::table('transactions')
    ->join('students', 'students.id', '=', 'transactions.student_id')
    ->where('students.school_id', $schoolId)
    ->whereMonth('transactions.created_at', now()->month)
    ->whereYear('transactions.created_at', now()->year)
    ->distinct('transactions.student_id')
    ->count('transactions.student_id');


// siswa yang belum topup
$santriBelumTopup = $totalSantri - $santriTopup;

// dashboarad pesantren
// untuk filter santri


$totalSantri = DB::table('students')
    ->where('school_id', $schoolId)
    ->count();

$santriLaki = DB::table('students')
    ->where('school_id', $schoolId)
    ->where('gender','Laki-Laki')
    ->count();

$santriPerempuan = DB::table('students')
    ->where('school_id', $schoolId)
    ->where('gender','Perempuan')
    ->count();

$santriAktif = DB::table('students')
    ->where('school_id', $schoolId)
    ->where('active', true)
    ->count();
$santriPerTingkat = DB::table('students')
    ->join('classes', 'classes.id', '=', 'students.class_id')
    ->where('students.school_id', $schoolId)
    ->selectRaw("
        SUBSTRING(classes.class_name FROM '^[0-9]+')::int as tingkat,
        SUM(CASE WHEN students.gender = 'Laki-Laki' THEN 1 ELSE 0 END) as laki,
        SUM(CASE WHEN students.gender = 'Perempuan' THEN 1 ELSE 0 END) as perempuan
    ")
    ->groupByRaw("SUBSTRING(classes.class_name FROM '^[0-9]+')")
    ->orderByRaw("SUBSTRING(classes.class_name FROM '^[0-9]+')")
    ->get();
    

    $tingkat = [];
$laki = [];
$perempuan = [];


// ======================
// DATA TEACHER
// ======================

$totalTeacher = DB::table('teachers')
    ->where('school_id', $schoolId)
    ->count();

$teacherLaki = DB::table('teachers')
    ->where('school_id', $schoolId)
    ->where('gender', 'Laki-Laki')
    ->count();

$teacherPerempuan = DB::table('teachers')
    ->where('school_id', $schoolId)
    ->where('gender', 'Perempuan')
    ->count();

$teacherAktif = DB::table('teachers')
    ->where('school_id', $schoolId)
    ->where('active', true)
    ->count();

foreach ($santriPerTingkat as $row) {
    $tingkat[] = "Kelas ".$row->tingkat;
    $laki[] = (int) $row->laki;
    $perempuan[] = (int) $row->perempuan;
}



// ======================
// DATA MERCHANT
// ======================

// total merchant
$totalMerchant = DB::table('merchants')
    ->where('school_id', $schoolId)
    ->count();


// merchant hari ini
$merchantHariIni = DB::table('merchants')
    ->where('school_id', $schoolId)
    ->whereDate('created_at', Carbon::today())
    ->count();


// merchant aktif
$merchantAktif = DB::table('merchants')
    ->where('school_id', $schoolId)
    ->where('is_active', true)
    ->count();


    // ======================
// MERCHANT HARIAN
// ======================

$merchantPerHari = DB::table('merchants')
    ->where('school_id', $schoolId)
    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfDay()])
    ->selectRaw('EXTRACT(DAY FROM created_at)::int as hari, COUNT(*) as total')
    ->groupByRaw('EXTRACT(DAY FROM created_at)')
    ->orderByRaw('EXTRACT(DAY FROM created_at)')
    ->pluck('total','hari');

$merchantDays = [];
$merchantJumlah = [];

$today = Carbon::now()->day;

for ($i = 1; $i <= $today; $i++) {
    $merchantDays[] = $i;
    $merchantJumlah[] = $merchantPerHari[$i] ?? 0;
}


// ======================
// TOP MERCHANT TRANSAKSI
// ======================

$merchantNames = [];
$merchantTotals = [];

$topMerchant = DB::table('transactions')
    ->join('merchants', 'merchants.id', '=', 'transactions.merchant_id')
    ->where('merchants.school_id', $schoolId)
    ->select(
        'merchants.merchant_name',
        DB::raw('COUNT(transactions.id) as total')
    )
    ->groupBy('merchants.merchant_name')
    ->orderByDesc('total')
    ->limit(5)
    ->get();

foreach ($topMerchant as $row) {
    $merchantNames[] = $row->merchant_name;
    $merchantTotals[] = (int) $row->total;
}


// pendapatan merchant

// ======================
// PENDAPATAN MERCHANT
// ======================

$merchantRevenueNames = [];
$merchantRevenueTotals = [];

$merchantRevenue = DB::table('transactions')
    ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
    ->join('merchants', 'merchants.id', '=', 'transactions.merchant_id')
    ->where('merchants.school_id', $schoolId)
    ->whereNotNull('transactions.paid_at')
    ->select(
        'merchants.merchant_name',
        DB::raw('SUM(transaction_details.amount) as total_revenue')
    )
    ->groupBy('merchants.merchant_name')
    ->orderByDesc('total_revenue')
    ->limit(5)
    ->get();

foreach ($merchantRevenue as $row) {
    $merchantRevenueNames[] = $row->merchant_name;
    $merchantRevenueTotals[] = (float) $row->total_revenue;
}

// ======================
// TOTAL MERCHANT
// ======================

$totalMerchant = DB::table('merchants')
    ->where('school_id', $schoolId)
    ->count();

$merchantTotalLabel = ['Total Merchant'];
$merchantTotalData = [$totalMerchant];

   return view('dashboard', compact(
    'totalTransaksi',
    'totalValue',
    'transaksiBulanIni',
    'valueBulanIni',
    'days',
    'jumlahPerHari',
    'totalSantri',
    'santriLaki',
    'santriPerempuan',
    'santriAktif',
    'santriPerTingkat',
    'tingkat',
    'laki',
    'perempuan',
    'santriTopup',
'santriBelumTopup',

    // teacher
    'totalTeacher',
    'teacherLaki',
    'teacherPerempuan',
    'teacherAktif',

       // merchant
    'totalMerchant',
    'merchantHariIni',
    'merchantAktif',
    'merchantDays',
 'merchantTotalLabel',
    'merchantTotalData',
    'merchantDays',
    'merchantJumlah',
    'merchantNames',
    'merchantTotals',
'merchantRevenueNames',
'merchantRevenueTotals'
));
    }
}