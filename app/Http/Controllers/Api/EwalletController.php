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

        // insert ke wallet movements
        WalletMovement::create([
            'ewallet_id' => $ewallet->id,
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
            'card_number' => 'required|exists:cards,card_number',
        ]);

        $cardNumber = Card::where('card_number', $request->card_number)->first();
        $userId = $cardNumber->student->user_id;
        $ewallet = Ewallet::where('user_id', $userId)->first();

        return $this->success(['balance' => $ewallet->balance], 'Ewallet balance retrieved successfully');
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
