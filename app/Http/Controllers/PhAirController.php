<?php

namespace App\Http\Controllers;
use App\Http\Repository\PhAirRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class PhAirController extends Controller
    {
        protected $PhAirRepository;

        public function __construct(PhAirRepository $PhAirRepository)
        {
            $this->PhAirRepository = $PhAirRepository;
        }


        public function index()
        {
            $PhAir= $this->PhAirRepository->getData();
            $Dosing= $this->PhAirRepository->getDataDosing('Clean Water');
            $Raw= $this->PhAirRepository->getDataDosing('Raw Water');
            $DosingPac= $this->PhAirRepository->getDataDosingPac();
            return view('/phair/phair', [
                'PhAir' => $PhAir,
                'Dosing' => $Dosing,
                'Raw' => $Raw,
                'DosingPac' => $DosingPac,
            ]);
        }



        public function add(Request $request)
        {
            $data = $request->except('_token');
            $data = $request->all();
            //dd($data);
            $result = $this->PhAirRepository->createData($data);



            if ($result) {
                return Response::json(['status' => 'success']);
            } else {
                return Response::json(['status' => 'error']);
            }

        }

        
        public function addDosing(Request $request)
        {
            $data = $request->except('_token');
            $data = $request->all();
          
            $result = $this->PhAirRepository->createDataDosing($data);

            if ($result) {
                return Response::json(['status' => 'success']);
            } else {
                return Response::json(['status' => 'error']);
            }

        }

          public function addDosingPac(Request $request)
        {
            $data = $request->except('_token');
            $data = $request->all();       
            $result = $this->PhAirRepository->createDataDosingPac($data);

            if ($result) {
                return Response::json(['status' => 'success']);
            } else {
                return Response::json(['status' => 'error']);
            }

        }

        public function getMeterAkhirSiang(Request $request)
        {
            $tanggal = $request->tanggal;
            $lokasi = $request->lokasi;
            $jenis = $request->jenis;

            $data = $this->PhAirRepository->getMeterAkhirShiftSiang($tanggal, $lokasi, $jenis);

            return response()->json([
                'meter_akhir' => $data ? $data->meter_akhir : null
            ]);
    }

    public function delete(Request $request)
    {

        $phUserId = $request->input('ph_id');

        $result = $this->PhAirRepository->delete($phUserId );

        return response()->json(['message' => $result]);
    }

    public function deleteDosing(Request $request)
    {

        $dosingId = $request->input('dosing_id');
        $result = $this->PhAirRepository->deleteDosing($dosingId);

        return response()->json(['message' => $result]);
    }

    public function deleteDosingPac(Request $request)
    {

        $dosingId = $request->input('dosing_id');
        $result = $this->PhAirRepository->deleteDosingPac($dosingId);

        return response()->json(['message' => $result]);
    }


    public function getEdit($id)
    {
        $user = $this->PhAirRepository->getById($id);
    
        return response()->json($user);
    }

    public function getEditDosing($id)
    {
        $dosing = $this->PhAirRepository->getByIdDosing($id);

        return response()->json($dosing);
    }

    public function getEditDosingPac($id)
    {
        $dosingpac = $this->PhAirRepository->getByIdDosingPac($id);

        return response()->json($dosingpac);
    }

    public function edit($id, Request $request)
    {
        $data = $request->all();
      
        $result = $this->PhAirRepository->edit($data, $id);

        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function editDosing($id, Request $request)
    {
        $data = $request->all();
        
        $result = $this->PhAirRepository->editDosing($data, $id);

        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function editDosingPac($id, Request $request)
    {
        $data = $request->all();
        // dd($data);
        $result = $this->PhAirRepository->editDosingPac($data, $id);
// dd($result);
        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function editProfile($id, Request $request)
    {
        $validatedData = $request->validate([
            'baju' => 'required|string|max:100',
            'sepatu' => 'nullable|string|max:100',
            'celana' => 'nullable|string|max:100',
            'rompi' => 'nullable|string|max:100',
        ]);

        $result = $this->PhAirRepository->editProfile($request, $id);
        $user = Auth::user();

        if ($result) {
            return response()->json([
                'status' => 'success',
                'id_role' => $user->id_role,
            ]);
        } else {
            return response()->json(['status' => 'error']);
        }
    }


}
