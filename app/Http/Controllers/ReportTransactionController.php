<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ReportTransactionController extends Controller
{
  
public function index(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = Transaction::with(['student','merchant'])
        ->whereHas('student', function ($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        });

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
        $query->whereDate('paid_at', '>=', $request->start_date);
    }

    // Filter End Date
    if ($request->end_date) {
        $query->whereDate('paid_at', '<=', $request->end_date);
    }

    $transactions = $query->orderBy('paid_at','desc')->paginate(10);

    return view('report.transaksi_santri', compact('transactions'));
}


public function detail($id)
{
    $transaction = Transaction::with([
        'student',
        'merchant',
        'details'
    ])->findOrFail($id);

    return view('report.detail_transaksi', compact('transaction'));
}

}