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
		$query = CardRequest::with(['student','requester'])
													->where('school_id',Auth::user()->school_id);

		if ($request->search) {
				$query->where(function ($q) use ($request) {
						$q->where('nis', 'ilike', '%'.$request->search.'%')
							->orWhere('status', 'ilike', '%'.$request->search.'%')
							->orWhere('reason', 'ilike', '%'.$request->search.'%') ;
				});
		}

		$cardrequest = $query->latest()->paginate(10);

		return view('cardrequest.index', compact('cardrequest')); 
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
        'old_card_id'=>$oldCard->id,
        'school_id'=>Auth::user()->school_id,
        'status'=>'pending',
        'requested_by'=>$user->username
    ]);
 
		return redirect()->route('cardrequest.index')->with('success', 'Pengajuan berhasil');
	}

	public function approve($id)
	{

		$request = CardRequest::findOrFail($id);

		DB::transaction(function() use ($request){

		if($request->reason != 'new' && $request->old_card_id){ 
			Card::where('id',$request->old_card_id)
					->update([
							'status'=>'inactive'
					]);
		}

		$number = app(CardService::class)
							->generateNumber($request->student_id);

		Card::create([
				'nis'=>$request->nis,
				'card_number'=>$number,
				'status'=>'active',
				'reason'=>$request->reason
		]);

		$request->update([
				'status'=>'approved',
				'approved_by'=>auth()->id(),
				'approved_at'=>now()
		]);

		});

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
