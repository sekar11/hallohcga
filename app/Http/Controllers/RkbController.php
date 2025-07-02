<?php

namespace App\Http\Controllers;
use App\Http\Repository\RkbRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RkbController extends Controller
{
    protected $RkbRepository;

    public function __construct(RkbRepository $RkbRepository)
    {
        $this->RkbRepository = $RkbRepository;
    }


    public function index()
    {
        $categories = $this->RkbRepository->getCategories();
        $items = $this->RkbRepository->getItems();
        $units = $this->RkbRepository->getUnits();
        $Rkb = $this->RkbRepository->getData();

        return view('/gudang/rkb', [
            'Rkb' => $Rkb,
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
        $data = $request->except('_token');

        $result = $this->RkbRepository->createData($data);

        if ($result) {
            return Response::json(['status' => 'success']);
        } else {
            return Response::json(['status' => 'error']);
        }
    }

 
 
    public function delete(Request $request)
    {

        $barangId = $request->input('barang_id');

        $result = $this->RkbRepository->delete($barangId );

        return response()->json(['message' => $result]);
    }

    public function getEdit($id)
    {
        $user = $this->RkbRepository->getById($id);
        return response()->json($user);
    }

    public function edit($id)
    {
        $request = DB::table('rkb')->where('id', $id)->first();

        if (!$request) {
            return response()->json(['status' => 'error', 'message' => 'Request tidak ditemukan']);
        }

        $items = DB::table('rkb_items')
            ->where('rkb_id', $id)
            ->join('items_barang', 'rkb_items.item_id', '=', 'items_barang.id')
            ->join('units_barang', 'rkb_items.unit_id', '=', 'units_barang.id')
            ->select(
                'rkb_items.item_id',
                'items_barang.name as name',
                'rkb_items.quantity',
                'rkb_items.unit_id',
                'units_barang.name as unit_name',
                'items_barang.stock as stock',
                'rkb_items.harga',
                'rkb_items.jenis'
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
            // Update data RKB-nya kalau ada perubahan
            $updateData = [];

            if ($request->filled('norkb')) {
                $updateData['no_rkb'] = $request->norkb;
            }

            if (!empty($updateData)) {
                DB::table('rkb')
                    ->where('id', $id)
                    ->update($updateData);
            }

            // Hapus data item lama dulu
            DB::table('rkb_items')->where('rkb_id', $id)->delete();

            // Masukkan item-item baru
            foreach ($request->nama_barang as $i => $itemId) {
                DB::table('rkb_items')->insert([
                    'rkb_id'  => $id,
                    'item_id' => $itemId,
                    'quantity' => $request->stock[$i],
                    'unit_id' => $request->unit_id[$i],
                    'harga'   => str_replace(',', '', $request->harga[$i]),
                    'jenis'   => $request->jenis[$i] ?? 'stock', // default kalau kosong
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
        $request = DB::table('rkb')->where('id', $id)->first();

        if (!$request) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        $items = DB::table('rkb_items')
            ->join('items_barang', 'rkb_items.item_id', '=', 'items_barang.id')
            ->join('units_barang', 'rkb_items.unit_id', '=', 'units_barang.id')
            ->where('rkb_items.rkb_id', $id)
            ->select(
                'items_barang.name as item_name',
                'rkb_items.quantity',
                'rkb_items.harga',
                'rkb_items.jenis',
                'rkb_items.status',
                DB::raw('rkb_items.quantity * CAST(rkb_items.harga AS UNSIGNED) as total_harga'),
                'units_barang.name as unit_name'
            )
            ->get();

        // total semua harga
        $totalHarga = $items->sum('total_harga');

        return response()->json([
            'status' => 'success',
            'request' => $request,
            'items' => $items,
            'total_harga' => $totalHarga
        ]);
    }


    public function approve(Request $request, $id)
    {
        
        $action = $request->action;
        $keterangan = $request->keterangan;
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
       
        // DB::table('requests')->where('id', $id)->update([
        //     'status' => $statusMap[$action]
        // ]);

         // Update status + keterangan di tabel requests
        DB::table('requests')->where('id', $id)->update([
            'status' => $statusMap[$action],
            'keterangan' => $keterangan,
        ]);


        $user = DB::table('requests')
            ->join('users', 'requests.requested_by', '=', 'users.nrp')
            ->where('requests.id', $id)
            ->select('users.nama', 'users.dept', 'users.no_hp', 'requests.keterangan')
            ->first();

        if ($user && $user->no_hp) {
            if ($action == 'ready') {
                $message = "📦 *PERSETUJUAN REQUEST BARANG*\n\n";
                $message .= "Halo $user->nama $user->dept\n\n";
                $message .= "Permintaan barang yang Anda ajukan telah *disetujui*.\n\n";
                $message .= "Keterangan: " . ($user->keterangan ?? '-') . "\n\n";
                $message.= "KETERANGAN LEBIH LANJUT\n";
                $message .= "SILAHKAN CEK DI PORTAL:\n";
                $message .= "https://hallohcga.com/";

                $this->sendWhatsAppMessage($user->no_hp, $message);
            } elseif ($action == 'rejected') {
                $message = "❌ *PENGAJUAN BELUM DISETUJUI*\n\n";
                $message .= "Halo $user->nama $user->dept\n\n";
                $message .= "Terima kasih atas permintaan pengambilan barang yang telah diajukan. Namun, mohon maaf saat ini permintaan tersebut belum dapat disetujui.\n\n";
                $message .= "Keterangan: " . ($user->keterangan ?? '-') . "\n\n";
                $message .= "Untuk informasi lebih lanjut, silakan hubungi admin GA.\n\n";
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

    public function getItems($id)
    {
        $items = DB::table('rkb_items')
            ->join('items_barang', 'rkb_items.item_id', '=', 'items_barang.id')
            ->select(
                'rkb_items.id',
                'items_barang.name as item_name',
                'rkb_items.quantity',
                'rkb_items.harga',
                'rkb_items.jumlah_datang',
                'rkb_items.status'
            )
            ->where('rkb_items.rkb_id', $id)
            ->get();
            //dd($items);
        return response()->json(['status' => 'success', 'items' => $items]);
    }

// public function approveItems(Request $request, $id)
// {
//     DB::beginTransaction();

//     try {
//         foreach ($request->items as $item) {
//             $currentItem = DB::table('rkb_items')->where('id', $item['id'])->first();

//             if ($item['status'] === 'partial') {
//                 if ($currentItem->jumlah_datang == $currentItem->quantity) {
//                     $newJumlahDatang = $item['jumlah_datang'];
//                 } else {
//                     $newJumlahDatang = $currentItem->jumlah_datang + $item['jumlah_datang'];
//                 }
//             } else {
            
//                 $newJumlahDatang = $item['jumlah_datang'];
//             }

//             DB::table('rkb_items')
//                 ->where('id', $item['id'])
//                 ->update([
//                     'quantity' => $item['quantity'],
//                     'harga' => $item['harga'],
//                     'status' => $item['status'],
//                     'jumlah_datang' => $newJumlahDatang
//                 ]);
//         }

//         DB::table('rkb')->where('id', $id)->update([
//             'status' => $request->action
//         ]);

//         DB::commit();
//         return response()->json(['status' => 'success', 'message' => 'Approval berhasil disimpan.']);
//     } catch (\Exception $e) {
//         DB::rollBack();
//         return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
//     }
// }

public function approveItems(Request $request, $id)
{
    DB::beginTransaction();

    try {
        foreach ($request->items as $item) {
            $currentItem = DB::table('rkb_items')->where('id', $item['id'])->first();

            // Inisialisasi jumlah datang default
            $newJumlahDatang = $currentItem->jumlah_datang;

            if ($item['status'] === 'partial') {
    $jumlahDatangInput = is_numeric($item['jumlah_datang']) ? $item['jumlah_datang'] : 0;

    $newJumlahDatang = $currentItem->jumlah_datang + $jumlahDatangInput;

    DB::table('items_barang')
        ->where('id', $currentItem->item_id)
        ->increment('stock', $jumlahDatangInput);
}
elseif ($item['status'] === 'done') {
    $newJumlahDatang = $currentItem->quantity;

    DB::table('items_barang')
        ->where('id', $currentItem->item_id)
        ->increment('stock', $currentItem->quantity);
}
else {
    $newJumlahDatang = is_numeric($item['jumlah_datang']) ? $item['jumlah_datang'] : 0;
}


            // Update ke rkb_items
            DB::table('rkb_items')
                ->where('id', $item['id'])
                ->update([
                    'quantity'       => $item['quantity'],
                    'harga'          => $item['harga'],
                    'status'         => $item['status'],
                    'jumlah_datang'  => $newJumlahDatang
                ]);
        }

        // Update status RKB-nya
        DB::table('rkb')->where('id', $id)->update([
            'status' => $request->action
        ]);

        DB::commit();
        return response()->json(['status' => 'success', 'message' => 'Approval berhasil disimpan.']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
}




}
