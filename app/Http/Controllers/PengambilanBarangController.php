<?php

namespace App\Http\Controllers;
use App\Http\Repository\PengambilanBarangRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengambilanBarangController extends Controller
{
    protected $PengambilanBarangRepository;

    public function __construct(PengambilanBarangRepository $PengambilanBarangRepository)
    {
        $this->PengambilanBarangRepository = $PengambilanBarangRepository;
    }


    public function index()
    {
        $categories = $this->PengambilanBarangRepository->getCategories();
        $items = $this->PengambilanBarangRepository->getItems();
        $units = $this->PengambilanBarangRepository->getUnits();
        $PengambilanBarang = $this->PengambilanBarangRepository->getData();

        return view('/gudang/pengambilan', [
            'PengambilanBarang' => $PengambilanBarang,
            'categories' => $categories,
            'units' => $units,
            'items' => $items,
        ]);
    }

    public function getStock($id)
    {
        $item = DB::table('items_barang')->where('id', $id)->first();
        return response()->json(['stock' => $item->stock ?? 0]);
    }

    public function add(Request $request)
    {
        $userTeam = auth()->user()->dept;
        $userNama = auth()->user()->username;
        $data = $request->except('_token');

        $result = $this->PengambilanBarangRepository->createData($data);

        if ($result) {
            $userTeam = auth()->user()->dept;
            $userNama = auth()->user()->nama;

            $messageUser = "PENGAMBILAN BARANG\n\n";
            $messageUser .= "Halo Admin HCGA\n\n";
            $messageUser .= "Terdapat data pengambilan barang oleh $userNama $userTeam yang baru diajukan\n\n";
            $messageUser .= "KETERANGAN LEBIH LANJUT\n";
            $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
            $messageUser .= "https://hallohcga.com/";

            $nomorTujuan = [
                '082181777455',
                '082281634184',
                '08982208304'
            ]; 
            foreach ($nomorTujuan as $nomor) {
                $this->sendWhatsAppMessage($nomor, $messageUser);
            }

            return Response::json(['status' => 'success']);
        } else {
            return Response::json(['status' => 'error']);
        }

    }
 
 
    public function delete(Request $request)
    {

        $barangId = $request->input('barang_id');

        $result = $this->PengambilanBarangRepository->delete($barangId );

        return response()->json(['message' => $result]);
    }

    public function getEdit($id)
    {
        $user = $this->PengambilanBarangRepository->getById($id);
        return response()->json($user);
    }

    public function edit($id)
    {
        $request = DB::table('requests')->where('id', $id)->first();

        if (!$request) {
            return response()->json(['status' => 'error', 'message' => 'Request tidak ditemukan']);
        }

        $items = DB::table('request_items')
            ->where('request_id', $id)
            ->join('items_barang', 'request_items.item_id', '=', 'items_barang.id')
            ->join('units_barang', 'request_items.unit_id', '=', 'units_barang.id')
            ->select(
                'request_items.item_id',
                'items_barang.name as name',
                'request_items.quantity',
                'request_items.unit_id',
                'units_barang.name as unit_name',
                'items_barang.stock as stock'
            )
            ->get();

        $all_items = DB::table('items_barang')->select('id', 'name', 'stock')->get();
        $units = DB::table('units_barang')->select('id', 'name')->get();

        return response()->json([
            'status' => 'success',
            'request' => $request,
            'items' => $items,
            'all_items' => $all_items,
            'units' => $units
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Ambil data yang tidak null saja
            $updateData = [];

            if ($request->filled('area')) {
                $updateData['area'] = $request->area;
            }
            if ($request->filled('gedung')) {
                $updateData['gedung'] = $request->gedung;
            }
            if ($request->filled('lokasi')) {
                $updateData['lokasi'] = $request->lokasi;
            }
            if ($request->filled('keterangan')) {
                $updateData['keterangan'] = $request->keterangan;
            }

            if (!empty($updateData)) {
                DB::table('requests')
                    ->where('id', $id)
                    ->update($updateData);
            }

            // Hapus data item lama
            DB::table('request_items')->where('request_id', $id)->delete();

            // Tambah item baru
            foreach ($request->nama_barang as $i => $itemId) {
                DB::table('request_items')->insert([
                    'request_id' => $id,
                    'item_id' => $itemId,
                    'quantity' => $request->stock[$i],
                    'unit_id' => $request->unit_id[$i],
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        $request = DB::table('requests')->where('id', $id)->first();

        if (!$request) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        $items = DB::table('request_items')
            ->join('items_barang', 'request_items.item_id', '=', 'items_barang.id')
            ->join('units_barang', 'request_items.unit_id', '=', 'units_barang.id')
            ->where('request_items.request_id', $id)
            ->select(
                'items_barang.name as item_name',
                'request_items.quantity',
                'units_barang.name as unit_name'
            )
            ->get();

        return response()->json([
            'status' => 'success',
            'request' => $request,
            'items' => $items
        ]);
    }

    public function approve(Request $request, $id)
    {
        $action = $request->action;

        $statusMap = [
            'ready' => 'ready',
            'rejected' => 'rejected',
            'done' => 'done',
        ];

        if (!array_key_exists($action, $statusMap)) {
            return response()->json(['status' => 'error', 'message' => 'Aksi tidak valid.']);
        }

        DB::beginTransaction();
        try {
            
            if ($action == 'done') {
            $items = DB::table('request_items')
                ->join('items_barang', 'request_items.item_id', '=', 'items_barang.id')
                ->where('request_id', $id)
                ->select('request_items.*', 'items_barang.stock as stok_tersedia', 'items_barang.name')
                ->get();

            $gagal = [];

            foreach ($items as $item) {
                if ($item->quantity > $item->stok_tersedia) {
                    $gagal[] = [
                        'name' => $item->name,
                        'diminta' => $item->quantity,
                        'tersedia' => $item->stok_tersedia,
                    ];
                }
            }

            if (count($gagal) > 0) {
                $messages = array_map(function ($item) {
                    return "{$item['name']}: diminta {$item['diminta']}, tersedia {$item['tersedia']}";
                }, $gagal);

                return response()->json([
                    'status' => 'error',
                    'message' => "Stok tidak mencukupi:\n" . implode("\n", $messages)
                ]);
            }

        foreach ($items as $item) {
            DB::table('items_barang')
                ->where('id', $item->item_id)
                ->decrement('stock', $item->quantity);
        }
    }
        // Update status
        DB::table('requests')->where('id', $id)->update([
            'status' => $statusMap[$action]
        ]);

        $user = DB::table('requests')
            ->join('users', 'requests.requested_by', '=', 'users.nrp')
            ->where('requests.id', $id)
            ->select('users.nama', 'users.dept', 'users.no_hp')
            ->first();

        if ($user && $user->no_hp) {
            if ($action == 'ready') {
                $message = "📦 *PENGAMBILAN BARANG*\n\n";
                $message .= "Halo $user->nama $user->dept\n\n";
                $message .= "Permintaan barang yang Anda ajukan telah *disetujui**.\n";
                $message .= "Silakan melakukan pengambilan barang di *Gudang GA* pada jam operasional.\n\n";
                $message.= "KETERANGAN LEBIH LANJUT\n";
                $message .= "SILAHKAN CEK DI PORTAL:\n";
                $message .= "https://hallohcga.com/";

                $this->sendWhatsAppMessage($user->no_hp, $message);
            } elseif ($action == 'rejected') {
                $message = "❌ *PENGAJUAN DITOLAK*\n\n";
                $message .= "Halo $user->nama $user->dept\n\n";
                $message .= "Mohon maaf, permintaan barang yang Anda ajukan *tidak dapat disetujui*, silahkan periksa kembali data.\n\n";
                $message .= "Untuk informasi lebih lanjut, silakan hubungi admin HCGA.\n\n";
                $message .= "Terima kasih";
                $this->sendWhatsAppMessage($user->no_hp, $message);
            }
        }



        DB::commit();
        return response()->json(['status' => 'success']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan perubahan: ' . $e->getMessage()]);
    }
}


    protected function sendWhatsAppMessage($no_hp, $message)
    {
        $apiKey = env('FONNTE_API_KEY');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $no_hp,
                'message' => $message,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $apiKey
            ),

        ));

        //curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($curl);
        $error_msg = null;

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if ($error_msg) {
            throw new \Exception("cURL Error: $error_msg");
        }

        return json_decode($response, true);
    }



}
