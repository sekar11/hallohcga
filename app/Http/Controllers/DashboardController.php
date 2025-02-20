<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\ComplainRepository;
use App\Http\Repository\PhAirRepository;
use App\Http\Repository\CoachingRepository;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpParser\Node\Stmt\Return_;
use Barryvdh\DomPDF\Facade as PDFFacade;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use PhpOffice\PhpWord\Writer\PDF as WriterPDF;
use PhpOffice\PhpWord\Writer\PDF\DomPDF;
use PhpOffice\PhpWord\IOFactory;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\Writer\PDF\MPDF as PDFMPDF;

class DashboardController extends Controller
{

    protected $ComplainRepository;
    protected $PhRepository;


    public function __construct(ComplainRepository $ComplainRepository, PhAirRepository $PhAirRepository)
    {
        $this->ComplainRepository = $ComplainRepository;
        $this->PhAirRepository = $PhAirRepository;
    }

    public function getMayorCount()
    {

        $mayorCount = $this->ComplainRepository->getMayorCount_();

        return response()->json([
            'mayor_count' => $mayorCount
        ]);
    }

    public function getMinorCount()
    {

        $minorCount = $this->ComplainRepository->getMinorCount_();

        return response()->json([
            'minor_count' => $minorCount
        ]);
    }

    public function getPrioritasCount()
    {

        $prioritasCount = $this->ComplainRepository->getPrioritasCount_();

        return response()->json([
            'prioritas_count' => $prioritasCount
        ]);
    }

    public function getPendingCount()
    {

        $pendingCount = $this->ComplainRepository->getpendingCount_();

        return response()->json([
            'pending_count' => $pendingCount
        ]);
    }

    public function getTotalCount()
    {

        $totalCount = $this->ComplainRepository->getTotalCount_();

        return response()->json([
            'total_count' => $totalCount
        ]);
    }

    public function getProgresCount()
    {

        $progresCount = $this->ComplainRepository->getProgresCount_();

        return response()->json([
            'progres_count' => $progresCount
        ]);
    }

    public function getDoneCount()
    {

        $doneCount = $this->ComplainRepository->getDoneCount_();

        return response()->json([
            'done_count' => $doneCount
        ]);
    }

    public function filterComplain(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $filters = [
            'total_count' => $this->ComplainRepository->getTotalCount($tanggalAwal, $tanggalAkhir),
            'progres_count' => $this->ComplainRepository->getProgresCount($tanggalAwal, $tanggalAkhir),
            'done_count' => $this->ComplainRepository->getDoneCount($tanggalAwal, $tanggalAkhir),
            'prioritas_count' => $this->ComplainRepository->getPrioritasCount($tanggalAwal, $tanggalAkhir),
            'mayor_count' => $this->ComplainRepository->getMayorCount($tanggalAwal, $tanggalAkhir),
            'minor_count' => $this->ComplainRepository->getMinorCount($tanggalAwal, $tanggalAkhir),
            'pending_count' => $this->ComplainRepository->getPendingCount($tanggalAwal, $tanggalAkhir),
        ];

        return response()->json($filters);
    }

    public function reportPelatihan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $pelatihanQuery = $this->ComplainRepository->getAllWithDate();

        if ($startDate && $endDate) {
            $pelatihanQuery->whereBetween('waktu', [$startDate, $endDate]);
        }

        $pelatihanData = $pelatihanQuery->get();

        return view('/dashboard/dashboard', [
            'pelatihanData' => $pelatihanData,
            'startDate' => $startDate,
            'endDate' => $endDate,

        ]);
    }

    public function reportComplain(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        $query = $this->ComplainRepository->getAllWithDate();
        if ($startDate && $endDate) {
            $query->whereBetween('complain.tanggal', [$startDate, $endDate]);
        }

        $complainData = $query->get();

        return view('dashboard/dashboard', [
            'coachingData' => $complainData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function getComplainData(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('status');
        $area = $request->query('area'); // Tambahkan area

        $data = $this->ComplainRepository->getFilteredComplains($startDate, $endDate, $status, $area);
        return response()->json($data);
    }

    public function getComplainDataArea(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $status = $request->query('statusarea');

        $data = $this->ComplainRepository->getFilteredComplainsArea($startDate, $endDate, $status);
        return response()->json($data);
    }

     //=============================================== DASHBOARD PH AIR ===============================================

     public function phAir(Request $request)
     {
         $startDate = $request->input('start_date');
         $endDate = $request->input('end_date');
 
         $pelatihanQuery = $this->ComplainRepository->getAllWithDate();
 
         if ($startDate && $endDate) {
             $pelatihanQuery->whereBetween('waktu', [$startDate, $endDate]);
         }
 
         $pelatihanData = $pelatihanQuery->get();
 
         return view('/dashboard/phair', [
             'pelatihanData' => $pelatihanData,
             'startDate' => $startDate,
             'endDate' => $endDate,
 
         ]);
     }

     public function getPhAir(Request $request)
     {
         $tanggalAwal = $request->input('tanggalAwal');
         $tanggalAkhir = $request->input('tanggalAkhir');
     
         // Debug untuk cek apakah tanggal masuk
         //dd($tanggalAwal, $tanggalAkhir);
     
         $data = $this->PhAirRepository->getPhAirData($tanggalAwal, $tanggalAkhir);
         return response()->json($data);
     }
     
}


