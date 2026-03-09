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

    // teacher
    'totalTeacher',
    'teacherLaki',
    'teacherPerempuan',
    'teacherAktif'
));
    }
}