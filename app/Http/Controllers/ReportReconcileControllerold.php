<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportReconcileController extends Controller
{
   public function index(Request $request)
{
    $schoolId = Auth::user()->school_id;

    $search = $request->search;
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $query = DB::table('transactions')
        ->join('transaction_details','transactions.id','=','transaction_details.transaction_id')
        ->join('merchants','merchants.id','=','transactions.merchant_id')
        ->join('students','students.id','=','transactions.student_id')
        ->where('merchants.school_id', $schoolId);

    if ($search) {
        $query->where('merchants.merchant_name','ilike',"%$search%");
    }

    if ($startDate && $endDate) {
        $query->whereBetween('transactions.created_at',[$startDate,$endDate]);
    }

    $reconcile = $query
        ->select(
            'merchants.id as merchant_id',
            'merchants.merchant_name',

            DB::raw('COUNT(transactions.id) as total_transaksi'),

            DB::raw('SUM(transaction_details.amount) as total_amount'),

            DB::raw("
                SUM(
                    CASE 
                        WHEN transactions.status = 'paid'
                        THEN transaction_details.amount
                        ELSE 0
                    END
                ) as total_paid
            "),

            DB::raw("
                SUM(
                    CASE 
                        WHEN transactions.status = 'pending'
                        THEN transaction_details.amount
                        ELSE 0
                    END
                ) as total_pending
            ")
        )
        ->groupBy('merchants.id','merchants.merchant_name')
        ->orderBy('merchants.merchant_name')
        ->get();

    return view('report.reconcile',compact(
        'reconcile',
        'search',
        'startDate',
        'endDate'
    ));
}

public function detail($merchantId)
{
    $merchant = DB::table('merchants')
        ->where('id', $merchantId)
        ->first();

    $transactions = DB::table('transactions')
        ->join('transaction_details','transactions.id','=','transaction_details.transaction_id')
        ->join('students','students.id','=','transactions.student_id')
        ->join('merchants','merchants.id','=','transactions.merchant_id')
        ->where('transactions.merchant_id',$merchantId)
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
        'merchant_name' => $merchant->merchant_name ?? '-'
    ]);
}
}