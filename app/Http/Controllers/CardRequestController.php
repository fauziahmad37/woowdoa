<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Card; 
use App\Models\CardRequest; 
use App\Models\Santri; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  
class CardRequestController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
	//	echo Auth::user()->user_level_id;
		$query = CardRequest::with(['student','requester'])
													->where('school_id',Auth::user()->school_id);

		if ($request->search) {
				$query->where(function ($q) use ($request) {
						$q->where('nis', 'ilike', '%'.$request->search.'%')
							->orWhere('status', 'ilike', '%'.$request->search.'%')
							->orWhere('student_name', 'ilike', '%'.$request->search.'%')
							->orWhere('reason', 'ilike', '%'.$request->search.'%') ;
				});
		}

		$cardrequest = $query->latest()->paginate(10);
		$user_level = Auth::user()->user_level_id;
		return view('cardrequest.index', compact('cardrequest','user_level')); 
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$students = Santri::orderBy('student_name')
													->where('school_id',Auth::user()->school_id)->get();
//var_dump($students);
//exit;
		return view('cardrequest.create',compact('students')); 	 
	}

	public function edit($id)
	{
		$cardrequest = CardRequest::with(['student','oldCard'])
                    ->findOrFail($id);

		return view('cardrequest.edit',compact('cardrequest')); 	 		
	}

	public function getStudentCard($nis)
	{ 
		$card = Card::where('nis',$nis)
						->where('status','active')->get()
						->first();

		if(!$card){
				return response()->json([
						'card_number' => null
				]);
		}

		return response()->json([
				'card_number' => $card->card_number
		]); 
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{

		$student = Santri::where('nis',$request->nis)->firstOrFail();
		$user = User::where('id',auth()->id())->firstOrFail();

    $oldCard = Card::where('nis',$request->nis)
                ->where('status','active')
                ->first();
								

    CardRequest::create([
        'nis'=>$request->nis,
        'reason'=>$request->reason,
        'old_card_id'=>$oldCard->id ?? null,
        'school_id'=>Auth::user()->school_id,
        'status'=>'pending',
        'requested_by'=>$user->username
    ]);
 
		return redirect()->route('cardrequest.index')->with('success', 'Pengajuan berhasil');
	}

 
	public function update(Request $request,$id)
	{
		$cardRequest = CardRequest::findOrFail($id);

		if($cardRequest->status != 'pending'){
				return back()->with('error','Request tidak bisa diubah');
		}

		$request->validate([
				'reason'=>'required'
		]);
    $oldCard = Card::where('nis',$request->nis)
                ->where('status','active')
                ->first();
								
		$cardRequest->update([
        'nis'=>$request->nis,		
				'reason'=>$request->reason,
        'old_card_id'=>$oldCard->id ?? null,
		]);

		return redirect()->route('cardrequest.index')->with('success','Request berhasil diupdate');

	}

	
	public function approve($id)
	{ 
		$requestCard = CardRequest::findOrFail($id);

		if($requestCard->status != 'pending'){
			return back()->with('error','Request sudah diproses');
		}

		/*
		NONAKTIFKAN KARTU LAMA
		*/

		if($requestCard->old_card_id){ 
			Card::where('id',$requestCard->old_card_id)
					->update([
							'status'=>'inactive',
							'reason'=>$requestCard->reason
					]);
		}

		/*
		GENERATE NOMOR KARTU BARU
		*/
		$lastCard = Card::where('nis',$requestCard->nis)
				->orderBy('id','desc')
				->first();
		$number = $lastCard ? $lastCard->sequence + 1 : 1;
		
	
		$cardNumber = $requestCard->nis.'-'.str_pad($number,3,'0',STR_PAD_LEFT);

		/*
		SIMPAN KARTU BARU
		*/
		Card::create([
			'nis'=>$requestCard->nis,
			'card_number'=>$cardNumber, 
      'sequence'=>$number,
			'status'=>'active',
			'school_id'=>$requestCard->school_id
		]);
	//echo 	$number; exit;
		/*
		UPDATE REQUEST
		*/

		$requestCard->update([
			'status'=>'approved',
			'approved_by'=>Auth::id(),
			'approved_at'=>now()
		]);

		return back()->with('success','Request berhasil di approve');

	}
	
	public function reject(Request $request,$id)
	{

			$cardRequest = CardRequest::findOrFail($id);

			$cardRequest->update([
					'status'=>'rejected',
					'approved_by'=>Auth::id(),
					'approved_at'=>now(),
					'approval_note'=>$request->note
			]);

			return back()->with('success','Request ditolak');

	}	
	
	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(CardRequest $cardrequest)
	{
		$cardrequest->delete();

		return redirect()->route('cardrequest.index')
										 ->with('success', 'Card Request deleted successfully');
	}	
}
