<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;
use Illuminate\Support\Facades\Schema;

class LapCateringDeptRepository
{

    public function createCatering($data)
    {
        $timPic = auth()->user()->tim_pic;

        $tableMapping = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'Mess Putri' => 'mk_mess_putri',
            'MESS_MEICU' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
        ];

        foreach (range(1, 10) as $i) {
            $tableMapping["B$i"] = "mk_mess_b{$i}";
        }
        if (!array_key_exists($timPic, $tableMapping)) {
            return response()->json(['error' => 'Tabel tidak ditemukan untuk tim_pic ini'], 400);
        }
        $table = $tableMapping[$timPic];

        $tableColumns = Schema::getColumnListing($table);

        $insertData = [
            'created_name' => auth()->user()->id,
            'create_at' => now(),
        ];

        foreach ($tableColumns as $column) {
            if (isset($data[$column . '_add'])) {
                $insertData[$column] = $data[$column . '_add'];
            }
        }
        return DB::table($table)->insert($insertData);
    }

    public function getData($tableName, $startDate, $endDate)
    {
        $columns = Schema::getColumnListing($tableName);

        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc'
        ];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE(t1.$col, 0)";
        }, $numericColumns));

        return DB::table("$tableName as t1")
            ->select(
                't1.id',
                't1.tanggal',
                't1.created_name',
                't1.waktu',
                't1.status',
                DB::raw("($totalExpression) AS total"),
                DB::raw("(SELECT SUM(" . implode(' + ', array_map(function ($col) {
                    return "COALESCE($col, 0)";
                }, $numericColumns)) . ")
                    FROM $tableName AS t2
                    WHERE t2.tanggal = (
                        SELECT MAX(t3.tanggal)
                        FROM $tableName AS t3
                        WHERE t3.tanggal < t1.tanggal
                        AND t3.waktu = t1.waktu
                    )
                    AND t2.waktu = t1.waktu
                    AND t2.status = 2
                ) AS total_hari_sebelumnya")
            )
            ->whereBetween('t1.tanggal', [$startDate, $endDate])
            ->orderBy('t1.tanggal', 'DESC')
            ->get();
    }

    public function deleteFromTable($tableName, $selectedUserId)
    {
        try {
            DB::table($tableName)->where('id', $selectedUserId)->delete();
            return 'Data berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data dari ' . $tableName . ': ' . $e->getMessage();
        }
    }


    public function getById($id, $departemen)
    {

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PRO' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'Mess Putri' => 'mk_mess_putri',
            'MESS_MEICU' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',

        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["Mess B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$departemen] ?? null;
        //dd($table);
        if (!$table) {
            return null;
        }

        // Ambil daftar kolom dari tabe
        $columns = Schema::getColumnListing($table);

        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc'
        ];

        // Ambil kolom numerik untuk perhitungan total
        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        //dd($numericColumns);

        // Buat ekspresi SQL untuk menjumlahkan semua kolom numerik
        $totalExpression = implode(' + ', array_map(fn($col) => "COALESCE($col, 0)", $numericColumns));

        return DB::table($table)
            ->select(
                'id',
                'tanggal',
                'created_name',
                'waktu',
                'status',
                DB::raw("($totalExpression) AS total"),
                ...$columns
            )
            ->where('id', $id)

            ->first();
    }

    public function edit($data, $id)
    {
        return DB::table('mk_coe')
            ->where('id', $id)
            ->update([
                'nrp' => $data['nrp'],
                'nama' => $data['nama'],
                'mk_coename' => $data['mk_coename'],
                'email' => $data['email'],
                'dept' => $data['dept'],
                'no_hp' => $data['no_hp'],
                'perusahaan' => $data['perusahaan'],
                'id_role' => $data['id_role'],
            ]);
    }

    public function getFilteredData($tableName, $startDate, $endDate)
    {
        $query = DB::table($tableName);

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        return $query->get();
    }


    public function approval($approvalName, $selectedComplainId, $approval, $departemen)
    {
        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PRO' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'Mess Putri' => 'mk_mess_putri',
            'MESS_MEICU' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["Mess B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$departemen] ?? null;

        if (!$table) {
            return 'Departemen tidak valid';
        }

        DB::table($table)
            ->where('id', $selectedComplainId)
            ->update([
                'approval_by' => $approvalName,
                'approval_on' => now(),
                'status' => 2,
                'approval_desc' => $approval,
            ]);

        return 'Data Catering Berhasil di "Setujui" untuk departemen ' . $departemen;
    }

    public function approvalAll($approvalName, $selectedComplainIds, $approval, $departemen)
    {
        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PRO' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'Mess Putri' => 'mk_mess_putri',
            'MESS_MEICU' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["Mess B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$departemen] ?? null;

        if (!$table) {
            return 'Departemen tidak valid';
        }

        DB::table($table)
            ->whereIn('id', $selectedComplainIds)
            ->update([
                'approval_by' => $approvalName,
                'approval_on' => now(),
                'status' => 2,
                'approval_desc' => $approval,
            ]);

        return 'Data Catering berhasil disetujui untuk departemen ' . $departemen;
    }

    public function revisi($revisiName, $selectedComplainId, $pesanRevisi, $departemen)
    {
        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PRO' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'Mess Putri' => 'mk_mess_putri',
            'MESS_MEICU' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["Mess B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$departemen] ?? null;

        if (!$table) {
            return 'Departemen tidak valid';
        }

        DB::table($table)
            ->where('id', $selectedComplainId)
            ->update([
                'revisi_by' => $revisiName,
                'revisi_on' => now(),
                'status' => 3,
                'revisi_desc' => $pesanRevisi
            ]);

        return 'Data Complain berhasil di "Revisi"';
    }

    public function sendRevisi($selectedComplainId, $departemen)
    {
//dd($departemen);
        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'Mess Putri' => 'mk_mess_putri',
            'MESS_MEICU' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["Mess B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$departemen] ?? null;

        if (!$table) {
            return 'Departemen tidak valid';
        }

        DB::table($table)
            ->where('id', $selectedComplainId)
            ->update([
                'status' => 1,
            ]);

        return 'Data MK berhasil di "Revisi"';
    }
}
