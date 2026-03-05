<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaction;

class ReportTransactionController extends Controller
{
   public function index(Request $request)
{
    $query = Transaction::with(['student','merchant']);

    // Search Nama / NIS
    if ($request->search) {
        $search = $request->search;

        $query->whereHas('student', function ($q) use ($search) {
            $q->where('student_name', 'like', "%$search%")
              ->orWhere('nis', 'like', "%$search%");
        });
    }

    // Filter Start Date
    if ($request->start_date) {
        $query->whereDate('transaction_date', '>=', $request->start_date);
    }

    // Filter End Date
    if ($request->end_date) {
        $query->whereDate('transaction_date', '<=', $request->end_date);
    }

    $transactions = $query->orderBy('transaction_date','desc')->paginate(10);

    return view('report.transaksi_santri', compact('transactions'));
}


    public function detail($id)
{
    $transaction = Transaction::with(['student','merchant'])->findOrFail($id);

    return view('report.detail_transaksi', compact('transaction'));
}
}