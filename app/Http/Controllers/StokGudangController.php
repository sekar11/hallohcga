<?php

namespace App\Http\Controllers;
use App\Http\Repository\StokGudangRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class StokGudangController extends Controller
{
    protected $StokGudangRepository;

    public function __construct(StokGudangRepository $StokGudangRepository)
    {
        $this->StokGudangRepository = $StokGudangRepository;
    }


    public function index()
    {
        $categories = $this->StokGudangRepository->getCategories();
        $units = $this->StokGudangRepository->getUnits();
        $StokGudang = $this->StokGudangRepository->getData('Alat Tulis Kantor');
        $StokMEP = $this->StokGudangRepository->getData('Mekanikal Elektrikal');
        $StokPlumber = $this->StokGudangRepository->getData('Plumber');
        $StokSembako = $this->StokGudangRepository->getData('Sembako');
        $StokPeralatan = $this->StokGudangRepository->getData('Peralatan');
        $StokPerabotan = $this->StokGudangRepository->getData('Perabotan Rumah Tangga');
        $StokSeragam = $this->StokGudangRepository->getData('Baju Kerja');

        return view('/gudang/gudang', [
            'StokGudang' => $StokGudang,
            'StokMEP' => $StokMEP,
            'StokPlumber' => $StokPlumber,
            'StokSembako' => $StokSembako,
            'StokPeralatan' => $StokPeralatan,
            'StokPerabotan' => $StokPerabotan,
            'StokSeragam' => $StokSeragam,
            'categories' => $categories,
            'units' => $units,
        ]);
    }


    public function add(Request $request)
    {
        $data = $request->except('_token');
        $data = $request->all();
        
        $result = $this->StokGudangRepository->createData($data);

        if ($result) {
            return Response::json(['status' => 'success']);
        } else {
            return Response::json(['status' => 'error']);
        }

    }
 
 
    public function delete(Request $request)
    {

        $barangId = $request->input('barang_id');

        $result = $this->StokGudangRepository->delete($barangId );

        return response()->json(['message' => $result]);
    }

    public function getEdit($id)
    {
        $user = $this->StokGudangRepository->getById($id);
        return response()->json($user);
    }

    public function edit($id, Request $request)
    {
        $data = $request->all();
        //dd($data);
        $result = $this->StokGudangRepository->edit($data, $id);

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

        $result = $this->StokGudangRepository->editProfile($request, $id);
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
