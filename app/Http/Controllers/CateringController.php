<?php

namespace App\Http\Controllers;
use App\Http\Repository\CateringRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpWord\TemplateProcessor;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CateringController extends Controller
{
    protected $CateringRepository;

    public function __construct(CateringRepository $CateringRepository)
    {
        $this->CateringRepository = $CateringRepository;
    }


    // public function create()
    // {
    //     $userTeam = auth()->user()->tim_pic;

    //     $tableMapping = [
    //         'COE' => 'mk_coe',
    //         'HCGA' => 'mk_hcga',
    //         'ENG' => 'mk_eng',
    //         'SHE' => 'mk_she',
    //         'FALOG' => 'mk_falog',
    //         'PROD' => 'mk_prod',
    //         'PLANT' => 'mk_plant',
    //         'A1' => 'mk_mess_a1',
    //         'C3' => 'mk_mess_c3',
    //         'AMM' => 'mk_mess_amm',
    //         'MESS' => 'mk_mess',
    //         'MESS_MEICU' => 'mk_mess_meicu',
    //         'MESS_PUTRI' => 'mk_mess_putri',
    //         'MARBOT' => 'mk_marbot',

    //     ];

    //     foreach (range(1, 10) as $i) {
    //         $tableMapping["B$i"] = "mk_mess_b{$i}";
    //     }


    //     $tableName = $tableMapping[$userTeam] ?? null;

    //     if (!$tableName) {
    //         abort(404, 'Tabel tidak ditemukan untuk tim ini.');
    //     }

    //     $columns = Schema::getColumnListing($tableName);

    //     $cateringData = $this->CateringRepository->getData();

    //     $snackData = null;
    //     return view('catering.catering', compact('columns', 'tableName', 'cateringData', 'snackData'));
    // }

    public function create()
    {
        $userTeam = auth()->user()->tim_pic;

        // Mapping table sesuai dengan tim pengguna
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
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
        ];

        foreach (range(1, 10) as $i) {
            $tableMapping["B$i"] = "mk_mess_b{$i}";
        }

        $tableName = $tableMapping[$userTeam] ?? null;

        if (!$tableName) {
            abort(404, 'Tabel tidak ditemukan untuk tim ini.');
        }


        $columns = Schema::getColumnListing($tableName);


        $cateringData = $this->CateringRepository->getData();
        $snackData = $this->CateringRepository->getSnackSummary($userTeam);
        $spesialData = $this->CateringRepository->getspesialSummary($userTeam);

        // Kirim kedua data ke view yang sama
        return view('catering.catering', compact('columns', 'tableName', 'cateringData', 'spesialData', 'snackData'));
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
                'mpict_engineer' => 'mpict_engineer',
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
                'admin_office' => 'admin_office',
                'drill' => 'drill',
                'driver_drill' => 'driver_drill',
                'helper_survey' => 'helper_survey',
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
                'barber_shop' => 'barber_shop',
                'mechanic_koperasi' => 'mechanic_koperasi',
                'koperasi_office' => 'koperasi_office',
                'opt_fuel_truck' => 'opt_fuel_truck',
                'fuelman' => 'fuelman',
                'gl' => 'gl',
                'admin_fuel' => 'admin_fuel',
                'spare_csa' => 'spare_csa',
                'driver_fa_log' => 'driver_fa_log',
                'driverlv_fuel' => 'driverlv_fuel',
                'visitor' => 'visitor',
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
                'visitor' => 'visitor',
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
            'MESS' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'mess_a1' => 'mess_a1',
                'mess_a2' => 'mess_a2',
                'mess_c3' => 'mess_c3',
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
                'rebusan_b1' => 'rebusan_b1',
                'rebusan_b2' => 'rebusan_b2',
                'rebusan_b3' => 'rebusan_b3',
                'rebusan_b4' => 'rebusan_b4',
                'rebusan_b5' => 'rebusan_b5',
                'rebusan_b6' => 'rebusan_b6',
                'rebusan_b7' => 'rebusan_b7',
                'rebusan_b8' => 'rebusan_b8',
                'rebusan_b9' => 'rebusan_b9',
                'rebusan_b10' => 'rebusan_b10',
                'rebusan_a1' => 'rebusan_a1',
                'rebusan_a2' => 'rebusan_a2',
                'rebusan_c3' => 'rebusan_c3',
                'spare_mess'=> 'spare_mess',
            ],
            'MESS_PUTRI' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'mess_gl' => 'mess_gl',
                'rebusan_gl' => 'rebusan_gl',
                'mess_admin' => 'mess_admin',
                'rebusan_admin' => 'rebusan_admin',
                'helper_mess' => 'helper_mess'
            ],
            'MARBOT' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'marbot' => 'marbot',
                'total_laundry' => 'total_laundry',
                'security_laundry' => 'security_laundry'
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
            'A1' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'rebusan_a1' => 'rebusan_a1',
                'spare_a1' => 'spare_a1',
                'visitor_a1' => 'visitor_a1',
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 38)),
                array_map(fn($i) => "kamar_$i", range(1, 38))
            )),
            'C3' => array_merge([
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

        $waktu = strtolower($request->input('waktu'));
        if (strpos($waktu, 'tambahan') !== false) {
            $pesan = "STATUS : MK TAMBAHAN!\n\n";
            $pesan .= "Departemen: {$userTeam}\n\n";
            $pesan .= "Tanggal: {$request->input('tanggal')}\n\n";
            $pesan .= "Terdapat data Mekilo Reguler yang baru ditambahkah oleh Departemen {$userTeam}\n\n";

            $pesan .= "KETERANGAN LEBIH LANJUT\n";
            $pesan .= "SILAHKAN CEK DI PORTAL:\n";
            $pesan .= "https://hallohcga.com/";

            $nomorTujuan = [
                '082181777455',
                '082177968433',
                '082177451148',
                '081770635505'
            ];

            // Kirim ke semua nomor
            foreach ($nomorTujuan as $nomor) {
                $this->sendWhatsAppMessage($nomor, $pesan);
            }
        }

        if ($insert) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }

    }

    public function storeSnack(Request $request)
    {
        //dd($request->all());
        $userTeam = auth()->user()->tim_pic;
        $createdBy = auth()->user()->nama;
        $status = 1;

        $tanggal = $request->tanggal_snack_add;
        $waktu   = $request->waktu_snack_add;
        $area    = $request->area_snack_add;
        $gedung  = $request->gedung_snack_add;
        $lokasi  = $request->lokasi_snack_add;
        $snack   = $request->snack_add;
        $jumlah  = $request->jumlah_snack_add;
        $keterangan  = $request->keterangan_snack_add;

        if (!$waktu || count($waktu) == 0) {
            return response()->json(['status' => 'error', 'message' => 'Data snack kosong']);
        }

        $insertData = [];

        foreach ($waktu as $index => $val) {
            $insertData[] = [
                'departemen'   => $userTeam,
                'tanggal'      => $tanggal,
                'waktu'        => $val,
                'area'         => $area[$index],
                'gedung'       => $gedung[$index],
                'lokasi'       => $lokasi[$index],
                'jenis'        => $snack[$index],
                'jumlah'       => $jumlah[$index],
                'keterangan'   => $keterangan[$index],
                'create_at'    => now(),
                'status'       => $status,
                'created_name' => $createdBy
            ];
        }

        $insert = DB::table('mk_snack')->insert($insertData);

        if ($insert) {
        $messageUser = "SNACK\n\n";

        $messageUser .= "DEPARTEMEN: $userTeam\n\n";
        $messageUser .= "Halo Admin HCGA\n\n";
        $messageUser .= "Terdapat penambahan MK SNACK oleh departemen $userTeam.\n\n";
        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $nomorTujuan = [
            '082181777455',
            '082177968433',
            '082177451148',
            '081770635505'
        ];

        foreach ($nomorTujuan as $nomor) {
            $this->sendWhatsAppMessage($nomor, $messageUser);
        }

        return response()->json(['status' => 'success']);
    } else {
        return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan data']);
    }



    }

    public function storeSpesial(Request $request)
    {
        //dd($request->all());
        $userTeam = auth()->user()->tim_pic;
        $createdBy = auth()->user()->nama;
        $status = 1;

        $tanggal = $request->tanggal_spesial_add;
        $waktu   = $request->waktu_spesial_add;
        $area   = $request->area_spesial_add;
        $gedung   = $request->gedung_spesial_add;
        $lokasi  = $request->lokasi_spesial_add;
        $spesial   = $request->spesial_add;
        $jumlah  = $request->jumlah_spesial_add;
        $keterangan  = $request->keterangan_spesial_add;

        if (!$waktu || count($waktu) == 0) {
            return response()->json(['status' => 'error', 'message' => 'Data spesial kosong']);
        }

        $insertData = [];

        foreach ($waktu as $index => $val) {
            $insertData[] = [
                'departemen'   => $userTeam,
                'tanggal'      => $tanggal,
                'waktu'        => $val,
                'area'         => $area[$index],
                'gedung'       => $gedung[$index],
                'lokasi'       => $lokasi[$index],
                'jenis'        => $spesial[$index],
                'jumlah'       => $jumlah[$index],
                'keterangan'         => $keterangan[$index],
                'create_at'    => now(),
                'status'       => $status,
                'created_name' => $createdBy
            ];
        }

        $insert = DB::table('mk_spesial')->insert($insertData);

        if ($insert) {
        $messageUser = "SPESIAL\n\n";

        $messageUser .= "DEPARTEMEN: $userTeam\n\n";
        $messageUser .= "Halo Admin HCGA\n\n";
        $messageUser .= "Terdapat penambahan MK SPESIAL oleh departemen $userTeam.\n\n";
        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $nomorTujuan = [
            '082181777455',
            '082177968433',
            '082177451148',
            '081770635505'
        ];

        foreach ($nomorTujuan as $nomor) {
            $this->sendWhatsAppMessage($nomor, $messageUser);
        }

        return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan data']);
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
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
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
                'admin_office' => 'admin_office',
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
                'barber_shop' => 'barber_shop',
                'mechanic_koperasi' => 'mechanic_koperasi',
                'koperasi_office' => 'koperasi_office',
                'opt_fuel_truck' => 'opt_fuel_truck',
                'fuelman' => 'fuelman',
                'gl' => 'gl',
                'admin_fuel' => 'admin_fuel',
                'spare_csa' => 'spare_csa',
                'driver_fa_log' => 'driver_fa_log',
                'driverlv_fuel'=> 'driverlv_fuel',
                'visitor' => 'visitor',
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
                'visitor' => 'visitor',
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
           'MESS' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'mess_a1' => 'mess_a1',
                'mess_a2' => 'mess_a2',
                'mess_c3' => 'mess_c3',
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
                'rebusan_b1' => 'rebusan_b1',
                'rebusan_b2' => 'rebusan_b2',
                'rebusan_b3' => 'rebusan_b3',
                'rebusan_b4' => 'rebusan_b4',
                'rebusan_b5' => 'rebusan_b5',
                'rebusan_b6' => 'rebusan_b6',
                'rebusan_b7' => 'rebusan_b7',
                'rebusan_b8' => 'rebusan_b8',
                'rebusan_b9' => 'rebusan_b9',
                'rebusan_b10' => 'rebusan_b10',
                'rebusan_a1' => 'rebusan_a1',
                'rebusan_a2' => 'rebusan_a2',
                'rebusan_c3' => 'rebusan_c3',
                'spare_mess'=> 'spare_mess',
            ],
            'MESS_PUTRI' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'mess_gl' => 'mess_gl',
                'rebusan_gl' => 'rebusan_gl',
                'mess_admin' => 'mess_admin',
                'rebusan_admin' => 'rebusan_admin',
                'helper_mess' => 'helper_mess'
            ],
            'MARBOT' => [
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'marbot' => 'marbot',
                'total_laundry' => 'total_laundry',
                'security_laundry' => 'security_laundry'
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
            'A1' => array_merge([
                'tanggal' => 'tanggal',
                'waktu' => 'waktu',
                'rebusan_a1' => 'rebusan_a1',
                'spare_a1' => 'spare_a1',
                'visitor_a1' => 'visitor_a1'
            ], array_combine(
                array_map(fn($i) => "kamar_$i", range(1, 38)),
                array_map(fn($i) => "kamar_$i", range(1, 38))
            )),
            'C3' => array_merge([
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

    public function editSnack(Request $request, $id)
    {
        $userTeam = auth()->user()->tim_pic;

        $table = 'mk_snack';

        $columnMappings = [
            'tanggal_snack_add' => 'tanggal',
            'waktu_snack_add'   => 'waktu',
            'area_snack_add'  => 'area',
            'gedung_snack_add'  => 'gedung',
            'lokasi_snack_add'  => 'lokasi',
            'snack_add'   => 'jenis',
            'jumlah_snack_add'  => 'jumlah',
            'keterangan_snack_add'  => 'keterangan'
        ];

        $inputData = $request->except(['_token', 'table_name', 'tipeSnack']);

        $data = [];
        foreach ($inputData as $inputName => $value) {
            $columnName = $columnMappings[$inputName] ?? $inputName;
            $data[$columnName] = is_array($value) ? $value[0] : $value;
        }

        $update = DB::table($table)
            ->where('id', $id)
            ->where('departemen', $userTeam)
            ->update($data);

        if ($update) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengupdate data']);
        }
    }

    public function editSpesial(Request $request, $id)
    {
        //dd($request->all());
        $userTeam = auth()->user()->tim_pic;

        $table = 'mk_spesial';

        $columnMappings = [
            'tanggal_spesial_add' => 'tanggal',
            'waktu_spesial_add'   => 'waktu',
            'area_spesial_add'    => 'area',
            'gedung_spesial_add'  => 'gedung',
            'lokasi_spesial_add'  => 'lokasi',
            'spesial_add'   => 'jenis',
            'jumlah_spesial_add'  => 'jumlah',
            'keterangan_spesial_add'  => 'keterangan',
        ];

        $inputData = $request->except(['_token', 'table_name']);

        $data = [];
        foreach ($inputData as $inputName => $value) {
            $columnName = $columnMappings[$inputName] ?? $inputName;
            $data[$columnName] = is_array($value) ? $value[0] : $value;
        }

        $update = DB::table($table)
            ->where('id', $id)
            ->where('departemen', $userTeam)
            ->update($data);

        if ($update !== false) {
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
            'SHE' => 'mk_she',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'AMM' => 'mk_mess_amm',
            'MESS' => 'mk_mess',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
            'MARBOT' => 'mk_marbot',
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

    public function deleteSnack(Request $request)
    {

        $selectedUserId = $request->input('snack_id');

        $tableName = 'mk_snack';

        if (!$tableName) {
            return response()->json(['message' => 'Tabel tidak ditemukan untuk tim ini.'], 404);
        }

        $result = $this->CateringRepository->deleteFromTableSnack($tableName, $selectedUserId);

        return response()->json(['message' => $result]);
    }

    public function deleteSpesial(Request $request)
    {

        $selectedUserId = $request->input('spesial_id');

        $tableName = 'mk_spesial';

        if (!$tableName) {
            return response()->json(['message' => 'Tabel tidak ditemukan untuk tim ini.'], 404);
        }

        $result = $this->CateringRepository->deleteFromTableSpesial($tableName, $selectedUserId);

        return response()->json(['message' => $result]);
    }

    public function sendRevisi(Request $request)
    {
        $departemen = $request->input('departemen', 'HCGA');
        $selectedComplainId = $request->input('catering_id');

        $result = $this->CateringRepository->sendRevisi($selectedComplainId, $departemen);

        $messageUser = "STATUS: REVISION IS DONE\n\n";

        $messageUser = "DEPARTEMEN: $departemen\n\n";

        $messageUser .= "Halo Admin HCGA\n\n";
        $messageUser .= "Revisi data telah diselesaikan oleh departemen $departemen .\n\n";

        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $nomorTujuan = [
            '082181777455',
            '082177968433',
            '082177451148',
            '081770635505'
        ];

        // Kirim ke semua nomor
        foreach ($nomorTujuan as $nomor) {
            $this->sendWhatsAppMessage($nomor, $messageUser);
        }

        return response()->json(['message' => $result]);
    }

    public function sendRevisiSnack(Request $request)
    {
        $departemen = $request->input('departemen', 'HCGA');
        $selectedComplainId = $request->input('snack_id');

        $result = $this->CateringRepository->sendRevisiSnack($selectedComplainId, $departemen);

        $messageUser = "STATUS: REVISION IS DONE\n\n";

        $messageUser = "DEPARTEMEN: $departemen\n\n";

        $messageUser .= "Halo Admin HCGA\n\n";
        $messageUser .= "Revisi data  SNACK telah diselesaikan oleh departemen $departemen .\n\n";

        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $nomorTujuan = [
            '082181777455',
            '082177968433',
            '082177451148',
            '081770635505'
        ];

        // Kirim ke semua nomor
        foreach ($nomorTujuan as $nomor) {
            $this->sendWhatsAppMessage($nomor, $messageUser);
        }

        return response()->json(['message' => $result]);
    }

    public function sendRevisiSpesial(Request $request)
    {
        $departemen = $request->input('departemen', 'HCGA');
        $selectedComplainId = $request->input('spesial_id');

        $result = $this->CateringRepository->sendRevisiSpesial($selectedComplainId, $departemen);

        $messageUser = "STATUS: REVISION IS DONE\n\n";

        $messageUser = "DEPARTEMEN: $departemen\n\n";

        $messageUser .= "Halo Admin HCGA\n\n";
        $messageUser .= "Revisi data MK Spesial telah diselesaikan oleh departemen $departemen .\n\n";

        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $nomorTujuan = [
            '082181777455',
            '082177968433',
            '082177451148',
            '081770635505'
        ];

        // Kirim ke semua nomor
        foreach ($nomorTujuan as $nomor) {
            $this->sendWhatsAppMessage($nomor, $messageUser);
        }

        return response()->json(['message' => $result]);
    }

    public function getEdit(Request $request, $id)
    {
        $departemen = $request->input('departemen', 'HCGA');

        $data = $this->CateringRepository->getById($id, $departemen);

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function getEditSnack(Request $request, $id)
    {
        //$departemen = auth()->user()->tim_pic;

        $data = $this->CateringRepository->getByIdSnack($id);
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function getEditSpesial(Request $request, $id)
    {
        $departemen = auth()->user()->tim_pic;

        $data = $this->CateringRepository->getByIdSpesial($id, $departemen);

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function getPrevious(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $waktu = $request->input('waktu');

        if (!$tanggal || !$waktu) {
            return response()->json(['error' => 'Tanggal dan Waktu wajib diisi'], 400);
        }

        $data = $this->CateringRepository->getPreviousData($tanggal, $waktu);

        if (!$data) {
            return response()->json(['error' => 'Data sebelumnya tidak ditemukan'], 404);
        }

        return response()->json($data);
    }


    public function exportData(Request $request)
    {
        $userTeam = auth()->user()->tim_pic;
        $tanggal = $request->query('tanggal');

        if (!$tanggal) {
            return response()->json(['status' => 'error', 'message' => 'Tanggal tidak ditemukan.'], 400);
        }

        $templateMapping = [
            'COE' => 'template_coe.docx',
            'HCGA' => 'template_hcga.docx',
            'ENG' => 'template_eng.docx',
            'SHE' => 'template_she.docx',
            'FALOG' => 'template_falog.docx',
            'PROD' => 'template_prod.docx',
            'PLANT' => 'template_plant.docx',
            'A1' => 'template_a1.docx',
            'C3' => 'template_c3.docx',
            'MESS_MEICU' => 'template_mess_meicu.docx',
            'MESS_PUTRI' => 'template_mess_putri.docx',
            'MARBOT' => 'template_marbot.docx',
            'AMM' => 'template_amm.docx',
            'MESS' => 'template_mess.docx',
        ];

        foreach (range(1, 10) as $i) {
            $templateMapping["B$i"] = "template_b{$i}.docx";
        }

        if (!isset($templateMapping[$userTeam])) {
            return response()->json(['status' => 'error', 'message' => 'Template tidak ditemukan untuk tim ini.'], 404);
        }

        $templatePath = resource_path("template/" . $templateMapping[$userTeam]);

        if (!file_exists($templatePath)) {
            return response()->json(['status' => 'error', 'message' => 'Template tidak ditemukan.'], 404);
        }

        $tableName = match (true) {
            $userTeam === 'MESS_MEICU' => 'mk_mess_meicu',
            $userTeam === 'MESS_PUTRI' => 'mk_mess_putri',
            $userTeam === 'A1' => 'mk_mess_a1',
            $userTeam === 'C3' => 'mk_mess_c3',
            $userTeam === 'AMM' => 'mk_mess_amm',
            $userTeam === 'MESS' => 'mk_mess',
            str_starts_with($userTeam, 'B') => 'mk_mess_' . strtolower($userTeam),
            default => 'mk_' . strtolower($userTeam),
        };

        $dataList = DB::table($tableName)
            ->where('status', 2)
            ->whereDate('tanggal', $tanggal)
            ->get();

        $templateProcessor = new TemplateProcessor($templatePath);

        $mainTimes = ['Siang', 'Pagi', 'Malam', 'Sore'];
        $extraTimes = ['Tambahan Siang', 'Tambahan Pagi', 'Tambahan Malam', 'Tambahan Sore'];

        $excludedColumns = ['id', 'tanggal', 'waktu', 'status', 'create_at', 'created_name',
            'approval_by', 'approval_on', 'approval_desc',
            'revisi_by', 'revisi_on', 'revisi_desc', 'visitor'];

        $dataByWaktu = [];
        $totals = [];
        $columns = [];
        $visitorByWaktu = [];

        if (!$dataList->isEmpty()) {
            foreach ($dataList as $data) {
                $waktu = $data->waktu;
                $rowData = (array) $data;

                $filteredData = array_diff_key($rowData, array_flip($excludedColumns));

                foreach ($filteredData as $key => $value) {
                    $columns[$key] = true;

                    $dataByWaktu["{$waktu}_{$key}"] = ($dataByWaktu["{$waktu}_{$key}"] ?? 0) + ($value ?? 0);

                    foreach ($mainTimes as $mainTime) {
                        if ($waktu === "Tambahan {$mainTime}") {
                            $dataByWaktu["{$mainTime}_{$key}"] = ($dataByWaktu["{$mainTime}_{$key}"] ?? 0) + ($value ?? 0);
                        }
                    }

                    if (is_numeric($value)) {
                        $totals[$key] = ($totals[$key] ?? 0) + $value;
                    }
                }

                // Simpan visitor berdasarkan waktu
                if (!empty($data->visitor)) {
                    $visitorByWaktu[$waktu][] = $data->visitor;
                }
            }
        }

        foreach (array_merge($mainTimes, $extraTimes) as $waktu) {
            foreach ($columns as $column => $_) {
                $key = "{$waktu}_{$column}";
                $value = $dataByWaktu[$key] ?? '-';
                $templateProcessor->setValue($key, in_array($value, [null, '', 0], true) ? '-' : $value);
            }
        }

        foreach ($columns as $column => $_) {
            $value = $totals[$column] ?? '-';
            $templateProcessor->setValue("total_{$column}", in_array($value, [null, '', 0], true) ? '-' : $value);
        }

        $totalSemua = array_sum($totals);
        $templateProcessor->setValue("total_semua", ($totalSemua === 0) ? '-' : $totalSemua);

        // Set tanggal ke template
        $templateProcessor->setValue('tanggal', $tanggal);

        // Proses gabungan visitor Siang & Tambahan Siang, Malam & Tambahan Malam
        foreach ($mainTimes as $mainTime) {
            $visitorsUtama = $visitorByWaktu[$mainTime] ?? [];
            $visitorsTambahan = $visitorByWaktu["Tambahan {$mainTime}"] ?? [];

            $gabunganVisitor = array_merge($visitorsUtama, $visitorsTambahan);
            $visitorStr = !empty($gabunganVisitor) ? implode(", ", $gabunganVisitor) : '-';

            $templateProcessor->setValue("{$mainTime}_visitor", $visitorStr);
        }

        $formattedDate = date('Y-m-d', strtotime($tanggal));
        $fileName = "{$formattedDate}_Laporan_Order_MK_Reguler_{$userTeam}.docx";
        $filePath = storage_path("app/public/$fileName");

        $templateProcessor->saveAs($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }





}
