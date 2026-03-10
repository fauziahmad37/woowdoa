<?php

namespace App\Http\Controllers;

use App\Models\Card; 
use App\Models\CardDesign; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  
class CardController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$query = Card::with(['student']);

		if ($request->search) {
				$query->where(function ($q) use ($request) {
						$q->where('nis', 'ilike', '%'.$request->search.'%')
							->orWhere('status', 'ilike', '%'.$request->search.'%')
							->orWhere('student_name', 'ilike', '%'.$request->search.'%')
							->orWhere('card_number', 'ilike', '%'.$request->search.'%') ;
				});
		}

		$card = $query->latest()->paginate(10);
		$user_level = Auth::user()->user_level_id;
		return view('cards.index', compact('card','user_level')); 
	}

 
	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate([ 
				'class_level' => 'required',
				'daily_limit' => 'required|numeric',
				'monthly_limit' => 'required|numeric'
		]);

		LimitBelanja::create($request->all());

		return redirect()->route('limitbelanja.index')
										 ->with('success', 'Limit Belanja created successfully');
	}

	public function print($id)
	{
		$card = Card::with('student')->findOrFail($id);
		$design = CardDesign::first();
		return view('card.print',compact('card','design'));
	}
	 
}
