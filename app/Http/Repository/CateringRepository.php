<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CateringRepository
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
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
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

    public function getData()
    {
        $userTeam = auth()->user()->tim_pic;

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$userTeam] ?? 'mk_coe';

        $columns = Schema::getColumnListing($table);

        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc'
        ];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        return DB::table($table)
            ->select(
                'id',
                'tanggal',
                'created_name',
                'waktu',
                'status',
                DB::raw("($totalExpression) AS total")
            )
            ->orderBy('tanggal', 'DESC')
            ->get();
    }

    public function getSnackSummary($userTeam)
    {
        $table = 'mk_snack';

        return DB::table($table)
            ->select('id','tanggal','area','gedung','lokasi', 'jenis', 'waktu', 'jumlah', 'status')
            ->where('departemen', $userTeam)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->get();
    }

    public function getSpesialSummary($userTeam)
    {
        $table = 'mk_spesial';

        return DB::table($table)
            ->select('id','tanggal','lokasi', 'jenis','area','gedung', 'waktu', 'jumlah', 'status')
            ->where('departemen', $userTeam)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->get();
    }


    //ACTUAL DAN PLAN ORDER
    public function getPlanActualOrder()
    {
        $userTeam = auth()->user()->tim_pic;

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$userTeam] ?? 'mk_coe';

        $columns = Schema::getColumnListing($table);

        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc','visitor'
        ];

        // Semua kolom numerik yang tidak termasuk dalam daftar pengecualian
        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        // TOTAL: Semua kolom numerik dijumlahkan
        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        // TOTAL PLAN: Hanya untuk waktu Pagi, Siang, Sore, Malam
        $totalPlanExpression = "(SELECT SUM($totalExpression) FROM $table WHERE waktu IN ('Pagi', 'Siang', 'Sore', 'Malam'))";

        // TOTAL ACTUAL: Menggabungkan waktu utama dengan tambahan
        $timeMappings = [
            'Pagi' => 'Tambahan Pagi',
            'Siang' => 'Tambahan Siang',
            'Sore' => 'Tambahan Sore',
            'Malam' => 'Tambahan Malam'
        ];

        $totalActualParts = [];
        foreach ($timeMappings as $mainTime => $extraTime) {
            $totalActualParts[] = "(SELECT COALESCE(SUM($totalExpression), 0) FROM $table WHERE waktu = '$mainTime') +
                                (SELECT COALESCE(SUM($totalExpression), 0) FROM $table WHERE waktu = '$extraTime')";
        }

        $totalActualExpression = implode(' + ', $totalActualParts);

        return DB::table($table)
            ->select(
                'id',
                'tanggal',
                'created_name',
                'waktu',
                'status',
                DB::raw("($totalExpression) AS total"),
                DB::raw("($totalPlanExpression) AS total_plan"),
                DB::raw("($totalActualExpression) AS total_actual")
            )
            ->orderBy('tanggal', 'DESC')
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

    public function deleteFromTableSnack($tableName, $selectedUserId)
    {
        try {
            DB::table($tableName)->where('id', $selectedUserId)->delete();
            return 'Data berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data dari ' . $tableName . ': ' . $e->getMessage();
        }
    }

    public function deleteFromTableSpesial($tableName, $selectedUserId)
    {
        try {
            DB::table($tableName)->where('id', $selectedUserId)->delete();
            return 'Data berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data dari ' . $tableName . ': ' . $e->getMessage();
        }
    }

    public function getById($id)
    {
        $userTeam = auth()->user()->tim_pic;

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$userTeam] ?? 'mk_coe';

        $columns = Schema::getColumnListing($table);

        $excludedColumns = ['id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status', 'approval_by', 'approval_on', 'approval_desc', 'revisi_by', 'revisi_on', 'revisi_desc'];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        return DB::table($table)
            ->select(
                'id',
                'tanggal',
                'created_name',
                'waktu',
                DB::raw("($totalExpression) AS total"),
                ...$columns
            )
            ->where('id', $id)
            ->first();
    }

    public function getByIdSnack($id)
    {

        $table = 'mk_snack';

        return DB::table($table)
            ->select(
                'id',
                'tanggal',
                'created_name',
                'waktu',
                'area',
                'gedung',
                'lokasi',
                'jenis',
                'revisi_desc',
                'jumlah',
                'keterangan'
            )
            ->where('id', $id)
            // ->where('departemen', $departemen)
            ->first();
    }

    public function getByIdSpesial($id, $departemen)
    {

        $table = 'mk_spesial';

        return DB::table($table)
            ->select(
                'id',
                'tanggal',
                'created_name',
                'waktu',
                'lokasi',
                'area',
                'gedung',
                'jenis',
                'revisi_desc',
                'jumlah',
                'keterangan'
            )
            ->where('id', $id)
            // ->where('departemen', $departemen)
            ->first();
    }

    public function getPreviousData($tanggal, $waktu)
    {
        $userTeam = auth()->user()->tim_pic;

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$userTeam] ?? 'mk_coe';

        $columns = Schema::getColumnListing($table);
        $excludedColumns = ['id', 'created_name', 'create_at', 'status', 'approval_by', 'approval_on', 'approval_desc', 'revisi_by', 'revisi_on', 'revisi_desc'];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        // Looping tanggal
        while ($tanggal) {
            $tanggal = date('Y-m-d', strtotime($tanggal . ' -1 day'));

            $data = DB::table($table)
                ->select(
                    'tanggal',
                    'waktu',
                    DB::raw("($totalExpression) AS total"),
                    ...$columns
                )
                ->where('tanggal', $tanggal)
                ->where('waktu', $waktu)
                ->orderBy('id', 'desc')
                ->first();

            if ($data) {
                return $data;
            }

            if ($tanggal < date('Y-m-d', strtotime('-30 days'))) {
                break;
            }
        }

        return null;
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

    public function sendRevisi($selectedComplainId, $departemen)
    {

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
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

    public function sendRevisiSnack($selectedComplainId, $departemen)
    {

        $table = 'mk_snack';

        DB::table($table)
            ->where('id', $selectedComplainId)
            ->update([
                'status' => 1,
            ]);

        return 'Data Revisi Snack berhasil di "KIRIM"';
    }

    public function sendRevisiSpesial($selectedComplainId, $departemen)
    {

        $table = 'mk_spesial';

        DB::table($table)
            ->where('id', $selectedComplainId)
            ->update([
                'status' => 1,
            ]);

        return 'Data Revisi MK Spesial telah berhasil di "KIRIM"';
    }



    //=============================================== DASHBOARD MK CATERING===============================================

    public function getGrafikDailyDept($departemen, $tanggalAwal, $tanggalAkhir)
    {
        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PRO' => 'mk_prod',
            'PLANT' => 'mk_plant',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[strtoupper($departemen)] ?? 'mk_hcga';

        $columns = Schema::getColumnListing($table);
        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc','visitor'
        ];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        $data = DB::table($table)
            ->select(
                'tanggal',
                DB::raw("SUM(CASE WHEN waktu IN ('Pagi', 'Siang', 'Sore', 'Malam') THEN $totalExpression ELSE 0 END) as total_plan"),
                DB::raw("SUM(CASE WHEN waktu IN ('Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore', 'Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
            )
            ->where('status', 2)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $totalPlan = $data->sum('total_plan');
        $totalActual = $data->sum('total_actual');
        $totalTambahan = $totalActual - $totalPlan;
        $totalCost = $totalActual * 17000;

        return [
            'data' => $data,
            'total_plan' => $totalPlan,
            'total_actual' => $totalActual,
            'total_tambahan' => $totalTambahan,
            'total_cost' => $totalCost
        ];
    }

    // public function getGrafikDailyMess($mess, $tanggalAwal, $tanggalAkhir)
    // {

    //     $tableMappings = [
    //         'a1' => 'mk_mess_a1',
    //         'c3' => 'mk_mess_c3',
    //         'mess putri' => 'mk_mess_putri',
    //         'mess meicu' => 'mk_mess_meicu',
    //     ];

    //     foreach (range(1, 10) as $i) {
    //         $tableMappings["b$i"] = "mk_mess_b{$i}";
    //     }

    //     $table = $tableMappings[strtolower($mess)];
    //     //dd($table);

    //     $columns = Schema::getColumnListing($table);
    //     $excludedColumns = [
    //         'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
    //         'approval_by', 'approval_on', 'approval_desc',
    //         'revisi_by', 'revisi_on', 'revisi_desc'
    //     ];

    //     $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
    //         return !in_array($column, $excludedColumns);
    //     });

    //     $totalExpression = implode(' + ', array_map(function ($col) {
    //         return "COALESCE($col, 0)";
    //     }, $numericColumns));

    //     $data = DB::table($table)
    //         ->select(
    //             'tanggal',
    //             DB::raw("SUM(CASE WHEN waktu IN ('Pagi', 'Siang', 'Sore', 'Malam') THEN $totalExpression ELSE 0 END) as total_plan"),
    //             DB::raw("SUM(CASE WHEN waktu IN ('Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore', 'Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
    //         )
    //         ->where('status', 2)
    //         ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
    //         ->groupBy('tanggal')
    //         ->orderBy('tanggal')
    //         ->get();

    //     $totalPlan = $data->sum('total_plan');
    //     $totalActual = $data->sum('total_actual');
    //     $totalTambahan = $totalActual - $totalPlan;
    //     $totalCost = $totalActual * 17000;

    //     return [
    //         'data' => $data,
    //         'total_plan_mess' => $totalPlan,
    //         'total_actual_mess' => $totalActual,
    //         'total_tambahan_mess' => $totalTambahan,
    //         'total_cost_mess' => $totalCost

    //     ];
    // }

    public function getGrafikDailyMess($mess, $tanggalAwal, $tanggalAkhir)
    {
        // mapping mess yang pakai penjumlahan mess_X + rebusan_X di tabel mk_mess
        $customMess = [
            'a1' => ['mess_a1', 'rebusan_a1'],
            'a2' => ['mess_a2', 'rebusan_a2'],
            'c3' => ['mess_c3', 'rebusan_c3'],
        ];

        // tambahkan mess b1-b10
        foreach (range(1, 10) as $i) {
            $customMess["b$i"] = ["mess_b$i", "rebusan_b$i"];
        }

        $messKey = strtolower($mess);

        // Kalau Mess Putri / Meicu → tabelnya beda
        if ($messKey == 'mess putri') {
            $table = 'mk_mess_putri';
        } elseif ($messKey == 'mess meicu') {
            $table = 'mk_mess_meicu';
        } else {
            $table = 'mk_mess';
        }

        // Tentukan total expression
        if (in_array($messKey, ['mess putri', 'mess meicu'])) {
            // Ambil semua kolom numeric (selain excluded) dari tabel terkait
            $columns = Schema::getColumnListing($table);
            $excludedColumns = [
                'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
                'approval_by', 'approval_on', 'approval_desc',
                'revisi_by', 'revisi_on', 'revisi_desc'
            ];

            $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
                return !in_array($column, $excludedColumns);
            });

            $totalExpression = implode(' + ', array_map(function ($col) {
                return "COALESCE($col, 0)";
            }, $numericColumns));

        } elseif (isset($customMess[$messKey])) {
            // pakai mess_x + rebusan_x
            $totalExpression = "COALESCE({$customMess[$messKey][0]},0) + COALESCE({$customMess[$messKey][1]},0)";
        } else {
            // kalau mess gak valid
            throw new \Exception("Mess $mess tidak ditemukan.");
        }

        // Ambil datanya
        $data = DB::table($table)
            ->select(
                'tanggal',
                DB::raw("SUM(CASE WHEN waktu IN ('Pagi', 'Siang', 'Sore', 'Malam') THEN $totalExpression ELSE 0 END) as total_plan"),
                DB::raw("SUM(CASE WHEN waktu IN ('Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore', 'Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
            )
            ->where('status', 2)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Hitung totalnya
        $totalPlan = $data->sum('total_plan');
        $totalActual = $data->sum('total_actual');
        $totalTambahan = $totalActual - $totalPlan;
        $totalCost = $totalActual * 17000;

        return [
            'data' => $data,
            'total_plan_mess' => $totalPlan,
            'total_actual_mess' => $totalActual,
            'total_tambahan_mess' => $totalTambahan,
            'total_cost_mess' => $totalCost
        ];
    }



    public function getGrafikMonthlyDept($departemen, $bulanAwal, $bulanAkhir, $tahun)
    {
        // dd([
        //     'mess' => $departemen,
        //     'tanggalAwal' => $bulanAwal,
        //     'tanggalAkhir' => $bulanAkhir,
        // ]);

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PRO' => 'mk_prod',
            'PLANT' => 'mk_plant',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[strtoupper($departemen)] ?? 'mk_hcga';

        $columns = Schema::getColumnListing($table);
        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc'
        ];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

         // dd([
        //     'table' => $table,
        //     'tanggal_range' => [$tanggalAwal, $tanggalAkhir],
        //     'raw_data' => DB::table($table)->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])->get(),
        //     'unique_waktu' => DB::table($table)->select('waktu')->distinct()->pluck('waktu'),
        //     'numericColumns' => $numericColumns
        //   ]);

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        $startDate = Carbon::createFromDate($tahun, $bulanAwal, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::createFromDate($tahun, $bulanAkhir, 1)->endOfMonth()->toDateString();

        $data = DB::table($table)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan")
            ->selectRaw("SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam') THEN $totalExpression ELSE 0 END) as total_plan")
            ->selectRaw("SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
            ->where('status', 2)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"))
            ->get();

        $totalPlan = $data->sum('total_plan');
        $totalActual = $data->sum('total_actual');
        $totalTambahan = $totalActual - $totalPlan;
        $totalCost = $totalActual * 17000;

        return [
            'data' => $data,
            'total_plan' => $totalPlan,
            'total_actual' => $totalActual,
            'total_tambahan' => $totalTambahan,
            'total_cost' => $totalCost
        ];
    }


    // public function getGrafikMonthlyAllDept($bulan, $tahun)
    // {
    //     $tableMappings = [
    //         'COE' => 'mk_coe',
    //         'HCGA' => 'mk_hcga',
    //         'ENG' => 'mk_eng',
    //         'SHE' => 'mk_she',
    //         'FALOG' => 'mk_falog',
    //         'PRO' => 'mk_prod',
    //         'PLANT' => 'mk_plant',
    //     ];

    //     $departemenList = array_keys($tableMappings);
    //     $results = [];
    //     $totalTambangActual = 0;
    //     $totalTambangPlan = 0;

    //     foreach ($departemenList as $departemen) {
    //         $table = $tableMappings[$departemen];

    //         $columns = Schema::getColumnListing($table);
    //         $excludedColumns = [
    //             'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
    //             'approval_by', 'approval_on', 'approval_desc',
    //             'revisi_by', 'revisi_on', 'revisi_desc'
    //         ];

    //         $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
    //             return !in_array($column, $excludedColumns);
    //         });

    //         $totalExpression = implode(' + ', array_map(function ($col) {
    //             return "COALESCE($col, 0)";
    //         }, $numericColumns));

    //         $query = DB::table($table)
    //             ->selectRaw("
    //                 SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam') THEN $totalExpression ELSE 0 END) as total_plan,
    //                 SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual
    //             ")
    //             ->where('status', 2)
    //             ->whereMonth('tanggal', $bulan)
    //             ->whereYear('tanggal', $tahun)
    //             ->first();

    //         $actual = $query->total_actual ?? 0;
    //         $plan = $query->total_plan ?? 0;
    //         $surplus = $actual - $plan;

    //         $results[] = [
    //             'departemen' => $departemen,
    //             'total_plan' => $plan,
    //             'total_actual' => $actual,
    //             'surplus' => $surplus,
    //         ];

    //         if (strtoupper($departemen) !== 'PLANT') {
    //             $totalTambangActual += $actual;
    //             $totalTambangPlan += $plan;
    //         }
    //     }

    //     // Tambahkan TAMBANG
    //     $results[] = [
    //         'departemen' => 'TAMBANG',
    //         'total_plan' => $totalTambangPlan,
    //         'total_actual' => $totalTambangActual,
    //         'surplus' => $totalTambangActual - $totalTambangPlan,
    //     ];

    //     return [
    //         'data' => $results
    //     ];
    // }

    public function getGrafikMonthlyAllDept($bulan, $tahun)
{
    $tableMappings = [
        'COE' => 'mk_coe',
        'HCGA' => 'mk_hcga',
        'ENG' => 'mk_eng',
        'SHE' => 'mk_she',
        'FALOG' => 'mk_falog',
        'PRO' => 'mk_prod',
        'PLANT' => 'mk_plant',
    ];

    $departemenList = array_keys($tableMappings);
    $results = [];

    $totalTambangActual = 0;
    $totalTambangPlan = 0;

    $totalAllActual = 0; // total semua departemen
    $totalAllPlan = 0;

    foreach ($departemenList as $departemen) {
        $table = $tableMappings[$departemen];

        $columns = Schema::getColumnListing($table);
        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc'
        ];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        $query = DB::table($table)
            ->selectRaw("
                SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam') THEN $totalExpression ELSE 0 END) as total_plan,
                SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual
            ")
            ->where('status', 2)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->first();

        $actual = $query->total_actual ?? 0;
        $plan = $query->total_plan ?? 0;
        $surplus = $actual - $plan;

        $results[] = [
            'departemen' => $departemen,
            'total_plan' => $plan,
            'total_actual' => $actual,
            'surplus' => $surplus,
        ];

        // total TAMBANG (selain PLANT)
        if (strtoupper($departemen) !== 'PLANT') {
            $totalTambangActual += $actual;
            $totalTambangPlan += $plan;
        }

        // total semua departemen
        $totalAllActual += $actual;
        $totalAllPlan += $plan;
    }

    // Tambahkan TAMBANG
    $results[] = [
        'departemen' => 'TAMBANG',
        'total_plan' => $totalTambangPlan,
        'total_actual' => $totalTambangActual,
        'surplus' => $totalTambangActual - $totalTambangPlan,
    ];

    // Tambahkan TOTAL SEMUA
    $results[] = [
        'departemen' => 'TOTAL',
        'total_plan' => $totalAllPlan,
        'total_actual' => $totalAllActual,
        'surplus' => $totalAllActual - $totalAllPlan,
    ];

    return [
        'data' => $results
    ];
}


    // public function getGrafikMonthlyMess($mess, $bulanAwal, $bulanAkhir, $tahun)
    // {
    
    //     $tableMappings = [
    //         'a1' => 'mk_mess_a1',
    //         'c3' => 'mk_mess_c3',
    //         'mess putri' => 'mk_mess_putri',
    //         'mess meicu' => 'mk_mess_meicu',
    //     ];

    //     foreach (range(1, 10) as $i) {
    //         $tableMappings["b$i"] = "mk_mess_b{$i}";
    //     }

    //     $table = $tableMappings[strtolower($mess)];

    //     $columns = Schema::getColumnListing($table);
    //     $excludedColumns = [
    //         'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
    //         'approval_by', 'approval_on', 'approval_desc',
    //         'revisi_by', 'revisi_on', 'revisi_desc'
    //     ];

    //     $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
    //         return !in_array($column, $excludedColumns);
    //     });


    //     $totalExpression = implode(' + ', array_map(function ($col) {
    //         return "COALESCE($col, 0)";
    //     }, $numericColumns));

    //     $startDate = Carbon::createFromDate($tahun, $bulanAwal, 1)->startOfMonth()->toDateString();
    //     $endDate = Carbon::createFromDate($tahun, $bulanAkhir, 1)->endOfMonth()->toDateString();

    //     $data = DB::table($table)
    //         ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan")
    //         ->selectRaw("SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam') THEN $totalExpression ELSE 0 END) as total_plan")
    //         ->selectRaw("SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
    //         ->where('status', 2)
    //         ->whereBetween('tanggal', [$startDate, $endDate])
    //         ->groupBy(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"))
    //         ->orderBy(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"))
    //         ->get();

    //     $totalPlan = $data->sum('total_plan');
    //     $totalActual = $data->sum('total_actual');
    //     $totalTambahan = $totalActual - $totalPlan;
    //     $totalCost = $totalActual * 17000;

    //     return [
    //         'data' => $data,
    //         'total_plan' => $totalPlan,
    //         'total_actual' => $totalActual,
    //         'total_tambahan' => $totalTambahan,
    //         'total_cost' => $totalCost
    //     ];
    // }

    public function getGrafikMonthlyMess($mess, $bulanAwal, $bulanAkhir, $tahun)
{
    $customMess = [
        'a1' => ['mess_a1', 'rebusan_a1'],
        'a2' => ['mess_a2', 'rebusan_a2'],
        'c3' => ['mess_c3', 'rebusan_c3'],
    ];

    // Mess B1-B10
    foreach (range(1, 10) as $i) {
        $customMess["b$i"] = ["mess_b$i", "rebusan_b$i"];
    }

    $messKey = strtolower($mess);

    // Cek tabel berdasarkan jenis mess
    if ($messKey == 'mess putri') {
        $table = 'mk_mess_putri';
    } elseif ($messKey == 'mess meicu') {
        $table = 'mk_mess_meicu';
    } else {
        $table = 'mk_mess';
    }

    // Tentukan total expression
    if (in_array($messKey, ['mess putri', 'mess meicu'])) {
        // Ambil semua kolom numeric
        $columns = Schema::getColumnListing($table);
        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc'
        ];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

    } elseif (isset($customMess[$messKey])) {
        $totalExpression = "COALESCE({$customMess[$messKey][0]},0) + COALESCE({$customMess[$messKey][1]},0)";
    } else {
        throw new \Exception("Mess $mess tidak ditemukan.");
    }

    $startDate = Carbon::createFromDate($tahun, $bulanAwal, 1)->startOfMonth()->toDateString();
    $endDate = Carbon::createFromDate($tahun, $bulanAkhir, 1)->endOfMonth()->toDateString();

    $data = DB::table($table)
        ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan")
        ->selectRaw("SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam') THEN $totalExpression ELSE 0 END) as total_plan")
        ->selectRaw("SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
        ->where('status', 2)
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->groupBy(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"))
        ->orderBy(DB::raw("DATE_FORMAT(tanggal, '%Y-%m')"))
        ->get();

    $totalPlan = $data->sum('total_plan');
    $totalActual = $data->sum('total_actual');
    $totalTambahan = $totalActual - $totalPlan;
    $totalCost = $totalActual * 17000;

    return [
        'data' => $data,
        'total_plan' => $totalPlan,
        'total_actual' => $totalActual,
        'total_tambahan' => $totalTambahan,
        'total_cost' => $totalCost
    ];
}

    // public function getGrafikMonthlyAllMess($bulan, $tahun)
    // {
       
    //     $tableMappings = [
    //         'a1' => 'mk_mess_a1',
    //         'c3' => 'mk_mess_c3',
    //         'mess putri' => 'mk_mess_putri',
    //         'mess meicu' => 'mk_mess_meicu',
    //     ];

    //     foreach (range(1, 10) as $i) {
    //         $tableMappings["b$i"] = "mk_mess_b{$i}";
    //     }

    //     $departemenList = array_keys($tableMappings);
    //     $results = [];
    //     $totalTambangActual = 0;
    //     $totalTambangPlan = 0;

    //     foreach ($departemenList as $departemen) {
    //         $table = $tableMappings[$departemen];

    //         $columns = Schema::getColumnListing($table);
    //         $excludedColumns = [
    //             'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
    //             'approval_by', 'approval_on', 'approval_desc',
    //             'revisi_by', 'revisi_on', 'revisi_desc'
    //         ];

    //         $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
    //             return !in_array($column, $excludedColumns);
    //         });

    //         $totalExpression = implode(' + ', array_map(function ($col) {
    //             return "COALESCE($col, 0)";
    //         }, $numericColumns));

    //         $query = DB::table($table)
    //             ->selectRaw("
    //                 SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam') THEN $totalExpression ELSE 0 END) as total_plan,
    //                 SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual
    //             ")
    //             ->where('status', 2)
    //             ->whereMonth('tanggal', $bulan)
    //             ->whereYear('tanggal', $tahun)
    //             ->first();

    //         $actual = $query->total_actual ?? 0;
    //         $plan = $query->total_plan ?? 0;
    //         $surplus = $actual - $plan;

    //         $results[] = [
    //             'departemen' => $departemen,
    //             'total_plan' => $plan,
    //             'total_actual' => $actual,
    //             'surplus' => $surplus,
    //         ];

    //         // if (strtoupper($departemen) !== 'PLANT') {
    //         //     $totalTambangActual += $actual;
    //         //     $totalTambangPlan += $plan;
    //         // }
    //     }

    //     // Tambahkan TAMBANG
    //     $results[] = [
    //         //'departemen' => 'TAMBANG',
    //         'total_plan' => $totalTambangPlan,
    //         'total_actual' => $totalTambangActual,
    //         'surplus' => $totalTambangActual - $totalTambangPlan,
    //     ];

    //     return [
    //         'data' => $results
    //     ];
    // }

    public function getGrafikMonthlyAllMess($bulan, $tahun)
    {
        $customMess = [
            'a1' => ['mess_a1', 'rebusan_a1'],
            'a2' => ['mess_a2', 'rebusan_a2'],
            'c3' => ['mess_c3', 'rebusan_c3'],
        ];

        foreach (range(1, 10) as $i) {
            if (!in_array($i, [5, 6])) {
                $customMess["b$i"] = ["mess_b$i", "rebusan_b$i"];
            }
        }

        $departemenList = array_merge(array_keys($customMess), ['mess putri', 'mess meicu']);
        $results = [];
        $totalTambangActual = 0;
        $totalTambangPlan = 0;

        foreach ($departemenList as $departemen) {
            // Tentukan table
            if ($departemen == 'mess putri') {
                $table = 'mk_mess_putri';
            } elseif ($departemen == 'mess meicu') {
                $table = 'mk_mess_meicu';
            } else {
                $table = 'mk_mess';
            }

            // Tentukan total expression
            if (in_array($departemen, ['mess putri', 'mess meicu'])) {
                $columns = Schema::getColumnListing($table);
                $excludedColumns = [
                    'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
                    'approval_by', 'approval_on', 'approval_desc',
                    'revisi_by', 'revisi_on', 'revisi_desc'
                ];

                $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
                    return !in_array($column, $excludedColumns);
                });

                $totalExpression = implode(' + ', array_map(function ($col) {
                    return "COALESCE($col, 0)";
                }, $numericColumns));
            } elseif (isset($customMess[$departemen])) {
                $totalExpression = "COALESCE({$customMess[$departemen][0]},0) + COALESCE({$customMess[$departemen][1]},0)";
            } else {
                throw new \Exception("Mess $departemen tidak ditemukan.");
            }

            // Query
            $query = DB::table($table)
                ->selectRaw("
                    SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam') THEN $totalExpression ELSE 0 END) as total_plan,
                    SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual
                ")
                ->where('status', 2)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->first();

            $actual = $query->total_actual ?? 0;
            $plan = $query->total_plan ?? 0;
            $surplus = $actual - $plan;

            $results[] = [
                'departemen' => $departemen,
                'total_plan' => $plan,
                'total_actual' => $actual,
                'surplus' => $surplus,
            ];

            // Total tambang
            $totalTambangActual += $actual;
            $totalTambangPlan += $plan;
        }

        // Tambahkan TAMBANG
        $results[] = [
            'departemen' => 'TOTAL',
            'total_plan' => $totalTambangPlan,
            'total_actual' => $totalTambangActual,
            'surplus' => $totalTambangActual - $totalTambangPlan,
        ];

        return [
            'data' => $results
        ];
    }


    // COST DEPARTEMEN
    // public function getGrafikDailyAllCost($tanggalAwal, $tanggalAkhir)
    // {
    //     $tableMappings = [
    //     'COE' => 'mk_coe',
    //     'HCGA' => 'mk_hcga',
    //     'ENG' => 'mk_eng',
    //     'SHE' => 'mk_she',
    //     'FALOG' => 'mk_falog',
    //     'PRO' => 'mk_prod',
    //     'PLANT' => 'mk_plant',
    //     ];

    //     foreach (range(1, 10) as $i) {
    //     $tableMappings["B$i"] = "mk_mess_b{$i}";
    //     }

    //     $excludedColumns = [
    //     'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
    //     'approval_by', 'approval_on', 'approval_desc',
    //     'revisi_by', 'revisi_on', 'revisi_desc','visitor'
    //     ];

    //     $dailyActuals = [];

    //     foreach ($tableMappings as $table) {
    //     if (!Schema::hasTable($table)) {
    //         continue;
    //     }

    //     $columns = Schema::getColumnListing($table);
    //     $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
    //         return !in_array($column, $excludedColumns);
    //     });

    //     if (empty($numericColumns)) {
    //         continue;
    //     }

    //     $totalExpression = implode(' + ', array_map(function ($col) {
    //         return "COALESCE($col, 0)";
    //     }, $numericColumns));

    //     $data = DB::table($table)
    //         ->select(
    //             'tanggal',
    //             DB::raw("SUM(CASE WHEN waktu IN ('Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore', 'Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
    //         )
    //         ->where('status', 2)
    //         ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
    //         ->groupBy('tanggal')
    //         ->get();

    //     foreach ($data as $row) {
    //         $tanggal = $row->tanggal;
    //         $actual = $row->total_actual ?? 0;

    //         if (!isset($dailyActuals[$tanggal])) {
    //             $dailyActuals[$tanggal] = 0;
    //         }

    //         $dailyActuals[$tanggal] += $actual;
    //     }
    //     }

    //     $result = [];
    //     $totalSemuaCost = 0;

    //     foreach ($dailyActuals as $tanggal => $totalActual) {
    //     $cost = $totalActual * 17000;
    //     $result[] = [
    //         'tanggal' => $tanggal,
    //         'total_cost' => $cost
    //     ];
    //     $totalSemuaCost += $cost;
    //     }

    //     // Urutkan berdasarkan tanggal
    //     usort($result, function ($a, $b) {
    //     return strcmp($a['tanggal'], $b['tanggal']);
    //     });

    //     // Tambahkan total cost tetap dan sisa cost
    //     $fixedCost = 2100000000; // 2.1 Miliar
    //     $sisaCost = $fixedCost - $totalSemuaCost;

    //     return [
    //         'data_per_hari' => $result,
    //         'total_semua_cost' => $totalSemuaCost,
    //         'cost' => $fixedCost,
    //         'sisa_cost' => $sisaCost
    //     ];
    // }

    public function getGrafikDailyAllCost($tanggalAwal, $tanggalAkhir)
    {
        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PRO' => 'mk_prod',
            'PLANT' => 'mk_plant',
        ];

        $excludedColumns = [
            'id', 'tanggal', 'waktu', 'create_at', 'created_name', 'status',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc', 'visitor'
        ];

        $dailyActuals = [];

        // Hitung data dari tableMappings dulu (tabel biasa)
        foreach ($tableMappings as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            $columns = Schema::getColumnListing($table);
            $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
                return !in_array($column, $excludedColumns);
            });

            if (empty($numericColumns)) {
                continue;
            }

            $totalExpression = implode(' + ', array_map(function ($col) {
                return "COALESCE($col, 0)";
            }, $numericColumns));

            $data = DB::table($table)
                ->select(
                    'tanggal',
                    DB::raw("SUM(CASE WHEN waktu IN ('Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore', 'Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
                )
                ->where('status', 2)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                ->groupBy('tanggal')
                ->get();

            foreach ($data as $row) {
                $tanggal = $row->tanggal;
                $actual = $row->total_actual ?? 0;

                if (!isset($dailyActuals[$tanggal])) {
                    $dailyActuals[$tanggal] = 0;
                }

                $dailyActuals[$tanggal] += $actual;
            }
        }

        // Tambahkan hitungan dari customMess dan mess putri & mess meicu per tanggal
        $customMess = [
            'a1' => ['mess_a1', 'rebusan_a1'],
            'a2' => ['mess_a2', 'rebusan_a2'],
            'c3' => ['mess_c3', 'rebusan_c3'],
        ];

        foreach (range(1, 10) as $i) {
            if (!in_array($i, [5, 6])) {
                $customMess["b$i"] = ["mess_b$i", "rebusan_b$i"];
            }
        }

        $departemenList = array_merge(array_keys($customMess), ['mess putri', 'mess meicu']);

        foreach ($departemenList as $departemen) {
            // Tentukan tabel berdasarkan departemen
            if ($departemen == 'mess putri') {
                $table = 'mk_mess_putri';
            } elseif ($departemen == 'mess meicu') {
                $table = 'mk_mess_meicu';
            } else {
                $table = 'mk_mess';
            }

            if (!Schema::hasTable($table)) {
                continue;
            }

            if (in_array($departemen, ['mess putri', 'mess meicu'])) {
                $columns = Schema::getColumnListing($table);
                $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
                    return !in_array($column, $excludedColumns);
                });

                if (empty($numericColumns)) {
                    continue;
                }

                $totalExpression = implode(' + ', array_map(function ($col) {
                    return "COALESCE($col, 0)";
                }, $numericColumns));
            } elseif (isset($customMess[$departemen])) {
                $totalExpression = "COALESCE({$customMess[$departemen][0]},0) + COALESCE({$customMess[$departemen][1]},0)";
            } else {
                continue;
            }

            $data = DB::table($table)
                ->select(
                    'tanggal',
                    DB::raw("SUM(CASE WHEN waktu IN ('Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam') THEN $totalExpression ELSE 0 END) as total_actual")
                )
                ->where('status', 2)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                ->groupBy('tanggal')
                ->get();

            foreach ($data as $row) {
                $tanggal = $row->tanggal;
                $actual = $row->total_actual ?? 0;

                if (!isset($dailyActuals[$tanggal])) {
                    $dailyActuals[$tanggal] = 0;
                }

                $dailyActuals[$tanggal] += $actual;
            }
        }

        $result = [];
        $totalSemuaCost = 0;

        foreach ($dailyActuals as $tanggal => $totalActual) {
            $cost = $totalActual * 17000;
            $result[] = [
                'tanggal' => $tanggal,
                'total_cost' => $cost,
            ];
            $totalSemuaCost += $cost;
        }

        usort($result, function ($a, $b) {
            return strcmp($a['tanggal'], $b['tanggal']);
        });

        $fixedCost = 2100000000; // 2.1 Miliar
        $sisaCost = $fixedCost - $totalSemuaCost;

        return [
            'data_per_hari' => $result,
            'total_semua_cost' => $totalSemuaCost,
            'cost' => $fixedCost,
            'sisa_cost' => $sisaCost,
        ];
    }

    //SNACK DAN SPESIAL
    public function getGrafikDailySnackSpesial($tanggalAwal, $tanggalAkhir, $departemen)
    {
        $snackData = DB::table('mk_snack')
            ->select('jenis', DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->where('departemen', $departemen)
            ->where('status', 2)
            ->groupBy('jenis');

        $spesialData = DB::table('mk_spesial')
            ->select('jenis', DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->where('departemen', $departemen)
            ->where('status', 2)
            ->groupBy('jenis');

        $result = $snackData->unionAll($spesialData)->get();
    // dd($result);
        return $result; 
    }

    public function getSnackDataPerBulan($bulanAwal, $bulanAkhir, $tahun, $departemen)
    {
        $snackData = DB::table('mk_snack')
            ->select(
                DB::raw("EXTRACT(MONTH FROM tanggal) AS bulan"),
                'jenis',
                DB::raw("COUNT(*) AS total")
            )
            ->whereYear('tanggal', $tahun)
            ->whereBetween(DB::raw("EXTRACT(MONTH FROM tanggal)"), [$bulanAwal, $bulanAkhir])
            ->where('departemen', $departemen)
            ->where('status', 2)
            ->groupBy('bulan', 'jenis');

        $spesialData = DB::table('mk_spesial')
            ->select(
                DB::raw("EXTRACT(MONTH FROM tanggal) AS bulan"),
                'jenis',
                DB::raw("COUNT(*) AS total")
            )
            ->whereYear('tanggal', $tahun)
            ->whereBetween(DB::raw("EXTRACT(MONTH FROM tanggal)"), [$bulanAwal, $bulanAkhir])
            ->where('departemen', $departemen)
            ->where('status', 2)
            ->groupBy('bulan', 'jenis');

        return $snackData->unionAll($spesialData)->get();
    }


  


}
