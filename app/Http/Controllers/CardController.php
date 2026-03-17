<?php

namespace App\Http\Controllers;

use App\Models\Card; 
use App\Models\CardDesign; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\CardExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
	
class CardController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
public function index(Request $request)
{
    $query = Card::with('student');

    if ($request->search) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('nis', 'ILIKE', "%{$search}%")
              ->orWhere('card_number', 'ILIKE', "%{$search}%")
              ->orWhereHas('student', function ($s) use ($search) {
                    $s->where('student_name', 'ILIKE', "%{$search}%");
              });
        });
    }

    $card = $query->latest()->paginate(20);
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
		$card = Card::with('user')->findOrFail($id);
		$design = CardDesign::first();
		$front = json_decode($design->front_elements, true);
		$back = json_decode($design->back_elements, true);
 
		return view('cards.print',compact('card','design','front','back'));
	}
	 
	 
	public function printFront($id)
	{ 
		$card = Card::with('user')->findOrFail($id);
		$design = CardDesign::first(); 
		$front = json_decode($design->front_elements, true);
		return view('cards.print-front',compact('card','design','front')); 
	}

	public function printBack($id)
	{ 
		$card = Card::with('user')->findOrFail($id);
		$design = CardDesign::first(); 
		$back = json_decode($design->back_elements, true);
		return view('cards.print-back',compact('card','design','back')); 
	}


public function report(Request $request)
{
    $query = Card::query()
        ->leftJoin('students', 'students.nis', '=', 'cards.nis')
        ->select('cards.*', 'students.student_name');

    if ($request->search) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('cards.nis', 'ILIKE', "%{$search}%")
              ->orWhere('cards.card_number', 'ILIKE', "%{$search}%")
              ->orWhere('cards.status', 'ILIKE', "%{$search}%")
              ->orWhere('students.student_name', 'ILIKE', "%{$search}%");
        });
    }

    $cards = $query->orderBy('cards.created_at','desc')->paginate(20);

    return view('cards.report', compact('cards'));
}


	// export excel
	public function exportExcel(Request $request)
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

		$cardreport = $query->get();

		return Excel::download(new \App\Exports\CardExport($cardreport), 'laporan_kartu.xlsx');
	}


	// export pdf

	public function exportPdf(Request $request)
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

		$cardreport = $query->get();

		$pdf = Pdf::loadView('card.reportpdf', compact('cardreport'));

		return $pdf->download('laporan_kartu.pdf');
	}
}
