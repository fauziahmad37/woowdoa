<?php

namespace App\Http\Controllers;

use App\Models\CardDesign; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  
class CardDesignController extends Controller
{
	
	/**
	 * Display a listing of the resource.
	 */
	/*public function index(Request $request)
	{
		$query = CardDesign::latest();

		if ($request->search) {
				$query->where(function ($q) use ($request) {
						$q->where('name', 'ilike', '%'.$request->search.'%');
				});
		}

		$carddesign = $query->paginate(10);

		return view('carddesign.index', compact('carddesign')); 
	}*/
	public function index()
	{ 	
		$carddesign = CardDesign::where('school_id',  Auth::user()->school_id)->first();
		return view('carddesign.edit', compact('carddesign'));
	}
	
	
	public function update(Request $request,$id)
	{
    $design = CardDesign::findOrFail($id);
    if($request->hasFile('front_background')){
        $front = 'storage/'.$request->file('front_background')->store('cards','public');
    }else{
        $front = $design->front_background;
    }

    if($request->hasFile('back_background')){
        $back = 'storage/'.$request->file('back_background')->store('cards','public');
    }else{
        $back = $design->back_background;
    }

    $design->update([
        'name'=>$request->name,
        'front_background'=>$front,
        'back_background'=>$back  
    ]);
		
		return redirect()->route('carddesign.index')
										 ->with('success', 'Card Design updated successfully');
	}
	
	/*
	public function update(Request $request)
	{
		$design = CardDesign::first();

		$design->update([
				'front_background'=>$request->background,
				'front_background'=>$request->background,
				'back_background'=>$request->background,
				'elements'=>json_encode($request->elements)
		]);

		return back();
	}*/
	
	public function store(Request $request)
	{

    $background = null;

    if($request->hasFile('background_image')){
        $background = $request->file('background_image')
        ->store('card_design','public');
    }

    $elements = [
        'photo'=>[
            'left'=>$request->photo_left,
            'top'=>$request->photo_top,
            'width'=>$request->photo_width,
            'height'=>$request->photo_height
        ],
        'name'=>[
            'left'=>$request->name_left,
            'top'=>$request->name_top,
            'font_size'=>$request->name_size
        ],
        'nis'=>[
            'left'=>$request->nis_left,
            'top'=>$request->nis_top,
            'font_size'=>$request->nis_size
        ],
        'card_number'=>[
            'left'=>$request->card_left,
            'top'=>$request->card_top,
            'font_size'=>$request->card_size
        ]
    ];

    CardDesign::create([
        'name'=>$request->name,
        'background_image'=>$background,
        'width'=>$request->width,
        'height'=>$request->height,
        'elements'=>json_encode($elements)
    ]);

    return redirect()->route('card-design.index');
	}
	
	public function preview($id)
	{ 
		$design = CardDesign::findOrFail($id);
		$elements = json_decode($design->elements,true);

		// dummy student untuk preview
		$student = (object)[
				'name' => 'Ahmad Fauzi',
				'nis' => '20240001',
				'photo' => 'images/sample-student.jpg'
		];

		$card = (object)[
				'card_number' => '20240001-001'
		];

		return view('card_design.preview',compact(
				'design',
				'elements',
				'student',
				'card'
		));

	}	
}
