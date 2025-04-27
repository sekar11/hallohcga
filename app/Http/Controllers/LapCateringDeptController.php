<?php

namespace App\Http\Controllers;
use App\Http\Repository\LapCateringDeptRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class LapCateringDeptController extends Controller
{
    protected $LapCateringDeptRepository;

    public function __construct(LapCateringDeptRepository $LapCateringDeptRepository)
    {
        $this->LapCateringDeptRepository = $LapCateringDeptRepository;
    }


    public function create(Request $request)
    {

        $startDate = $request->input('start_date', now()->addDay()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->addDay()->format('Y-m-d'));
        $selectedDept = $request->input('departemen', 'HCGA');

        if (!$selectedDept) {
            return response()->json(['error' => 'Harap pilih departemen!'], 400);
        }

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
            $tableMapping["Mess B$i"] = "mk_mess_b{$i}";
        }

        $tableName = $tableMapping[$selectedDept] ?? null;

        if (!$tableName) {
            abort(404, 'Tabel tidak ditemukan untuk departemen ini.');
        }

        $columns = Schema::getColumnListing($tableName);

        $cateringData = $this->LapCateringDeptRepository->getData($tableName, $startDate, $endDate);

        return view('catering.laporanCateringDepartemen', compact('columns', 'tableName', 'cateringData', 'startDate', 'endDate', 'selectedDept'));
    }

    public function store(Request $request)
    {
        $table = $request->table_name;
        $userTeam = auth()->user()->tim_pic;
        $createdBy = auth()->user()->nama;
        $status = 1;

        $columnMappings = [
            'COE' => [
               'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'section' => 'section',
                'tamu_ho' => 'tamu_ho',
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
                'visitor' => 'visitor',
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
                'laundry' => 'laundry',
                'visitor' => 'visitor',
                'sertifikasi_hcga' => 'sertifikasi_hcga',
                'driver_bus_jumat' => 'driver_bus_jumat',
                'driver_bus_jumat_mess'=> 'driver_bus_jumat_mess',
                'admin_spbi' => 'admin_spbi',
                'driver_bus' => 'driver_bus',
                'test_praktek' => 'test_praktek',
                'security_laundry' => 'security_laundry',
                'security_pit1' => 'security_pit1',
                'security_pit3' => 'security_pit3',
                'security_anjungan' => 'security_anjungan',
                'marbot' => 'marbot',
                'test_praktek_csapit' => 'test_praktek_csapit',
                'bagong' => 'bagong',
                'vendor_meicu' => 'vendor_meicu',
                'visitor_meicu' => 'visitor_meicu',
            ],
            'ENG' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
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
                'pitstop' => 'pitstop',
                'vendor_jmi' => 'vendor_jmi',
                'gl_civil' => 'gl_civil',
                'visitor' => 'visitor',
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
                'visitor' => 'visitor',
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
                'admin_csapit1' => 'admin_csapit1',
                'skillup_csapit1' => 'skillup_csapit1',
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
                'admin_officecsapit1' => 'admin_officecsapit1',
                'operator_csahrm' => 'operator_csahrm',
                'gl_csahrm' => 'gl_csahrm',
                'spare_csahrm' => 'spare_csahrm',
                'driverlv_pitstop' => 'driverlv_pitstop',
                'gl_pitstop' => 'gl_pitstop',
                'spare_pitstop' => 'spare_pitstop',
                'vendor' => 'vendor',
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
                'visitor' => 'visitor',
            ],
            'MARBOT' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'marbot' => 'marbot',
                'total_laundry' => 'total_laundry',
                'security_laundry' => 'security_laundry'
            ],
            'AMM' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'mess_b1' => 'mess_b1',
                'mess_b2' => 'mess_b2',
                'mess_b3' => 'mess_b3',
                'mess_b4' => 'mess_b4',
                'mess_b5' => 'mess_b5',
                'mess_b6' => 'mess_b6',
                'mess_b7' => 'mess_b7',
                'mess_b8' => 'mess_b8',
                'mess_b9' => 'mess_b9',
                'mess_b10' => 'mess_b10',
                'spare_amm'=> 'spare_amm',
            ],
            'Mess Putri' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'mess_gl' => 'mess_gl',
                'rebusan_gl' => 'rebusan_gl',
                'mess_admin' => 'mess_admin',
                'rebusan_admin' => 'rebusan_admin',
                'helper_mess' => 'helper_mess'
            ],
            'MESS_MEICU' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'total' => 'total',
                'ruko_1' => 'ruko_1',
                'ruko_2' => 'ruko_2',
                'ruko_3' => 'ruko_3',
                'ruko_4' => 'ruko_4',
                'ruko_5' => 'ruko_5',
                'rebusan_ruko1' => 'rebusan_ruko1',
                'rebusan_ruko2' => 'rebusan_ruko2',
                'rebusan_ruko3' => 'rebusan_ruko3',
                'rebusan_ruko4' => 'rebusan_ruko4',
                'rebusan_ruko5' => 'rebusan_ruko5',
                'test_praktek' => 'test_praktek',
                'magang' => 'magang',
            ],
            'Mess A1' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'rebusan_a1' => 'rebusan_a1',
                'spare_a1' => 'spare_a1',
                'visitor_a1' => 'visitor_a1',
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 38)),
                array_map(fn($i) => "kamar_$i", range(1, 38))
            )),
            'Mess C3' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'rebusan_c3' => 'rebusan_c3',
                'spare_c3' => 'spare_c3',
                'visitor_c3' => 'visitor_c3',
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 20)),
                array_map(fn($i) => "kamar_$i", range(1, 20))
            )),


        ];

        foreach (range(1, 10) as $i) {
            $columnMappings["B$i"] = array_merge(
                ['tanggal' => 'tanggal', 'waktu' => 'waktu','rebusan' => 'rebusan', 'spare' => 'spare', 'visitor' => 'visitor'],
                array_combine(
                    array_map(fn($j) => "kamar_$j", range(1, 32)),
                    array_map(fn($j) => "kamar_$j", range(1, 32))
                )
            );
        }

        $columnMapping = $columnMappings[$userTeam] ?? [];

        $inputData = $request->except(['_token', 'table_name', 'departemen']);

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
        //dd($request);
        $userTeam = request('departemen');

       $tableMapping = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'Mess Putri' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
            'AMM' => 'mk_mess_amm',
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
               'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'section' => 'section',
                'tamu_ho' => 'tamu_ho',
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
                'visitor' => 'visitor',
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
                'laundry' => 'laundry',
                'visitor' => 'visitor',
                'sertifikasi_hcga' => 'sertifikasi_hcga',
                'driver_bus_jumat' => 'driver_bus_jumat',
                'driver_bus_jumat_mess'=> 'driver_bus_jumat_mess',
                'admin_spbi' => 'admin_spbi',
                'driver_bus' => 'driver_bus',
                'test_praktek' => 'test_praktek',
                'security_laundry' => 'security_laundry',
                'security_pit1' => 'security_pit1',
                'security_pit3' => 'security_pit3',
                'security_anjungan' => 'security_anjungan',
                'marbot' => 'marbot',
                'test_praktek_csapit' => 'test_praktek_csapit',
                'bagong' => 'bagong',
                'vendor_meicu' => 'vendor_meicu',
                'visitor_meicu' => 'visitor_meicu',
            ],
            'ENG' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
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
                'pitstop' => 'pitstop',
                'vendor_jmi' => 'vendor_jmi',
                'gl_civil' => 'gl_civil',
                'visitor' => 'visitor',
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
                'visitor' => 'visitor',
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
                'admin_csapit1' => 'admin_csapit1',
                'skillup_csapit1' => 'skillup_csapit1',
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
                'admin_officecsapit1' => 'admin_officecsapit1',
                'operator_csahrm' => 'operator_csahrm',
                'gl_csahrm' => 'gl_csahrm',
                'spare_csahrm' => 'spare_csahrm',
                'driverlv_pitstop' => 'driverlv_pitstop',
                'gl_pitstop' => 'gl_pitstop',
                'spare_pitstop' => 'spare_pitstop',
                'vendor' => 'vendor',
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
                'visitor' => 'visitor',
            ],
            'MARBOT' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'marbot' => 'marbot',
                'total_laundry' => 'total_laundry',
                'security_laundry' => 'security_laundry'
            ],
            'AMM' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'mess_b1' => 'mess_b1',
                'mess_b2' => 'mess_b2',
                'mess_b3' => 'mess_b3',
                'mess_b4' => 'mess_b4',
                'mess_b5' => 'mess_b5',
                'mess_b6' => 'mess_b6',
                'mess_b7' => 'mess_b7',
                'mess_b8' => 'mess_b8',
                'mess_b9' => 'mess_b9',
                'mess_b10' => 'mess_b10',
                'spare_amm' => 'spare_amm',
            ],
            'Mess Putri' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'mess_gl' => 'mess_gl',
                'rebusan_gl' => 'rebusan_gl',
                'mess_admin' => 'mess_admin',
                'rebusan_admin' => 'rebusan_admin',
                'helper_mess' => 'helper_mess'
            ],
            'MESS_MEICU' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'total' => 'total',
                'ruko_1' => 'ruko_1',
                'ruko_2' => 'ruko_2',
                'ruko_3' => 'ruko_3',
                'ruko_4' => 'ruko_4',
                'ruko_5' => 'ruko_5',
                'rebusan_ruko1' => 'rebusan_ruko1',
                'rebusan_ruko2' => 'rebusan_ruko2',
                'rebusan_ruko3' => 'rebusan_ruko3',
                'rebusan_ruko4' => 'rebusan_ruko4',
                'rebusan_ruko5' => 'rebusan_ruko5',
                'test_praktek' => 'test_praktek',
                'magang' => 'magang',
            ],
            'Mess A1' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'rebusan_a1' => 'rebusan_a1',
                'spare_a1' => 'spare_a1',
                'visitor_a1' => 'visitor_a1'
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 38)),
                array_map(fn($i) => "kamar_$i", range(1, 38))
            )),
            'Mess C3' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'rebusan_c3' => 'rebusan_c3',
                'spare_c3' => 'spare_c3',
                'visitor_c3' => 'visitor_c3'
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 20)),
                array_map(fn($i) => "kamar_$i", range(1, 20))
            )),
        ];

        foreach (range(1, 10) as $i) {
            $columnMappings["B$i"] = array_merge(
                ['tanggal' => 'tanggal', 'waktu' => 'waktu','rebusan' => 'rebusan', 'spare' => 'spare', 'visitor' => 'visitor'],
                array_combine(
                    array_map(fn($j) => "kamar_$j", range(1, 32)),
                    array_map(fn($j) => "kamar_$j", range(1, 32))
                )
            );
        }

        $columnMapping = $columnMappings[$userTeam] ?? [];

        $inputData = $request->except(['_token', 'table_name', 'departemen']);

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
            'Mess A1' => 'mk_mess_a1',
            'Mess C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'Mess Putri' => 'mk_mess_putri',
            'AMM' => 'mk_mess_amm',
        ];

        foreach (range(1, 10) as $i) {
            $tableMapping["B$i"] = "mk_mess_b{$i}";
        }

        $tableName = $tableMapping[$userTeam] ?? null;

        if (!$tableName) {
            return response()->json(['message' => 'Tabel tidak ditemukan untuk tim ini.'], 404);
        }

        $result = $this->LapCateringDeptRepository->deleteFromTable($tableName, $selectedUserId);

        return response()->json(['message' => $result]);
    }

    public function getEdit(Request $request, $id)
    {
        $departemen = $request->input('departemen', 'HCGA');

        $data = $this->LapCateringDeptRepository->getById($id, $departemen);

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function revisi(Request $request)
    {
        $departemen = $request->input('departemen', 'HCGA');
        $revisiName = auth()->user()->nama;
        $selectedComplainId = $request->input('catering_id');
        $pesanRevisi = $request->input('revisi');

        $result = $this->LapCateringDeptRepository->revisi($revisiName, $selectedComplainId, $pesanRevisi, $departemen);

        return response()->json(['message' => $result]);
    }

    public function approval(Request $request)
    {

        $departemen = $request->input('departemen', 'HCGA');
        $approvalName = auth()->user()->nama;
        $selectedComplainId = $request->input('catering_id');
        $approval = $request->input('keterangan');

        $result = $this->LapCateringDeptRepository->approval($approvalName, $selectedComplainId, $approval, $departemen);


        return response()->json([
            'status' => 'success',
            'message' => $result,
        ]);
    }

    public function approvalAll(Request $request)
    {
        $departemen = $request->input('departemen');
        $approvalName = auth()->user()->nama;
        $selectedComplainIds = $request->input('ids', []);
        $approval = 'ok';

        if (empty($selectedComplainIds)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada data yang dipilih untuk approval.',
            ]);
        }

        $result = $this->LapCateringDeptRepository->approvalAll($approvalName, $selectedComplainIds, $approval, $departemen);

        return response()->json([
            'status' => 'success',
            'message' => $result,
        ]);
    }

    public function sendRevisi(Request $request)
    {
        //dd($request->all());
        $departemen = $request->input('departemen', 'HCGA');
        $selectedComplainId = $request->input('catering_id');


        $result = $this->LapCateringDeptRepository->sendRevisi($selectedComplainId, $departemen);

        return response()->json(['message' => $result]);
    }


}
