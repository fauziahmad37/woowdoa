<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
    $search = strtolower($request->search);

    $query->whereHas('student', function ($q) use ($search) {
        $q->whereRaw('LOWER(student_name) LIKE ?', ["%{$search}%"])
          ->orWhereRaw('LOWER(nis) LIKE ?', ["%{$search}%"]);
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

    $wallet = DB::table('wallet_movements')
        ->where('transaction_id', $id)
        ->first();

    return view('report.detail_transaksi', compact('transaction','wallet'));
}


// report excel 

public function exportExcel(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = Transaction::with(['student','merchant'])
        ->whereHas('student', function ($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        });

    if ($request->search) {
        $query->whereHas('student', function ($q) use ($request) {
            $q->where('student_name','like','%'.$request->search.'%')
              ->orWhere('nis','like','%'.$request->search.'%');
        });
    }

    if ($request->start_date) {
        $query->whereDate('paid_at','>=',$request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('paid_at','<=',$request->end_date);
    }

    $transactions = $query->orderBy('paid_at','desc')->get();

    return Excel::download(new TransactionExport($transactions), 'laporan_transaksi_santri.xlsx');
}

// report pdf

public function exportPdf(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = Transaction::with(['student','merchant'])
        ->whereHas('student', function ($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        });

    if ($request->search) {
        $query->whereHas('student', function ($q) use ($request) {
            $q->where('student_name','like','%'.$request->search.'%')
              ->orWhere('nis','like','%'.$request->search.'%');
        });
    }

    if ($request->start_date) {
        $query->whereDate('paid_at','>=',$request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('paid_at','<=',$request->end_date);
    }

    $transactions = $query->orderBy('paid_at','desc')->get();

    $pdf = Pdf::loadView('report.transaksi_pdf', compact('transactions'));

    return $pdf->download('laporan_transaksi_santri.pdf');
}

}