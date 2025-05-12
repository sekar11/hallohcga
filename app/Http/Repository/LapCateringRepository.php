<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;
use Illuminate\Support\Facades\Schema;

class LapCateringRepository
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
            return "COALESCE($col, 0)";
        }, $numericColumns));

        return DB::table($tableName)
        ->select(
            'id',
            'tanggal',
            'created_name',
            'waktu',
            'status',
            DB::raw("($totalExpression) AS total")
        )
        ->whereBetween('tanggal', [$startDate, $endDate]) // Filter berdasarkan tanggal
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
            'Mess Meicu' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
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

        // Kolom yang dikecualikan darotal perhitungan
        $excludedColumns = ['id', 'tanggal', 'waktu', 'created_at', 'created_name', 'status'];

        // Ambil kolom numerik untuk perhitungan total
        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

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
            'Mess Meicu' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
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
            'Mess Meicu' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
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
            'Mess Meicu' => 'mk_mess_meicu',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
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

    public function getCateringFitri($month, $year, $catering)
    {
        $cateringTables = [
            'FITRI' => ['main' => 'catering_fitri', 'tambahan' => 'catering_tambahan_fitri'],
            'WASTU' => ['main' => 'catering_wastu', 'tambahan' => 'catering_tambahan_wastu'],
            'BINTANG' => ['main' => 'catering_bintang', 'tambahan' => 'catering_tambahan_bintang']
        ];

        $cateringColumns = [
            'FITRI' => [
                'tanggal'                          => 'tanggal',
                'prod_csa_pit1'                    => 'prod_csa_pit1',
                'prod_skillup_csapit1'             => 'prod_skillup_csapit1',
                'section_head_pit1'                => 'section_head_pit1',
                'prod_pit2'                        => 'prod_pit2',
                'driver_lv_pit2'                   => 'driver_lv_pit2',
                'section_head_pit2'                => 'section_head_pit2',
                'eng_drill'                        => 'eng_drill',
                'eng_csapit2'                      => 'eng_csapit2',
                'eng_driver_csapit2'               => 'eng_driver_csapit2',
                'eng_vendor_jmi'                   => 'eng_vendor_jmi',
                'hcga_security_rosela'             => 'hcga_security_rosela',
                'prod_pitstop'                     => 'prod_pitstop',
                'prod_csahrm'                      => 'prod_csahrm',
            ],
            'WASTU' => [
                'tanggal' => 'tanggal',
                'pagi_kamar_c3' => 'pagi_kamar_c3',
                'siang_kamar_c3' => 'siang_kamar_c3',
                'siang_mess_gl' => 'siang_mess_gl',
                'siang_mess_admin' => 'siang_mess_admin',
                'siang_helper_mess_putri' => 'siang_helper_mess_putri',
                'siang_laundry' => 'siang_laundry',
                'siang_ruko_1' => 'siang_ruko_1',
                'siang_ruko_2' => 'siang_ruko_2',
                'siang_ruko_3' => 'siang_ruko_3',
                'siang_ruko_45' => 'siang_ruko_45',
                'siang_driver_meicu' => 'siang_driver_meicu',
                'siang_office_meicu' => 'siang_office_meicu',
                'siang_security_meicu' => 'siang_security_meicu',
                'siang_vendor_meicu' => 'siang_vendor_meicu',
                'siang_cv_ade' => 'siang_cv_ade',
                'siang_helper_meicu' => 'siang_helper_meicu',
                'siang_kamar_a1' => 'siang_kamar_a1',
                'siang_kamar_a2' => 'siang_kamar_a2',
                'siang_kamar_b1' => 'siang_kamar_b1',
                'siang_kamar_b2' => 'siang_kamar_b2',
                'siang_kamar_b3' => 'siang_kamar_b3',
                'siang_kamar_b4' => 'siang_kamar_b4',
                'siang_kamar_b7' => 'siang_kamar_b7',
                'siang_kamar_b8' => 'siang_kamar_b8',
                'siang_kamar_b9' => 'siang_kamar_b9',
                'siang_kamar_b10' => 'siang_kamar_b10',
                'siang_mess_b1' => 'siang_mess_b1',
                'siang_mess_b2' => 'siang_mess_b2',
                'siang_mess_b3' => 'siang_mess_b3',
                'siang_mess_b4' => 'siang_mess_b4',
                'siang_mess_b7' => 'siang_mess_b7',
                'siang_mess_b8' => 'siang_mess_b8',
                'siang_mess_b9' => 'siang_mess_b9',
                'siang_mess_b10' => 'siang_mess_b10',
                'siang_spare_amm' => 'siang_spare_amm',
                'siang_container_ga_mess' => 'siang_container_ga_mess',
                'siang_electrical_ga' => 'siang_electrical_ga',
                'siang_helper_mess' => 'siang_helper_mess',
                'siang_driver_bus' => 'siang_driver_bus',
                'siang_koperasi_mess' => 'siang_koperasi_mess',
                'siang_kontainer_medic' => 'siang_kontainer_medic',
                'siang_security_poss' => 'siang_security_poss',
                'siang_mekanic_trac' => 'siang_mekanic_trac',
                'siang_driver_bus_jumat_mess' => 'siang_driver_bus_jumat_mess',
                'siang_gl_civil' => 'siang_gl_civil',
                'siang_skill_up_lt' => 'siang_skill_up_lt',
                'siang_dept_head_plant' => 'siang_dept_head_plant',
                'siang_tamu_ho' => 'siang_tamu_ho',
                'siang_pjo' => 'siang_pjo',
                'siang_dept_sect_csapit1' => 'siang_dept_sect_csapit1',
                'siang_dept_head' => 'siang_dept_head',
                'siang_dept_head_plant' => 'siang_dept_head_plant',
                'siang_dept_head_pitstop' => 'siang_dept_head_pitstop',
                'siang_driver_bus_jumat' => 'siang_driver_bus_jumat',
                'siang_office_ccr_moco' => 'siang_office_ccr_moco',
                'siang_section' => 'siang_section',
                'siang_plant' => 'siang_plant',
                'siang_sect_head_plant' => 'siang_sect_head_plant',
                'siang_security_patrol' => 'siang_security_patrol',
                'siang_hcga_office_plant' => 'siang_hcga_office_plant',
                'siang_sect_head' => 'siang_sect_head',
                'siang_driver_plant' => 'siang_driver_plant',
                'siang_sertifikasi_hcga' => 'siang_sertifikasi_hcga',
                'siang_admin_officeplant' => 'siang_admin_officeplant',
                'siang_driver_eng' => 'siang_driver_eng',
                'siang_sect_head_eng' => 'siang_sect_head_eng',
                'siang_engineering' => 'siang_engineering',
                'sore_kamar_c3' => 'sore_kamar_c3',
                'malam_plant_pitstop' => 'malam_plant_pitstop',
                'malam_driver_plant' => 'malam_driver_plant',
                'malam_plant_workshop' => 'malam_plant_workshop',
                'malam_driver_workshop' => 'malam_driver_workshop',
                'malam_mechanic_koperasi' => 'malam_mechanic_koperasi',
                'malam_kontainer_medic' => 'malam_kontainer_medic',
                'malam_security_poss' => 'malam_security_poss',
                'malam_helper_mess' => 'malam_helper_mess',
                'malam_admin_ga' => 'malam_admin_ga',
                'malam_driver_mess' => 'malam_driver_mess',
                'malam_electrical_ga' => 'malam_electrical_ga',
                'malam_mekanic_trac' => 'malam_mekanic_trac',
                'malam_coe_csa_pit1' => 'malam_coe_csa_pit1',
                'malam_mpss6_sysdev' => 'malam_mpss6_sysdev',
                'malam_mpccr_admccr' => 'malam_mpccr_admccr',
                'malam_dept_sect_csapit2' => 'malam_dept_sect_csapit2',
                'malam_prod_pit2' => 'malam_prod_pit2',
                'malam_driverlv_csapit2' => 'malam_driverlv_csapit2',
                'malam_prod_pit3' => 'malam_prod_pit3',
                'malam_vendor_jmi' => 'malam_vendor_jmi',
                'malam_she_csa_pit1' => 'malam_she_csa_pit1',
                'malam_driver' => 'malam_driver',
                'malam_log_warehouse_falog' => 'malam_log_warehouse_falog',
                'malam_mechanic_koperasi' => 'malam_mechanic_koperasi',
                'malam_fuel' => 'malam_fuel',
                'malam_driver_helper_office' => 'malam_driver_helper_office',
                'malam_security_pit1' => 'malam_security_pit1',
                'malam_security_pit3' => 'malam_security_pit3',
                'malam_security_anjungan' => 'malam_security_anjungan',
                'malam_security_laundry' => 'malam_security_laundry',
                'malam_security_plant'       => 'malam_security_plant',
                'malam_security_patrol'      => 'malam_security_patrol',
                'malam_base_control'         => 'malam_base_control',
                'malam_eng_plant'            => 'malam_eng_plant',
                'malam_coe_office'           => 'malam_coe_office',

            ],
            'BINTANG' => [
                'tanggal'                      => 'tanggal',
                'pagi_mess_gl'                 => 'pagi_mess_gl',
                'pagi_rebusan_gl'              => 'pagi_rebusan_gl',
                'pagi_mess_admin'              => 'pagi_mess_admin',
                'pagi_rebusan_admin'           => 'pagi_rebusan_admin',
                'pagi_ruko_1'                  => 'pagi_ruko_1',
                'pagi_ruko_2'                  => 'pagi_ruko_2',
                'pagi_ruko_3'                  => 'pagi_ruko_3',
                'pagi_ruko_45'                 => 'pagi_ruko_45',
                'pagi_rebusan_ruko1'           => 'pagi_rebusan_ruko1',
                'pagi_rebusan_ruko2'           => 'pagi_rebusan_ruko2',
                'pagi_rebusan_ruko3'           => 'pagi_rebusan_ruko3',
                'pagi_rebusan_ruko45'          => 'pagi_rebusan_ruko45',
                'pagi_magang_meicu'            => 'pagi_magang_meicu',
                'pagi_test_praktek'            => 'pagi_test_praktek',
                'pagi_kamar_a1'                => 'pagi_kamar_a1',
                'pagi_rebusan_a1'              => 'pagi_rebusan_a1',
                'pagi_kamar_a2'                => 'pagi_kamar_a2',
                'pagi_rebusan_a2'              => 'pagi_rebusan_a2',
                'pagi_kamar_b1'                => 'pagi_kamar_b1',
                'pagi_rebusan_b1'              => 'pagi_rebusan_b1',
                'pagi_kamar_b2'                => 'pagi_kamar_b2',
                'pagi_rebusan_b2'              => 'pagi_rebusan_b2',
                'pagi_kamar_b3'                => 'pagi_kamar_b3',
                'pagi_rebusan_b3'              => 'pagi_rebusan_b3',
                'pagi_kamar_b4'                => 'pagi_kamar_b4',
                'pagi_rebusan_b4'              => 'pagi_rebusan_b4',
                'pagi_rebusan_b6'              => 'pagi_rebusan_b6',
                'pagi_kamar_b7'                => 'pagi_kamar_b7',
                'pagi_rebusan_b7'              => 'pagi_rebusan_b7',
                'pagi_kamar_b8'                => 'pagi_kamar_b8',
                'pagi_rebusan_b8'              => 'pagi_rebusan_b8',
                'pagi_kamar_b9'                => 'pagi_kamar_b9',
                'pagi_rebusan_b9'              => 'pagi_rebusan_b9',
                'pagi_kamar_b10'               => 'pagi_kamar_b10',
                'pagi_rebusan_b10'             => 'pagi_rebusan_b10',
                'pagi_spare_b1'                => 'pagi_spare_b1',
                'pagi_visitor_hcga'            => 'pagi_visitor_hcga',
                'pagi_bagong'                  => 'pagi_bagong',
                'pagi_vendor_jmi'             => 'pagi_vendor_jmi',
                'siang_pitcontrol'             => 'siang_pitcontrol',
                // 'siang_eng_csa_pit2_drill_blast' => 'siang_eng_csa_pit2_drill_blast',
                // 'siang_eng_csa_pit2'           => 'siang_eng_csa_pit2',
                // 'siang_driver_survey'          => 'siang_driver_survey',
                // 'siang_vendor_jmi'             => 'siang_vendor_jmi',
                'siang_mpccr_admccr_pit'       => 'siang_mpccr_admccr_pit',
                'siang_coe_pitstop_ss6'        => 'siang_coe_pitstop_ss6',
                'siang_coe_csa_pit1_ict'       => 'siang_coe_csa_pit1_ict',
                'siang_mpict_driver'           => 'siang_mpict_driver',
                'siang_plant_pitstop'          => 'siang_plant_pitstop',
                'siang_training'               => 'siang_training',
                'siang_driver_plant'           => 'siang_driver_plant',
                'siang_plant_office_pitstop'   => 'siang_plant_office_pitstop',
                'siang_plant_workshop'         => 'siang_plant_workshop',
                'siang_driver_workshop'        => 'siang_driver_workshop',
                'siang_sect_head_pitstop'      => 'siang_sect_head_pitstop',
                'siang_sect_head_plant'        => 'siang_sect_head_plant',
                'siang_sect_head_she'          => 'siang_sect_head_she',
                'siang_she_csa_pit1'           => 'siang_she_csa_pit1',
                'siang_driver_she'             => 'siang_driver_she',
                'siang_driver_fa_log'          => 'siang_driver_fa_log',
                'siang_koperasi_office'        => 'siang_koperasi_office',
                'siang_falog_warehouse'        => 'siang_falog_warehouse',
                'siang_sect_head_falog'        => 'siang_sect_head_falog',
                'siang_fuel'                   => 'siang_fuel',
                'siang_mechanic_koperasi'      => 'siang_mechanic_koperasi',
                'siang_test_praktek_hcga'      => 'siang_test_praktek_hcga',
                'siang_admin_spbi'             => 'siang_admin_spbi',
                'siang_carpenter'              => 'siang_carpenter',
                'siang_test_praktek_csapit'    => 'siang_test_praktek_csapit',
                'siang_security_spbi'          => 'siang_security_spbi',
                'siang_prod_pit_3'             => 'siang_prod_pit_3',
                'sore_mess_gl'                 => 'sore_mess_gl',
                'sore_mess_admin'              => 'sore_mess_admin',
                'sore_ruko_1'                  => 'sore_ruko_1',
                'sore_ruko_2'                  => 'sore_ruko_2',
                'sore_ruko_3'                  => 'sore_ruko_3',
                'sore_ruko_45'                 => 'sore_ruko_45',
                'sore_test_praktek'            => 'sore_test_praktek',
                'sore_magang_meicu'            => 'sore_magang_meicu',
                'sore_security_meicu'          => 'sore_security_meicu',
                'sore_visitor'                 => 'sore_visitor',
                'sore_helper_meicu'            => 'sore_helper_meicu',
                'sore_bagong'                  => 'sore_bagong',
                'sore_test_praktek_hcga'       => 'sore_test_praktek_hcga',
                'sore_admin_spbi'              => 'sore_admin_spbi',
                'sore_carpenter'               => 'sore_carpenter',
                'sore_test_praktek_csapit1'    => 'sore_test_praktek_csapit1',
                'sore_security_spbi'           => 'sore_security_spbi',
                'sore_vendor_jmi'              => 'sore_vendor_jmi',
                'sore_kamar_a1'                => 'sore_kamar_a1',
                'sore_kamar_a2'                => 'sore_kamar_a2',
                'sore_rebusan_a1'              => 'sore_rebusan_a1',
                'sore_rebusan_a2'              => 'sore_rebusan_a2',
                'sore_kamar_b1'                => 'sore_kamar_b1',
                'sore_rebusan_b1'              => 'sore_rebusan_b1',
                'sore_kamar_b2'                => 'sore_kamar_b2',
                'sore_rebusan_b2'              => 'sore_rebusan_b2',
                'sore_kamar_b3'                => 'sore_kamar_b3',
                'sore_rebusan_b3'              => 'sore_rebusan_b3',
                'sore_kamar_b4'                => 'sore_kamar_b4',
                'sore_rebusan_b4'              => 'sore_rebusan_b4',

                'sore_rebusan_b6'              => 'sore_rebusan_b6',
                'sore_kamar_b7'                => 'sore_kamar_b7',
                'sore_rebusan_b7'              => 'sore_rebusan_b7',
                'sore_kamar_b8'                => 'sore_kamar_b8',
                'sore_rebusan_b8'              => 'sore_rebusan_b8',
                'sore_kamar_b9'                => 'sore_kamar_b9',
                'sore_rebusan_b9'              => 'sore_rebusan_b9',
                'sore_kamar_b10'               => 'sore_kamar_b10',
                'sore_rebusan_b10'             => 'sore_rebusan_b10',
                'sore_spare_b1'                => 'sore_spare_b1',

            ]
        ];

        if (!isset($cateringTables[$catering]) || !isset($cateringColumns[$catering])) {
            return collect();
        }

        $tables = $cateringTables[$catering];
        $columns = $cateringColumns[$catering];

        $mainQuery = DB::table($tables['main'])
            ->select(DB::raw("DATE({$columns['tanggal']}) as tanggal"));

        $tambahanQuery = DB::table($tables['tambahan'])
            ->select(DB::raw("DATE({$columns['tanggal']}) as tanggal"));

        foreach ($columns as $alias => $colName) {
            if ($alias !== 'tanggal') {
                $mainQuery->addSelect(DB::raw("SUM($colName) as $alias"));
                $tambahanQuery->addSelect(DB::raw("SUM($colName) as $alias"));
            }
        }

        $mainQuery->whereMonth($columns['tanggal'], $month)
            ->whereYear($columns['tanggal'], $year)
            ->groupBy(DB::raw("DATE({$columns['tanggal']})"));

        $tambahanQuery->whereMonth($columns['tanggal'], $month)
            ->whereYear($columns['tanggal'], $year)
            ->groupBy(DB::raw("DATE({$columns['tanggal']})"));

        // Union kedua query
        $finalQuery = $mainQuery->unionAll($tambahanQuery);

        // Bungkus hasil union dalam query builder buat bisa select final group by tanggal dan SUM lagi
        $result = DB::table(DB::raw("({$finalQuery->toSql()}) as combined"))
            ->mergeBindings($finalQuery)
            ->select('tanggal');

        foreach ($columns as $alias => $colName) {
            if ($alias !== 'tanggal') {
                $result->addSelect(DB::raw("SUM($alias) as $alias"));
            }
        }

        $result->groupBy('tanggal');

        return $result->get();
    }

    public function getCateringData($date, $categories, $cateringName)
    {
        $tableName = 'catering_' . strtolower($cateringName);
        $result = [];

        // Mapping kategori per catering
        $categoryMapping = [
            'fitri' => [
                'Makan Tambang Siang' => [
                    'Produksi CSA PIT 1'                  => 'prod_csa_pit1',
                    'Section Head Anjungan pit 1'         => 'section_head_pit1',
                    'Produksi CSA PIT 1 Akademi Skill up' => 'prod_skillup_csapit1',
                    'Prod PIT 2'                          => 'prod_pit2',
                    // 'Prod PIT 3'                          => 'prod_pit3',
                    'DRIVER LV PRODUKSI PIT 2'            => 'driver_lv_pit2',
                    'Sect. Head Produksi PIT 2'           => 'section_head_pit2',
                    'ENG CSA PIT 2 DRILL & BLAST'         => 'eng_drill',
                    'Eng CSA Pit 2'                       => 'eng_csapit2',
                    'DRIVER ENG CSA PIT 2T'               => 'eng_driver_csapit2',
                    'ENG CSA HRM (Vendor JMI)'            => 'eng_vendor_jmi',
                    'HCGA CSA PIT 2 ROSELA (SECURITY)'    => 'hcga_security_rosela',
                    'PRODUKSI PITSTOP (Di Tulis ODP)'     => 'prod_pitstop',
                    'PRODUKSI CSA HRM SKILL UP (ACADEMY)' => 'prod_csahrm',
                ],
            ],
            'wastu' => [
                'MK PAGI MESS C 3(DH & SH)' => [
                    'MESS DH & PJO - MESS SECTION HEAD' => 'pagi_kamar_c3',
                ],
                'MK SIANG MESS PUTRI TALANG JAWA' => [
                        'MESS GL PUTRI TALANG JAWA' => 'siang_mess_gl',
                        'MESS ADMIN PUTRI TALANG JAWA' => 'siang_mess_admin',
                        'HELPER MESS PUTRI' => 'siang_helper_mess',
                ],
                'MK SIANG MESS C3 (DH & SH)' => [
                    'MESS DPET/SECT HEAD' => 'siang_kamar_c3',
                ],
                'MK SIANG MESS PUTRI TALANG JAWA' => [
                    'Mess GL Putri Talang Jawa' => 'siang_mess_gl',
                    'MESS ADMIN PUTRI Talang Jawa' => 'siang_mess_admin',
                    'HELPER MESS PUTRI' => 'siang_helper_mess_putri',
                ],
                'MK SIANG KARTIKA' => [
                    'LAUNDRY KARTIKA' => 'siang_laundry',
                ],
                'MK SIANG MEICU' => [
                    'Mess Meicu R1' => 'siang_ruko_1',
                    'Mess Meicu R2' => 'siang_ruko_2',
                    'Mess Meicu R3 FMDP' => 'siang_ruko_3',
                    'Mess Meicu R4-5' => 'siang_ruko_45',
                ],
                'MK SIANG OFFICE GA MEICU' => [
                    'Driver LV' => 'siang_driver_meicu',
                    'Office Meicu' => 'siang_office_meicu',
                    'Meicu Security' => 'siang_security_meicu',
                    'VENDOR' => 'siang_vendor_meicu',
                    'CV ADE(PETUGAS SAMPAH)' => 'siang_cv_ade',
                    'Helper' => 'siang_helper_meicu',
                ],
                'MK SIANG MESS TAMBANG' => [
                    'RENCANA MESS GL A1' => 'siang_kamar_a1',
                    'RENCANA MESS GL A2' => 'siang_kamar_a2',
                    'Rencana Mess B1' => 'siang_kamar_b1',
                    'Rencana Mess B2' => 'siang_kamar_b2',
                    'Rencana Mess B3' => 'siang_kamar_b3',
                    'Rencana Mess B4' => 'siang_kamar_b4',
                    'Rencana Mess B7' => 'siang_kamar_b7',
                    'Rencana Mess B8' => 'siang_kamar_b8',
                    'Rencana Mess B9' => 'siang_kamar_b9',
                    'Rencana Mess B10' => 'siang_kamar_b10',
                ],
                'MK SIANG MESS TAMBANG AMM' => [
                    'Rencana Mess B1' => 'siang_mess_b1',
                    'Rencana Mess B2' => 'siang_mess_b2',
                    'Rencana Mess B3' => 'siang_mess_b3',
                    'Rencana Mess B4' => 'siang_mess_b4',
                    'Rencana Mess B7' => 'siang_mess_b7',
                    'Rencana Mess B8' => 'siang_mess_b8',
                    'Rencana Mess B9' => 'siang_mess_b9',
                    'Rencana Mess B10' => 'siang_mess_b10',
                    'SPARE' => 'siang_spare_amm',
                ],
                'OFFICE GA MESS TAMBANG' => [
                    'Kontainer GA Mess Tambang' => 'siang_container_ga_mess',
                    'Electrical GA' => 'siang_electrical_ga',
                    'Helper Mess' => 'siang_helper_mess',
                    'Driver bus Mess Tambang' => 'siang_driver_bus',
                    'KOPERASI MESS TAMBANG' => 'siang_koperasi_mess',
                    'KONTAINER MEDIC MESS TAMBANG' => 'siang_kontainer_medic',
                    'Security Mess Tambang' => 'siang_security_poss',
                    'Mekanik TRAC Mess Tambang' => 'siang_mekanic_trac',
                    'Driver BUS JUM\'AT' => 'siang_driver_bus_jumat',
                    'GL CIVIEL ENG' => 'siang_gl_civil',
                    'Skill UP LT CSA pit 1' => 'siang_skill_up_lt',
                ],
                'MK SIANG DEPTHEAD & PJO' => [
                    'Dept.Head ENG ★(Office Plant)' => 'siang_dept_head_eng',
                    'TAMU HO COE ★(Office Plant)' => 'siang_tamu_ho',
                    'PJO ★(Office Plant)' => 'siang_pjo',
                    'Dept.Head Produksi ★(CSA PIT 1)' => 'siang_dept_sect_csapit1',
                    'Dept Head SHE ★(CSA PIT 1)' => 'siang_dept_head',
                    'Dept.Head PLANT ★(WORKSHOP)' => 'siang_dept_head_plant',
                    'Dept.Head PLANT ★(PITSTOP)' => 'siang_dept_head_pitstop,', //'BELUM', // Belum ada kode
                ],
                'OFFICE PLANT SIANG' => [
                    'Driver Bus Jum\'atan' => 'siang_driver_bus_jumat', // Harusnya ada dua data katanya
                    'COE OFFICE ( CCR,MOCO)' => 'siang_office_ccr_moco',
                    'SectHead COE' => 'siang_section',
                    'PLANT' => 'siang_plant',
                    'Section Head PLANT' => 'siang_sect_head_plant',
                    'SECURITY PATROL' => 'siang_security_patrol',
                    'HCGA' => 'siang_hcga_office_plant',
                    'Section Head HCGA' => 'siang_sect_head',
                    'DRIVER HCGA (88,01)' => 'siang_driver_plant',
                    'SERTIFIKASI HCGA' => 'siang_sertifikasi_hcga',
                    'Produksi' => 'siang_admin_officeplant',
                    'Driver Engineering' => 'siang_driver_eng',
                    'Sect.Head ENG' => 'siang_sect_head_eng',
                    'Engineering' => 'siang_engineering',
                ],
                'MK SORE MESS DH & SH (PPA RESIDANCE)' => [
                    'MESS DH & PJO - MESS SECTION HEAD' => 'sore_kamar_c3',

                ],
                'MK TAMBANG MALAM' => [
                    'Plant Pitstop' => 'malam_plant_pitstop',
                    //sekar
                    'DRIVER PLANT PITSTOP' => 'malam_driver_plant_plant',
                    'Plant Workshop' => 'malam_plant_workshop',
                    'DRIVER PLANT WORKSHOP' => 'malam_driver_workshop',
                    'FA - LOG KOPERASI MESS TAMBANG' => 'malam_mechanic_koperasi',
                    'SHE KONTAINER MEDIC MESS TAMBANG' => 'malam_kontainer_medic',
                    'HCGA Security mess tambang' => 'malam_security_poss',
                    'Helper mess tambang' => 'malam_helper_mess',
                    'Kontainer GA Mess Tambang' => 'malam_admin_ga',
                    'driver lv mess tambang' => 'malam_driver_mess',
                    'ELEKTRIKAL GA MESS TAMBANG' => 'malam_electrical_ga',
                    'Mekanik TRAC Mess Tambang' => 'malam_mekanic_trac',
                    'COE( ICT ) CSA PIT 1' => 'malam_coe_csa_pit1',
                    'COE PITSOP - SS6' => 'malam_mpss6_sysdev',
                    'COE CSA PIT 3' => 'malam_mpccr_admccr',
                    'Sect. Head Produksi PIT 2' => 'malam_dept_sect_csapit2',
                    'Prod PIT 2' => 'malam_prod_pit2',
                    'DRIVER LV PRODUKSI PIT 2' => 'malam_driverlv_csapit2',
                    'Produksi Pit 3' => 'malam_prod_pit3',
                    'ENG CSA HRM (Vendor JMI)' => 'malam_vendor_jmi',
                    'SHE CSA PIT 1' => 'malam_she_csa_pit1',
                    'DRIVER SHE CSA PIT 1' => 'malam_driver',
                    'LOG WAREHOUSE' => 'malam_log_warehouse_falog',
                    'malam_mechanic_koperasi' => 'malam_mechanic_koperasi',
                    'Fuel' => 'malam_fuel',
                    'Driver GA+Helper office' => 'malam_driver_helper_office',
                    'Security Pit 2' => 'malam_security_pit1', // 'BELUM',
                    'Security Pit 3' => 'malam_security_pit3', // BELUM
                    'Security anjungan' => 'malam_security_anjungan', // BELUM
                    'SECURITY LAUNDRY KARTIKA' => 'malam_security_laundry',
                ],
                'MK OFFICE PLANT MALAM' => [
                    'Security'             => 'malam_security_plant',
                    'SECURITY PATROL'      => 'malam_security_patrol',
                    'PLANT'                => 'malam_base_control',
                    'ENGINEERING'          => 'malam_eng_plant',
                    'COE - CCR'            => 'malam_coe_office',
                ],
            ],
            'bintang' => [
                'MK PAGI MESS PUTRI' => [
                    'MESS GL PUTRI TALANG JAWA'     => 'pagi_mess_gl',
                    'REBUSAN GL PUTRI TALANG JAWA'  => 'pagi_rebusan_gl',
                    'MESS ADMIN PUTRI TALANG JAWA'  => 'pagi_mess_admin',
                    'REBUSAN ADMIN PUTRI'           => 'pagi_rebusan_admin',
                ],
                'MK PAGI MESS MEICU' => [
                    'Meicu Ruko 1'       => 'pagi_ruko_1',
                    'Meicu Ruko 2'       => 'pagi_ruko_2',
                    'Meicu Ruko 3'       => 'pagi_ruko_3',
                    'Meicu Ruko 4-5'     => 'pagi_ruko_45',
                    'REBUSAN R1'         => 'pagi_rebusan_ruko1',
                    'REBUSAN R3'         => 'pagi_rebusan_ruko3',
                    'REBUSAN R4-R5'      => 'pagi_rebusan_ruko45',
                    'VISITOR'            => 'pagi_visitor_hcga',
                    'MAGANG'         => 'pagi_magang_meicu',
                ],
                'MK PAGI OFFICE PLANT' => [
                    'VENDOR JMI' => 'pagi_vendor_jmi',
                ],
                'MK PAGI OFFICE MEICU' => [
                    'Bagong'        => 'pagi_bagong',
                    'TEST PRAKTEK'  => 'pagi_test_praktek',
                ],
                'MK PAGI MESS TAMBANG' => [
                    'Mess Tambang GL A1' => 'pagi_kamar_a1',
                    'Mess Tambang GL A2' => 'pagi_kamar_a2',
                    'Mess Tambang B1'    => 'pagi_kamar_b1',
                    'Mess Tambang B2'    => 'pagi_kamar_b2',
                    'Mess Tambang B3'    => 'pagi_kamar_b3',
                    'Mess Tambang B4'    => 'pagi_kamar_b4',
                    'Mess Tambang B7'    => 'pagi_kamar_b7',
                    'Mess Tambang B8'    => 'pagi_kamar_b8',
                    'Mess Tambang B9'    => 'pagi_kamar_b9',
                    'Mess Tambang B10'   => 'pagi_kamar_b10',
                    'REBUSAN GL A1'      => 'pagi_rebusan_a1',
                    'REBUSAN GL A2'      => 'pagi_rebusan_a2',
                    'REBUSAN B1'         => 'pagi_rebusan_b1',
                    'REBUSAN B2'         => 'pagi_rebusan_b2',
                    'REBUSAN B3'         => 'pagi_rebusan_b3',
                    'REBUSAN B4'         => 'pagi_rebusan_b4',
                    'REBUSAN B7'         => 'pagi_rebusan_b7',
                    'REBUSAN B8'         => 'pagi_rebusan_b8',
                    'REBUSAN B9'         => 'pagi_rebusan_b9',
                    'REBUSAN B10'        => 'pagi_rebusan_b10',
                    'SPARE'              => 'pagi_spare_b1',
                ],
                'Sore (Jam 15:40 WIB) MESS TALANG JAWA' => [
                    'Mess Gl putri Talang Jawa'      => 'sore_mess_gl',
                    'MESS ADMIN PUTRI Talang Jawa'   => 'sore_mess_admin',
                ],
                'Sore (Jam 15:40 WIB) MESS MEICU' => [
                    'Mess Meicu R1'       => 'sore_ruko_1',
                    'Mess Meicu R2'       => 'sore_ruko_2',
                    'Mess Meicu R3 FMDP'  => 'sore_ruko_3',
                    'Mess Meicu R4-5'     => 'sore_ruko_45',
                ],
                'MK SORE OFFICE MEICU' => [
                    'Meicu Security'     => 'sore_security_meicu',
                    'VISITOR'            => 'sore_visitor',
                    'Helper Meicu'       => 'sore_helper_meicu',
                    'Bagong'             => 'sore_bagong',
                    'TES PRAKTEK'        => 'sore_test_praktek',
                    'MAGANG'         => 'sore_magang_meicu',
                ],
                'MK SORE OFFICE PLANT' => [
                    'VENDOR JMI (ENG)' => 'siang_vendor_jmi',
                ],
                'Sore (Jam 15:40 WIB) MESS TAMBANG' => [
                    'Mess Tambang A1'    => 'sore_kamar_a1',
                    'Mess Tambang A2'    => 'sore_kamar_a2',
                    'Mess Tambang B1'    => 'sore_kamar_b1',
                    'Mess Tambang B2'    => 'sore_kamar_b2',
                    'Mess Tambang B3'    => 'sore_kamar_b3',
                    'Mess Tambang B4'    => 'sore_kamar_b4',
                    'Mess Tambang B7'    => 'sore_kamar_b7',
                    'Mess Tambang B8'    => 'sore_kamar_b8',
                    'Mess Tambang B9'    => 'sore_kamar_b9',
                    'Mess Tambang B10'   => 'sore_kamar_b10',
                    'REBUSAN B2'         => 'sore_rebusan_b2',
                    'REBUSAN B3'         => 'sore_rebusan_b3',
                    'REBUSAN B4'         => 'sore_rebusan_b4',
                    'REBUSAN B7'         => 'sore_rebusan_b7',
                    'REBUSAN B9'         => 'sore_rebusan_b9',
                    'SPARE'              => 'sore_spare_b1',
                ],
                'MAKAN TAMBANG SIANG' => [
                    'Produksi Pit 3 (Jam 10.00 WIB)'        => 'siang_prod_pit_3',
                    'ENG CSA PIT 3'                         => 'siang_pitcontrol',
                    // 'ENG CSA PIT 2 DRILL & BLAST'           => 'siang_eng_csa_pit2_drill_blast',
                    // 'Eng CSA Pit 2'                         => 'siang_eng_csa_pit2_drill_blast',
                    // 'DRIVER ENG CSA PIT 2'                  => 'siang_driver_survey',
                    // 'ENG CSA HRM (Vendor JMI)'              => 'siang_vendor_jmi',
                    'COE CSA PIT 3'                         => 'siang_mpccr_admccr_pit',
                    'COE PITSOP - SS6'                      => 'siang_coe_pitstop_ss6',
                    'COE CSA PIT 1 - ICT'                   => 'siang_coe_csa_pit1_ict',
                    'Driver COE CSA PIT 1'                  => 'siang_mpict_driver',
                    'Plant Pitstop'                         => 'siang_plant_pitstop',
                    'Training Plant Pitstop'                => 'siang_training',
                    'DRIVER PLANT PITSTOP'                  => 'siang_driver_plant',
                    'PLANT OFFICE PITSTOP'                  => 'siang_plant_office_pitstop',
                    'Plant Workshop'                        => 'siang_plant_workshop',
                    'DRIVER PLANT WORKSHOP'                 => 'siang_driver_workshop',
                    'Sect.Head PLANT PITSTOP'               => 'siang_sect_head_pitstop',
                    'Sect.Head PLANT WORKSHOP'              => 'siang_sect_head_plant',
                    'Sect Head SHE CSA PIT 1'               => 'siang_sect_head_she',
                    'SHE CSA PIT 1'                         => 'siang_she_csa_pit1',
                    'DRIVER SHE CSA PIT 1'                  => 'siang_driver_she',
                    'DRIVER FA-LOG WAREHOUSE'               => 'siang_driver_fa_log',
                    'KOPERASI FALOG (RENCANA OFFICE)'       => 'siang_koperasi_office',
                    'FA-Log (WAREHOUSE PPA)'                => 'siang_falog_warehouse',
                    'SectHead FA-LOG WAREHOUSE'             => 'siang_sect_head_falog',
                    'Fuel'                                  => 'siang_fuel',
                    'FALOG( WORKSHOP KOPERASI GUDANG GA)'   => 'siang_mechanic_koperasi',
                    'HCGA Tes Praktek (Opsional)'           => 'siang_test_praktek_hcga',
                    'HCGA SPBI'                             => 'siang_admin_spbi',
                    'HCGA TAMBANG'                          => 'siang_carpenter',
                    'HCGA CSA PIT (PRAKTEK)'                => 'siang_test_praktek_csapit',
                    'HCGA Security SPBI'                    => 'siang_security_spbi',
                ],
            ],
        ];

        // Pastikan catering yang dipilih ada dalam mapping
        if (!isset($categoryMapping[strtolower($cateringName)])) {
            return [];
        }

        // Ambil kategori spesifik berdasarkan catering yang dipilih
        $selectedCategories = $categoryMapping[strtolower($cateringName)];

        // Ambil data dari tabel berdasarkan tanggal
        $data = DB::table($tableName)
            ->whereDate('tanggal', $date)
            ->first();

        // Jika tidak ada data, kembalikan array kosong
        if (!$data) {
            return [];
        }

        // Loop berdasarkan kategori dan lokasi
        foreach ($selectedCategories as $category => $locations) {
            foreach ($locations as $location => $columnName) {
                $total = $columnName ? ($data->{$columnName} ?? '-') : '-';

                $result[$category][] = [
                    'name' => $location,
                    'total' => $total
                ];
            }
        }

        return $result;
    }

    public function getCateringDataRevisi($date, $categories, $cateringName)
    {
        $tableName = 'catering_tambahan_' . strtolower($cateringName);
        $result = [];

        // Mapping kategori per catering
        $categoryMapping = [
            'fitri' => [
                'Makan Tambang Siang' => [
                    'Produksi CSA PIT 1'                  => 'prod_csa_pit1',
                    'Section Head Anjungan pit 1'         => 'section_head_pit1',
                    'Produksi CSA PIT 1 Akademi Skill up' => 'prod_skillup_csapit1',
                    'Prod PIT 2'                          => 'prod_pit2',
                    // 'Prod PIT 3'                          => 'prod_pit3',
                    'DRIVER LV PRODUKSI PIT 2'            => 'driver_lv_pit2',
                    'Sect. Head Produksi PIT 2'           => 'section_head_pit2',
                    'ENG CSA PIT 2 DRILL & BLAST'         => 'eng_drill',
                    'Eng CSA Pit 2'                       => 'eng_csapit2',
                    'DRIVER ENG CSA PIT 2T'               => 'eng_driver_csapit2',
                    'ENG CSA HRM (Vendor JMI)'            => 'eng_vendor_jmi',
                    'HCGA CSA PIT 2 ROSELA (SECURITY)'    => 'hcga_security_rosela',
                    'PRODUKSI PITSTOP (Di Tulis ODP)'     => 'prod_pitstop',
                    'PRODUKSI CSA HRM SKILL UP (ACADEMY)' => 'prod_csahrm',
                ],
            ],
            'wastu' => [
                'MK PAGI MESS C 3(DH & SH)' => [
                    'MESS DH & PJO - MESS SECTION HEAD' => 'pagi_kamar_c3',
                ],
                'MK SIANG MESS PUTRI TALANG JAWA' => [
                        'MESS GL PUTRI TALANG JAWA' => 'siang_mess_gl',
                        'MESS ADMIN PUTRI TALANG JAWA' => 'siang_mess_admin',
                        'HELPER MESS PUTRI' => 'siang_helper_mess',
                ],
                'MK SIANG MESS C3 (DH & SH)' => [
                    'MESS DPET/SECT HEAD' => 'siang_kamar_c3',
                ],
                'MK SIANG MESS PUTRI TALANG JAWA' => [
                    'Mess GL Putri Talang Jawa' => 'siang_mess_gl',
                    'MESS ADMIN PUTRI Talang Jawa' => 'siang_mess_admin',
                    'HELPER MESS PUTRI' => 'siang_helper_mess_putri',
                ],
                'MK SIANG KARTIKA' => [
                    'LAUNDRY KARTIKA' => 'siang_laundry',
                ],
                'MK SIANG MEICU' => [
                    'Mess Meicu R1' => 'siang_ruko_1',
                    'Mess Meicu R2' => 'siang_ruko_2',
                    'Mess Meicu R3 FMDP' => 'siang_ruko_3',
                    'Mess Meicu R4-5' => 'siang_ruko_45',
                ],
                'MK SIANG OFFICE GA MEICU' => [
                    'Driver LV' => 'siang_driver_meicu',
                    'Office Meicu' => 'siang_office_meicu',
                    'Meicu Security' => 'siang_security_meicu',
                    'VENDOR' => 'siang_vendor_meicu',
                    'CV ADE(PETUGAS SAMPAH)' => 'siang_cv_ade',
                    'Helper' => 'siang_helper_meicu',
                ],
                'MK SIANG MESS TAMBANG' => [
                    'RENCANA MESS GL A1' => 'siang_kamar_a1',
                    'RENCANA MESS GL A2' => 'siang_kamar_a2',
                    'Rencana Mess B1' => 'siang_kamar_b1',
                    'Rencana Mess B2' => 'siang_kamar_b2',
                    'Rencana Mess B3' => 'siang_kamar_b3',
                    'Rencana Mess B4' => 'siang_kamar_b4',
                    'Rencana Mess B7' => 'siang_kamar_b7',
                    'Rencana Mess B8' => 'siang_kamar_b8',
                    'Rencana Mess B9' => 'siang_kamar_b9',
                    'Rencana Mess B10' => 'siang_kamar_b10',
                ],
                'MK SIANG MESS TAMBANG AMM' => [
                    'Rencana Mess B1' => 'siang_mess_b1',
                    'Rencana Mess B2' => 'siang_mess_b2',
                    'Rencana Mess B3' => 'siang_mess_b3',
                    'Rencana Mess B4' => 'siang_mess_b4',
                    'Rencana Mess B7' => 'siang_mess_b7',
                    'Rencana Mess B8' => 'siang_mess_b8',
                    'Rencana Mess B9' => 'siang_mess_b9',
                    'Rencana Mess B10' => 'siang_mess_b10',
                    'SPARE' => 'siang_spare_amm',
                ],
                'OFFICE GA MESS TAMBANG' => [
                    'Kontainer GA Mess Tambang' => 'siang_container_ga_mess',
                    'Electrical GA' => 'siang_electrical_ga',
                    'Helper Mess' => 'siang_helper_mess',
                    'Driver bus Mess Tambang' => 'siang_driver_bus',
                    'KOPERASI MESS TAMBANG' => 'siang_koperasi_mess',
                    'KONTAINER MEDIC MESS TAMBANG' => 'siang_kontainer_medic',
                    'Security Mess Tambang' => 'siang_security_poss',
                    'Mekanik TRAC Mess Tambang' => 'siang_mekanic_trac',
                    'Driver BUS JUM\'AT' => 'siang_driver_bus_jumat',
                    'GL CIVIEL ENG' => 'siang_gl_civil',
                    'Skill UP LT CSA pit 1' => 'siang_skill_up_lt',
                ],
                'MK SIANG DEPTHEAD & PJO' => [
                    'Dept.Head ENG ★(Office Plant)' => 'siang_dept_head_eng',
                    'TAMU HO COE ★(Office Plant)' => 'siang_tamu_ho',
                    'PJO ★(Office Plant)' => 'siang_pjo',
                    'Dept.Head Produksi ★(CSA PIT 1)' => 'siang_dept_sect_csapit1',
                    'Dept Head SHE ★(CSA PIT 1)' => 'siang_dept_head',
                    'Dept.Head PLANT ★(WORKSHOP)' => 'siang_dept_head_plant',
                    'Dept.Head PLANT ★(PITSTOP)' => 'siang_dept_head_pitstop,', //'BELUM', // Belum ada kode
                ],
                'OFFICE PLANT SIANG' => [
                    'Driver Bus Jum\'atan' => 'siang_driver_bus_jumat', // Harusnya ada dua data katanya
                    'COE OFFICE ( CCR,MOCO)' => 'siang_office_ccr_moco',
                    'SectHead COE' => 'siang_section',
                    'PLANT' => 'siang_plant',
                    'Section Head PLANT' => 'siang_sect_head_plant',
                    'SECURITY PATROL' => 'siang_security_patrol',
                    'HCGA' => 'siang_hcga_office_plant',
                    'Section Head HCGA' => 'siang_sect_head',
                    'DRIVER HCGA (88,01)' => 'siang_driver_plant',
                    'SERTIFIKASI HCGA' => 'siang_sertifikasi_hcga',
                    'Produksi' => 'siang_admin_officeplant',
                    'Driver Engineering' => 'siang_driver_eng',
                    'Sect.Head ENG' => 'siang_sect_head_eng',
                    'Engineering' => 'siang_engineering',
                ],
                'MK SORE MESS DH & SH (PPA RESIDANCE)' => [
                    'MESS DH & PJO - MESS SECTION HEAD' => 'sore_kamar_c3',

                ],
                'MK TAMBANG MALAM' => [
                    'Plant Pitstop' => 'malam_plant_pitstop',
                    //sekar
                    'DRIVER PLANT PITSTOP' => 'malam_driver_plant_plant',
                    'Plant Workshop' => 'malam_plant_workshop',
                    'DRIVER PLANT WORKSHOP' => 'malam_driver_workshop',
                    'FA - LOG KOPERASI MESS TAMBANG' => 'malam_mechanic_koperasi',
                    'SHE KONTAINER MEDIC MESS TAMBANG' => 'malam_kontainer_medic',
                    'HCGA Security mess tambang' => 'malam_security_poss',
                    'Helper mess tambang' => 'malam_helper_mess',
                    'Kontainer GA Mess Tambang' => 'malam_admin_ga',
                    'driver lv mess tambang' => 'malam_driver_mess',
                    'ELEKTRIKAL GA MESS TAMBANG' => 'malam_electrical_ga',
                    'Mekanik TRAC Mess Tambang' => 'malam_mekanic_trac',
                    'COE( ICT ) CSA PIT 1' => 'malam_coe_csa_pit1',
                    'COE PITSOP - SS6' => 'malam_mpss6_sysdev',
                    'COE CSA PIT 3' => 'malam_mpccr_admccr',
                    'Sect. Head Produksi PIT 2' => 'malam_dept_sect_csapit2',
                    'Prod PIT 2' => 'malam_prod_pit2',
                    'DRIVER LV PRODUKSI PIT 2' => 'malam_driverlv_csapit2',
                    'Produksi Pit 3' => 'malam_prod_pit3',
                    'ENG CSA HRM (Vendor JMI)' => 'malam_vendor_jmi',
                    'SHE CSA PIT 1' => 'malam_she_csa_pit1',
                    'DRIVER SHE CSA PIT 1' => 'malam_driver',
                    'LOG WAREHOUSE' => 'malam_log_warehouse_falog',
                    'malam_mechanic_koperasi' => 'malam_mechanic_koperasi',
                    'Fuel' => 'malam_fuel',
                    'Driver GA+Helper office' => 'malam_driver_helper_office',
                    'Security Pit 2' => 'malam_security_pit1', // 'BELUM',
                    'Security Pit 3' => 'malam_security_pit3', // BELUM
                    'Security anjungan' => 'malam_security_anjungan', // BELUM
                    'SECURITY LAUNDRY KARTIKA' => 'malam_security_laundry',
                ],
                'MK OFFICE PLANT MALAM' => [
                    'Security'             => 'malam_security_plant',
                    'SECURITY PATROL'      => 'malam_security_patrol',
                    'PLANT'                => 'malam_base_control',
                    'ENGINEERING'          => 'malam_eng_plant',
                    'COE - CCR'            => 'malam_coe_office',
                ],
            ],
            'bintang' => [
                'MK PAGI MESS PUTRI' => [
                    'MESS GL PUTRI TALANG JAWA'     => 'pagi_mess_gl',
                    'REBUSAN GL PUTRI TALANG JAWA'  => 'pagi_rebusan_gl',
                    'MESS ADMIN PUTRI TALANG JAWA'  => 'pagi_mess_admin',
                    'REBUSAN ADMIN PUTRI'           => 'pagi_rebusan_admin',
                ],
                'MK PAGI MESS MEICU' => [
                    'Meicu Ruko 1'       => 'pagi_ruko_1',
                    'Meicu Ruko 2'       => 'pagi_ruko_2',
                    'Meicu Ruko 3'       => 'pagi_ruko_3',
                    'Meicu Ruko 4-5'     => 'pagi_ruko_45',
                    'REBUSAN R1'         => 'pagi_rebusan_ruko1',
                    'REBUSAN R3'         => 'pagi_rebusan_ruko3',
                    'REBUSAN R4-R5'      => 'pagi_rebusan_ruko45',
                    'VISITOR'            => 'pagi_visitor_hcga',
                    'MAGANG'         => 'pagi_magang_meicu',
                ],
                'MK PAGI OFFICE PLANT' => [
                    'VENDOR JMI' => 'pagi_vendor_jmi',
                ],
                'MK PAGI OFFICE MEICU' => [
                    'Bagong'        => 'pagi_bagong',
                    'TEST PRAKTEK'  => 'pagi_test_praktek',
                ],
                'MK PAGI MESS TAMBANG' => [
                    'Mess Tambang GL A1' => 'pagi_kamar_a1',
                    'Mess Tambang GL A2' => 'pagi_kamar_a2',
                    'Mess Tambang B1'    => 'pagi_kamar_b1',
                    'Mess Tambang B2'    => 'pagi_kamar_b2',
                    'Mess Tambang B3'    => 'pagi_kamar_b3',
                    'Mess Tambang B4'    => 'pagi_kamar_b4',
                    'Mess Tambang B7'    => 'pagi_kamar_b7',
                    'Mess Tambang B8'    => 'pagi_kamar_b8',
                    'Mess Tambang B9'    => 'pagi_kamar_b9',
                    'Mess Tambang B10'   => 'pagi_kamar_b10',
                    'REBUSAN GL A1'      => 'pagi_rebusan_a1',
                    'REBUSAN GL A2'      => 'pagi_rebusan_a2',
                    'REBUSAN B1'         => 'pagi_rebusan_b1',
                    'REBUSAN B2'         => 'pagi_rebusan_b2',
                    'REBUSAN B3'         => 'pagi_rebusan_b3',
                    'REBUSAN B4'         => 'pagi_rebusan_b4',
                    'REBUSAN B7'         => 'pagi_rebusan_b7',
                    'REBUSAN B8'         => 'pagi_rebusan_b8',
                    'REBUSAN B9'         => 'pagi_rebusan_b9',
                    'REBUSAN B10'        => 'pagi_rebusan_b10',
                    'SPARE'              => 'pagi_spare_b1',
                ],
                'Sore (Jam 15:40 WIB) MESS TALANG JAWA' => [
                    'Mess Gl putri Talang Jawa'      => 'sore_mess_gl',
                    'MESS ADMIN PUTRI Talang Jawa'   => 'sore_mess_admin',
                ],
                'Sore (Jam 15:40 WIB) MESS MEICU' => [
                    'Mess Meicu R1'       => 'sore_ruko_1',
                    'Mess Meicu R2'       => 'sore_ruko_2',
                    'Mess Meicu R3 FMDP'  => 'sore_ruko_3',
                    'Mess Meicu R4-5'     => 'sore_ruko_45',
                ],
                'MK SORE OFFICE MEICU' => [
                    'Meicu Security'     => 'sore_security_meicu',
                    'VISITOR'            => 'sore_visitor',
                    'Helper Meicu'       => 'sore_helper_meicu',
                    'Bagong'             => 'sore_bagong',
                    'TES PRAKTEK'        => 'sore_test_praktek',
                    'MAGANG'         => 'sore_magang_meicu',
                ],
                'MK SORE OFFICE PLANT' => [
                    'VENDOR JMI (ENG)' => 'siang_vendor_jmi',
                ],
                'Sore (Jam 15:40 WIB) MESS TAMBANG' => [
                    'Mess Tambang A1'    => 'sore_kamar_a1',
                    'Mess Tambang A2'    => 'sore_kamar_a2',
                    'Mess Tambang B1'    => 'sore_kamar_b1',
                    'Mess Tambang B2'    => 'sore_kamar_b2',
                    'Mess Tambang B3'    => 'sore_kamar_b3',
                    'Mess Tambang B4'    => 'sore_kamar_b4',
                    'Mess Tambang B7'    => 'sore_kamar_b7',
                    'Mess Tambang B8'    => 'sore_kamar_b8',
                    'Mess Tambang B9'    => 'sore_kamar_b9',
                    'Mess Tambang B10'   => 'sore_kamar_b10',
                    'REBUSAN B2'         => 'sore_rebusan_b2',
                    'REBUSAN B3'         => 'sore_rebusan_b3',
                    'REBUSAN B4'         => 'sore_rebusan_b4',
                    'REBUSAN B7'         => 'sore_rebusan_b7',
                    'REBUSAN B9'         => 'sore_rebusan_b9',
                    'SPARE'              => 'sore_spare_b1',
                ],
                'MAKAN TAMBANG SIANG' => [
                    'Produksi Pit 3 (Jam 10.00 WIB)'        => 'siang_prod_pit_3',
                    'ENG CSA PIT 3'                         => 'siang_pitcontrol',
                    // 'ENG CSA PIT 2 DRILL & BLAST'           => 'siang_eng_csa_pit2_drill_blast',
                    // 'Eng CSA Pit 2'                         => 'siang_eng_csa_pit2_drill_blast',
                    // 'DRIVER ENG CSA PIT 2'                  => 'siang_driver_survey',
                    // 'ENG CSA HRM (Vendor JMI)'              => 'siang_vendor_jmi',
                    'COE CSA PIT 3'                         => 'siang_mpccr_admccr_pit',
                    'COE PITSOP - SS6'                      => 'siang_coe_pitstop_ss6',
                    'COE CSA PIT 1 - ICT'                   => 'siang_coe_csa_pit1_ict',
                    'Driver COE CSA PIT 1'                  => 'siang_mpict_driver',
                    'Plant Pitstop'                         => 'siang_plant_pitstop',
                    'Training Plant Pitstop'                => 'siang_training',
                    'DRIVER PLANT PITSTOP'                  => 'siang_driver_plant',
                    'PLANT OFFICE PITSTOP'                  => 'siang_plant_office_pitstop',
                    'Plant Workshop'                        => 'siang_plant_workshop',
                    'DRIVER PLANT WORKSHOP'                 => 'siang_driver_workshop',
                    'Sect.Head PLANT PITSTOP'               => 'siang_sect_head_pitstop',
                    'Sect.Head PLANT WORKSHOP'              => 'siang_sect_head_plant',
                    'Sect Head SHE CSA PIT 1'               => 'siang_sect_head_she',
                    'SHE CSA PIT 1'                         => 'siang_she_csa_pit1',
                    'DRIVER SHE CSA PIT 1'                  => 'siang_driver_she',
                    'DRIVER FA-LOG WAREHOUSE'               => 'siang_driver_fa_log',
                    'KOPERASI FALOG (RENCANA OFFICE)'       => 'siang_koperasi_office',
                    'FA-Log (WAREHOUSE PPA)'                => 'siang_falog_warehouse',
                    'SectHead FA-LOG WAREHOUSE'             => 'siang_sect_head_falog',
                    'Fuel'                                  => 'siang_fuel',
                    'FALOG( WORKSHOP KOPERASI GUDANG GA)'   => 'siang_mechanic_koperasi',
                    'HCGA Tes Praktek (Opsional)'           => 'siang_test_praktek_hcga',
                    'HCGA SPBI'                             => 'siang_admin_spbi',
                    'HCGA TAMBANG'                          => 'siang_carpenter',
                    'HCGA CSA PIT (PRAKTEK)'                => 'siang_test_praktek_csapit',
                    'HCGA Security SPBI'                    => 'siang_security_spbi',
                ],
            ],
        ];

        // Pastikan catering yang dipilih ada dalam mapping
        if (!isset($categoryMapping[strtolower($cateringName)])) {
            return [];
        }

        // Ambil kategori spesifik berdasarkan catering yang dipilih
        $selectedCategories = $categoryMapping[strtolower($cateringName)];


        $data = DB::table($tableName)
            ->whereDate('tanggal', $date)
            ->first();


        // Jika tidak ada data, kembalikan array kosong
        if (!$data) {
            return [];
        }

        // Loop berdasarkan kategori dan lokasi
        foreach ($selectedCategories as $category => $locations) {
            foreach ($locations as $location => $columnName) {
                $total = $columnName ? ($data->{$columnName} ?? '-') : '-';

                $result[$category][] = [
                    'name' => $location,
                    'total' => $total
                ];
            }
        }

        return $result;
    }

    public function getCateringFitriInvoice($month, $year, $catering)
    {
        // Mapping tabel berdasarkan catering
        $cateringTables = [
            'FITRI' => 'catering_fitri',
        ];

        // Mapping kolom berdasarkan catering
        $cateringColumns = [
            'FITRI' => [
                'tanggal' => 'tanggal',
                'produksi_pit_1' => 'prod_csa_pit1',
                'section_head_anjungan_pit_1' => 'section_head_pit1',
                'prod_pit2' => 'prod_pit2',
                'sect_head_produksi_pit_2' => 'section_head_pit2'
            ],
            'WASTU' => [
                'tanggal' => 'tgl',
                'produksi_pit_1' => 'pit1_prod',
                'section_head_anjungan_pit_1' => 'pit1_head',
                'prod_pit2' => 'pit2_prod',
                'sect_head_produksi_pit_2' => 'pit2_head'
            ],
            'BINTANG' => [
                'tanggal' => 'date',
                'produksi_pit_1' => 'p1_prod',
                'section_head_anjungan_pit_1' => 'p1_sect_head',
                'prod_pit2' => 'p2_prod',
                'sect_head_produksi_pit_2' => 'p2_sect_head'
            ]
        ];

        // Pastikan catering tersedia dalam mapping
        if (!isset($cateringTables[$catering]) || !isset($cateringColumns[$catering])) {
            return collect(); // Return collection kosong jika catering tidak valid
        }

        // Ambil tabel dan kolom yang sesuai
        $table = $cateringTables[$catering];
        $columns = $cateringColumns[$catering];

        // Bangun query dengan kolom yang sesuai
        $query = DB::table($table)
            ->select(DB::raw("DATE({$columns['tanggal']}) as tanggal"));

        // Tambahkan kolom SUM hanya jika tersedia di mapping
        foreach ($columns as $alias => $colName) {
            if ($alias !== 'tanggal') {
                $query->addSelect(DB::raw("SUM($colName) as $alias"));
            }
        }

        // Tambahkan filter bulan dan tahun
        $query->whereMonth($columns['tanggal'], $month)
            ->whereYear($columns['tanggal'], $year)
            ->groupBy(DB::raw("DATE({$columns['tanggal']})"));

        return $query->get();
    }

    public function getWastuInvoiceSummary($month, $year)
    {
        $mapping = [
            'MK SIANG MESS PUTRI TALANG JAWA' => [
                'mk_gl', 'mk_admin', 'helper_mess'
            ],
            'MK SIANG LAUNDRY KARTIKA' => [
                'laundry'
            ],
            'MK SIANG MESS MEICU' => [
                'ruko_1', 'ruko_2', 'ruko_3', 'ruko_45',
                'driver_lv', 'office_meicu', 'security_meicu', 'visitor', 'cv_ade', 'helper_meicu'
            ],
            'MK SIANG MESS TAMBANG' => [
                'mk_mess_a1', 'mk_mess_b1', 'mk_mess_b2', 'mk_mess_b3'
            ],
            'TAMBAHAN' => [
                'tambahan_siang_b1'
            ],
        ];

        $startDate = "{$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";

        if ((int)$month === (int)date('m') && (int)$year === (int)date('Y')) {
            $endDate = date('Y-m-d');
        } else {
            $endDate = date('Y-m-t', strtotime($startDate));
        }

        $query = DB::table('catering_wastu')
            ->select('tanggal');

        foreach ($mapping as $uraian => $kolomArray) {
            foreach ($kolomArray as $kolom) {
                $query->addSelect(DB::raw("SUM($kolom) as $kolom"));
            }
        }

        $rows = $query
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        if ($rows->isEmpty()) {
            return [];
        }
        $summary = [];

        foreach ($mapping as $uraian => $kolomArray) {
            $jumlah = 0;
            foreach ($kolomArray as $kolom) {
                $jumlah += (int)$rows[0]->$kolom;
            }
            $summary[$uraian] = $jumlah;
        }

        return $summary;
    }

    //===================================================== DASHBOARD CATERING ===============================================


}
