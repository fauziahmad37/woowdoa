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
      $startDate = request('start_date')
    ? Carbon::parse(request('start_date'))->startOfDay()
    : Carbon::now()->startOfMonth();

$endDate = request('end_date')
    ? Carbon::parse(request('end_date'))->endOfDay()
    : Carbon::now()->endOfDay();


        $schoolId = Auth::user()->school_id;
  //  dd(Carbon::now());
        // total transaksi
     $totalTransaksi = DB::table('transactions')
    ->join('students', 'students.id', '=', 'transactions.student_id')
    ->where('students.school_id', $schoolId)
    
    ->where('transactions.status', 'paid')
        ->whereBetween('transactions.created_at', [$startDate, $endDate])
    ->count();

        // total value transaksi
        
     $totalValue = DB::table('transaction_details')
    ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
    ->join('students', 'students.id', '=', 'transactions.student_id')
    ->where('students.school_id', $schoolId)
    ->where('transactions.status', 'paid')
    ->whereBetween('transactions.created_at', [$startDate, $endDate])
    ->sum('transactions.total_amount');
    
        // transaksi bulan ini
      $transaksiBulanIni = DB::table('transactions')
    ->join('students', 'students.id', '=', 'transactions.student_id')
    ->where('students.school_id', $schoolId)
    ->where('transactions.status', 'paid')
    ->whereBetween('transactions.created_at', [$startDate, $endDate])
    ->count();

        // value transaksi bulan ini
$valueBulanIni = DB::table('transactions')
    ->join('students', 'students.id', '=', 'transactions.student_id')
    ->where('students.school_id', $schoolId)
    ->where('transactions.status', 'paid')
    ->whereBetween('transactions.created_at', [$startDate, $endDate])
    ->sum('transactions.total_amount');




     
// transaksi per hari (bulan berjalan)

$start = Carbon::now()->startOfMonth();
$end = Carbon::now()->endOfDay();
$transaksiPerHari = DB::table('transactions')
    ->join('students', 'students.id', '=', 'transactions.student_id')
    ->where('students.school_id', $schoolId)
    ->where('transactions.status', 'paid')
    ->whereNotNull('transactions.paid_at')
    ->whereBetween('transactions.paid_at', [$startDate, $endDate])
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


$chartLabels = [];
$chartData = [];



// top saldo 10 tertinggi siswa
$topSaldo = DB::table('ewallets')
    ->join('students', 'students.id', '=', 'ewallets.user_id')
    ->where('students.school_id', $schoolId)
    ->where('ewallets.wallet_type', 'student')
    ->whereBetween('ewallets.created_at', [$startDate, $endDate])
    ->select(
        'students.student_name',
        'ewallets.balance'
    )
    ->orderByDesc('ewallets.balance')
    ->limit(10)
    ->get();

$saldoNames = [];
$saldoTotals = [];

foreach ($topSaldo as $row) {
    $saldoNames[] = $row->student_name;
    $saldoTotals[] = (float) $row->balance;
}

// top belanja tertinggi siswa

$topBelanja = DB::table('transactions')
    ->join('students', 'students.id', '=', 'transactions.student_id')
    ->where('students.school_id', $schoolId)
    ->where('transactions.status', 'paid')
    ->whereBetween('transactions.paid_at', [$startDate, $endDate])
    ->select(
        'students.student_name',
        DB::raw('SUM(transactions.total_amount) as total_belanja')
    )
    ->groupBy('students.student_name')
    ->orderByDesc('total_belanja')
    ->limit(10)
    ->get();

$belanjaNames = [];
$belanjaTotals = [];

foreach ($topBelanja as $row) {
    $belanjaNames[] = $row->student_name;
    $belanjaTotals[] = (float) $row->total_belanja;
}
// dd($belanjaNames, $belanjaTotals);
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
    ->whereBetween('transactions.created_at', [$startDate, $endDate])
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

    $angkatanList = DB::table('tahun_ajaran')
    ->select('tahun_ajaran.id','tahun_ajaran.tahun_ajaran')
    ->get();


$santriPerAngkatan = DB::table('students')
    ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'students.tahun_ajaran_id')
    ->where('students.school_id', $schoolId)
    ->select(
        'tahun_ajaran.id',
        'tahun_ajaran.tahun_ajaran',
        DB::raw('COUNT(students.id) as total')
    )
    ->groupBy('tahun_ajaran.id', 'tahun_ajaran.tahun_ajaran')
    ->orderByDesc('tahun_ajaran.id') 
    ->limit(10)
    ->get()
    ->sortBy('tahun_ajaran'); 

$angkatanLabels = [];
$angkatanTotal = [];

foreach ($santriPerAngkatan as $row) {
    $angkatanLabels[] = $row->tahun_ajaran;
    $angkatanTotal[] = (int) $row->total;
}

$angkatan = DB::table('students')
    ->join('tahun_ajaran', 'tahun_ajaran.id', '=', 'students.tahun_ajaran_id')
    ->where('students.school_id', $schoolId)
    ->select('tahun_ajaran.id', 'tahun_ajaran.tahun_ajaran')
    ->distinct()
    ->orderBy('tahun_ajaran.tahun_ajaran')
    ->get();


// santri by angkatan dan kelas

$tahunAjaranId = request('tahun_ajaran_id');
$classId = request('class_id');

// default null (biar gak error di blade)
$filterTotalSantri = null;
$filterSantriLaki = null;
$filterSantriPerempuan = null;
$filterSantriAktif = null;
$chartLabels = [];
$chartData = [];
if ($tahunAjaranId) {
    $filterQuery = DB::table('students')
        ->where('school_id', $schoolId)
        ->where('tahun_ajaran_id', $tahunAjaranId);

    if ($classId) {
        $filterQuery->where('class_id', $classId);
    }

    $filterTotalSantri = (clone $filterQuery)->count();

    $filterSantriLaki = (clone $filterQuery)
        ->where('gender', 'Laki-Laki')
        ->count();

    $filterSantriPerempuan = (clone $filterQuery)
        ->where('gender', 'Perempuan')
        ->count();

    $filterSantriAktif = (clone $filterQuery)
        ->where('active', true)
        ->count();

    // ✅ chart saat filter
    $chartLabels = ['Laki-laki', 'Perempuan', 'Aktif'];
    $chartData = [
        $filterSantriLaki,
        $filterSantriPerempuan,
        $filterSantriAktif
    ];

} else {
    // ✅ chart default (semua data)
    $chartLabels = ['Laki-laki', 'Perempuan', 'Aktif'];
    $chartData = [
        $santriLaki,
        $santriPerempuan,
        $santriAktif
    ];
}


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
    ->whereBetween('created_at', [$startDate, $endDate])
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
    ->whereBetween('created_at', [$startDate, $endDate])
    ->count();

    // ======================
// MERCHANT HARIAN
// ======================

$merchantPerHari = DB::table('merchants')
    ->where('school_id', $schoolId)
    ->whereBetween('created_at', [$startDate, $endDate])
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
    ->where('transactions.status','paid')
    ->whereBetween('transactions.created_at', [$startDate, $endDate])
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
    ->join('merchants', 'merchants.id', '=', 'transactions.merchant_id')
    ->where('merchants.school_id', $schoolId)
    ->whereNotNull('transactions.paid_at')
    ->whereBetween('transactions.paid_at', [$startDate, $endDate])
    ->select(
        'merchants.merchant_name',
        DB::raw('SUM(transactions.total_amount) as total_revenue')
    )
    ->groupBy('merchants.merchant_name')
    ->orderByDesc('total_revenue')
    ->limit(5)
    ->get();

foreach ($merchantRevenue as $row) {
    $merchantRevenueNames[] = $row->merchant_name;
    $merchantRevenueTotals[] = (float) $row->total_revenue;
}


// filter merchant by date







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
'merchantRevenueTotals',
'saldoNames',
    'saldoTotals',
    'belanjaNames',
    'belanjaTotals',
      'angkatanLabels',
    'angkatanTotal',
    'filterTotalSantri',
'filterSantriLaki',
'filterSantriPerempuan',
'filterSantriAktif',
'tahunAjaranId',
'classId',
'angkatan',
'chartLabels',
'chartData',
'topMerchant' ,
'merchantRevenue', 
    'angkatanList'

));
    }

    public function getKelas($tahunAjaranId)
{
    $schoolId = auth()->user()->school_id;

    $kelas = DB::table('students')
        ->join('classes', 'classes.id', '=', 'students.class_id')
        ->where('students.tahun_ajaran_id', $tahunAjaranId)
        ->where('students.school_id', $schoolId)
        ->select('classes.id', 'classes.class_name')
        ->distinct()
        ->orderBy('classes.class_name')
        ->get();

    return response()->json($kelas);
}

public function santriByAngkatan($angkatanId)
    {
        $schoolId = Auth::user()->school_id;

        $data = DB::table('students')
        ->join('classes', 'classes.id', '=', 'students.class_id')
        ->where('students.school_id', $schoolId)
        ->where('students.tahun_ajaran_id', $angkatanId)
        ->select(
        'classes.id as class_id',
        'classes.class_name',
        DB::raw('COUNT(students.id) as total'),
        )
        ->groupBy('classes.id', 'classes.class_name')
        ->orderBy('classes.class_name')
        ->get();

        // Cek dulu hasilnya
        // dd($data, $angkatanId, $schoolId);

        return response()->json([
            'labels' => $data->pluck('class_name'),
            'totals' => $data->pluck('total')->map(fn($v) => (int)$v),
        ]);
    }


}