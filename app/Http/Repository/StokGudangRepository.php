<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;

class StokGudangRepository
{

   public function createData($data)
    {

        return DB::table('items_barang')->insert([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'unit_id' => $data['unit_id'] ?? null,
            'stock' => $data['stock'] ?? null,
            'min_stock' => $data['min_stock'] ?? null,
            'max_stock' => $data['max_stock'] ?? null,
            'created_by' => auth()->user()->nrp,
            'created_name' => auth()->user()->username,
            'created_on' => now(),
        ]);
    }

    //  public function getData()
    // {
    //     return DB::table('items_barang')
    //         ->leftJoin('categories_barang', 'items_barang.category_id', '=', 'categories_barang.id')
    //         ->leftJoin('units_barang', 'items_barang.unit_id', '=', 'units_barang.id')
    //         ->select('items_barang.*', 'categories_barang.name as category_name', 'units_barang.name as unit_name')
    //         ->get();
    // }

    public function getData($categoryName = null)
    {
        $query = DB::table('items_barang')
            ->leftJoin('categories_barang', 'items_barang.category_id', '=', 'categories_barang.id')
            ->leftJoin('units_barang', 'items_barang.unit_id', '=', 'units_barang.id')
            ->select(
                'items_barang.*',
                'categories_barang.name as category_name',
                'units_barang.name as unit_name'
            );

        if ($categoryName) {
            $query->where('categories_barang.name', $categoryName);
        }

        return $query->get();
    }



    public function delete($barangId )
    {
        try {
            DB::table('items_barang')->where('id', $barangId )->delete();
            return 'Data Berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data: ' . $e->getMessage();
        }
    }

    public function getById($id)
    {
        $data = DB::table('items_barang')
        ->leftJoin('categories_barang', 'items_barang.category_id', '=', 'categories_barang.id')
        ->leftJoin('units_barang', 'items_barang.unit_id', '=', 'units_barang.id')
        ->select(
            'items_barang.*',
            'categories_barang.name as category_name',
            'units_barang.name as unit_name'
        )
        ->where('items_barang.id', $id)
        ->first(); // ← penting, ambil satu data saja;

        return $data;
    }

    public function edit(array $data, $id)
    {
        try {
            $existingRecord = DB::table('items_barang')->where('id', $id)->first();

            if (!$existingRecord) {
                throw new \Exception("Data tidak ditemukan untuk ID: $id");
            }
            $updateData = [
                'category_id' => $data['category_id'],
                'name'        => $data['name'],
                'stock'       => $data['stock'],
                'min_stock'   => $data['min_stock'],
                'max_stock'   => $data['max_stock'],
                'unit_id'     => $data['unit_id'],
            ];

            $update = DB::table('items_barang')->where('id', $id)->update($updateData);

            return $update ? true : false;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function tambah($data, $id)
    {
        try {
        
            $barang = DB::table('items_barang')->where('id', $id)->first();

            if (!$barang) {
                throw new \Exception("Barang dengan ID $id tidak ditemukan.");
            }

            $stokBaru = $barang->stock + (int) $data;

            $update = DB::table('items_barang')
                ->where('id', $id)
                ->update(['stock' => $stokBaru]);

            return $update ? true : false;

        } catch (\Exception $e) {
        
            return false;
        }
    }

    public function supply($data, $id)
    {
        try {
            $barang = DB::table('items_barang')->where('id', $id)->first();
// dd($barang);
            if (!$barang) {
                throw new \Exception("Barang dengan ID $id tidak ditemukan.");
            }

            // Pastikan stok mencukupi
            if ($barang->stock < (int) $data) {
                throw new \Exception("Stok tidak mencukupi.");
            }

            $stokBaru = $barang->stock - (int) $data;

            $update = DB::table('items_barang')
                ->where('id', $id)
                ->update(['stock' => $stokBaru]);

            return $update ? true : false;

        } catch (\Exception $e) {
            // Bisa ditambahkan log error kalau perlu
            return false;
        }
    }


    public function getBarangById($id)
    {
        return DB::table('items_barang')
            ->join('categories_barang', 'items_barang.category_id', '=', 'categories_barang.id')
            ->select(
                'items_barang.name as nama_barang',
                'categories_barang.name as kategori',
                'items_barang.stock as stok_awal'
            )
            ->where('items_barang.id', $id)
            ->first();
    }


    public function editProfile($data, $id)
    {
        try {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'nrp' => $data['nrp'],
                    'nama' => $data['name'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'dept' => $data['departemen'],
                    'perusahaan' => $data['perusahaan'],
                    'no_hp' => $data['phone_number'],
                    'baju' => $data['baju'],
                    'celana' => $data['celana'],
                    'rompi' => $data['rompi'],
                    'sepatu' => $data['sepatu'],
                ]);

            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getStokGudangData($tanggalAwal, $tanggalAkhir)
    {
        $data = DB::table('ph_air')
            ->select(
                'tanggal',
                DB::raw('MAX(MESS) as MESS'),
                DB::raw('MAX(WT) as WT'),
                DB::raw('MAX(WTP) as WTP'),
                DB::raw('MAX(STP) as STP'),
                DB::raw('MAX(PIT_1) as PIT_1'),
                DB::raw('MAX(PIT_2) as PIT_2'),
                DB::raw('MAX(PIT_3) as PIT_3'),
                DB::raw('MAX(WORKSHOP) as WORKSHOP'),
                DB::raw('MAX(WAREHOUSE) as WAREHOUSE'),
                DB::raw('MAX(OFFICE_PLANT) as OFFICE_PLANT')
            )
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        return $data->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'lokasi' => [
                    'MESS' => $item->MESS,
                    'WT' => $item->WT,
                    'WTP' => $item->WTP,
                    'STP' => $item->STP,
                    'PIT_1' => $item->PIT_1,
                    'PIT_2' => $item->PIT_2,
                    'PIT_3' => $item->PIT_3,
                    'WORKSHOP' => $item->WORKSHOP,
                    'WAREHOUSE' => $item->WAREHOUSE,
                    'OFFICE_PLANT' => $item->OFFICE_PLANT,
                ]
            ];
        });
    }


    public function getStokGudangDataPer($tanggalAwal, $tanggalAkhir, $lokasi)
    {
        $data = DB::table('ph_air')
            ->select('tanggal', DB::raw("MAX($lokasi) as pH"))
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Hitung rata-rata pH dari semua data yang diambil
        $rataRata = $data->avg('pH');

        return [
            'dataHarian' => $data->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal,
                    'pH' => $item->pH,
                ];
            }),
            'rataRata' => round($rataRata, 2) // Bulatkan ke 2 desimal
        ];
    }


    //     public function getData()
    // {
    //     return DB::table('items')
    //         ->leftJoin('categories', 'items.category_id', '=', 'categories.id')
    //         ->leftJoin('units', 'items.unit_id', '=', 'units.id')
    //         ->select('items.*', 'categories.name as category_name', 'units.name as unit_name')
    //         ->get();
    // }

    public function getCategories()
    {
        return DB::table('categories_barang')->get();
    }

    public function getUnits()
    {
        return DB::table('units_barang')->get();
    }




}
