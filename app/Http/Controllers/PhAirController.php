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

        return view('/phair/phair', [
            'PhAir' => $PhAir,
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

  
    
    
 
    public function delete(Request $request)
    {

        $phUserId = $request->input('ph_id');

        $result = $this->PhAirRepository->delete($phUserId );

        return response()->json(['message' => $result]);
    }

    public function getEdit($id)
    {
        $user = $this->PhAirRepository->getById($id);

        return response()->json($user);
    }

    public function edit($id, Request $request)
    {
        $data = $request->all();
        //dd($data);
        $result = $this->PhAirRepository->edit($data, $id);

        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function editProfile($id, Request $request)
    {
        // Validasi input
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
