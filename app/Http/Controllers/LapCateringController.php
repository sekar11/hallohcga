<?php

namespace App\Http\Controllers;
use App\Http\Repository\LapCateringRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;

class LapCateringController extends Controller
{
    protected $LapCateringRepository;

    public function __construct(LapCateringRepository $LapCateringRepository)
    {
        $this->LapCateringRepository = $LapCateringRepository;
    }

    public function create(Request $request)
    {
        // Ambil nilai filter dari request
        $startDate = $request->input('start_date', now()->addDay()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->addDay()->format('Y-m-d'));
        $selectedDept = $request->input('departemen', 'HCGA'); // Default HCGA

        // Pastikan departemen tidak kosong sebelum mengambil tabel
        if (!$selectedDept) {
            return response()->json(['error' => 'Harap pilih departemen!'], 400);
        }

        // Mapping tabel berdasarkan catering
        $tableMapping = [
            'FITRI' => 'mk_coe',
            'WASTU' => 'mk_hcga',
            'BINTANG' => 'mk_eng',

        ];

        // Tambahkan Mess B1 - B10 ke dalam mapping
        foreach (range(1, 10) as $i) {
            $tableMapping["Mess B$i"] = "mk_mess_b{$i}";
        }

        // Cek apakah departemen yang dipilih memiliki tabel yang sesuai
        $tableName = $tableMapping[$selectedDept] ?? null;

        if (!$tableName) {
            abort(404, 'Tabel tidak ditemukan untuk departemen ini.');
        }

        // Ambil daftar kolom dari tabel
        $columns = Schema::getColumnListing($tableName);

        // Ambil data dari repository dengan filter tanggal dan departemen
        $cateringData = $this->LapCateringRepository->getData($tableName, $startDate, $endDate);

        return view('catering.laporanCatering', compact('columns', 'tableName', 'cateringData', 'startDate', 'endDate', 'selectedDept'));

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $categories = [
            'Makan Tambang Siang Fitri' => ['Produksi CSA PIT 1', 'Section Head Anjungan PIT 1','Produksi CSA PIT 2', 'Section Head Anjungan PIT 2'],
        ];

        $cateringData = $this->LapCateringRepository->getCateringData($selectedDate, $categories);

        return view('catering.laporanCatering', compact('cateringData', 'selectedDate'));
    }


    public function index(Request $request)
    {
        $selectedDate = $request->input('date', now()->format('Y-m-d')); // Perbaikan dari 'selected_date'
        $userTeam = auth()->user()->tim_pic;
        $selectedCatering = $request->input('catering', $userTeam);

        // Definisi kategori berdasarkan catering yang dipilih
        $categories = [
            'FITRI' => [
                'Makan Tambang Siang Fitri' => ['Produksi CSA PIT 1', 'Section Head Anjungan PIT 1', 'Produksi CSA PIT 2', 'Section Head Anjungan PIT 2']
            ],
            'wastu' => [
                'MK SIANG MESS C1 (DH & SH)' => ['MESS SECTION HEAD'],
                'MK SIANG MESS PUTRI TALANG JAWA' => ['Mess GL Putri Talang Jawa', 'MESS ADMIN PUTRI Talang Jawa', 'HELPER MESS PUTRI'],
                'MK SIANG KARTIKA' => ['LAUNDRY KARTIKA'],
                'MK SIANG MEICU' => ['Mess Meicu R1', 'Mess Meicu R2', 'Mess Meicu R3 FMDP', 'Mess Meicu R4-5'],
                'MK SIANG OFFICE GA MEICU' => ['Driver LV', 'Office Meicu', 'Meicu Security', 'VENDOR', 'CV ADE(PETUGAS SAMPAH)', 'Helper'],
                'MK SIANG MESS TAMBANG' => ['RENCANA MESS GL A1','RENCANA MESS GL A2', 'Rencana Mess B1', 'Rencana Mess B2', 'Rencana Mess B3', 'Rencana Mess B4', 'Rencana Mess B7', 'Rencana Mess B8', 'Rencana Mess B9', 'Rencana Mess B10'],
                'MK SIANG MESS TAMBANG AMM' => ['Rencana Mess B1', 'Rencana Mess B2', 'Rencana Mess B3', 'Rencana Mess B4', 'Rencana Mess B7', 'Rencana Mess B8', 'Rencana Mess B9', 'Rencana Mess B10', 'SPARE'],
                'OFFICE GA MESS TAMBANG' => ['Kontainer GA Mess Tambang', 'Electrical GA', 'Helper Mess', 'Driver bus Mess Tambang', 'KOPERASI MESS TAMBANG', 'KONTAINER MEDIC MESS TAMBANG', 'Security Mess Tambang', 'Mekanik TRAC Mess Tambang', 'Driver BUS JUM\'AT', 'GL CIVIEL ENG', 'Skill UP LT CSA pit 1'],
                'MK SIANG DEPTHEAD & PJO' => ['Dept.Head ENG ★(Office Plant)', 'TAMU HO COE ★(Office Plant)', 'PJO ★(Office Plant)', 'Dept.Head Produksi ★(CSA PIT 1)', 'Dept Head SHE ★(CSA PIT 1)', 'Dept.Head PLANT ★(WORKSHOP)', 'Dept.Head PLANT ★(PITSTOP)'],
                'OFFICE PLANT SIANG' => ['Driver Bus Jum\'atan', 'COE OFFICE ( CCR,MOCO)', 'SectHead COE', 'PLANT', 'Section Head PLANT', 'SECURITY PATROL', 'HCGA', 'Section Head HCGA', 'DRIVER HCGA (88,01)', 'SERTIFIKASI HCGA', 'Produksi', 'Driver Engineering', 'Sect.Head ENG', 'Engineering'],
                'MK SORE MESS DH & SH (PPA RESIDANCE)' => ['MESS DH & PJO', 'MESS SECTION HEAD'],
            ],

           'bintang' => [
                'MK PAGI MESS PUTRI' => ['MESS GL PUTRI TALANG JAWA', 'REBUSAN GL PUTRI TALANG JAWA', 'MESS ADMIN PUTRI TALANG JAWA', 'REBUSAN ADMIN PUTRI'],
                'MK PAGI MESS MEICU' => ['Meicu Ruko 1', 'Meicu Ruko 2', 'Meicu Ruko 3', 'Meicu Ruko 4-5', 'REBUSAN R1', 'REBUSAN R3', 'REBUSAN R4-R5', 'VISITOR', 'MAGANG UGM'],
                'MK PAGI OFFICE PLANT' => ['VENDOR JMI'],
                'MK PAGI OFFICE MEICU' => ['Bagong', 'TEST PRAKTEK'],
                'MK PAGI MESS TAMBANG' => ['Mess Tambang GL A1', 'Mess Tambang B1', 'Mess Tambang B2', 'Mess Tambang B3', 'Mess Tambang B4', 'Mess Tambang B7', 'Mess Tambang B8', 'Mess Tambang B9', 'Mess Tambang B10', 'REBUSAN GL A1', 'REBUSAN B1', 'REBUSAN B2', 'REBUSAN B3', 'REBUSAN B4', 'REBUSAN B7', 'REBUSAN B8', 'REBUSAN B9', 'REBUSAN B10', 'SPARE'],
                'Sore (Jam 15:40 WIB) MESS TALANG JAWA' => ['Mess Gl putri Talang Jawa', 'MESS ADMIN PUTRI Talang Jawa'],
                'Sore (Jam 15:40 WIB) MESS MEICU' => ['Mess Meicu R1', 'Mess Meicu R2', 'Mess Meicu R3 FMDP', 'Mess Meicu R4-5'],
                'MK SORE OFFICE MEICU' => ['Meicu Security', 'VISITOR', 'Helper Meicu', 'Bagong', 'TES PRAKTEK', 'MAGANG UGM'],
                'MK SORE OFFICE PLANT' => ['VENDOR JMI (ENG)'],
                'Sore (Jam 15:40 WIB) MESS TAMBANG' => ['Mess Tambang A1', 'Mess Tambang B1', 'Mess Tambang B2', 'Mess Tambang B3', 'Mess Tambang B4', 'Mess Tambang B7', 'Mess Tambang B8', 'Mess Tambang B9', 'Mess Tambang B10', 'REBUSAN B2', 'REBUSAN B3', 'REBUSAN B4', 'REBUSAN B7', 'REBUSAN B9', 'SPARE'],
                'MAKAN TAMBANG SIANG' => ['Produksi Pit 3 (Jam 10.00 WIB)', 'ENG CSA PIT 3', 'ENG CSA PIT 2 DRILL & BLAST', 'Eng CSA Pit 2', 'DRIVER ENG CSA PIT 2', 'ENG CSA HRM (Vendor JMI)', 'COE CSA PIT 3', 'COE PITSOP - SS6', 'COE CSA PIT 1 - ICT', 'Driver COE CSA PIT 1', 'Plant Pitstop', 'Training Plant Pitstop', 'DRIVER PLANT PITSTOP', 'PLANT OFFICE PITSTOP', 'Plant Workshop', 'DRIVER PLANT WORKSHOP', 'Sect.Head PLANT PITSTOP', 'Sect.Head PLANT WORKSHOP', 'Sect Head SHE CSA PIT 1', 'SHE CSA PIT 1', 'DRIVER SHE CSA PIT 1', 'DRIVER FA-LOG WAREHOUSE', 'KOPERASI FALOG (RENCANA OFFICE)', 'FA-Log (WAREHOUSE PPA)', 'SectHead FA-LOG WAREHOUSE', 'Fuel', 'FALOG( WORKSHOP KOPERASI GUDANG GA)', 'HCGA Tes Praktek (Opsional)', 'HCGA SPBI', 'HCGA TAMBANG', 'HCGA CSA PIT (PRAKTEK)', 'HCGA Security SPBI'],
            ],

        ];

        // Gunakan kategori berdasarkan catering yang dipilih, jika tidak ada default ke array kosong
        $selectedCategories = $categories[$selectedCatering] ?? [];

        // Ambil data catering berdasarkan kategori yang sesuai
        $cateringData = $this->LapCateringRepository->getCateringData($selectedDate, $selectedCategories, $selectedCatering);
        $cateringDataRevisi = $this->LapCateringRepository->getCateringDataRevisi($selectedDate, $selectedCategories, $selectedCatering);
        $snackData = $this->LapCateringRepository->getSnackSummary($selectedCatering, $selectedDate);
        $spesialData = $this->LapCateringRepository->getSpesialSummary($selectedCatering, $selectedDate);
        //dd($snackData);
        return view('catering.laporanCatering', compact('cateringData', 'cateringDataRevisi','selectedDate', 'userTeam', 'selectedCatering', 'snackData', 'spesialData'));
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
                'admin_office' => 'admin_office',
                'drill' => 'drill',
                'driver_drill' => 'driver_drill',
                'helper_survey' => 'helper_survey',
                'driver_survey' => 'driver_survey',
                'vendor_jmi' => 'vendor_jmi',
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

    public function exportExcel(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        if (auth()->user()->id_role == 7) {
            $catering = strtoupper(auth()->user()->tim_pic);
        } else {
            $catering = strtoupper($request->input('catering_export'));
        }

        $data = $this->LapCateringRepository->getCateringFitri($month, $year, $catering);

        $templatePath = resource_path("template/{$catering}.xlsx");
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template not found'], 404);
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Placeholder: isi bulan dan tahun di template
        $bulanNama = Carbon::create()->month($month)->locale('id')->isoFormat('MMMM');
        $sheet->setCellValue('A1', $bulanNama);
        $sheet->setCellValue('B1', $year);

        // Mapping lokasi berdasarkan catering
        $lokasiMappingFitri = [
            'prod_csa_pit1'                   => 2,
            'section_head_pit1'               => 3,
            'prod_skillup_csapit1'            => 4,
            'prod_pit2'                       => 5,
            'driver_lv_pit2'                  => 6,
            'section_head_pit2'               => 7,
            'eng_drill'                       => 8,
            'eng_csapit2'                     => 9,
            'eng_driver_csapit2'              => 10,
            'eng_vendor_jmi'                  => 11,
            'hcga_security_rosela'            => 12,
            'prod_pitstop'                    => 13,
            'prod_csahrm'                     => 14,
        ];

        $lokasiMappingWastu = [
            'pagi_kamar_c3'                   => 3,
            'siang_kamar_c3'                  => 5,
            'siang_mess_gl'                   => 6,
            'siang_mess_admin'                => 7,
            'siang_helper_mess_putri'         => 8,
            'siang_laundry'                   => 9,
            'siang_ruko_1'                    => 10,
            'siang_ruko_2'                    => 11,
            'siang_ruko_3'                    => 12,
            'siang_ruko_45'                   => 13,
            'siang_magang_mess_meicu'         => 14,
            'siang_driver_meicu'              => 15,
            'siang_office_meicu'              => 16,
            'siang_security_meicu'            => 17,
            'siang_vendor_meicu'              => 18,
            'siang_cv_ade'                    => 19,
            'siang_helper_meicu'              => 20,
            'siang_kamar_a1'                  => 21,
            'siang_kamar_a2'                  => 22,
            'siang_kamar_b1'                  => 23,
            'siang_kamar_b2'                  => 24,
            'siang_kamar_b3'                  => 25,
            'siang_kamar_b4'                  => 26,
            'siang_kamar_b7'                  => 27,
            'siang_kamar_b8'                  => 28,
            'siang_kamar_b9'                  => 29,
            'siang_kamar_b10'                 => 30,
            'siang_mess_b1'                   => 31,
            'siang_mess_b2'                   => 32,
            'siang_mess_b3'                   => 33,
            'siang_mess_b4'                   => 34,
            'siang_mess_b7'                   => 35,
            'siang_mess_b8'                   => 36,
            'siang_mess_b9'                   => 37,
            'siang_mess_b10'                  => 38,
            'siang_spare_amm'                 => 39, // SPARE
            'siang_container_ga_mess'         => 40,
            'siang_electrical_ga'             => 41,
            'siang_helper_mess'               => 42,
            'siang_driver_bus'                => 43,
            'siang_koperasi_mess'             => 44,
            'siang_kontainer_medic'           => 45,
            'siang_security_poss'             => 46,
            'siang_mekanic_trac'              => 47,
            'siang_driver_bus_jumat_mess'     => 48,
            'siang_gl_civil'                  => 49,
            'siang_skill_up_lt'               => 50,
            'siang_dept_head_eng'             => 51,
            'siang_tamu_ho'                   => 52,
            'siang_pjo'                       => 53,
            'siang_dept_sect_csapit1'         => 54,
            'siang_dept_head'                 => 55,
            'siang_dept_head_plant'           => 56,
            'siang_dept_head_pitstop'         => 57,
            'siang_dept_head_falog'           => 58,
            'siang_driver_bus_jumat'          => 60,
            'siang_office_ccr_moco'           => 61,
            'siang_section'                   => 62,
            'siang_plant'                     => 63,
            'siang_sect_head_plant'           => 64,
            'siang_security_patrol'           => 65,
            'siang_hcga_office_plant'         => 66,
            'siang_sect_head'                 => 67,
            'siang_driver_plant'              => 68,
            'siang_sertifikasi_hcga'          => 69,
            'siang_admin_officeplant'         => 70,
            'siang_driver_eng'                => 71,
            'siang_sect_head_eng'             => 72,
            'siang_engineering'               => 73,
            'sore_kamar_c3'                   => 74,
            'malam_plant_pitstop'             => 76,
            'malam_driver_plant_plant'        => 77,
            'malam_plant_workshop'            => 78,
            'malam_driver_workshop'           => 79,
            'malam_koperasi_mess'             => 80,
            'malam_kontainer_medic'           => 81,
            'malam_security_poss'             => 82,
            'malam_helper_mess'               => 83,
            'malam_admin_ga'                  => 84,
            'malam_driver_mess'               => 85,
            'malam_electrical_ga'             => 86,
            'malam_mekanic_trac'              => 87,
            'malam_coe_csa_pit1'              => 88,
            'malam_mpss6_sysdev'              => 89,
            'malam_mpccr_admccr'              => 90,
            'malam_dept_sect_csapit2'         => 91,
            'malam_prod_pit2'                 => 92,
            'malam_driverlv_csapit2'          => 93,
            'malam_prod_pit3'                 => 94,
            'malam_vendor_jmi'                => 95,
            'malam_she_csa_pit1'              => 96,
            'malam_driver'                    => 97,
            'malam_log_warehouse_falog'       => 98,
            'malam_mechanic_koperasi'         => 99,
            'malam_fuel'                      => 100,
            'malam_driver_helper_office'      => 101,
            'malam_security_pit1'             => 102,
            'malam_security_pit3'             => 103,
            'malam_security_anjungan'         => 104,
            'malam_security_laundry'          => 105,
            'malam_security_plant'        => 107,
            'malam_security_patrol'       => 108,
            'malam_base_control'          => 109,
            'malam_eng_plant'             => 110,
            'malam_coe_office'            => 111,


        ];

        $lokasiMappingBintang = [

            'pagi_mess_gl'                    => 2,
            'pagi_rebusan_gl'                 => 3,
            'pagi_mess_admin'                 => 4,
            'pagi_rebusan_admin'              => 5,
            'pagi_ruko_1'                     => 6,
            'pagi_ruko_2'                     => 7,
            'pagi_ruko_3'                     => 8,
            'pagi_ruko_45'                    => 9,
            'pagi_rebusan_ruko1'              => 10,
            'pagi_rebusan_ruko3'              => 11,
            'pagi_rebusan_ruko45'             => 12,
            'pagi_visitor_hcga'               => 13,
            'pagi_magang_meicu'               => 14,
            'pagi_vendor_jmi'                 => 15,
            'pagi_bagong'                     => 16,
            'pagi_test_praktek'               => 17,
            'pagi_kamar_a1'       => 18,
            'pagi_kamar_a2'       => 19,
            'pagi_kamar_b1'       => 20,
            'pagi_kamar_b2'       => 21,
            'pagi_kamar_b3'       => 22,
            'pagi_kamar_b4'       => 23,
            'pagi_kamar_b7'       => 24,
            'pagi_kamar_b8'       => 25,
            'pagi_kamar_b9'       => 26,
            'pagi_kamar_b10'      => 27,
            'pagi_rebusan_a1'     => 28,
            'pagi_rebusan_a2'     => 29,
            'pagi_rebusan_b1'     => 30,
            'pagi_rebusan_b2'     => 31,
            'pagi_rebusan_b3'     => 32,
            'pagi_rebusan_b4'     => 33,
            'pagi_rebusan_b7'     => 34,
            'pagi_rebusan_b8'     => 35,
            'pagi_rebusan_b9'     => 36,
            'pagi_rebusan_b10'    => 37,
            'pagi_spare_b1'       => 38,

            'sore_mess_gl'                   => 40,
            'sore_mess_admin'                => 41,
            'sore_ruko_1'                    => 42,
            'sore_ruko_2'                    => 43,
            'sore_ruko_3'                    => 44,
            'sore_ruko_45'                   => 45,
            // 'sore_test_praktek'              => 44,
            // 'sore_magang_meicu'              => 45,
            'sore_security_meicu'            => 46,
            'sore_visitor'                   => 47,
            'sore_helper_meicu'              => 48,
            'sore_bagong'                    => 49,
            'sore_test_praktek'              => 50,
            'sore_magang_meicu'              => 51,
            'sore_vendor_jmi'                => 52,

            'sore_kamar_a1'       => 53,
            'sore_kamar_a2'       => 54,
            'sore_kamar_b1'       => 55,
            'sore_kamar_b2'       => 56,
            'sore_kamar_b3'       => 57,
            'sore_kamar_b4'       => 58,
            'sore_kamar_b7'       => 59,
            'sore_kamar_b8'       => 60,
            'sore_kamar_b9'       => 61,
            'sore_kamar_b10'      => 62,

            'sore_rebusan_b2'     => 63,
            'sore_rebusan_b3'     => 64,
            'sore_rebusan_b4'     => 65,
            'sore_rebusan_b7'     => 66,
            'sore_rebusan_b9'     => 67,
            'sore_spare_b1'       => 68,

            'siang_prod_pit_3'               => 69,
            'siang_pitcontrol'               => 70,
            // 'siang_eng_csa_pit2_drill_blast' => 71,
            // 'siang_eng_csa_pit2'             => 72,
            // 'siang_driver_survey'            => 73,
            // 'siang_vendor_jmi'               => 74,
            'siang_mpccr_admccr_pit'         => 71,
            'siang_coe_pitstop_ss6'          => 72,
            'siang_coe_csa_pit1_ict'         => 73,
            'siang_mpict_driver'             => 74,
            'siang_plant_pitstop'            => 75,
            'siang_training'                 => 76,
            'siang_driver_plant'             => 77,
            'siang_plant_office_pitstop'     => 78,
            'siang_plant_workshop'           => 79,
            'siang_driver_workshop'          => 80,
            'siang_sect_head_pitstop'        => 81,
            'siang_sect_head_plant'          => 82,
            'siang_sect_head_she'            => 83,
            'siang_she_csa_pit1'             => 84,
            'siang_driver_she'               => 85,
            'siang_driver_fa_log'            => 86,
            'siang_koperasi_office'          => 87,
            'siang_falog_warehouse'          => 88,
            'siang_sect_head_falog'          => 89,
            'siang_fuel'                     => 90,
            'siang_mechanic_koperasi'        => 91,
            'siang_test_praktek_hcga'        => 92,
            'siang_admin_spbi'               => 93,
            'siang_carpenter'                => 94,
            'siang_test_praktek_csapit'      => 95,
            'siang_security_spbi'            => 96,


        ];

        $lokasiMapping = match ($catering) {
            'FITRI' => $lokasiMappingFitri,
            'WASTU' => $lokasiMappingWastu,
            'BINTANG' => $lokasiMappingBintang,
            default => []
        };

        foreach ($data as $row) {
            $tanggal = Carbon::parse($row->tanggal)->day;
            $col = Coordinate::stringFromColumnIndex(5 + $tanggal - 1); // Misal kolom E = tanggal 1

            foreach ($lokasiMapping as $lokasiNama => $rowIndex) {
                if (isset($row->$lokasiNama)) {
                    $sheet->setCellValue("{$col}{$rowIndex}", $row->$lokasiNama);
                }
            }
        }
        // SNACK
        $snackStartRow = match ($catering) {
            'FITRI'   => 29,
            'WASTU'   => 127,
            'BINTANG' => 112,
            default   => 30
        };

        $snackData = DB::table('mk_snack')
            ->select('jenis', DB::raw('DAY(tanggal) as day'), DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('catering', $catering)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status', 2)
            ->groupBy('jenis', 'day')
            ->orderBy('jenis')
            ->orderBy('day')
            ->get();

        $snackJenis = $snackData->pluck('jenis')->unique();

        $startRow = $snackStartRow;
        $no = 1;
        foreach ($snackJenis as $jenis) {
            $sheet->setCellValue("B{$startRow}", $no);
            $sheet->setCellValue("C{$startRow}", $jenis);

            foreach ($snackData->where('jenis', $jenis) as $snack) {
                $col = Coordinate::stringFromColumnIndex(4 + $snack->day); // 4+1 = 5 (E)
                $sheet->setCellValue("{$col}{$startRow}", $snack->total_jumlah);
            }

            $totalJumlahCol = Coordinate::stringFromColumnIndex(4 + 32); // 4+32=36 (AJ)
            $sheet->setCellValue("{$totalJumlahCol}{$startRow}", "=SUM(E{$startRow}:AI{$startRow})");

            $no++;
            $startRow++;
        }

        $sheet->setCellValue("B{$startRow}", 'TOTAL');

        for ($day = 1; $day <= 31; $day++) {
            $col = Coordinate::stringFromColumnIndex(4 + $day); // 4+1=5 (E)
            $sheet->setCellValue("{$col}{$startRow}", "=SUM({$col}{$snackStartRow}:{$col}" . ($startRow - 1) . ")");
        }

        $totalJumlahCol = Coordinate::stringFromColumnIndex(4 + 32); // 36 (AJ)
        $sheet->setCellValue("{$totalJumlahCol}{$startRow}", "=SUM({$totalJumlahCol}{$snackStartRow}:{$totalJumlahCol}" . ($startRow - 1) . ")");

        // SNACK SHEET 2
        $snackFullData = DB::table('mk_snack')
            ->select('departemen', 'tanggal', 'waktu', 'jenis', 'jumlah', 'keterangan')
            ->where('catering', $catering)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status', 2)
            ->orderBy('tanggal')
            ->orderBy('departemen')
            ->orderBy('jenis')
            ->orderByRaw("FIELD(waktu, 'pagi', 'siang', 'sore', 'malem')")
            ->get();

        $totalPerGroup = DB::table('mk_snack')
            ->select('departemen', 'tanggal', 'jenis', DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('catering', $catering)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status', 2)
            ->groupBy('departemen', 'tanggal', 'jenis')
            ->get()
            ->keyBy(function($item) {
                return $item->departemen . '_' . $item->tanggal . '_' . $item->jenis;
            });

        $sheet2 = $spreadsheet->getSheetByName('Snack');

        $sheet2->setCellValue('A1', 'Tanggal');
        $sheet2->setCellValue('B1', 'Departemen');
        $sheet2->setCellValue('C1', 'Waktu');
        $sheet2->setCellValue('D1', 'Jenis');
        $sheet2->setCellValue('E1', 'Jumlah');
        $sheet2->setCellValue('F1', 'Total Jumlah');
        $sheet2->setCellValue('G1', 'Keterangan');

        $rowIndex = 2;
        $lastGroupKey = null;
        $mergeStartRow = 2;

        foreach ($snackFullData as $item) {
            $key = $item->departemen . '_' . $item->tanggal . '_' . $item->jenis;

            // jika group berubah, merge dan set total jumlah sebelumnya
            if ($lastGroupKey !== null && $lastGroupKey != $key) {
                $sheet2->mergeCells("F{$mergeStartRow}:F" . ($rowIndex - 1));
                $sheet2->setCellValue("F{$mergeStartRow}", $totalPerGroup[$lastGroupKey]->total_jumlah ?? 0);
                $mergeStartRow = $rowIndex;
            }

            // isi data baris
            $sheet2->setCellValue("A{$rowIndex}", Carbon::parse($item->tanggal)->format('Y-m-d'));
            $sheet2->setCellValue("B{$rowIndex}", $item->departemen);
            $sheet2->setCellValue("C{$rowIndex}", ucfirst($item->waktu));
            $sheet2->setCellValue("D{$rowIndex}", $item->jenis);
            $sheet2->setCellValue("E{$rowIndex}", $item->jumlah);
            $sheet2->setCellValue("G{$rowIndex}", $item->keterangan);

            $lastGroupKey = $key;
            $rowIndex++;
        }

        // merge dan set total jumlah untuk group terakhir
        if ($lastGroupKey !== null) {
            $sheet2->mergeCells("F{$mergeStartRow}:F" . ($rowIndex - 1));
            $sheet2->setCellValue("F{$mergeStartRow}", $totalPerGroup[$lastGroupKey]->total_jumlah ?? 0);
        }

        $lastTanggal = null;
        $startRow = 2;
        $lastRow = $rowIndex - 1;

        for ($row = 2; $row <= $lastRow + 1; $row++) {
            $tanggal = $sheet2->getCell("A{$row}")->getValue();

            if ($tanggal === $lastTanggal) {
                // Masih tanggal yang sama, lanjut
            } else {
                // Tanggal beda, merge sebelumnya kalau lebih dari 1 baris
                if ($lastTanggal !== null && $startRow < $row - 1) {
                    $sheet2->mergeCells("A{$startRow}:A" . ($row - 1));
                }
                $startRow = $row;
            }
            $lastTanggal = $tanggal;
        }
        // Merge range terakhir kalau ada
        if ($startRow < $lastRow) {
            $sheet2->mergeCells("A{$startRow}:A{$lastRow}");
        }

        // SPESIAL
        $spesialStartRow = match ($catering) {
            'FITRI'   => 19,
            'WASTU'   => 117,
            'BINTANG' => 102,
            default   => 150
        };

        $spesialData = DB::table('mk_spesial')
            ->select('jenis', DB::raw('DAY(tanggal) as day'), DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('catering', $catering)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status', 2)
            ->groupBy('jenis', 'day')
            ->orderBy('jenis')
            ->orderBy('day')
            ->get();

        $spesialJenis = $spesialData->pluck('jenis')->unique();

        $startRow = $spesialStartRow;
        $no = 1;
        foreach ($spesialJenis as $jenis) {
            $sheet->setCellValue("B{$startRow}", $no);
            $sheet->setCellValue("C{$startRow}", $jenis);

            foreach ($spesialData->where('jenis', $jenis) as $spesial) {
                $col = Coordinate::stringFromColumnIndex(4 + $spesial->day);
                $sheet->setCellValue("{$col}{$startRow}", $spesial->total_jumlah);
            }

            $totalJumlahCol = Coordinate::stringFromColumnIndex(4 + 32);
            $sheet->setCellValue("{$totalJumlahCol}{$startRow}", "=SUM(E{$startRow}:AI{$startRow})");

            $no++;
            $startRow++;
        }

        $sheet->setCellValue("B{$startRow}", 'TOTAL');

        for ($day = 1; $day <= 31; $day++) {
            $col = Coordinate::stringFromColumnIndex(4 + $day);
            $sheet->setCellValue("{$col}{$startRow}", "=SUM({$col}{$spesialStartRow}:{$col}" . ($startRow - 1) . ")");
        }

        $totalJumlahCol = Coordinate::stringFromColumnIndex(4 + 32);
        $sheet->setCellValue("{$totalJumlahCol}{$startRow}", "=SUM({$totalJumlahCol}{$spesialStartRow}:{$totalJumlahCol}" . ($startRow - 1) . ")");

        // SPESIAL SHEET 3
        $spesialFullData = DB::table('mk_spesial')
            ->select('departemen', 'tanggal', 'waktu', 'jenis', 'jumlah', 'keterangan')
            ->where('catering', $catering)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status', 2)
            ->orderBy('tanggal')
            ->orderBy('departemen')
            ->orderBy('jenis')
            ->orderByRaw("FIELD(waktu, 'pagi', 'siang', 'sore', 'malem')")
            ->get();

        $totalPerGroupSpesial = DB::table('mk_spesial')
            ->select('departemen', 'tanggal', 'jenis', DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('catering', $catering)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status', 2)
            ->groupBy('departemen', 'tanggal', 'jenis')
            ->get()
            ->keyBy(function($item) {
                return $item->departemen . '_' . $item->tanggal . '_' . $item->jenis;
            });

        $sheet3 = $spreadsheet->getSheetByName('Spesial');

        $sheet3->setCellValue('A1', 'Tanggal');
        $sheet3->setCellValue('B1', 'Departemen');
        $sheet3->setCellValue('C1', 'Waktu');
        $sheet3->setCellValue('D1', 'Jenis');
        $sheet3->setCellValue('E1', 'Jumlah');
        $sheet3->setCellValue('F1', 'Total Jumlah');
        $sheet3->setCellValue('G1', 'Keterangan');

        $rowIndexSpesial = 2;
        $lastGroupKeySpesial = null;
        $mergeStartRowSpesial = 2;

        foreach ($spesialFullData as $item) {
            $key = $item->departemen . '_' . $item->tanggal . '_' . $item->jenis;

            // jika group berubah, merge dan set total jumlah sebelumnya
            if ($lastGroupKeySpesial !== null && $lastGroupKeySpesial != $key) {
                $sheet3->mergeCells("F{$mergeStartRowSpesial}:F" . ($rowIndexSpesial - 1));
                $sheet3->setCellValue("F{$mergeStartRowSpesial}", $totalPerGroupSpesial[$lastGroupKeySpesial]->total_jumlah ?? 0);
                $mergeStartRowSpesial = $rowIndexSpesial;
            }

            // isi data baris
            $sheet3->setCellValue("A{$rowIndexSpesial}", Carbon::parse($item->tanggal)->format('Y-m-d'));
            $sheet3->setCellValue("B{$rowIndexSpesial}", $item->departemen);
            $sheet3->setCellValue("C{$rowIndexSpesial}", ucfirst($item->waktu));
            $sheet3->setCellValue("D{$rowIndexSpesial}", $item->jenis);
            $sheet3->setCellValue("E{$rowIndexSpesial}", $item->jumlah);
            $sheet3->setCellValue("G{$rowIndexSpesial}", $item->keterangan);

            $lastGroupKeySpesial = $key;
            $rowIndexSpesial++;
        }

        // merge dan set total jumlah untuk group terakhir
        if ($lastGroupKeySpesial !== null) {
            $sheet3->mergeCells("F{$mergeStartRowSpesial}:F" . ($rowIndexSpesial - 1));
            $sheet3->setCellValue("F{$mergeStartRowSpesial}", $totalPerGroupSpesial[$lastGroupKeySpesial]->total_jumlah ?? 0);
        }

        $lastTanggalSpesial = null;
        $startRowSpesial = 2;
        $lastRowSpesial = $rowIndexSpesial - 1;

        for ($rowSpesial = 2; $rowSpesial <= $lastRowSpesial + 1; $rowSpesial++) {
            $tanggalSpesial = $sheet3->getCell("A{$rowSpesial}")->getValue();

            if ($tanggalSpesial === $lastTanggalSpesial) {
                // Masih tanggal yang sama, lanjut
            } else {
                // Tanggal beda, merge sebelumnya kalau lebih dari 1 baris
                if ($lastTanggalSpesial !== null && $startRowSpesial < $rowSpesial - 1) {
                    $sheet3->mergeCells("A{$startRowSpesial}:A" . ($rowSpesial - 1));
                }
                $startRowSpesial = $rowSpesial;
            }
            $lastTanggalSpesial = $tanggalSpesial;
        }
        // Merge range terakhir kalau ada
        if ($startRowSpesial < $lastRowSpesial) {
            $sheet3->mergeCells("A{$startRowSpesial}:A{$lastRowSpesial}");
        }

        $fileName = "catering_{$catering}_{$month}_{$year}.xlsx";
        $outputPath = storage_path("app/public/{$fileName}");

        $writer = new Xlsx($spreadsheet);
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    // public function exportDaily(Request $request)
    // {

    //     $tanggal = $request->query('tanggal');

    //     if (!$tanggal) {
    //         return response()->json(['status' => 'error', 'message' => 'Tanggal tidak ditemukan.'], 400);
    //     }
    //     //$userTeam = strtoupper($request->query('catering_export') ?? auth()->user()->tim_pic);

    //     if (auth()->user()->id_role == 7) {
    //         $userTeam = strtoupper(auth()->user()->tim_pic);
    //     } else {
    //         $userTeam = strtoupper($request->input('catering_export'));
    //     }

    //     $jenisExport = strtoupper($request->input('jenis_data'));

    //     $templateMapping = [
    //         'PLAN' => [
    //             'FITRI' => 'template_fitri.docx',
    //             'WASTU' => 'template_wastu.docx',
    //             'BINTANG' => 'template_bintang.docx',
    //         ],
    //         'TAMBAHAN' => [
    //             'FITRI' => 'template_tambahan_fitri.docx',
    //             'WASTU' => 'template_tambahan_wastu.docx',
    //             'BINTANG' => 'template_tambahan_bintang.docx',
    //         ]
    //     ];

    //     if (!isset($templateMapping[$jenisExport][$userTeam])) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => "Template tidak ditemukan untuk tim '$userTeam' dan jenis '$jenisExport'."
    //         ], 404);
    //     }

    //     $templatePath = resource_path("template/" . $templateMapping[$jenisExport][$userTeam]);

    //     // Cek apakah file template ada
    //     if (!file_exists($templatePath)) {
    //         return response()->json(['status' => 'error', 'message' => 'Template tidak ditemukan.'], 404);
    //     }

    //     $tableName = match (true) {
    //         $jenisExport === 'PLAN' && $userTeam === 'FITRI' => 'catering_fitri',
    //         $jenisExport === 'PLAN' && $userTeam === 'WASTU' => 'catering_wastu',
    //         $jenisExport === 'PLAN' && $userTeam === 'BINTANG' => 'catering_bintang',
    //         $jenisExport === 'TAMBAHAN' && $userTeam === 'FITRI' => 'catering_tambahan_fitri',
    //         $jenisExport === 'TAMBAHAN' && $userTeam === 'WASTU' => 'catering_tambahan_wastu',
    //         $jenisExport === 'TAMBAHAN' && $userTeam === 'BINTANG' => 'catering_tambahan_bintang',
    //         default => null,
    //     };

    //     // Jika tabel tidak ditemukan
    //     if (!$tableName) {
    //         return response()->json(['status' => 'error', 'message' => 'Data untuk export tidak ditemukan.'], 404);
    //     }

    //     // Ambil data berdasarkan tanggal dan status
    //     $dataList = DB::table($tableName)

    //         ->whereDate('tanggal', $tanggal)
    //         ->get();

    //     // Load template
    //     $templateProcessor = new TemplateProcessor($templatePath);

    //     // Kolom yang akan dikecualikan dari data
    //     $excludedColumns = ['id', 'tanggal', 'waktu', 'status', 'create_at', 'created_name',
    //         'approval_by', 'approval_on', 'approval_desc',
    //         'revisi_by', 'revisi_on', 'revisi_desc'];

    //     $dataByColumn = [];
    //     $totals = [];
    //     $columns = [];

    //     // Proses data jika ada
    //     if (!$dataList->isEmpty()) {
    //         foreach ($dataList as $data) {
    //             $rowData = (array) $data;

    //             // Filter kolom yang tidak diperlukan
    //             $filteredData = array_diff_key($rowData, array_flip($excludedColumns));

    //             foreach ($filteredData as $key => $value) {
    //                 $columns[$key] = true;

    //                 // Tambahkan nilai ke dataByColumn untuk setiap kolom
    //                 $dataByColumn[$key] = ($dataByColumn[$key] ?? 0) + ($value ?? 0);

    //                 // Jika data berupa angka, tambahkan ke total
    //                 if (is_numeric($value)) {
    //                     $totals[$key] = ($totals[$key] ?? 0) + $value;
    //                 }
    //             }
    //         }
    //     }

    //     // Jika tidak ada data, isi dengan '-'
    //     if (empty($dataByColumn)) {
    //         foreach ($columns as $column => $_) {
    //             $dataByColumn[$column] = '-';
    //         }
    //     }

    //     // Set nilai untuk setiap placeholder di template
    //     foreach ($dataByColumn as $key => $value) {
    //         $templateProcessor->setValue($key, $value ?? '-');
    //     }

    //     // Set total untuk setiap kolom
    //     foreach ($columns as $column => $_) {
    //         $templateProcessor->setValue("total_{$column}", $totals[$column] ?? 0);
    //     }

    //     // Hitung total seluruh data
    //     $totalSemua = array_sum($totals);
    //     $templateProcessor->setValue("total_semua", $totalSemua ?: '-');

    //     // Set tanggal ke template
    //     $templateProcessor->setValue('tanggal', $tanggal);

    //     // Pastikan semua placeholder terisi
    //     $allPlaceholders = $templateProcessor->getVariables();
    //     foreach ($allPlaceholders as $placeholder) {
    //         if (!isset($dataByColumn[$placeholder])) {
    //             $templateProcessor->setValue($placeholder, '-');
    //         }
    //     }

    //     // Format tanggal untuk nama file
    //     $formattedDate = date('Y-m-d', strtotime($tanggal));
    //     $fileName = "{$formattedDate}_Laporan_Order_MK_Reguler_{$userTeam}.docx";
    //     $filePath = storage_path("app/public/$fileName");

    //     // Simpan file
    //     $templateProcessor->saveAs($filePath);

    //     // Kembalikan file untuk diunduh dan hapus setelah terkirim
    //     return response()->download($filePath)->deleteFileAfterSend(true);
    // }

    public function exportDaily(Request $request)
    {
        $tanggal = $request->query('tanggal');
        if (!$tanggal) {
            return response()->json(['status' => 'error', 'message' => 'Tanggal tidak ditemukan.'], 400);
        }

        if (auth()->user()->id_role == 7) {
            $userTeam = strtoupper(auth()->user()->tim_pic);
        } else {
            $userTeam = strtoupper($request->input('catering_export'));
        }

        $jenisExport = strtoupper($request->input('jenis_data'));

        $templateMapping = [
            'PLAN' => [
                'FITRI' => 'template_fitri.docx',
                'WASTU' => 'template_wastu.docx',
                'BINTANG' => 'template_bintang.docx',
            ],
            'TAMBAHAN' => [
                'FITRI' => 'template_tambahan_fitri.docx',
                'WASTU' => 'template_tambahan_wastu.docx',
                'BINTANG' => 'template_tambahan_bintang.docx',
            ],
            'SNACK' => [
                'FITRI' => 'template_snack.docx',
                'WASTU' => 'template_snack.docx',
                'BINTANG' => 'template_snack.docx',
            ],
            'SPESIAL' => [
                'FITRI' => 'template_spesial.docx',
                'WASTU' => 'template_spesial.docx',
                'BINTANG' => 'template_spesial.docx',
            ],
        ];

        if (!isset($templateMapping[$jenisExport][$userTeam])) {
            return response()->json([
                'status' => 'error',
                'message' => "Template tidak ditemukan untuk tim '$userTeam' dan jenis '$jenisExport'."
            ], 404);
        }

        $templatePath = resource_path("template/" . $templateMapping[$jenisExport][$userTeam]);

        if (!file_exists($templatePath)) {
            return response()->json(['status' => 'error', 'message' => 'Template tidak ditemukan.'], 404);
        }

        // Tentukan tabel sesuai jenis export
        $tableName = match (true) {
            $jenisExport === 'PLAN' && $userTeam === 'FITRI' => 'catering_fitri',
            $jenisExport === 'PLAN' && $userTeam === 'WASTU' => 'catering_wastu',
            $jenisExport === 'PLAN' && $userTeam === 'BINTANG' => 'catering_bintang',
            $jenisExport === 'TAMBAHAN' && $userTeam === 'FITRI' => 'catering_tambahan_fitri',
            $jenisExport === 'TAMBAHAN' && $userTeam === 'WASTU' => 'catering_tambahan_wastu',
            $jenisExport === 'TAMBAHAN' && $userTeam === 'BINTANG' => 'catering_tambahan_bintang',
            $jenisExport === 'SNACK' => 'mk_snack',
            $jenisExport === 'SPESIAL' => 'mk_spesial',
            default => null,
        };

        if (!$tableName) {
            return response()->json(['status' => 'error', 'message' => 'Data untuk export tidak ditemukan.'], 404);
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        if ($jenisExport === 'SNACK') {

            $dataList = DB::table($tableName)
                ->where('catering', $userTeam)
                ->whereDate('tanggal', $tanggal)
                ->where('status', 2)
                ->orderBy('departemen', 'asc')
                ->orderBy('waktu', 'desc')
                ->get();

            if ($dataList->count() > 0) {
                $templateProcessor->cloneRow('waktu', $dataList->count());

                $index = 1;
                foreach ($dataList as $data) {
                    $templateProcessor->setValue("no#$index", $index);
                    $templateProcessor->setValue("waktu#$index", $data->waktu);
                    $templateProcessor->setValue("departemen#$index", $data->departemen);
                    $templateProcessor->setValue("area#$index", $data->area);
                    $templateProcessor->setValue("gedung#$index", $data->gedung);
                    $templateProcessor->setValue("lokasi#$index", $data->lokasi);
                    $templateProcessor->setValue("jenis#$index", $data->jenis);
                    $templateProcessor->setValue("jumlah#$index", $data->jumlah);
                    $index++;
                }
            } else {
                $templateProcessor->setValue('no', '-');
                $templateProcessor->setValue('waktu', '-');
                $templateProcessor->setValue('departemen', '-');
                $templateProcessor->setValue('area', '-');
                $templateProcessor->setValue('gedung', '-');
                $templateProcessor->setValue('lokasi', '-');
                $templateProcessor->setValue('jenis', '-');
                $templateProcessor->setValue('jumlah', '-');
            }

        } else if ($jenisExport === 'SPESIAL') {
            $dataList = DB::table($tableName)
                ->where('catering', $userTeam)
                ->whereDate('tanggal', $tanggal)
                ->where('status', 2)
                ->orderBy('departemen', 'asc')
                ->orderBy('waktu', 'desc')
                ->get();

            if ($dataList->count() > 0) {
                $templateProcessor->cloneRow('waktu', $dataList->count());

                $index = 1;
                foreach ($dataList as $data) {
                    $templateProcessor->setValue("no#$index", $index);
                    $templateProcessor->setValue("waktu#$index", $data->waktu);
                    $templateProcessor->setValue("departemen#$index", $data->departemen);
                    $templateProcessor->setValue("area#$index", $data->area);
                    $templateProcessor->setValue("gedung#$index", $data->gedung);
                    $templateProcessor->setValue("lokasi#$index", $data->lokasi);
                    $templateProcessor->setValue("jenis#$index", $data->jenis);
                    $templateProcessor->setValue("jumlah#$index", $data->jumlah);
                    $index++;
                }
            } else {
                $templateProcessor->setValue('no', '-');
                $templateProcessor->setValue('waktu', '-');
                $templateProcessor->setValue('departemen', '-');
                $templateProcessor->setValue('area', '-');
                $templateProcessor->setValue('gedung', '-');
                $templateProcessor->setValue('lokasi', '-');
                $templateProcessor->setValue('jenis', '-');
                $templateProcessor->setValue('jumlah', '-');
            }
        }

        else {
            // Export PLAN dan TAMBAHAN: logika sama seperti yang kamu punya
            $excludedColumns = ['id', 'tanggal', 'waktu', 'status', 'create_at', 'created_name',
                'approval_by', 'approval_on', 'approval_desc',
                'revisi_by', 'revisi_on', 'revisi_desc','visitor'];

            $dataList = DB::table($tableName)
                ->whereDate('tanggal', $tanggal)
                ->get();

            $dataByColumn = [];
            $totals = [];
            $columns = [];

            if (!$dataList->isEmpty()) {
                foreach ($dataList as $data) {
                    $rowData = (array)$data;
                    $filteredData = array_diff_key($rowData, array_flip($excludedColumns));

                    foreach ($filteredData as $key => $value) {
                        $columns[$key] = true;
                        $dataByColumn[$key] = ($dataByColumn[$key] ?? 0) + ($value ?? 0);

                        if (is_numeric($value)) {
                            $totals[$key] = ($totals[$key] ?? 0) + $value;
                        }
                    }
                }
            }

            if (empty($dataByColumn)) {
                foreach ($columns as $column => $_) {
                    $dataByColumn[$column] = '-';
                }
            }

            foreach ($dataByColumn as $key => $value) {
                $templateProcessor->setValue($key, $value ?? '-');
            }

            foreach ($columns as $column => $_) {
                $templateProcessor->setValue("total_{$column}", $totals[$column] ?? 0);
            }

            $totalSemua = array_sum($totals);
            $templateProcessor->setValue("total_semua", $totalSemua ?: '-');
        }

        $templateProcessor->setValue('tanggal', $tanggal);

        // Pastikan semua placeholder terisi
        $allPlaceholders = $templateProcessor->getVariables();
        foreach ($allPlaceholders as $placeholder) {
            if (!isset($dataByColumn[$placeholder])) {
                $templateProcessor->setValue($placeholder, '-');
            }
        }

        // Format tanggal untuk nama file
        $formattedDate = date('Y-m-d', strtotime($tanggal));
        $fileName = "{$formattedDate}_Laporan_Order_MK_Reguler_{$userTeam}_{$jenisExport}.docx";
        $filePath = storage_path("app/public/$fileName");

        $templateProcessor->saveAs($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }


    public function exportWord(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        //dd($month);
        $hargaPerPack = 17000;
        $data = $this->LapCateringRepository->getWastuInvoiceSummary($month, $year);

        $uraianMap = [
            'MK SIANG MESS PUTRI TALANG JAWA' => 'putri',
            'MK SIANG MESS MEICU' => 'meicu',
            'MK SIANG MESS TAMBANG' => 'tambang',
        ];

        // Variabel untuk menghitung total harga
        $totalHarga = 0;

        // Path ke template Word
        $templatePath = resource_path('template/invoice_preview.docx');
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

        // Set nilai bulan dan tahun
        $templateProcessor->setValue('bulan', date('F', mktime(0, 0, 0, $month, 1)));
        $templateProcessor->setValue('tahun', $year);

        // Menambahkan tanggal saat ini
        $templateProcessor->setValue('tanggal', date('d-m-Y'));

        // Iterasi untuk setiap item dan set nilai untuk placeholder
        foreach ($uraianMap as $judul => $placeholder) {
            $qty = $data[$judul] ?? 0;  // Ambil kuantitas untuk judul ini
            $totalItem = $qty * $hargaPerPack;  // Hitung total harga untuk item ini

            // Tambahkan total harga item ke totalHarga
            $totalHarga += $totalItem;

            // Setel nilai untuk kuantitas, harga per pack, dan total harga item
            $templateProcessor->setValue("qty_{$placeholder}", $qty);
            $templateProcessor->setValue("harga_{$placeholder}", number_format($hargaPerPack, 0, ',', '.'));
            $templateProcessor->setValue("total_{$placeholder}", number_format($totalItem, 0, ',', '.'));
        }

        // Setel nilai untuk total harga seluruh item
        $templateProcessor->setValue('total_harga', number_format($totalHarga, 0, ',', '.'));

        // Nama file untuk download
        $filename = "Invoice-WASTU-{$month}-{$year}.docx";
        $tempFile = tempnam(sys_get_temp_dir(), 'invoice');

        // Simpan file Word sementara
        $templateProcessor->saveAs($tempFile);

        // Kembalikan response download
        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    // public function indexInvoice(Request $request)
    // {
    //     $month = $request->query('month', date('m'));
    //     $year = $request->query('year', date('Y'));

    //     $hargaPerPack = 17000;
    //     $data = $this->LapCateringRepository->getWastuInvoiceSummary($month, $year);

    //     $totalQty = array_sum($data);

    //     if ($totalQty === 0) {
    //         $data = [];
    //         return view('catering.invoicePreview', compact('data', 'month', 'year'));
    //     }

    //     $uraianMap = [
    //         'MK SIANG MESS PUTRI TALANG JAWA' => 'putri',
    //         'MK SIANG MESS MEICU' => 'meicu',
    //         'MK SIANG MESS TAMBANG' => 'tambang',
    //     ];

    //     $totalHarga = 0;

    //     $templatePath = resource_path('template/invoice_preview.docx');
    //     $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

    //     $templateProcessor->setValue('bulan', date('F', mktime(0, 0, 0, $month, 1)));
    //     $templateProcessor->setValue('tahun', $year);
    //     $templateProcessor->setValue('tanggal', date('d-m-Y'));

    //     foreach ($uraianMap as $judul => $placeholder) {
    //         $qty = $data[$judul] ?? 0;
    //         $totalItem = $qty * $hargaPerPack;
    //         $totalHarga += $totalItem;

    //         $templateProcessor->setValue("qty_{$placeholder}", $qty);
    //         $templateProcessor->setValue("harga_{$placeholder}", number_format($hargaPerPack, 0, ',', '.'));
    //         $templateProcessor->setValue("total_{$placeholder}", number_format($totalItem, 0, ',', '.'));
    //     }

    //     $templateProcessor->setValue('total_harga', number_format($totalHarga, 0, ',', '.'));

    //     $outputPath = resource_path("template/invoice_preview.docx");
    //     if (file_exists($outputPath)) {
    //         unlink($outputPath);
    //     }
    //     $templateProcessor->saveAs($outputPath);

    //     return view('catering.invoicePreview', compact('outputPath', 'month', 'year', 'data'));
    // }

    // public function indexInvoice(Request $request)
    // {
    //     $month = $request->query('month', date('m'));
    //     $year = $request->query('year', date('Y'));

    //     $hargaPerPack = 17000;
    //     $data = $this->LapCateringRepository->getWastuInvoiceSummary($month, $year);

    //     $totalQty = array_sum($data);

    //     if ($totalQty === 0) {
    //         $data = [];
    //         return view('catering.invoicePreview', compact('data', 'month', 'year'));
    //     }

    //     $totalHarga = $totalQty * $hargaPerPack;

    //     $templatePath = resource_path('template/invoice_preview.docx');
    //     $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

    //     $templateProcessor->setValue('bulan', date('F', mktime(0, 0, 0, $month, 1)));
    //     $templateProcessor->setValue('tahun', $year);
    //     $templateProcessor->setValue('tanggal', date('d-m-Y'));

    //     $templateProcessor->setValue("qty_total", $totalQty);
    //     $templateProcessor->setValue("harga_total", number_format($hargaPerPack, 0, ',', '.'));
    //     $templateProcessor->setValue("total_total", number_format($totalHarga, 0, ',', '.'));
    //     $templateProcessor->setValue('total_harga', number_format($totalHarga, 0, ',', '.'));

    //     // Simpan file di storage publik agar bisa dibaca browser
    //     $outputPath = storage_path('app/public/invoice_preview.docx');
    //     if (file_exists($outputPath)) {
    //         unlink($outputPath);
    //     }
    //     $templateProcessor->saveAs($outputPath);

    //     return view('catering.invoicePreview', compact('month', 'year', 'data'));
    // }

    // public function indexInvoice(Request $request)
    // {
    //     $month = $request->query('month', date('m'));
    //     $year = $request->query('year', date('Y'));

    //     $hargaPerPack = 17000;
    //     $data = $this->LapCateringRepository->getWastuInvoiceSummary($month, $year);

    //     $totalQty = array_sum($data);

    //     if ($totalQty === 0) {
    //         $data = [];
    //         return view('catering.invoicePreview', compact('data', 'month', 'year'));
    //     }

    //     $totalHarga = $totalQty * $hargaPerPack;

    //     $templatePath = resource_path('template/invoice_preview.docx');
    //     $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

    //     $templateProcessor->setValue('bulan', date('F', mktime(0, 0, 0, $month, 1)));
    //     $templateProcessor->setValue('tahun', $year);
    //     $templateProcessor->setValue('tanggal', date('d-m-Y'));

    //     $templateProcessor->setValue("qty_total", $totalQty);
    //     $templateProcessor->setValue("harga_total", number_format($hargaPerPack, 0, ',', '.'));
    //     $templateProcessor->setValue("total_total", number_format($totalHarga, 0, ',', '.'));
    //     $templateProcessor->setValue('total_harga', number_format($totalHarga, 0, ',', '.'));

    //    $snackSummary = $this->LapCateringRepository->getSnackInvoice($month, $year);
    //  ///dd($snackSummary);
    //     // Clone rows dan isi datanya
    //     $templateProcessor->cloneRow('no', count($snackSummary));
    //     foreach ($snackSummary as $index => $snack) {
    //         $i = $index + 1;
    //         $templateProcessor->setValue("no#$i", $i);
    //         $templateProcessor->setValue("jenis#$i", $snack['jenis']);
    //         $templateProcessor->setValue("jumlah#$i", $snack['jumlah']);
    //         $templateProcessor->setValue("rata_rata#$i", number_format($snack['rata_rata'], 0, ',', '.'));
    //         $templateProcessor->setValue("total#$i", number_format($snack['total'], 0, ',', '.'));
    //     }



    //     // Buat file output yang unik per bulan dan tahun
    //     $fileName = "invoice_preview_{$month}_{$year}.docx";
    //     $outputPath = storage_path("app/public/{$fileName}");

    //     // Simpan file baru
    //     $templateProcessor->saveAs($outputPath);

    //     // Kirim nama file ke view untuk ditampilkan dengan Mammoth.js
    //     return view('catering.invoicePreview', compact('month', 'year', 'data', 'fileName'));
    // }

    public function indexInvoice(Request $request)
{
    $month = $request->query('month', date('m'));
    $year = $request->query('year', date('Y'));

    $hargaPerPack = 17000;
    $data = $this->LapCateringRepository->getWastuInvoiceSummary($month, $year);

    $totalQty = array_sum($data);
    if ($totalQty === 0) {
        $data = [];
        return view('catering.invoicePreview', compact('data', 'month', 'year'));
    }

    $totalHarga = $totalQty * $hargaPerPack;

    // Ambil data snack & mk spesial dari repository
    $snackData = $this->LapCateringRepository->getSnackInvoice($month, $year);
    $spesialData = $this->LapCateringRepository->getSpesialInvoice($month, $year);

    $templatePath = resource_path('template/invoice_preview.docx');
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

    // Bagian cloneRow untuk snack
    $snackRows = [];
    $grandTotalSnack = 0;
    foreach ($snackData as $item) {
        $snackRows[] = [
            'snack_jenis' => $item['jenis'],
            'snack_jumlah' => $item['jumlah'],
            'snack_rata' => number_format($item['rata'], 0, ',', '.'),
            'snack_total' => number_format($item['total'], 0, ',', '.'),
        ];
        $grandTotalSnack += $item['total'];
    }
    $templateProcessor->cloneRowAndSetValues('snack_jenis', $snackRows);

    $templateProcessor->setValue('grand_total_snack', number_format($grandTotalSnack, 0, ',', '.'));

    // Bagian cloneRow untuk MK Spesial
$spesialRows = [];
$grandTotalSpesial = 0;
foreach ($spesialData as $item) {
    $spesialRows[] = [
        'spesial_jenis' => $item['jenis'],
        'spesial_jumlah' => $item['jumlah'],
        'spesial_rata' => number_format($item['rata'], 0, ',', '.'),
        'spesial_total' => number_format($item['total'], 0, ',', '.'),
    ];
    $grandTotalSpesial += $item['total'];
}
$templateProcessor->cloneRowAndSetValues('spesial_jenis', $spesialRows);

    $templateProcessor->setValue('grand_total_spesial', number_format($grandTotalSpesial, 0, ',', '.'));

    // Bagian utama catering
    $templateProcessor->setValue('bulan', date('F', mktime(0, 0, 0, $month, 1)));
    $templateProcessor->setValue('tahun', $year);
    $templateProcessor->setValue('tanggal', date('d-m-Y'));
    $templateProcessor->setValue("qty_total", $totalQty);
    $templateProcessor->setValue("harga_total", number_format($hargaPerPack, 0, ',', '.'));
    $templateProcessor->setValue("total_total", number_format($totalHarga, 0, ',', '.'));
    $templateProcessor->setValue('total_harga', number_format($totalHarga, 0, ',', '.'));

    // Hitung total keseluruhan invoice
$totalKeseluruhan = $totalHarga + $grandTotalSnack + $grandTotalSpesial;
$templateProcessor->setValue('totalKeseluruhan', number_format($totalKeseluruhan, 0, ',', '.'));


    $fileName = "invoice_preview_{$month}_{$year}.docx";
    $outputPath = storage_path("app/public/{$fileName}");
    $templateProcessor->saveAs($outputPath);

    return view('catering.invoicePreview', compact('month', 'year', 'data', 'fileName'));
}




}
