<?php

namespace App\Http\Controllers\Api;

use App\Services\FirebaseService;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\ImageUploadService;
use App\Http\Controllers\Controller;
use App\Models\ReportCard;
use App\Models\ReportCardDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\News;
use App\Models\Student;
use App\Models\TahunAjaran;

class ReportCardController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
        ]);

        $student = Student::where('nis', $request->nis)->first();

        if (!$student) {
            return $this->error(null, 'Student tidak ditemukan', 404);
        }

        $tahunAjaran = TahunAjaran::where('is_active', true)->first();

        $reportCards = ReportCard::where('student_id', $student->id)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->first();

        $reportCardDetails = ReportCardDetail::where('report_card_id', $reportCards->id)
            ->get();

        $reportCards->student_name = $student->student_name;
        $reportCards->nis = $student->nis;
        $reportCards->tahun_ajaran = $tahunAjaran->tahun_ajaran;
        $reportCards->semester = $tahunAjaran->semester;
        $reportCards->details = $reportCardDetails;
        

        return $this->success($reportCards, 'List of report cards retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImageUploadService $imageService)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ImageUploadService $imageService)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ImageUploadService $imageService)
    {
    }
}
