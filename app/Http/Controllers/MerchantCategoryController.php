<?php

namespace App\Http\Controllers;

use App\Models\MerchantCategory;
use Illuminate\Http\Request;

class MerchantCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$query = MerchantCategory::latest();

		if ($request->search) {
				$query->where(function ($q) use ($request) {
						$q->where('mc_name', 'ilike', '%'.$request->search.'%');
				});
		}

		$merchantcategory = $query->paginate(10);

		return view('merchantcategory.index', compact('merchantcategory')); 
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$merchantcategory = null; 
		return view('merchantcategory.create', compact('merchantcategory'));			 
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate([ 
				'mc_name' => 'required' 
		]);

		MerchantCategory::create($request->all());

		return redirect()->route('merchantcategory.index')
										 ->with('success', 'Merchant Category  created successfully');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(MerchantCategory $merchantCategory)
	{
			//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(MerchantCategory $merchantcategory)
	{
		return view('merchantcategory.edit', compact('merchantcategory'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	 
 
	 
	public function update(Request $request, MerchantCategory $merchantcategory)
	{
 
		$request->validate([ 
				'mc_name' => 'required' 
		]);


		$merchantcategory->update($request->all());

		return redirect()->route('merchantcategory.index')
										 ->with('success', 'Merchant Category created successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(MerchantCategory $merchantcategory)
	{
		$merchantcategory->delete();

		return redirect()->route('merchantcategory.index')
										 ->with('success', 'Merchant Category deleted successfully');
	}
}
