<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\ReconcileExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportReconcileController extends Controller
{

public function index(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = DB::table('transactions')
        ->join('merchants','merchants.id','=','transactions.merchant_id')
        ->join('students','students.id','=','transactions.student_id')
        ->leftJoin('transaction_details','transaction_details.transaction_id','=','transactions.id')
        ->where('merchants.school_id',$schoolId);

    /*
    |--------------------------------------------------------------------------
    | FILTER SEARCH
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $search = $request->search;

     $query->where(function ($q) use ($search) {

    $search = strtolower($search);

    $q->whereRaw('LOWER(students.student_name) LIKE ?', ["%{$search}%"])
      ->orWhereRaw('LOWER(transactions.virtual_account_number) LIKE ?', ["%{$search}%"])
      ->orWhereRaw('LOWER(transactions.transaction_code) LIKE ?', ["%{$search}%"])
      ->orWhereRaw('LOWER(merchants.merchant_name) LIKE ?', ["%{$search}%"]);

});
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER DATE
    |--------------------------------------------------------------------------
    */

    if ($request->filled('start_date')) {
        $query->whereDate('transactions.paid_at','>=',$request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('transactions.paid_at','<=',$request->end_date);
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY RESULT
    |--------------------------------------------------------------------------
    */

   $reconcile = $query
    ->select(
        'transactions.id',
        'transactions.merchant_id',
        'transactions.student_id',
        'transactions.transaction_code',
        'transactions.virtual_account_number',
        'transactions.total_amount',
        'transactions.paid_amount',
        'transactions.status',
        'transactions.paid_at',
        'merchants.merchant_name',
        'students.student_name',
        DB::raw('COALESCE(SUM(transaction_details.amount),0) as ledger_amount'),
        DB::raw('(transactions.total_amount * 0.005) as admin_fee')
    )
        ->groupBy(
            'transactions.id',
            'transactions.transaction_code',
            'transactions.virtual_account_number',
            'transactions.total_amount',
            'transactions.paid_amount',
            'transactions.status',
            'transactions.paid_at',
            'merchants.merchant_name',
            'students.student_name'
        )
        ->orderBy('merchants.merchant_name')
        ->orderByDesc('transactions.paid_at')
        ->get();

    $grouped = $reconcile->groupBy('merchant_name');

    return view('report.reconcile', compact('reconcile','grouped'));
}
// public function detail($merchantId, $studentId)
public function detail($merchantId)
{
    $merchant = DB::table('merchants')
        ->where('id', $merchantId)
        ->first();

    // $student = DB::table('students')
    //     ->where('id', $studentId)
    //     ->first();

    $transactions = DB::table('transactions')
        ->join('transaction_details','transactions.id','=','transaction_details.transaction_id')
        ->join('students','students.id','=','transactions.student_id')
        ->join('merchants','merchants.id','=','transactions.merchant_id')

        ->where('transactions.merchant_id',$merchantId)
        // ->where('transactions.student_id',$studentId)

        ->select(
            'transactions.id',
            'transactions.transaction_code',
            'students.student_name',
            'transaction_details.amount',
            'transactions.paid_at',
            'transactions.status'
        )

        ->orderByDesc('transactions.paid_at')
        ->get();

    return view('report.reconcile_detail', [
        'transactions' => $transactions,
        'merchant_name' => $merchant->merchant_name ?? '-',
        'student_name' => $student->student_name ?? '-'
    ]);
}


// export excel

public function exportExcel(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = DB::table('transactions')
        ->join('merchants','merchants.id','=','transactions.merchant_id')
        ->join('students','students.id','=','transactions.student_id')
        ->leftJoin('transaction_details','transaction_details.transaction_id','=','transactions.id')
        ->where('merchants.school_id',$schoolId);

    if ($request->filled('search')) {

        $search = strtolower($request->search);

        $query->where(function ($q) use ($search) {
            $q->whereRaw('LOWER(students.student_name) LIKE ?', ["%{$search}%"])
              ->orWhereRaw('LOWER(transactions.virtual_account_number) LIKE ?', ["%{$search}%"])
              ->orWhereRaw('LOWER(transactions.transaction_code) LIKE ?', ["%{$search}%"])
              ->orWhereRaw('LOWER(merchants.merchant_name) LIKE ?', ["%{$search}%"]);
        });
    }

    if ($request->filled('start_date')) {
        $query->whereDate('transactions.paid_at','>=',$request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('transactions.paid_at','<=',$request->end_date);
    }

    $reconcile = $query
        ->select(
            'transactions.transaction_code',
            'transactions.virtual_account_number',
            'transactions.total_amount',
            'transactions.paid_amount',
            'transactions.status',
            'transactions.paid_at',
            'merchants.merchant_name',
            'students.student_name',
            DB::raw('COALESCE(SUM(transaction_details.amount),0) as ledger_amount'),
            DB::raw('(transactions.total_amount * 0.005) as admin_fee')
        )
        ->groupBy(
            'transactions.id',
            'transactions.transaction_code',
            'transactions.virtual_account_number',
            'transactions.total_amount',
            'transactions.paid_amount',
            'transactions.status',
            'transactions.paid_at',
            'merchants.merchant_name',
            'students.student_name'
        )
        ->orderBy('merchants.merchant_name')
        ->orderByDesc('transactions.paid_at')
        ->get();

    return Excel::download(new \App\Exports\ReconcileExport($reconcile), 'laporan_reconcile.xlsx');
}


// export pdf

public function exportPdf(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $query = DB::table('transactions')
        ->join('merchants','merchants.id','=','transactions.merchant_id')
        ->join('students','students.id','=','transactions.student_id')
        ->leftJoin('transaction_details','transaction_details.transaction_id','=','transactions.id')
        ->where('merchants.school_id',$schoolId);

    if ($request->filled('search')) {

        $search = strtolower($request->search);

        $query->where(function ($q) use ($search) {
            $q->whereRaw('LOWER(students.student_name) LIKE ?', ["%{$search}%"])
              ->orWhereRaw('LOWER(transactions.virtual_account_number) LIKE ?', ["%{$search}%"])
              ->orWhereRaw('LOWER(transactions.transaction_code) LIKE ?', ["%{$search}%"])
              ->orWhereRaw('LOWER(merchants.merchant_name) LIKE ?', ["%{$search}%"]);
        });
    }

    if ($request->filled('start_date')) {
        $query->whereDate('transactions.paid_at','>=',$request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('transactions.paid_at','<=',$request->end_date);
    }

    $reconcile = $query
        ->select(
            'transactions.transaction_code',
            'transactions.virtual_account_number',
            'transactions.total_amount',
            'transactions.paid_amount',
            'transactions.status',
            'transactions.paid_at',
            'merchants.merchant_name',
            'students.student_name',
            DB::raw('COALESCE(SUM(transaction_details.amount),0) as ledger_amount'),
            DB::raw('(transactions.total_amount * 0.005) as admin_fee')
        )
        ->groupBy(
            'transactions.id',
            'transactions.transaction_code',
            'transactions.virtual_account_number',
            'transactions.total_amount',
            'transactions.paid_amount',
            'transactions.status',
            'transactions.paid_at',
            'merchants.merchant_name',
            'students.student_name'
        )
        ->orderBy('merchants.merchant_name')
        ->orderByDesc('transactions.paid_at')
        ->get();

    $pdf = Pdf::loadView('report.reconcile_pdf', compact('reconcile'));

    return $pdf->download('laporan_reconcile.pdf');
}
}