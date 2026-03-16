<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{ 	
		$school = School::where('id',  Auth::user()->school_id)->first();
		return view('school.index', compact('school'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
			//
	}



	/**
	 * Display the specified resource.
	 */
	public function show(School $school)
	{
			//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(School $school)
	{
			//
	}

	public function update(Request $request, School $school)
	{ 
		$school->update($request->all());
		return redirect()->route('school.index')
										 ->with('success', 'Profil pesantren berhasil diupdate');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(School $school)
	{
			//
	}
}
