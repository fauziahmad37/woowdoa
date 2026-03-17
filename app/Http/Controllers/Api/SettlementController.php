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
        $request->validate([
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
        ]);

        $perPage = $request->input('per_page', 10);

        $settlements = Settlement::query()
            ->when($request->search, function ($query) use ($request) {
                $query->whereRaw('LOWER(settlement_code) like ?', ['%' . strtolower($request->search) . '%']);
            })
            ->when($request->start_date, function ($query) use ($request) {
                $query->where('created_at', '>=', \Carbon\Carbon::parse($request->start_date)->startOfDay());
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->where('created_at', '<=', \Carbon\Carbon::parse($request->end_date)->endOfDay());
            })
            ->latest()
            ->paginate($perPage);

        return $this->successPaginate($settlements, 'List of settlements retrieved successfully');
    }

    /**
     * Process settlement for a merchant within a specified period.
     */
    public function process(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $user = auth()->user();

        // hanya merchant owner & kasir yang bisa melakukan settlement
        if (!in_array($user->user_level_id, ['2', '3'])) {
            return $this->error('Unauthorized', 403);
        }

        $settlement = Settlement::create([
            'merchant_id' => $user->merchant_id,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);






        return $this->success($settlement, 'Settlement processed successfully');
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
