<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;

class DashboardTransaksiSiswaController extends Controller
{
    public function index()
    {
        // jumlah semua transaksi
        $jumlahTransaksi = Transaction::count();

        // total value transaksi
        $valueTransaksi = Transaction::sum('total_amount');

        // jumlah transaksi bulan ini
        $jumlahTransaksiBulanIni = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        return view('dashboard.dashboard_transaksi_siswa', compact(
            'jumlahTransaksi',
            'valueTransaksi',
            'jumlahTransaksiBulanIni'
        ));
    }
}