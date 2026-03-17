<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Card;
use App\Services\ImageUploadService;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Settlement;
use App\Models\Transaction;
use App\Models\Ewallet;
use App\Models\WalletMovement;
use App\Models\Student;

class EwalletController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $ewallets = Ewallet::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereRaw('LOWER(wallet_code) like ?', ['%' . strtolower($request->search) . '%']);
            })
            ->latest()
            ->paginate($perPage);

        $ewallets->getCollection()->transform(function ($item) {
            $item->merchant = $item->merchant;
            return $item;
        });

        return $this->successPaginate($ewallets, 'List of ewallets retrieved successfully');
    }

    /**
     * Process top-up for a merchant's ewallet.
     */
    public function topup(Request $request)
    {
        $request->validate([
            'card_number' => 'required|exists:cards,card_number',
            'amount' => 'required|numeric|min:1',
        ]);

        $student = Student::select('students.id', 'students.student_name', 'students.nis', 'students.user_id')
            ->leftJoin('cards as c', 'students.nis', '=', 'c.nis')
            ->where('c.card_number', $request->card_number)
            ->first();

        $ewallet = Ewallet::where('user_id', $student->user_id)->first();

        // insert ke transactions
        $transaction = Transaction::create([
            'student_id' => $student->id,
            'transaction_code' => $this->generateTransactionCode(),
            'total_amount' => $request->amount,
            'paid_amount' => $request->amount,
            'status' => 'paid',
            'paid_at' => $request->created_at,
            'payment_type_id' => 5, // 5 = top-up ewallet
            'card_number' => $request->card_number,
            'trx_id_bank' => $request->trxid ?? null,
        ]);

        // insert ke wallet movements
        WalletMovement::create([
            'ewallet_id' => $ewallet->id,
            'transaction_id' => $transaction->id,
            'type' => 'credit',
            'amount' => $request->amount,
            'balance_before' => $ewallet->balance,
            'balance_after' => $ewallet->balance + $request->amount,
            'description' => 'Top-up ewallet',
        ]);

        $ewallet->balance += $request->amount;
        $ewallet->save();

        return $this->success(null, 'Ewallet topped up successfully');
    }

    /**
     * Display the balance of the authenticated user's ewallet.
     */
    public function balance(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:students,nis',
        ]);

        $student = Student::where('nis', $request->nis)->first();
        $userId = $student->user_id;
        $ewallet = Ewallet::where('user_id', $userId)->first();

        return $this->success(['balance' => $ewallet->balance], 'Ewallet balance retrieved successfully');
    }

    /**
     * Display the transaction history of the authenticated user's ewallet.
     */
    public function history(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:students,nis',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Ambil data ewallet berdasarkan nis
        $student = Student::where('nis', $request->nis)->first();
        $userId = $student->user_id;
        $ewallet = Ewallet::where('user_id', $userId)->first();
        $history = WalletMovement::where('ewallet_id', $ewallet->id)
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->success($history, 'Ewallet transaction history retrieved successfully');
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

    /**
     * Generate kode transaksi unik
     */
    function generateTransactionCode()
    {
        do {
            $code = 'TRX-' . now()->format('Ymd') . Str::upper(Str::random(6));
        } while (Transaction::where('transaction_code', $code)->exists());

        return $code;
    }
}
