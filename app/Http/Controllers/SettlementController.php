<?php

namespace App\Http\Controllers;

use App\Models\Settlement;  
use App\Models\WalletMovement;  
use App\Models\Ewallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
	
class SettlementController extends Controller
{
 
	public function index(Request $request)
	{
		$query = Settlement::with(['merchant','ewallet']);
		if ($request->search) {
				$search = $request->search; 
				$query->where(function ($q) use ($request) {
						$q->where('merchant_name', 'ilike', '%'.$request->search.'%');
				}); 
		}

		$settlement = $query->latest()->paginate(20); 

		$user_level = Auth::user()->user_level_id;
		return view('settlement.index', compact('settlement','user_level'));
	}
 
	public function approve($id)
	{ 
	
		$setreq = Settlement::findOrFail($id);
		$setreq->update([
			'status'=>'approved',
			'approved_by'=>Auth::id(),
			'approved_at'=>now()
		]); 
		$ewallet = Ewallet::where('user_id', $setreq->user_id_owner)->first();	
			 
    WalletMovement::create([
			'transaction_id',
			'type'=>'debit',
			'ewallet_id'=>$ewallet->id,
			'amount'=>$setreq->amount,
			'balance_before' => $ewallet->balance,
			'balance_after' => $ewallet->balance + $setreq->amount,
			'description'=>'Penarikan dana seniai '.$setreq->amount,
			'approved_by'=>Auth::id(),
			'approved_at'=>now() 
    ]);
	
		$ewallet->update([
			'balance'=>$ewallet->balance-$setreq->amount 
		]); 	
		return back()->with('success','Request berhasil di approve');
		
	}
	public function reject($id)
	{ 
		$setreq = Settlement::findOrFail($id);

		$setreq->update([
				'status'=>'rejected',
				'approved_by'=>Auth::id(),
				'approved_at'=>now() 
		]);

		return back()->with('success','Request ditolak');	
	}	
}
