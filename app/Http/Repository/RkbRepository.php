<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;
use Carbon\Carbon;


class RkbRepository
{
    public function createData($data)
    {
        DB::beginTransaction();

        try {
            $norkb = !empty($data['norkb']) ? $data['norkb'] : null;

            $requestInsertData = [
                'requested_by'   => auth()->user()->nrp ?? 'unknown',
                'requested_name' => auth()->user()->nama ?? 'unknown',
                'request_date'   => Carbon::now(),
                'no_rkb'         => $norkb,
            ];

            $requestId = DB::table('rkb')->insertGetId($requestInsertData);

            foreach ($data['nama_barang'] as $i => $itemId) {
                $jumlah = (int) $data['stock'][$i];
                $unitId = (int) $data['unit_id'][$i];
                $harga  = (int) str_replace(',', '', $data['harga'][$i]);
                $jenis = $data['jenis'] ?? 'stock';

                DB::table('rkb_items')->insert([
                    'rkb_id' => $requestId,
                    'item_id'    => $itemId,
                    'quantity'   => $jumlah,
                    'unit_id'    => $unitId,
                    'harga'      => $harga,
                    'jenis'      => $jenis,
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
        $query = DB::table('rkb')
            ->select(
                'rkb.*',
                DB::raw('COUNT(rkb_items.id) as total_item'),
                DB::raw('SUM(rkb_items.quantity * CAST(rkb_items.harga AS UNSIGNED)) as total_harga'),
                DB::raw('SUM(CASE WHEN rkb_items.status = "approve" THEN 1 ELSE 0 END) as approve_count'),
                DB::raw('SUM(CASE WHEN rkb_items.status = "pending" THEN 1 ELSE 0 END) as pending_count'),
                DB::raw('SUM(CASE WHEN rkb_items.status = "reject" THEN 1 ELSE 0 END) as reject_count'),
                DB::raw('SUM(CASE WHEN rkb_items.status = "supply" THEN 1 ELSE 0 END) as supply_count'),
                DB::raw('SUM(CASE WHEN rkb_items.status = "done" THEN 1 ELSE 0 END) as done_count'),
                DB::raw('SUM(CASE WHEN rkb_items.status = "partial" THEN 1 ELSE 0 END) as partial_count'),
                DB::raw('SUM(CASE WHEN rkb_items.status = "ready" THEN 1 ELSE 0 END) as ready_count')
            )
            ->leftJoin('rkb_items', 'rkb_items.rkb_id', '=', 'rkb.id')
            ->groupBy(
                'rkb.id',
                'rkb.requested_by',
                'rkb.requested_name',
                'rkb.request_date',
                'rkb.status',
                'rkb.status_date',
                'rkb.no_rkb'
            )
            ->orderBy('rkb.request_date', 'desc')
            ->get();

        return $query;
    }


    public function delete($requestId)
    {
        try {
            DB::table('rkb_items')->where('rkb_id', $requestId)->delete();

            DB::table('rkb')->where('id', $requestId)->delete();

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
