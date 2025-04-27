<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\ComplainRepository;
use App\Http\Repository\PhAirRepository;
use App\Http\Repository\CateringRepository;
use App\Http\Repository\LapCateringDeptRepository;
use App\Http\Repository\LapCateringRepository;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{

    protected $ComplainRepository;
    protected $PhRepository;
    protected $CateringRepository;
    protected $LapCateringRepository;
    protected $LapCateringDeptRepository;

    public function __construct(ComplainRepository $ComplainRepository, PhAirRepository $PhAirRepository, CateringRepository $CateringRepository, LapCateringRepository $LapCateringRepository, LapCateringDeptRepository $LapCateringDeptRepository )
    {
        $this->ComplainRepository = $ComplainRepository;
        $this->PhRepository = $PhAirRepository;
        $this -> CateringRepository = $CateringRepository;
        $this -> LapCateringRepository = $LapCateringRepository;
        $this ->LapCateringDeptRepository = $LapCateringDeptRepository;
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
        $area = $request->query('area');

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
         $data = $this->PhRepository->getPhAirData($tanggalAwal, $tanggalAkhir);
         return response()->json($data);
     }

    public function getPhAirPer(Request $request)
    {
        $tanggalAwal = $request->input('tanggalAwal');
        $tanggalAkhir = $request->input('tanggalAkhir');
        $lokasi = $request->input('lokasi');

        $data = $this->PhRepository->getPhAirDataPer($tanggalAwal, $tanggalAkhir, $lokasi);

        return response()->json($data);
    }

    //=============================================== DASHBOARD MK CATERING ===============================================

    public function mkCatering(Request $request)
    {
         $startDate = $request->input('start_date');
         $endDate = $request->input('end_date');

         $pelatihanQuery = $this->ComplainRepository->getAllWithDate();

         if ($startDate && $endDate) {
             $pelatihanQuery->whereBetween('waktu', [$startDate, $endDate]);
         }

         $pelatihanData = $pelatihanQuery->get();

         return view('/dashboard/mk_dashboard', [
             'pelatihanData' => $pelatihanData,
             'startDate' => $startDate,
             'endDate' => $endDate,

         ]);
    }

    public function getPlanActualOrderData(Request $request)
    {
        $departemen = $request->departemen ?? 'HCGA'; // default: hcga
        $tanggalAwal = $request->tanggalAwal ?? Carbon::now()->startOfMonth()->toDateString(); // default: tanggal 1 bulan ini
        $tanggalAkhir = $request->tanggalAkhir ?? Carbon::now()->toDateString();

        $result = $this->CateringRepository->getGrafikDailyDept($departemen, $tanggalAwal, $tanggalAkhir);

        return response()->json($result);
    }

    public function getPlanActualOrderDataMess(Request $request)
    {

        $mess = $request->input('mess');
        $tanggalAwal = $request->tanggalAwal ?? Carbon::now()->startOfMonth()->toDateString(); // default: tanggal 1 bulan ini
        $tanggalAkhir = $request->tanggalAkhir ?? Carbon::now()->toDateString();

        $result = $this->CateringRepository->getGrafikDailyMess($mess, $tanggalAwal, $tanggalAkhir);

        return response()->json($result);
    }

    public function getPlanActualOrderDataMonthly(Request $request)
    {
        //dd($request->all());
        $departemen = $request->input('departemenMonthly');
        $bulanAwal = $request->input('bulanAwal');
        $bulanAkhir = $request->input('bulanAkhir');
        $tahun = $request->input('tahun');

        $result = $this->CateringRepository->getGrafikMonthlyDept($departemen, $bulanAwal, $bulanAkhir, $tahun);

        return response()->json($result);
    }

    public function getPlanActualOrderDataMonthlyAllDept(Request $request)
    {
        //dd($request->all());
        $bulan = $request->input('bulanDept');
        $tahun = $request->input('tahunAllDept');

        $result = $this->CateringRepository->getGrafikMonthlyAllDept($bulan, $tahun);

        return response()->json($result);
    }

    public function getPlanActualOrderDataMonthlyMess(Request $request)
    {
        $mess = $request->input('messMonthly');
        $bulanAwal = $request->input('bulanAwalMess');
        $bulanAkhir = $request->input('bulanAkhirMess');
        $tahun = $request->input('tahunMess');

        $result = $this->CateringRepository->getGrafikMonthlyMess($mess, $bulanAwal, $bulanAkhir, $tahun);

        return response()->json($result);
    }

    public function getPlanActualOrderDataMonthlyAllMess(Request $request)
    {
        //
        $bulan = $request->input('bulanMess');
        $tahun = $request->input('tahunAllMess');

        $result = $this->CateringRepository->getGrafikMonthlyAllMess($bulan, $tahun);

        return response()->json($result);
    }

    public function getPlanActualOrderDataAllCost(Request $request)
    {
        //dd($request->all());
        $tanggalAwal = $request->tanggalAwalAllCost ?? Carbon::now()->startOfMonth()->toDateString(); // default: tanggal 1 bulan ini
        $tanggalAkhir = $request->tanggalAkhirAllCost ?? Carbon::now()->toDateString();

        $result = $this->CateringRepository->getGrafikDailyAllCost($tanggalAwal, $tanggalAkhir);

        return response()->json($result);
    }


}


