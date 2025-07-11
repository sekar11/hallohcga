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
        $AllData = $this->StokGudangRepository->getData();
        $StokGudang = $this->StokGudangRepository->getData('Alat Tulis Kantor');
        $StokMEP = $this->StokGudangRepository->getData('Mekanikal Elektrikal');
        $StokPlumber = $this->StokGudangRepository->getData('Plumber');
        $StokSembako = $this->StokGudangRepository->getData('Sembako');
        $StokPeralatan = $this->StokGudangRepository->getData('Peralatan');
        $StokPerabotan = $this->StokGudangRepository->getData('Perabotan Rumah Tangga');
        $StokSeragam = $this->StokGudangRepository->getData('Baju Kerja');
        $NonStok = $this->StokGudangRepository->getData('Non Stock');

        return view('/gudang/gudang', [
            'AllData' => $AllData,
            'StokGudang' => $StokGudang,
            'StokMEP' => $StokMEP,
            'StokPlumber' => $StokPlumber,
            'StokSembako' => $StokSembako,
            'StokPeralatan' => $StokPeralatan,
            'StokPerabotan' => $StokPerabotan,
            'NonStok' => $NonStok,
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

    public function tambah(Request $request)
    {
        $data = $request->input('tambah');
        $tambah_id = $request->input('tambah_id');
       
        $result = $this->StokGudangRepository->tambah($data, $tambah_id);

        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function supply(Request $request)
    {
        $data = $request->input('tambah');
        $tambah_id = $request->input('tambah_id');
    //    dd($tambah_id);
        $result = $this->StokGudangRepository->supply($data, $tambah_id);

        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function getBarang($id)
    {
        $barang = $this->StokGudangRepository->getBarangById($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json([
            'nama_barang' => $barang->nama_barang,
            'kategori'    => $barang->kategori,
            'stok_awal'   => $barang->stok_awal,
        ]);
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
