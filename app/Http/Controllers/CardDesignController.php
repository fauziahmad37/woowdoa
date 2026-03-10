<?php

namespace App\Http\Controllers;

use App\Models\LimitBelanja;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  
class LimitBelanjaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$query = LimitBelanja::where('school_id',Auth::user()->school_id);

		if ($request->search) {
				$query->where(function ($q) use ($request) {
						$q->where('daily_limit', 'ilike', '%'.$request->search.'%')
							->orWhere('monthly_limit', 'ilike', '%'.$request->search.'%')
							->orWhere('class_level', 'ilike', '%'.$request->search.'%');
				});
		}

		$limitbelanja = $query->latest()->paginate(10);

		return view('limitbelanja.index', compact('limitbelanja')); 
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$limitbelanja = null;//LimitBelanja::where('school_id',  Auth::user()->school_id)->first();
		$classlevel = Classes::select('class_level')->groupBy('class_level')->orderBy('class_level')->get();
		return view('limitbelanja.create', compact('limitbelanja','classlevel'));			 
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

	/**
	 * Display the specified resource.
	 */
	public function show(LimitBelanja $limitbelanja)
	{
			//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(LimitBelanja $limitbelanja)
	{ 		 
		$classlevel = Classes::select('class_level')->groupBy('class_level')->orderBy('class_level')->get();		
		return view('limitbelanja.edit', compact('limitbelanja','classlevel'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, LimitBelanja $limitbelanja)
	{
		$request->validate([ 
				'class_level' => 'required',
				'daily_limit' => 'required|numeric',
				'monthly_limit' => 'required|numeric'
		]);


		$limitbelanja->update($request->all());

		return redirect()->route('limitbelanja.index')
										 ->with('success', 'Limit Belanja created successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(LimitBelanja $limitbelanja)
	{
		$limitbelanja->delete();

		return redirect()->route('limitbelanja.index')
										 ->with('success', 'limit belanja deleted successfully');
	}
}
