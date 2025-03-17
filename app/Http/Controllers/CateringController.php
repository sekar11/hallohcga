<?php

namespace App\Http\Controllers;
use App\Http\Repository\CateringRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CateringController extends Controller
{
    protected $CateringRepository;

    public function __construct(CateringRepository $CateringRepository)
    {
        $this->CateringRepository = $CateringRepository;
    }


    public function create()
    {
        $userTeam = auth()->user()->tim_pic;

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


        $tableName = $tableMapping[$userTeam] ?? null;

        if (!$tableName) {
            abort(404, 'Tabel tidak ditemukan untuk tim ini.');
        }

        // Ambil daftar kolom dari tabel yang sesuai
        $columns = Schema::getColumnListing($tableName);

        // Ambil data dari repository
        $cateringData = $this->CateringRepository->getData();

        return view('catering.catering', compact('columns', 'tableName', 'cateringData'));
    }

    public function store(Request $request)
    {
        $table = $request->table_name;
        $userTeam = auth()->user()->tim_pic;
        $createdBy = auth()->user()->nama;
        $status = 1;

        $columnMappings = [
            'COE' => [
                'section' => 'section',
                'gl_ss6' => 'gl_ss6',
                'mpss6_glss6' => 'mpss6_glss6',
                'mpict_engineer' => 'mpict_engineer',
                'mpss6_driver' => 'mpss6_driver',
                'mpict_glict' => 'mpict_glict',
                'mpss6_sysdev' => 'mpss6_sysdev',
                'mpict_engineer' => 'mpict_engineer',
                'mpict_driver' => 'mpict_driver',
                'mpccr_admccr' => 'mpccr_admccr',
                'mpccr_asstmoco' => 'mpccr_asstmoco',
                'mpccr_glmoco' => 'mpccr_glmoco',
                'mpccr_driver' => 'mpccr_driver',
                'mpccr_admccr_pit' => 'mpccr_admccr_pit',
                ],
            'HCGA' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'pjo' => 'pjo',
                'sect_head' => 'sect_head',
                'gl_hc' => 'gl_hc',
                'admin_hc' => 'admin_hc',
                'admin_ga_plant' => 'admin_ga_plant',
                'helper_plant' => 'helper_plant',
                'security_plant' => 'security_plant',
                'alpen' => 'alpen',
                'driver_plant' => 'driver_plant',
                'security_spbi' => 'security_spbi',
                'admin_ga' => 'admin_ga',
                'gl_ga' => 'gl_ga',
                'electrical_ga' => 'electrical_ga',
                'driver_mess' => 'driver_mess',
                'carpenter' => 'carpenter',
                'gardener' => 'gardener',
                'mekanic_trac' => 'mekanic_trac',
                'security_pos' => 'security_pos',
                'security_patrol' => 'security_patrol',
                'driver_lv_cuti' => 'driver_lv_cuti',
                'helper_mess' => 'helper_mess',
                'admin_ga_meicu' => 'admin_ga_meicu',
                'gl_ga_meicu' => 'gl_ga_meicu',
                'security_meicu' => 'security_meicu',
                'driver_meicu' => 'driver_meicu',
                'cv_ade' => 'cv_ade',
                'helper_meicu' => 'helper_meicu',
                'laundry' => 'laundry'
            ],
            'ENG' => [
                'dept_head' => 'dept_head',
                'gl_ss6' => 'gl_ss6',
                'sect_head' => 'sect_head',
                'gl_eng' => 'gl_eng',
                'driver' => 'driver',
                'crew_ssr' => 'crew_ssr',
                'office_pldp' => 'office_pldp',
                'drill' => 'drill',
                'driver_drill' => 'driver_drill',
                'helper_survey' => 'helper_survey',
                'driver_survey' => 'driver_survey',
                'gl_survey' => 'gl_survey',
                'magang' => 'magang',
                'warehouse_pldp' => 'warehouse_pldp',
            ],
            'SHE' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'dept_head' => 'dept_head',
                'sect_head' => 'sect_head',
                'gl_k3' => 'gl_k3',
                'dokter' => 'dokter',
                'gl_ert' => 'gl_ert',
                'gl_ko' => 'gl_ko',
                'medic' => 'medic',
                'ert' => 'ert',
                'admin' => 'admin',
                'sample_makan' => 'sample_makan',
                'helper_hcga' => 'helper_hcga',
                'crew_she' => 'crew_she',
                'magang' => 'magang',
                'driver' => 'driver',
                'grounded' => 'grounded',
                'spare' => 'spare',
                'kontainer_medic' => 'kontainer_medic',
            ],
            'FALOG' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'dept_head' => 'dept_head',
                'sect_head' => 'sect_head',
                'gl_fa' => 'gl_fa',
                'admin_fa' => 'admin_fa',
                'gl_logistik' => 'gl_logistik',
                'admin_logistik' => 'admin_logistik',
                'swi' => 'swi',
                'vendor' => 'vendor',
                'spare' => 'spare',
                'pldp' => 'pldp',
                'koperasi_mess' => 'koperasi_mess',
                'mechanic_koperasi' => 'mechanic_koperasi',
                'koperasi_office' => 'koperasi_office',
                'opt_fuel_truck' => 'opt_fuel_truck',
                'fuelman' => 'fuelman',
                'gl' => 'gl',
                'admin_fuel' => 'admin_fuel',
                'spare_csa' => 'spare_csa',
                'driver_fa_log' => 'driver_fa_log'
            ],
            'PROD' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'dept_sect_csapit1' => 'dept_sect_csapit1',
                'dept_sect_csapit2' => 'dept_sect_csapit2',
                'dept_sect_csapit3' => 'dept_sect_csapit3',
                'operator_csapit1' => 'operator_csapit1',
                'gl_csapit1' => 'gl_csapit1',
                'spare_csapit1' => 'spare_csapit1',
                'operator_csapit2' => 'operator_csapit2',
                'gl_csapit2' => 'gl_csapit2',
                'spare_csapit2' => 'spare_csapit2',
                'operator_csapit3' => 'operator_csapit3',
                'gl_csapit3' => 'gl_csapit3',
                'spare_csapit3' => 'spare_csapit3',
                'dept_sect_officeplant' => 'dept_sect_officeplant',
                'admin_officeplant' => 'admin_officeplant',
                'gl_officecsapit1' => 'gl_officecsapit1',
                'admin_officecsapit1' => 'admin_officecsapit1'
            ],
            'PLANT' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'dept_head' => 'dept_head',
                'sect_head' => 'sect_head',
                'dept_head_pitstop' => 'dept_head_pitstop',
                'sect_head_pitstop' => 'sect_head_pitstop',
                'new_office' => 'new_office',
                'sect_head_plant' => 'sect_head_plant',
                'siswa_magang' => 'siswa_magang',
                'base_control' => 'base_control',
                'wheel_ps' => 'wheel_ps',
                'track' => 'track',
                'support' => 'support',
                'tyre' => 'tyre',
                'fabrikasi' => 'fabrikasi',
                'tool_room' => 'tool_room',
                'pldp' => 'pldp',
                'fmdp_track' => 'fmdp_track',
                'fmdp_wheel' => 'fmdp_wheel',
                'fmdp_support' => 'fmdp_support',
                'gmi_mercy' => 'gmi_mercy',
                'mastratech' => 'mastratech',
                'trakindo' => 'trakindo',
                'siswa_magang_pitstop' => 'siswa_magang_pitstop',
                'new_hire' => 'new_hire',
                'mutasi' => 'mutasi',
                'driver' => 'driver',
                'spare' => 'spare',
                'congkelman_apn' => 'congkelman_apn',
                'training' => 'training',
                'vendor_plant_pitstop' => 'vendor_plant_pitstop',
                'office_pitstop' => 'office_pitstop',
                'plant_engineer' => 'plant_engineer',
                'skill_up_lt' => 'skill_up_lt',
                'wheel_ws_workshop' => 'wheel_ws_workshop',
                'fabrikasi_workshop' => 'fabrikasi_workshop',
                'planner' => 'planner',
                'plant_engineer_workshop' => 'plant_engineer_workshop',
                'mastratech_workshop' => 'mastratech_workshop',
                'fmdp_ws_workshop' => 'fmdp_ws_workshop',
                'siswa_magang_ws' => 'siswa_magang_ws',
                'driver_workshop' => 'driver_workshop',
                'gmi' => 'gmi',
                'swi' => 'swi',
                'track_ws' => 'track_ws',
                'spare_workshop' => 'spare_workshop',
                'helper_workshop' => 'helper_workshop',
                'trakindo_workshop' => 'trakindo_workshop',
                'backup_opp' => 'backup_opp',
            ],
            'MESS_PUTRI' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'total' => 'total',
            ],
            'MESS_MEICU' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'total' => 'total',
            ],
            'A1' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 38)),
                array_map(fn($i) => "kamar_$i", range(1, 38))
            )),
            'C3' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 20)),
                array_map(fn($i) => "kamar_$i", range(1, 20))
            )),


        ];

        foreach (range(1, 10) as $i) {
            $columnMappings["B$i"] = array_merge(
                ['tanggal' => 'tanggal', 'waktu' => 'waktu'],
                array_combine(
                    array_map(fn($j) => "kamar_$j", range(1, 32)),
                    array_map(fn($j) => "kamar_$j", range(1, 32))
                )
            );
        }

        $columnMapping = $columnMappings[$userTeam] ?? [];

        $inputData = $request->except(['_token', 'table_name']);

        $data = [];
        foreach ($inputData as $inputName => $value) {
            $columnName = $columnMapping[$inputName] ?? $inputName;
            $data[$columnName] = $value;
        }

        $data['create_at'] = now();
        $data['status'] = $status;
        $data['created_name'] = $createdBy;

        $insert = DB::table($table)->insert($data);

        if ($insert) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }

    public function edit(Request $request, $id)
    {
        $userTeam = auth()->user()->tim_pic;

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

        $table = $tableMapping[$userTeam] ?? null;

        if (!$table) {
            return response()->json(['status' => 'error', 'message' => 'Tabel tidak ditemukan untuk tim ini.'], 404);
        }

        $columnMappings = [
            'COE' => [
                'section' => 'section',
                'gl_ss6' => 'gl_ss6',
                'mpss6_glss6' => 'mpss6_glss6',
                'mpict_engineer' => 'mpict_engineer',
                'mpss6_driver' => 'mpss6_driver',
                'mpict_glict' => 'mpict_glict',
                'mpss6_sysdev' => 'mpss6_sysdev',
                'mpict_driver' => 'mpict_driver',
                'mpccr_admccr' => 'mpccr_admccr',
                'mpccr_asstmoco' => 'mpccr_asstmoco',
                'mpccr_glmoco' => 'mpccr_glmoco',
                'mpccr_driver' => 'mpccr_driver',
                'mpccr_admccr_pit' => 'mpccr_admccr_pit',
            ],
            'HCGA' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'pjo' => 'pjo',
                'sect_head' => 'sect_head',
                'gl_hc' => 'gl_hc',
                'admin_hc' => 'admin_hc',
                'admin_ga_plant' => 'admin_ga_plant',
                'helper_plant' => 'helper_plant',
                'security_plant' => 'security_plant',
                'alpen' => 'alpen',
                'driver_plant' => 'driver_plant',
                'security_spbi' => 'security_spbi',
                'admin_ga' => 'admin_ga',
                'gl_ga' => 'gl_ga',
                'electrical_ga' => 'electrical_ga',
                'driver_mess' => 'driver_mess',
                'carpenter' => 'carpenter',
                'gardener' => 'gardener',
                'mekanic_trac' => 'mekanic_trac',
                'security_pos' => 'security_pos',
                'security_patrol' => 'security_patrol',
                'driver_lv_cuti' => 'driver_lv_cuti',
                'helper_mess' => 'helper_mess',
                'admin_ga_meicu' => 'admin_ga_meicu',
                'gl_ga_meicu' => 'gl_ga_meicu',
                'security_meicu' => 'security_meicu',
                'driver_meicu' => 'driver_meicu',
                'cv_ade' => 'cv_ade',
                'helper_meicu' => 'helper_meicu',
                'laundry' => 'laundry'
            ],

            'ENG' => [
                'dept_head' => 'dept_head',
                'gl_ss6' => 'gl_ss6',
                'sect_head' => 'sect_head',
                'gl_eng' => 'gl_eng',
                'driver' => 'driver',
                'crew_ssr' => 'crew_ssr',
                'office_pldp' => 'office_pldp',
                'drill' => 'drill',
                'driver_drill' => 'driver_drill',
                'driver_survey' => 'driver_survey',
                'gl_survey' => 'gl_survey',
                'magang' => 'magang',
                'warehouse_pldp' => 'warehouse_pldp',
            ],
            'SHE' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'dept_head' => 'dept_head',
                'sect_head' => 'sect_head',
                'gl_k3' => 'gl_k3',
                'dokter' => 'dokter',
                'gl_ert' => 'gl_ert',
                'gl_ko' => 'gl_ko',
                'medic' => 'medic',
                'ert' => 'ert',
                'admin' => 'admin',
                'sample_makan' => 'sample_makan',
                'helper_hcga' => 'helper_hcga',
                'crew_she' => 'crew_she',
                'magang' => 'magang',
                'driver' => 'driver',
                'grounded' => 'grounded',
                'spare' => 'spare',
                'kontainer_medic' => 'kontainer_medic',
            ],
            'FALOG' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'dept_head' => 'dept_head',
                'sect_head' => 'sect_head',
                'gl_fa' => 'gl_fa',
                'admin_fa' => 'admin_fa',
                'gl_logistik' => 'gl_logistik',
                'admin_logistik' => 'admin_logistik',
                'swi' => 'swi',
                'vendor' => 'vendor',
                'spare' => 'spare',
                'pldp' => 'pldp',
                'koperasi_mess' => 'koperasi_mess',
                'mechanic_koperasi' => 'mechanic_koperasi',
                'koperasi_office' => 'koperasi_office',
                'opt_fuel_truck' => 'opt_fuel_truck',
                'fuelman' => 'fuelman',
                'gl' => 'gl',
                'admin_fuel' => 'admin_fuel',
                'spare_csa' => 'spare_csa',
                'driver_fa_log' => 'driver_fa_log'
            ],
            'PROD' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'dept_sect_csapit1' => 'dept_sect_csapit1',
                'dept_sect_csapit2' => 'dept_sect_csapit2',
                'dept_sect_csapit3' => 'dept_sect_csapit3',
                'operator_csapit1' => 'operator_csapit1',
                'gl_csapit1' => 'gl_csapit1',
                'spare_csapit1' => 'spare_csapit1',
                'operator_csapit2' => 'operator_csapit2',
                'gl_csapit2' => 'gl_csapit2',
                'spare_csapit2' => 'spare_csapit2',
                'operator_csapit3' => 'operator_csapit3',
                'gl_csapit3' => 'gl_csapit3',
                'spare_csapit3' => 'spare_csapit3',
                'dept_sect_officeplant' => 'dept_sect_officeplant',
                'admin_officeplant' => 'admin_officeplant',
                'gl_officecsapit1' => 'gl_officecsapit1',
                'admin_officecsapit1' => 'admin_officecsapit1'
            ],
            'PLANT' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'dept_head' => 'dept_head',
                'sect_head' => 'sect_head',
                'dept_head_pitstop' => 'dept_head_pitstop',
                'sect_head_pitstop' => 'sect_head_pitstop',
                'new_office' => 'new_office',
                'sect_head_plant' => 'sect_head_plant',
                'siswa_magang' => 'siswa_magang',
                'base_control' => 'base_control',
                'wheel_ps' => 'wheel_ps',
                'track' => 'track',
                'support' => 'support',
                'tyre' => 'tyre',
                'fabrikasi' => 'fabrikasi',
                'tool_room' => 'tool_room',
                'pldp' => 'pldp',
                'fmdp_track' => 'fmdp_track',
                'fmdp_wheel' => 'fmdp_wheel',
                'fmdp_support' => 'fmdp_support',
                'gmi_mercy' => 'gmi_mercy',
                'mastratech' => 'mastratech',
                'trakindo' => 'trakindo',
                'siswa_magang_pitstop' => 'siswa_magang_pitstop',
                'new_hire' => 'new_hire',
                'mutasi' => 'mutasi',
                'driver' => 'driver',
                'spare' => 'spare',
                'congkelman_apn' => 'congkelman_apn',
                'training' => 'training',
                'vendor_plant_pitstop' => 'vendor_plant_pitstop',
                'office_pitstop' => 'office_pitstop',
                'plant_engineer' => 'plant_engineer',
                'skill_up_lt' => 'skill_up_lt',
                'wheel_ws_workshop' => 'wheel_ws_workshop',
                'fabrikasi_workshop' => 'fabrikasi_workshop',
                'planner' => 'planner',
                'plant_engineer_workshop' => 'plant_engineer_workshop',
                'mastratech_workshop' => 'mastratech_workshop',
                'fmdp_ws_workshop' => 'fmdp_ws_workshop',
                'siswa_magang_ws' => 'siswa_magang_ws',
                'driver_workshop' => 'driver_workshop',
                'gmi' => 'gmi',
                'swi' => 'swi',
                'track_ws' => 'track_ws',
                'spare_workshop' => 'spare_workshop',
                'helper_workshop' => 'helper_workshop',
                'trakindo_workshop' => 'trakindo_workshop',
                'backup_opp' => 'backup_opp',
            ],
            'MESS_PUTRI' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'total' => 'total',
            ],
            'MESS_MEICU' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'total' => 'total',
            ],
            'A1' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 38)),
                array_map(fn($i) => "kamar_$i", range(1, 38))
            )),
            'C3' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 20)),
                array_map(fn($i) => "kamar_$i", range(1, 20))
            )),
        ];

        foreach (range(1, 10) as $i) {
            $columnMappings["B$i"] = array_merge(
                ['tanggal' => 'tanggal', 'waktu' => 'waktu'],
                array_combine(
                    array_map(fn($j) => "kamar_$j", range(1, 32)),
                    array_map(fn($j) => "kamar_$j", range(1, 32))
                )
            );
        }

        $columnMapping = $columnMappings[$userTeam] ?? [];

        $inputData = $request->except(['_token', 'table_name']);

        $data = [];
        foreach ($inputData as $inputName => $value) {
            $columnName = $columnMapping[$inputName] ?? $inputName;
            $data[$columnName] = $value;
        }

        $update = DB::table($table)->where('id', $id)->update($data);

        if ($update) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengupdate data']);
        }
    }

    public function delete(Request $request)
    {
        $selectedUserId = $request->input('catering_id');
        $userTeam = auth()->user()->tim_pic;
        $tableMapping = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
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

        $tableName = $tableMapping[$userTeam] ?? null;

        if (!$tableName) {
            return response()->json(['message' => 'Tabel tidak ditemukan untuk tim ini.'], 404);
        }

        $result = $this->CateringRepository->deleteFromTable($tableName, $selectedUserId);

        return response()->json(['message' => $result]);
    }

    public function getEdit($id)
    {
        $data = $this->CateringRepository->getById($id);

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

}
