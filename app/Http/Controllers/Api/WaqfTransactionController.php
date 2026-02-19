<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WaqfTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WaqfTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = WaqfTransaction::orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'transaction_type' => 'required|in:wakaf,sadaqah,infaq',
            'purpose' => 'nullable|string',
            'payment_method' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $transaction = WaqfTransaction::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Transaksi wakaf berhasil dibuat',
            'data' => $transaction,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = WaqfTransaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $transaction,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = WaqfTransaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'donor_name' => 'sometimes|required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'sometimes|required|numeric|min:0',
            'transaction_type' => 'sometimes|required|in:wakaf,sadaqah,infaq',
            'purpose' => 'nullable|string',
            'payment_method' => 'nullable|string|max:50',
            'payment_status' => 'sometimes|required|in:pending,completed,failed',
            'paid_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $transaction->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Transaksi wakaf berhasil diperbarui',
            'data' => $transaction,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = WaqfTransaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi wakaf berhasil dihapus',
        ]);
    }
}
