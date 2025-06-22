<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;
use Carbon\Carbon;


class PengambilanBarangRepository
{
    public function createData($data)
    {
        DB::beginTransaction();

        try {
            $area = $data['area'];
            $gedung = !empty($data['gedung']) ? $data['gedung'] : null;
            $lokasi = !empty($data['lokasi']) ? $data['lokasi'] : null;

            $requestInsertData = [
                'requested_by' => auth()->user()->nrp ?? 'unknown',
                'requested_name' => auth()->user()->nama ?? 'unknown',
                'requested_dept' => auth()->user()->dept ?? 'HCG',
                'request_date' => Carbon::now(),
                'status' => 'waiting approval GA',
                'area' => $area,
                'gedung' => $gedung,
                'lokasi' => $lokasi,
            ];

            //dd($requestInsertData);

            if (!empty($data['keterangan'])) {
                $requestInsertData['keterangan'] = $data['keterangan'];
            }

            $requestId = DB::table('requests')->insertGetId($requestInsertData);

            foreach ($data['nama_barang'] as $i => $itemId) {
                $jumlah = (int) $data['stock'][$i];
                $unitId = (int) $data['unit_id'][$i];

                DB::table('request_items')->insert([
                    'request_id' => $requestId,
                    'item_id' => $itemId,
                    'quantity' => $jumlah,
                    'unit_id' => $unitId,
                ]);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getData()
    {
       $query = DB::table('requests')
            ->select('*')
            ->orderBy('request_date', 'desc');

        $user = auth()->user();

        if (in_array($user->id_role, [1, 2, 6])) {
            $query->where('requested_by', $user->nrp);
        }

        return $query->get();
    }

    public function delete($requestId)
    {
        try {
            DB::table('request_items')->where('request_id', $requestId)->delete();

            DB::table('requests')->where('id', $requestId)->delete();

            return 'Data berhasil dihapus.';
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
        ->first();

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

    public function getCategories()
    {
        return DB::table('categories_barang')->get();
    }

    public function getUnits()
    {
        return DB::table('units_barang')->get();
    }

    public function getItems()
    {
        return DB::table('items_barang')
            ->select('id', 'name', 'stock') 
            ->get();
    }



}
