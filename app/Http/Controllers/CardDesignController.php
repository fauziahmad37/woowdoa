<?php

namespace App\Http\Controllers;

use App\Models\CardDesign; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  
class LimitBelanjaController extends Controller
{
	public function update(Request $request)
	{
		$design = CardDesign::first();

		$design->update([
				'background_image'=>$request->background,
				'elements'=>json_encode($request->elements)
		]);

		return back();
	}
}
