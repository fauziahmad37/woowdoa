<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\ImageUploadService;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Settlement;
use App\Models\Transaction;

class SettlementController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $settlements = Settlement::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereRaw('LOWER(settlement_code) like ?', ['%' . strtolower($request->search) . '%']);
            })
            ->latest()
            ->paginate($perPage);

        $settlements->getCollection()->transform(function ($item) {
            $item->merchant = $item->merchant;
            return $item;
        });

        return $this->successPaginate($settlements, 'List of settlements retrieved successfully');
    }

    /**
     * Process settlement for a merchant within a specified period.
     */
    public function process(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $user = auth()->user();

        // hanya admin
        if ($user->user_level_id != '1') {
            return $this->error('Unauthorized', 403);
        }

        // cek apakah sudah ada settlement untuk periode tersebut
        $existing = Settlement::where('period_start', $request->start_date)
            ->where('period_end', $request->end_date)
            ->first();
        if ($existing) {
            return $this->error('Settlement for this period already exists', 400);
        }

        // ambil transaksi yang sudah dibayar dalam periode tersebut
        $transactions = Transaction::whereDate('paid_at', '>=', $request->start_date)
            ->whereDate('paid_at', '<=', $request->end_date)
            ->get();

        // group transaksi per merchant
        $grouped = $transactions->groupBy('merchant_id');

        $settlements = [];

        foreach ($grouped as $merchantId => $merchantTransactions) {

            $total = $merchantTransactions->sum('paid_amount');

            // simpan ke tabel settlement
            $settlement = Settlement::create([
                'merchant_id' => $merchantId,
                'settlement_code' => 'SETTLEMENT-' . Str::upper(Str::random(10)),
                'period_start' => $request->start_date,
                'period_end' => $request->end_date,
                'amount' => $total,
                'status' => 'pending'
            ]);

            // update status settlement di transaksi
            Transaction::whereIn('id', $merchantTransactions->pluck('id'))->update(['settlement_id' => $settlement->id]);

            $settlements[] = $settlement;
        }

        return $this->success([
            'total_settlements' => count($settlements),
            'settlements' => $settlements
        ], 'Settlement successfully created');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImageUploadService $imageService)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ImageUploadService $imageService)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ImageUploadService $imageService)
    {
    }
}
