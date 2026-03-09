<?php

namespace App\Http\Controllers;

use App\Models\ShortcutNominal;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class ShortcutNominalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 	
			$shortcutnominal = ShortcutNominal::where('school_id',  Auth::user()->school_id)->first();
			return view('shortcutnominal.index', compact('shortcutnominal'));
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
    public function show(ShortcutNominal $shortcutNominal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortcutNominal $shortcutNominal)
    {
        //
    }

	public function update(Request $request, ShortcutNominal $shortcutnominal)
	{ 
		$shortcutnominal->update($request->all());

		return redirect()->route('shortcutnominal.index')
										 ->with('success', 'Shortcut Nominal saved successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(ShortcutNominal $shortcutNominal)
	{
			//
	}
}
