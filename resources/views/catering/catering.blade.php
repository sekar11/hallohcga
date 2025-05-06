@extends('include/mainlayout')
@section('title', 'catering')
@section('content')
    <div class="pagetitle">
      <h1>MK Catering Reguler</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item active">MK Catering</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> MK Catering</h5>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary" id="btn-open-modal" data-bs-toggle="modal" data-bs-target="#cateringModal"> Add MK Catering Reguler</button>
              <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exportModal"><i class="fas fa-file-excel"></i> Export Data</button>

                <!-- Modal View Data -->
                <div class="modal fade modal-view" id="viewcateringModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Detail Data Catering</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Tempat</th>
                                            <th>Man Power</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="viewDataContainer">
                                        <!-- Data akan diisi dengan JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add -->
                <div class="modal fade modal_add" id="cateringModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mode="add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="btn-add">Add MK Catering Reguler</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @if(in_array(auth()->user()->tim_pic, [
                            'COE', 'HCGA', 'ENG', 'SHE', 'FALOG', 'PROD', 'PLANT',
                            'A1', 'C3', 'MESS_MEICU', 'MESS_PUTRI','MARBOT',
                            'B1', 'B2', 'B3', 'B4', 'B5',
                            'B6', 'B7', 'B8', 'B9', 'B10', 'AMM','MESS',
                        ]))
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="copyPreviousData">
                                <label class="form-check-label" for="copyPreviousData">
                                    Apakah data sama seperti sebelumnya?
                                </label>
                            </div>
                        </div>
                        <form id="cateringForm" class="row g-3 needs-validation">
                            @csrf
                            <input type="hidden" name="table_name" value="{{ $tableName ?? '' }}">

                            @php
                                $userTeam = auth()->user()->tim_pic;

                                $customLabels = [
                                    'COE' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Siang','Malam','Tambahan Siang','Tambahan Malam'], 'category' => 'Waktu'],
                                        'section' => ['label' => 'Section Head', 'name' => 'section', 'type' => 'text','category' => 'Office Plant'],
                                        'tamu_ho' => ['label' => 'TAMU HO', 'name' => 'tamu_ho', 'type' => 'text','category' => 'Office Plant'],
                                        'gl_ss6' => ['label' => 'GL SS6', 'name' => 'gl_ss6','type' => 'text', 'category' => 'Office Plant'],
                                        'mpccr_admccr' => ['label' => 'Admin', 'name' => 'mpccr_admccr', 'type' => 'text','category' => 'Office Plant'],
                                        'mpccr_asstmoco' => ['label' => 'Asst. Moco', 'name' => 'mpccr_asstmoco', 'type' => 'text','category' => 'Office Plant'],
                                        'mpccr_glmoco' => ['label' => 'GL Moco', 'name' => 'mpccr_glmoco', 'type' => 'text','category' => 'Office Plant'],
                                        'mpccr_driver' => ['label' => 'Driver CCR', 'name' => 'mpccr_driver', 'type' => 'text','category' => 'Office Plant'],
                                        'mpss6_glss6' => ['label' => 'GL SS6', 'name' => 'mpss6_glss6','type' => 'text', 'category' => 'PITSTOP | MP SS6'],
                                        'mpss6_sysdev' => ['label' => 'Sysdev SS6', 'name' => 'mpss6_sysdev','type' => 'text', 'category' => 'PITSTOP | MP SS6'],
                                        'mpss6_driver' => ['label' => 'Driver SS6', 'name' => 'mpss6_driver','type' => 'text', 'category' => 'PITSTOP | MP SS6'],
                                        'mpict_glict' => ['label' => 'GL ICT', 'name' => 'mpict_glict','type' => 'text', 'category' => 'CSA PIT 1 | MP ICT'],
                                        'mpict_engineer' => ['label' => 'Engineer', 'name' => 'mpict_engineer','type' => 'text', 'category' => 'CSA PIT 1 | MP ICT'],
                                        'mpict_driver' => ['label' => 'Driver SS6', 'name' => 'mpict_driver','type' => 'text', 'category' => 'CSA PIT 1 | MP ICT'],
                                        'mpccr_admccr_pit' => ['label' => 'Adm CCR', 'name' => 'mpccr_admccr_pit', 'type' => 'text','category' => 'PIT 3 Container | PIT Control | MP CCR'],
                                        'visitor' => ['label' => 'Vendor/Tamu', 'name' => 'visitor', 'type' => 'text', 'category' => 'Vendor/Tamu'],
                                    ],
                                    'ENG' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Siang','Malam','Tambahan Siang','Tambahan Malam'], 'category' => 'Waktu'],
                                        'dept_head' => ['label' => 'Dept Head', 'name' => 'dept_head','type' => 'text', 'category' => 'Office Plant'],
                                        'sect_head' => ['label' => 'Section', 'name' => 'sect_head','type' => 'text', 'category' => 'Office Plant'],
                                        'gl_eng' => ['label' => 'GL', 'name' => 'gl_eng','type' => 'text', 'category' => 'Office Plant'],
                                        'driver' => ['label' => 'Driver', 'name' => 'driver','type' => 'text', 'category' => 'Office Plant'],
                                        'crew_ssr' => ['label' => 'Crew SSR', 'name' => 'crew_ssr','type' => 'text', 'category' => 'Office Plant'],
                                        'office_pldp' => ['label' => 'PLDP', 'name' => 'office_pldp','type' => 'text', 'category' => 'Office Plant'],
                                        'admin_office' => ['label' => 'Admin', 'name' => 'admin_office','type' => 'text', 'category' => 'Office Plant'],
                                        'drill' => ['label' => 'Drill & PIT Control', 'name' => 'drill','type' => 'text', 'category' => 'CSA PIT 2'],
                                        'driver_drill' => ['label' => 'Driver Drill & PIT Control', 'name' => 'driver_drill', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'driver_survey' => ['label' => 'Driver Survey', 'name' => 'driver_survey', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'helper_survey' => ['label' => 'Helper Survey', 'name' => 'helper_survey', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'gl_survey' => ['label' => 'GL Surver', 'name' => 'gl_survey', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'magang' => ['label' => 'Magang', 'name' => 'magang', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'warehouse_pldp' => ['label' => 'PLDP', 'name' => 'warehouse_pldp', 'type' => 'text','category' => 'CSA PIT 2'], // PINDAH KE CSA PIT 2
                                        'pitcontrol' => ['label' => 'PIT CONTROL', 'name' => 'pitcontrol', 'type' => 'text','category' => 'CSA PIT 3'],
                                        'gl_civil' => ['label' => 'GL CIVIL', 'name' => 'gl_civil', 'type' => 'text','category' => 'Mess Tambang'],
                                        'vendor_jmi' => ['label' => 'Vendor JMI', 'name' => 'vendor_jmi', 'type' => 'text','category' => 'Vendor JMI'],
                                        'visitor' => ['label' => 'Vendor/Tamu', 'name' => 'visitor', 'type' => 'text', 'category' => 'Vendor/Tamu'],
                                    ],
                                    'SHE' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Siang','Malam','Tambahan Siang','Tambahan Malam'], 'category' => 'Waktu'],
                                        'dept_head' => ['label' => 'Dept Head', 'name' => 'dept_head', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'sect_head' => ['label' => 'Section', 'name' => 'sect_head', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'gl_k3' => ['label' => 'GL K3', 'name' => 'gl_k3', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'dokter' => ['label' => 'Dokter', 'name' => 'dokter', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'gl_ert' => ['label' => 'GL ERT', 'name' => 'gl_ert', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'gl_ko' => ['label' => 'GL KO', 'name' => 'gl_ko', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'medic' => ['label' => 'Medic', 'name' => 'medic', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'ert' => ['label' => 'ERT', 'name' => 'ert', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'admin' => ['label' => 'Admin', 'name' => 'admin', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'sample_makan' => ['label' => 'Sample Makan', 'name' => 'sample_makan', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'helper_hcga' => ['label' => 'Helper HCGA', 'name' => 'helper_hcga', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'crew_she' => ['label' => 'Crew SHE', 'name' => 'crew_she', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'magang' => ['label' => 'Magang', 'name' => 'magang', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'driver' => ['label' => 'Driver', 'name' => 'driver', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'grounded' => ['label' => 'Grounded', 'name' => 'grounded', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'spare' => ['label' => 'Spare', 'name' => 'spare', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'kontainer_medic' => ['label' => 'Kontainer Medic', 'name' => 'kontainer_medic', 'type' => 'text', 'category' => 'Mess Tambang'],
                                        'visitor' => ['label' => 'Vendor/Tamu', 'name' => 'visitor', 'type' => 'text', 'category' => 'Vendor/Tamu'],
                                    ],
                                    'FALOG' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Siang','Malam','Tambahan Siang','Tambahan Malam'], 'category' => 'Waktu'],
                                        'dept_head' => ['label' => 'Dept Head', 'name' => 'dept_head', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'sect_head' => ['label' => 'Section', 'name' => 'sect_head', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'gl_fa' => ['label' => 'GL FA', 'name' => 'gl_fa', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'admin_fa' => ['label' => 'Admin FA', 'name' => 'admin_fa', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'driver_fa_log' => ['label' => 'Driver FA Log', 'name' => 'driver_fa_log', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'gl_logistik' => ['label' => 'GL Logistik', 'name' => 'gl_logistik', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'admin_logistik' => ['label' => 'Admin Logistik', 'name' => 'admin_logistik', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'swi' => ['label' => 'SWI', 'name' => 'swi', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'vendor' => ['label' => 'Vendor', 'name' => 'vendor', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'spare' => ['label' => 'Spare', 'name' => 'spare', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'pldp' => ['label' => 'PLDP', 'name' => 'pldp', 'type' => 'text', 'category' => 'WAREHOUSE'],
                                        'koperasi_mess' => ['label' => 'Koperasi Mess', 'name' => 'koperasi_mess', 'type' => 'text', 'category' => 'KOPPA MART MESS TAMBANG'],
                                        'mechanic_koperasi' => ['label' => 'Mechanic Koperasi', 'name' => 'mechanic_koperasi', 'type' => 'text', 'category' => 'WORKSHOP KOPERASI MESS TAMBANG'],
                                        'koperasi_office' => ['label' => 'Koperasi Office', 'name' => 'koperasi_office', 'type' => 'text', 'category' => 'KOPPA MART OFFICE'],
                                        'opt_fuel_truck' => ['label' => 'Opt Fuel Truck', 'name' => 'opt_fuel_truck', 'type' => 'text', 'category' => 'CSA FUEL'],
                                        'fuelman' => ['label' => 'Fuelman', 'name' => 'fuelman', 'type' => 'text', 'category' => 'CSA FUEL'],
                                        'gl' => ['label' => 'GL', 'name' => 'gl', 'type' => 'text', 'category' => 'CSA FUEL'],
                                        'admin_fuel' => ['label' => 'Admin', 'name' => 'admin_fuel', 'type' => 'text', 'category' => 'CSA FUEL'],
                                        'driverlv_fuel' => ['label' => 'Driver LV', 'name' => 'driverlv_fuel', 'type' => 'text', 'category' => 'CSA FUEL'],
                                        'spare_csa' => ['label' => 'Spare', 'name' => 'spare_csa', 'type' => 'text', 'category' => 'CSA FUEL'],
                                        'visitor' => ['label' => 'Vendor/Tamu', 'name' => 'visitor', 'type' => 'text', 'category' => 'Vendor/Tamu'],
                                    ],
                                    'PROD' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Siang','Malam','Tambahan Siang','Tambahan Malam'], 'category' => 'Waktu'],

                                        'admin_officeplant' => ['label' => 'Admin', 'name' => 'admin_officeplant', 'type' => 'text', 'category' => 'Office PLANT'],

                                        'dept_sect_officeplant' => ['label' => 'Dept. Head', 'name' => 'dept_sect_officeplant', 'type' => 'text', 'category' => 'Anjungan CSA PIT 1'],
                                        'dept_sect_csapit1' => ['label' => 'Sect. Head', 'name' => 'dept_sect_csapit1', 'type' => 'text', 'category' => 'Anjungan CSA PIT 1'],

                                        // 'gl_officecsapit1' => ['label' => 'GL', 'name' => 'gl_officecsapit1', 'type' => 'text', 'category' => 'Office CSA PIT 1'],
                                        // 'admin_officecsapit1' => ['label' => 'Admin', 'name' => 'admin_officecsapit1', 'type' => 'text', 'category' => 'Office CSA PIT 1'],
                                        'operator_csapit1' => ['label' => 'Operator', 'name' => 'operator_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'gl_csapit1' => ['label' => 'GL', 'name' => 'gl_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'spare_csapit1' => ['label' => 'Spare', 'name' => 'spare_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'admin_csapit1' => ['label' => 'Admin CSA PIT 1', 'name' => 'admin_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'skillup_csapit1' => ['label' => 'CSA PIT 1 Skill Up', 'name' => 'skillup_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],

                                        'dept_sect_csapit2' => ['label' => 'Sect. Head', 'name' => 'dept_sect_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'operator_csapit2' => ['label' => 'Operator', 'name' => 'operator_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'gl_csapit2' => ['label' => 'GL', 'name' => 'gl_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'spare_csapit2' => ['label' => 'Spare', 'name' => 'spare_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'driverlv_csapit2' => ['label' => 'Driver LV', 'name' => 'driverlv_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'admin_csapit2' => ['label' => 'Admin CSA PIT 2', 'name' => 'admin_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],

                                        'dept_sect_csapit3' => ['label' => 'Sect. Head', 'name' => 'dept_sect_csapit3', 'type' => 'text', 'category' => 'CSA PIT 3'],
                                        'operator_csapit3' => ['label' => 'Operator', 'name' => 'operator_csapit3', 'type' => 'text', 'category' => 'CSA PIT 3'],
                                        'gl_csapit3' => ['label' => 'GL', 'name' => 'gl_csapit3', 'type' => 'text', 'category' => 'CSA PIT 3'],
                                        'spare_csapit3' => ['label' => 'Spare', 'name' => 'spare_csapit3', 'type' => 'text', 'category' => 'CSA PIT 3'],
                                        'operator_csahrm' => ['label' => 'Operator', 'name' => 'operator_csahrm', 'type' => 'text', 'category' => 'CSA HRM'],
                                        'gl_csahrm' => ['label' => 'GL', 'name' => 'gl_csahrm', 'type' => 'text', 'category' => 'CSA HRM'],
                                        'spare_csahrm' => ['label' => 'Spare', 'name' => 'spare_csahrm', 'type' => 'text', 'category' => 'CSA HRM'],
                                        'driverlv_pitstop' => ['label' => 'Driver', 'name' => 'driverlv_pitstop', 'type' => 'text', 'category' => 'CSA PITSTOP AKADEMI'],
                                        'gl_pitstop' => ['label' => 'GL', 'name' => 'gl_pitstop', 'type' => 'text', 'category' => 'CSA PITSTOP AKADEMI'],
                                        'spare_pitstop' => ['label' => 'Spare', 'name' => 'spare_pitstop', 'type' => 'text', 'category' => 'CSA PITSTOP AKADEMI'],
                                        'visitor' => ['label' => 'Vendor/Tamu', 'name' => 'visitor', 'type' => 'text', 'category' => 'Vendor/Tamu'],
                                    ],
                                    'HCGA' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore','Tambahan Malam'], 'category' => 'Waktu'],
                                        'pjo' => ['label' => 'PJO', 'name' => 'pjo', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'sect_head' => ['label' => 'Sect. Head', 'name' => 'sect_head', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'gl_hc' => ['label' => 'GL HC', 'name' => 'gl_hc', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'admin_hc' => ['label' => 'Admin HC', 'name' => 'admin_hc', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'admin_ga_plant' => ['label' => 'Admin GA', 'name' => 'admin_ga_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'helper_plant' => ['label' => 'Helper', 'name' => 'helper_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'security_plant' => ['label' => 'Security', 'name' => 'security_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'alpen' => ['label' => 'Alpen', 'name' => 'alpen', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'driver_plant' => ['label' => 'Driver', 'name' => 'driver_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'sertifikasi_hcga' => ['label' => 'Sertifikasi HCGA', 'name' => 'sertifikasi_hcga', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'driver_bus_jumat' => ['label' => 'Driver Bus Jumat Office Plant', 'name' => 'driver_bus_jumat', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'security_spbi' => ['label' => 'Security', 'name' => 'security_spbi', 'type' => 'text', 'category' => 'SPBI'],
                                        'admin_spbi' => ['label' => 'Admin GA SPBI', 'name' => 'admin_spbi', 'type' => 'text', 'category' => 'SPBI'],
                                        'admin_ga' => ['label' => 'Admin GA', 'name' => 'admin_ga', 'type' => 'text', 'category' => 'OFFICE GA MESS TAMBANG'],
                                        'gl_ga' => ['label' => 'GL GA', 'name' => 'gl_ga', 'type' => 'text', 'category' => 'OFFICE GA MESS TAMBANG'],
                                        'electrical_ga' => ['label' => 'Electrical GA', 'name' => 'electrical_ga', 'type' => 'text', 'category' => 'OFFICE GA MESS TAMBANG'],
                                        'driver_mess' => ['label' => 'Driver', 'name' => 'driver_mess', 'type' => 'text', 'category' => 'OFFICE GA MESS TAMBANG'],
                                        'carpenter' => ['label' => 'Carpenter', 'name' => 'carpenter', 'type' => 'text', 'category' => 'OFFICE GA MESS TAMBANG'],
                                        'gardener' => ['label' => 'Gardener', 'name' => 'gardener', 'type' => 'text', 'category' => 'OFFICE GA MESS TAMBANG'],
                                        'mekanic_trac' => ['label' => 'Mekanik Trac', 'name' => 'mekanic_trac', 'type' => 'text', 'category' => 'MEKANIK TRAC'],
                                        'security_pos' => ['label' => 'Security Pos', 'name' => 'security_pos', 'type' => 'text', 'category' => 'POS SECURTY MESS TAMBANG'],
                                        'security_patrol' => ['label' => 'Security Patrol', 'name' => 'security_patrol', 'type' => 'text', 'category' => 'POS SECURTY MESS TAMBANG'],
                                        'driver_lv_cuti' => ['label' => 'Driver LV Cuti', 'name' => 'driver_lv_cuti', 'type' => 'text', 'category' => 'POS SECURTY MESS TAMBANG'],
                                        'helper_mess' => ['label' => 'Helper Mess', 'name' => 'helper_mess', 'type' => 'text', 'category' => 'MESS TAMBANG'],
                                        'driver_bus' => ['label' => 'Driver Bus', 'name' => 'driver_bus', 'type' => 'text', 'category' => 'MESS TAMBANG'],
                                        'driver_bus_jumat_mess' => ['label' => 'Driver Bus Jumat Mess', 'name' => 'driver_bus_jumat_mess', 'type' => 'text', 'category' => 'MESS TAMBANG'],
                                        'admin_ga_meicu' => ['label' => 'Admin GA', 'name' => 'admin_ga_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'gl_ga_meicu' => ['label' => 'GL GA', 'name' => 'gl_ga_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'security_meicu' => ['label' => 'Security', 'name' => 'security_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'driver_meicu' => ['label' => 'Driver', 'name' => 'driver_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'cv_ade' => ['label' => 'CV.ADE', 'name' => 'cv_ade', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'helper_meicu' => ['label' => 'Helper', 'name' => 'helper_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'bagong' => ['label' => 'Bagong', 'name' => 'bagong', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'visitor_meicu' => ['label' => 'Visitor Meicu', 'name' => 'visitor_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'vendor_meicu' => ['label' => 'Vendor Meicu', 'name' => 'vendor_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],

                                        'test_praktek' => ['label' => 'Test Praktek', 'name' => 'test_praktek', 'type' => 'text', 'category' => 'TEST PRAKTEK'],
                                        'marbot' => ['label' => 'Marbot', 'name' => 'marbot', 'type' => 'text', 'category' => 'MARBOT'],
                                        'laundry' => ['label' => 'Laundry', 'name' => 'laundry', 'type' => 'text', 'category' => 'LAUNDRY KARTIKA'],
                                        'security_laundry' => ['label' => 'Security Laundry', 'name' => 'security_laundry', 'type' => 'text', 'category' => 'LAUNDRY KARTIKA'],
                                        'security_pit1' => ['label' => 'Security PIT 2 ROSELA', 'name' => 'security_pit1', 'type' => 'text', 'category' => 'SECURITY'],
                                        'security_pit3' => ['label' => 'Security PIT 3', 'name' => 'security_pit3', 'type' => 'text', 'category' => 'SECURITY'],
                                        'security_anjungan' => ['label' => 'Security Anjungan', 'name' => 'security_anjungan', 'type' => 'text', 'category' => 'SECURITY'],
                                        'test_praktek_csapit' => ['label' => 'Test Praktek CSA PIT 1', 'name' => 'test_praktek_csapit', 'type' => 'text', 'category' => 'TEST PRAKTEK CSA PIT 1'],
                                        'visitor' => ['label' => 'Vendor/Tamu', 'name' => 'visitor', 'type' => 'text', 'category' => 'Vendor/Tamu'],
                                    ],
                                    'PLANT' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Siang','Malam','Tambahan Siang','Tambahan Malam'], 'category' => 'Waktu'],
                                        'dept_head' => ['label' => 'Dept Head', 'name' => 'dept_head', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'sect_head' => ['label' => 'Sect Head', 'name' => 'sect_head', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'dept_head_pitstop' => ['label' => 'Dept Head', 'name' => 'dept_head_pitstop', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'sect_head_pitstop' => ['label' => 'Sect Head', 'name' => 'sect_head_pitstop', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'new_office' => ['label' => 'New Office', 'name' => 'new_office', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'sect_head_plant' => ['label' => 'Sect Head', 'name' => 'sect_head_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'siswa_magang' => ['label' => 'Siswa Magang', 'name' => 'siswa_magang', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'base_control' => ['label' => 'Base Control', 'name' => 'base_control', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'wheel_ps' => ['label' => 'Wheel PS', 'name' => 'wheel_ps', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'track' => ['label' => 'Track', 'name' => 'track', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'support' => ['label' => 'Support', 'name' => 'support', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'tyre' => ['label' => 'Tyre', 'name' => 'tyre', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'fabrikasi' => ['label' => 'Fabrikasi', 'name' => 'fabrikasi', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'tool_room' => ['label' => 'Tool Room', 'name' => 'tool_room', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'pldp' => ['label' => 'PLDP', 'name' => 'pldp', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'fmdp_track' => ['label' => 'FMDP Track', 'name' => 'fmdp_track', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'fmdp_wheel' => ['label' => 'FMDP Wheel', 'name' => 'fmdp_wheel', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'fmdp_support' => ['label' => 'FMDP Support', 'name' => 'fmdp_support', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'gmi_mercy' => ['label' => 'GMI+Mercy', 'name' => 'gmi_mercy', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'mastratech' => ['label' => 'Mastratech', 'name' => 'mastratech', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'trakindo' => ['label' => 'Trakindo', 'name' => 'trakindo', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'siswa_magang_pitstop' => ['label' => 'Siswa Magang', 'name' => 'siswa_magang_pitstop', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'new_hire' => ['label' => 'New Hire', 'name' => 'new_hire', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'mutasi' => ['label' => 'Mutasi', 'name' => 'mutasi', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'driver' => ['label' => 'Driver', 'name' => 'driver', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'spare' => ['label' => 'Spare', 'name' => 'spare', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'congkelman_apn' => ['label' => 'Congkelman APN', 'name' => 'congkelman_apn', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'training' => ['label' => 'Training', 'name' => 'training', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'vendor_plant_pitstop' => ['label' => 'Vendor Plant Pitstop', 'name' => 'vendor_plant_pitstop', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'office_pitstop' => ['label' => 'Office Pitstop', 'name' => 'office_pitstop', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'plant_engineer' => ['label' => 'Plant Engineer', 'name' => 'plant_engineer', 'type' => 'text', 'category' => 'PITSTOP'],
                                        'skill_up_lt' => ['label' => 'Skill Up LT', 'name' => 'skill_up_lt', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'wheel_ws_workshop' => ['label' => 'Wheel WS', 'name' => 'wheel_ws_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'fabrikasi_workshop' => ['label' => 'Fabrikasi', 'name' => 'fabrikasi_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'planner' => ['label' => 'Planner', 'name' => 'planner', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'plant_engineer_workshop' => ['label' => 'Plant Engineer', 'name' => 'plant_engineer_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'mastratech_workshop' => ['label' => 'Mastratech', 'name' => 'mastratech_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'fmdp_ws_workshop' => ['label' => 'FMDP WS', 'name' => 'fmdp_ws_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'siswa_magang_ws' => ['label' => 'Siswa Magang WS', 'name' => 'siswa_magang_ws', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'driver_workshop' => ['label' => 'Driver', 'name' => 'driver_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'gmi' => ['label' => 'GMI', 'name' => 'gmi', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'swi' => ['label' => 'SWI', 'name' => 'swi', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'track_ws' => ['label' => 'Track WS', 'name' => 'track_ws', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'spare_workshop' => ['label' => 'Spare', 'name' => 'spare_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'helper_workshop' => ['label' => 'Helper', 'name' => 'helper_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'trakindo_workshop' => ['label' => 'Indoparta', 'name' => 'trakindo_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'backup_opp' => ['label' => 'Backup OPP', 'name' => 'backup_opp', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'visitor' => ['label' => 'Vendor/Tamu', 'name' => 'visitor', 'type' => 'text', 'category' => 'Vendor/Tamu'],
                                    ],
                                    'MARBOT' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore','Tambahan Malam'], 'category' => 'Waktu'],
                                        'marbot' => ['label' => 'Marbot', 'name' => 'marbot', 'type' => 'text', 'category' => 'Staff'],
                                        'total_laundry' => ['label' => 'Total Laundry', 'name' => 'total_laundry', 'type' => 'text', 'category' => 'Laundry'],
                                        'security_laundry' => ['label' => 'Security Laundry', 'name' => 'security_laundry', 'type' => 'text', 'category' => 'Laundry'],
                                    ],
                                    'AMM' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore', 'Tambahan Malam'], 'category' => 'Waktu'],
                                        'mess_b1' => ['label' => 'Mess B1', 'name' => 'mess_b1', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b2' => ['label' => 'Mess B2', 'name' => 'mess_b2', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b3' => ['label' => 'Mess B3', 'name' => 'mess_b3', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b4' => ['label' => 'Mess B4', 'name' => 'mess_b4', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b5' => ['label' => 'Mess B5', 'name' => 'mess_b5', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b6' => ['label' => 'Mess B6', 'name' => 'mess_b6', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b7' => ['label' => 'Mess B7', 'name' => 'mess_b7', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b8' => ['label' => 'Mess B8', 'name' => 'mess_b8', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b9' => ['label' => 'Mess B9', 'name' => 'mess_b9', 'type' => 'text', 'category' => 'AMM'],
                                        'mess_b10' => ['label' => 'Mess B10', 'name' => 'mess_b10', 'type' => 'text', 'category' => 'AMM'],
                                        'spare_amm' => ['label' => 'Spare AMM', 'name' => 'spare_amm', 'type' => 'text', 'category' => 'AMM']
                                    ],
                                    'MESS' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore', 'Tambahan Malam'], 'category' => 'Waktu'],
                                        'mess_a1' => ['label' => 'Mess A1', 'name' => 'mess_a1', 'type' => 'text', 'category' => 'MK'],
                                        'mess_a2' => ['label' => 'Mess A2', 'name' => 'mess_a2', 'type' => 'text', 'category' => 'MK'],
                                        'mess_c3' => ['label' => 'Mess C3', 'name' => 'mess_c3', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b1' => ['label' => 'Mess B1', 'name' => 'mess_b1', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b2' => ['label' => 'Mess B2', 'name' => 'mess_b2', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b3' => ['label' => 'Mess B3', 'name' => 'mess_b3', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b4' => ['label' => 'Mess B4', 'name' => 'mess_b4', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b5' => ['label' => 'Mess B5', 'name' => 'mess_b5', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b6' => ['label' => 'Mess B6', 'name' => 'mess_b6', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b7' => ['label' => 'Mess B7', 'name' => 'mess_b7', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b8' => ['label' => 'Mess B8', 'name' => 'mess_b8', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b9' => ['label' => 'Mess B9', 'name' => 'mess_b9', 'type' => 'text', 'category' => 'MK'],
                                        'mess_b10' => ['label' => 'Mess B10', 'name' => 'mess_b10', 'type' => 'text', 'category' => 'MK'],
                                        'rebusan_a1' => ['label' => 'Rebusan A1', 'name' => 'rebusan_a1', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_a2' => ['label' => 'Rebusan A2', 'name' => 'rebusan_a2', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_c3' => ['label' => 'Rebusan C3', 'name' => 'rebusan_c3', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b1' => ['label' => 'Rebusan B1', 'name' => 'rebusan_b1', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b2' => ['label' => 'Rebusan B2', 'name' => 'rebusan_b2', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b3' => ['label' => 'Rebusan B3', 'name' => 'rebusan_b3', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b4' => ['label' => 'Rebusan B4', 'name' => 'rebusan_b4', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b5' => ['label' => 'Rebusan B5', 'name' => 'rebusan_b5', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b6' => ['label' => 'Rebusan B6', 'name' => 'rebusan_b6', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b7' => ['label' => 'Rebusan B7', 'name' => 'rebusan_b7', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b8' => ['label' => 'Rebusan B8', 'name' => 'rebusan_b8', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b9' => ['label' => 'Rebusan B9', 'name' => 'rebusan_b9', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b10' => ['label' => 'Rebusan B10', 'name' => 'rebusan_b10', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'spare_mess' => ['label' => 'Spare', 'name' => 'spare_mess', 'type' => 'text', 'category' => 'MK Spare']
                                    ],
                                    'MESS_PUTRI' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore','Tambahan Malam'], 'category' => 'Waktu'],
                                        'mess_gl' => ['label' => 'GL', 'name' => 'mess_gl', 'type' => 'text', 'category' => 'Mess'],
                                        'mess_admin' => ['label' => 'Admin', 'name' => 'mess_admin', 'type' => 'text', 'category' => 'Mess'],
                                        'rebusan_admin' => ['label' => 'Rebusan Admin', 'name' => 'rebusan_admin', 'type' => 'text', 'category' => 'Rebusan'],
                                        'rebusan_gl' => ['label' => 'Rebusan GL', 'name' => 'rebusan_gl', 'type' => 'text', 'category' => 'Rebusan'],
                                        'helper_mess' => ['label' => 'Helper Mess', 'name' => 'helper_mess', 'type' => 'text', 'category' => 'Helper']
                                    ],
                                    'MESS_MEICU' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore','Tambahan Malam'], 'category' => 'Waktu'],
                                        'ruko_1' => ['label' => 'Ruko 1', 'name' => 'ruko_1', 'type' => 'text', 'category' => 'Ruko'],
                                        'ruko_2' => ['label' => 'Ruko 2', 'name' => 'ruko_2', 'type' => 'text', 'category' => 'Ruko'],
                                        'ruko_3' => ['label' => 'Ruko 3', 'name' => 'ruko_3', 'type' => 'text', 'category' => 'Ruko'],
                                        'ruko_4' => ['label' => 'Ruko 4', 'name' => 'ruko_4', 'type' => 'text', 'category' => 'Ruko'],
                                        'ruko_5' => ['label' => 'Ruko 5', 'name' => 'ruko_5', 'type' => 'text', 'category' => 'Ruko'],
                                        'rebusan_ruko1' => ['label' => 'Rebusan Ruko 1', 'name' => 'rebusan_ruko1', 'type' => 'text', 'category' => 'Rebusan'],
                                        'rebusan_ruko2' => ['label' => 'Rebusan Ruko 2', 'name' => 'rebusan_ruko2', 'type' => 'text', 'category' => 'Rebusan'],
                                        'rebusan_ruko3' => ['label' => 'Rebusan Ruko 3', 'name' => 'rebusan_ruko3', 'type' => 'text', 'category' => 'Rebusan'],
                                        'rebusan_ruko4' => ['label' => 'Rebusan Ruko 4', 'name' => 'rebusan_ruko4', 'type' => 'text', 'category' => 'Rebusan'],
                                        'rebusan_ruko5' => ['label' => 'Rebusan Ruko 5', 'name' => 'rebusan_ruko5', 'type' => 'text', 'category' => 'Rebusan'],
                                        'test_praktek' => ['label' => 'Test Praktek', 'name' => 'test_praktek', 'type' => 'text', 'category' => 'Umum'],
                                        'magang' => ['label' => 'Magang', 'name' => 'magang', 'type' => 'text', 'category' => 'Umum'],
                                    ],
                                    'C3' => array_merge([
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore','Tambahan Malam'], 'category' => 'Waktu'],
                                        'rebusan_c3' => ['label' => 'Rebusan', 'name' => 'rebusan_c3', 'type' => 'text', 'category' => 'Tambahan'],
                                        'spare_c3' => ['label' => 'Spare', 'name' => 'spare_c3', 'type' => 'text', 'category' => 'Tambahan'],
                                        'visitor_c3' => ['label' => 'Visitor', 'name' => 'visitor_c3', 'type' => 'text', 'category' => 'Tambahan']
                                    ],
                                    array_reduce(range(1, 20), function($carry, $i) {
                                        $carry["kamar_$i"] = ['label' => "Kamar $i", 'name' => "kamar_$i", 'type' => 'number', 'category' => 'Kamar'];
                                        return $carry;
                                    }, [])
                                    ),
                                    'A1' => array_merge([
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore','Tambahan Malam'], 'category' => 'Waktu'],
                                        'rebusan_a1' => ['label' => 'Rebusan', 'name' => 'rebusan_a1', 'type' => 'text', 'category' => 'Tambahan'],
                                        'spare_a1' => ['label' => 'Spare', 'name' => 'spare_a1', 'type' => 'text', 'category' => 'Tambahan'],
                                        'visitor_a1' => ['label' => 'Visitor', 'name' => 'visitor_a1', 'type' => 'text', 'category' => 'Tambahan']
                                    ],
                                    array_reduce(range(1, 38), function($carry, $i) {
                                        $carry["kamar_$i"] = ['label' => "Kamar $i", 'name' => "kamar_$i", 'type' => 'number', 'category' => 'Kamar'];
                                        return $carry;
                                    }, [])
                                    ),


                                ];

                                $customLabels += array_combine(
                                    array_map(fn($b) => "B$b", range(1, 10)),
                                    array_fill(0, 10, array_merge(
                                        [
                                            'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                            'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan Pagi', 'Tambahan Siang', 'Tambahan Sore','Tambahan Malam'], 'category' => 'Waktu'],
                                        ],
                                        array_combine(
                                            array_map(fn($i) => "kamar_$i", range(1, 32)),
                                            array_map(fn($i) => ['label' => "Kamar $i", 'name' => "kamar_$i", 'type' => 'number', 'category' => 'Kamar'], range(1, 32))
                                        ),
                                        [
                                            'spare' => ['label' => 'Spare', 'name' => 'spare', 'type' => 'number', 'category' => 'Tambahan'],
                                            'visitor' => ['label' => 'Visitor', 'name' => 'visitor', 'type' => 'number', 'category' => 'Tambahan'],
                                            'rebusan' => ['label' => 'Rebusan', 'name' => 'rebusan', 'type' => 'number', 'category' => 'Tambahan'],
                                        ]
                                    ))
                                );


                                $formFields = $customLabels[$userTeam] ?? [];
                                $currentCategory = null;
                            @endphp

                            @foreach($formFields as $column => $fieldData)
                            @php
                                $inputLabel = $fieldData['label'];
                                $inputName = $fieldData['name'];
                                $inputCategory = $fieldData['category'];
                                $inputType = $fieldData['type'];
                                $options = $fieldData['options'] ?? [];
                            @endphp

                            @if($currentCategory !== $inputCategory)
                                <div class="col-12">
                                    <h6 class="mt-1">{{ $inputCategory }}</h6>
                                    <hr>
                                </div>
                                @php $currentCategory = $inputCategory; @endphp
                            @endif

                            <div class="col-md-3">
                                <div class="form-floating">
                                    @if($inputType === 'date')
                                    <input type="date" class="form-control" id="{{ $inputName }}" name="{{ $inputName }}" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @elseif($inputType === 'select')
                                        <select class="form-control" id="{{ $inputName }}" name="{{ $inputName }}">
                                            @foreach($fieldData['options'] as $option)
                                                <option value="{{ $option }}" @if($option === 'Silahkan Pilih Waktu') selected @endif>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control" id="{{ $inputName }}" name="{{ $inputName }}"
                                            placeholder="{{ $inputLabel }}">
                                    @endif
                                    <label for="{{ $inputName }}">{{ $inputLabel }}</label>
                                </div>
                            </div>
                            @endforeach

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-yes-add">Tambah Data</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                        @endif
                    </div>
                    </div>
                </div>
                </div>
                {{-- End Modal Add --}}

                <!-- Modal Add SNACK-->
                <div class="modal fade modal_add_snack" id="cateringSnackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mode="add">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="btn-add">Add Snack</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> --}}
                            <input type="hidden" name="id" id="id"/>
                            <form class="row g-3 needs-validation" method="POST" enctype="multipart/form-data" accept="image/*" capture="environment">
                            @csrf
                                <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="tanggal_add_snack" name="tanggal_add_snack" placeholder="Tanggal" readonly>
                                    <label for="message-text">Tanggal </label>
                                </div>
                                </div>
                                <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="snack_biasa_add" name="snack_biasa_add" placeholder="Snack Biasa">
                                    <label for="message-text">Snack Biasa</label>
                                </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="snack_spesial_add" name="snack_spesial_add" placeholder="Snack Spesial">
                                        <label for="message-text">Snack Spesial</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="parcel_buah_add" name="parcel_buah_add" placeholder="Parcel">
                                        <label for="message-text">Parcel Buah Biasa</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="parcel_spesial_add" name="parcel_spesial_add" placeholder="Parcel">
                                        <label for="message-text">Parcel Buah Spesial</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="pempek_add" name="pempek_add" placeholder="Pempek">
                                        <label for="message-text">Pempek</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="kopi_add" name="kopi_add" placeholder="Kopi">
                                        <label for="message-text">Kopi Iglo</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="jahe_add" name="jahe_add" placeholder="Jahe">
                                        <label for="message-text">Wedang Jahe Iglo</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="jahe_add" name="teh_add" placeholder="Teh">
                                        <label for="message-text">Teh Iglo</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="aqua_cup_add" name="aqua_cup_add" placeholder="Aqua">
                                        <label for="message-text">Aqua Cup 220 ml</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="aqua_330_add" name="aqua_330_add" placeholder="Aqua">
                                        <label for="message-text">Aqua Botol 330 ml</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="aqua_660_add" name="aqua_660_add" placeholder="Aqua">
                                        <label for="message-text">Aqua Botol 660 ml</label>
                                    </div>
                                </div>
                                @if(auth()->user()->tim_pic == 'PROD')
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="bubur_add" name="bubur_add" placeholder="Bubur">
                                        <label for="message-text">Bubur Jubaidah</label>
                                    </div>
                                </div>
                                @endif
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-yes-add-snack">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <div id="loading-spinner" >
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal Add --}}

                <!--Modal Add MK Spesial-->
                <div class="modal fade modal_add_spesial" id="cateringSpesialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add MK Spesial</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="kt-form kt-form--label-right form_validasi"method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf

                              <!-- Input Kategori -->
                              <div class="col-md-12">
                                <div class="form-floating">
                                  <label for="kategori" class="form-control"</label>
                                  <select class="form-control" id="spesial_add" name="spesial_add">
                                      <option value="">- Pilih Mk Spesial -</option>
                                      <option value="prasmanan">Prasmanan</option>
                                      <option value="ayam_bakar">Ayam Bakar</option>
                                      <option value="nasi_liwet">Nasi Liwet</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="jumlah_spesial_add" name="jumlah_spesial_add" placeholder="Jumlah">
                                    <label for="message-text">Jumlah</label>
                                </div>

                               </div>

                          </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn-yes-jumlah-spesial">Kirim</button>
                            <div id="loading-spinner" >
                                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!--end::Modal MK Spesial-->

                <!-- Modal -->
                <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exportModalLabel">Export Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/export-dept') }}" method="GET">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="tanggal_export" class="form-label">Pilih Tanggal:</label>
                                        <input type="date" name="tanggal_export" class="form-control" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Export</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

              <!-- Table with stripped rows -->
              <div class="table-responsive">
              <table class="table dt_catering responsive" id="datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Nama</th>
                    <th scope="col" class="hide-mobile">Waktu</th>
                    <th scope="col" class="hide-mobile">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                {{-- //sekar --}}
                @foreach($cateringData as $no => $catering)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $catering->tanggal }}</td>
                    <td>{{ $catering->created_name }}</td>
                    <td class="hide-mobile">{{ $catering->waktu}}</td>
                    <td class="hide-mobile">{{ $catering->total}}</td>
                    <td>
                        @if($catering->status == 1)
                            <span class="badge rounded-pill text-bg-info">Waiting Approval GA</span>
                        @elseif($catering->status == 2)
                            <span class="badge rounded-pill text-bg-success text-start">On Catering</span>
                        @elseif($catering->status == 3)
                            <span class="badge rounded-pill text-bg-warning text-start">Revisi</span>
                        @endif
                    <td>
                    <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    @if(auth()->user()->id_role == 0)
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewcateringModal" data-id="{{ $catering->id }}"><i class="fa fa-expand"></i>View</a></li>
                        <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#cateringModal" data-id="{{ $catering->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                        <li><a class="dropdown-item delete" href="#" data-id="{{ $catering->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                        <li><a class="dropdown-item send" href="#" data-id="{{ $catering->id }}"><i class="fa-regular fa-paper-plane"></i>Kirim Revisi</a></li>
                    </ul>
                    @elseif(in_array($catering->status, [1]) && auth()->user()->id_role == 6)
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewcateringModal" data-id="{{ $catering->id }}"><i class="fa fa-expand"></i>View</a></li>
                        <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#cateringModal" data-id="{{ $catering->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                        <li><a class="dropdown-item delete" href="#" data-id="{{ $catering->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                    </ul>
                    @elseif(in_array($catering->status, [3]) && auth()->user()->id_role == 6)
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewcateringModal" data-id="{{ $catering->id }}"><i class="fa fa-expand"></i>View</a></li>
                        <li><a id="btn-hide-edit" class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#cateringModal" data-id="{{ $catering->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                        <li><a id="btn-hide-delete" class="dropdown-item delete" href="#" data-id="{{ $catering->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                        <li><a id="btn-hide-send" class="dropdown-item send" href="#" data-id="{{ $catering->id }}"><i class="fa-regular fa-paper-plane"></i>Kirim Revisi</a></li>
                    </ul>
                    @else
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewcateringModal" data-id="{{ $catering->id }}"><i class="fa fa-expand"></i>View</a></li>
                    </ul>
                    @endif
                </tr>
                @endforeach 

              </tbody>
              </table>
              </div>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

    {{-- <script src="app/javascript/catering.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

<script>

$(document).ready(function() {
    $("#exportModal form").on("submit", function(event) {
        event.preventDefault();

        let tanggal = $("input[name='tanggal_export']").val();

        if (!tanggal) {
            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "Harap pilih tanggal!"
            });
            return;
        }

        let url = `/export-dept?tanggal=${tanggal}`;

        fetch(url, { method: 'GET' })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                window.location.href = url;
            })
            .catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Gagal Ekspor",
                    text: error.message || "Data tidak ditemukan untuk tanggal yang dipilih."
                });
            });
    });
});

$(document).ready(function () {
    $('.view').click(function () {
        let cateringId = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: '{{ url('/catering/get') }}/' + cateringId,
            success: function (response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }

                let userTeam = "{{ auth()->user()->tim_pic }}";
                let customLabels = {
                    'COE': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'Office Plant': ['section', 'tamu_ho','gl_ss6','mpccr_admccr', 'mpccr_asstmoco', 'mpccr_glmoco', 'mpccr_driver'],
                        'PITSTOP | MP SS6': ['mpss6_glss6', 'mpss6_sysdev', 'mpss6_driver'],
                        'CSA PIT 1 | MP ICT': ['mpict_glict', 'mpict_engineer', 'mpict_driver'],
                        'PIT 3 Container | PIT Control | MP CCR': ['mpccr_admccr_pit'],
                        'Vendor/Tamu': ['visitor']
                    },
                    'ENG' : {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'Office Plant' : ['dept_head', 'sect_head', 'gl_eng', 'driver', 'crew_ssr', 'office_pldp', 'admin_office'],
                        'CSA PIT 2' : ['drill', 'driver_drill','helper_survey', 'driver_survey', 'gl_survey', 'magang', 'warehouse_pldp'],
                        //'Warehouse' : ['warehouse_pldp'],
                        'CSA PIT 3' : ['pitstop'],
                        'Mess Tambang' : ['gl_civil'],
                        'Vendor JMI' : ['vendor_jmi'],
                        'Vendor/Tamu': ['visitor']
                    },
                    'SHE': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'CSA PIT 1': ['dept_head', 'sect_head', 'gl_k3', 'dokter', 'gl_ert', 'gl_ko','medic', 'ert', 'admin', 'sample_makan', 'helper_hcga', 'crew_she','magang', 'driver', 'grounded', 'spare'],
                        'Mess Tambang': ['kontainer_medic'],
                        'Vendor/Tamu': ['visitor']
                    },
                    'FALOG': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'WAREHOUSE': ['dept_head', 'sect_head', 'gl_fa', 'admin_fa','gl_logistik', 'admin_logistik', 'swi', 'vendor','spare', 'pldp','driver_fa_log'],
                        'KOPPA MART MESS TAMBANG': ['koperasi_mess'],
                        'WORKSHOP KOPERASI MESS TAMBANG': ['mechanic_koperasi'],
                        'KOPPA MART OFFICE': ['koperasi_office'],
                        // 'FALOG':,
                        'CSA FUEL': ['opt_fuel_truck','fuelman', 'gl', 'admin_fuel', 'spare_csa', 'driverlv_fuel'],
                        'Vendor/Tamu': ['visitor']
                    },
                    'PROD': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'Office PlANT': ['admin_officeplant'],
                        'Anjungan CSA PIT 1': ['dept_sect_officeplant', 'dept_sect_csapit1'],
                        //'Office CSA PIT 1': ['gl_officecsapit1', 'admin_officecsapit1'],
                        'CSA PIT 1': ['operator_csapit1', 'gl_csapit1', 'spare_csapit1', 'admin_csapit1', 'skillup_csapit1',],
                        'CSA PIT 2': ['dept_sect_csapit2', 'operator_csapit2', 'gl_csapit2', 'spare_csapit2','admin_csapit2','driverlv_csapit2'],
                        'CSA PIT 3': ['dept_sect_csapit3', 'operator_csapit3', 'gl_csapit3', 'spare_csapit3'],
                        'CSA HRM': [ 'operator_csahrm', 'gl_csahrm', 'spare_csahrm'],
                        'CSA PITSTOP AKADEMIN': [ 'driverlv_pitstop', 'gl_pitstop', 'spare_pitstop'],
                        'Vendor/Tamu': ['visitor']
                    },
                    'HCGA': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'OFFICE PLANT': ['pjo', 'sect_head', 'gl_hc', 'admin_hc', 'admin_ga_plant', 'helper_plant', 'security_plant', 'alpen', 'driver_plant', 'sertifikasi_hcga', 'driver_bus_jumat'],
                        'SPBI': ['security_spbi', 'admin_spbi'],
                        'OFFICE GA MESS TAMBANG': ['admin_ga', 'gl_ga', 'electrical_ga', 'driver_mess', 'carpenter', 'gardener'],
                        'MEKANIK TRAC': ['mekanic_trac'],
                        'POS SECURITY MESS TAMBANG': ['security_pos', 'security_patrol', 'driver_lv_cuti'],
                        'MESS TAMBANG': ['helper_mess', 'driver_bus', 'driver_bus_jumat_mess'],
                        'OFFICE GA MEICU': ['admin_ga_meicu', 'gl_ga_meicu', 'security_meicu', 'driver_meicu', 'cv_ade', 'helper_meicu','bagong', 'visitor_meicu', 'vendor_meicu'],
                        'LAUNDRY KARTIKA': ['laundry', 'security_laundry'],
                        'SECURITY' : ['security_pit1', 'security_pit3', 'security_anjungan'],
                        'MARBOT': ['marbot'],
                        'TESK PRAKTEK': ['test_praktek'],
                        'TEST PRAKTEK CSA PIT 1': ['test_praktek_csapit'],
                        'Vendor/Tamu': ['visitor']
                    },
                    'PLANT': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'OFFICE PLANT': ['new_office', 'sect_head_plant', 'siswa_magang', 'base_control'],
                        'PITSTOP': ['dept_head_pitstop', 'sect_head_pitstop', 'wheel_ps', 'track', 'support', 'tyre', 'fabrikasi', 'tool_room', 'pldp',
                                    'fmdp_track', 'fmdp_wheel', 'fmdp_support', 'gmi_mercy', 'mastratech', 'trakindo', 'siswa_magang_pitstop',
                                    'new_hire', 'mutasi', 'driver', 'spare', 'congkelman_apn', 'training', 'vendor_plant_pitstop', 'office_pitstop',
                                    'plant_engineer'],
                        'WORKSHOP': ['dept_head', 'sect_head', 'wheel_ws_workshop', 'fabrikasi_workshop', 'planner', 'plant_engineer_workshop',
                                    'mastratech_workshop', 'fmdp_ws_workshop', 'siswa_magang_ws', 'driver_workshop', 'gmi', 'swi', 'track_ws',
                                    'spare_workshop', 'helper_workshop', 'trakindo_workshop'],
                        'CSA PIT 1': ['skill_up_lt'],
                        'Vendor/Tamu': ['visitor']
                    },
                    'A1': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'KAMAR': [
                            'kamar_1', 'kamar_2', 'kamar_3', 'kamar_4', 'kamar_5', 'kamar_6', 'kamar_7', 'kamar_8', 'kamar_9', 'kamar_10',
                            'kamar_11', 'kamar_12', 'kamar_13', 'kamar_14', 'kamar_15', 'kamar_16', 'kamar_17', 'kamar_18', 'kamar_19', 'kamar_20',
                            'kamar_21', 'kamar_22', 'kamar_23', 'kamar_24', 'kamar_25', 'kamar_26', 'kamar_27', 'kamar_28', 'kamar_29', 'kamar_30',
                            'kamar_31', 'kamar_32', 'kamar_33', 'kamar_34', 'kamar_35', 'kamar_36', 'kamar_37', 'kamar_38'
                        ],
                        'TAMBAHAN': ['rebusan_a1','spare_a1','visitor_a1'],
                    },
                    'C3': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'KAMAR': [
                            'kamar_1', 'kamar_2', 'kamar_3', 'kamar_4', 'kamar_5', 'kamar_6', 'kamar_7', 'kamar_8', 'kamar_9', 'kamar_10',
                            'kamar_11', 'kamar_12', 'kamar_13', 'kamar_14', 'kamar_15', 'kamar_16', 'kamar_17', 'kamar_18', 'kamar_19', 'kamar_20'
                        ],
                        'TAMBAHAN': ['rebusan_c3','spare_c3','visitor_c3'],
                    },
                   'AMM': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'AMM': [
                            'mess_b1', 'mess_b2', 'mess_b3', 'mess_b4', 'mess_b5',
                            'mess_b6', 'mess_b7', 'mess_b8', 'mess_b9', 'mess_b10', 'spare_amm',

                        ],
                    },
                    'MESS': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'MK': [
                            'mess_a1','mess_a2','mess_c3','mess_b1', 'mess_b2', 'mess_b3', 'mess_b4', 'mess_b5',
                            'mess_b6', 'mess_b7', 'mess_b8', 'mess_b9', 'mess_b10', 'spare_mess',
                        ],
                        'REBUSAN': [
                            'rebusan_b1', 'rebusan_b2', 'rebusan_b3', 'rebusan_b4', 'rebusan_b5',
                            'rebusan_b6', 'rebusan_b7', 'rebusan_b8', 'rebusan_b9', 'rebusan_b10','rebusan_a1','rebusan_a2','rebusan_c3'
                        ],
                    },
                    'MESS_PUTRI': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'MESS PUTRI TALANG JAWA  ': ['mess_gl', 'rebusan_gl', 'mess_admin', 'rebusan_admin', 'helper_mess']
                    },
                    'MARBOT': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'LAUNDRY KARTIKA': ['marbot', 'total_laundry', 'security_laundry']
                    },
                    'MESS_MEICU': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'RUKO': [ 'ruko_1', 'ruko_2', 'ruko_3', 'ruko_4', 'ruko_5'],
                        'REBUSAN': ['rebusan_ruko1', 'rebusan_ruko2', 'rebusan_ruko3', 'rebusan_ruko4', 'rebusan_ruko5'],
                        'UMUM': ['test_praktek', 'magang']
                    }

                };

                // Loop untuk menambahkan B1 sampai B10
                for (let i = 1; i <= 10; i++) {
                    customLabels[`B${i}`] = {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'KAMAR': Array.from({ length: 38 }, (_, j) => `kamar_${j + 1}`),
                        'TAMBAHAN': ['rebusan', 'spare','visitor'],
                    };
                }


                let placeLabels = {
                    'admin_fuel': 'ADMIN',
                    'spare_csa': 'SPARE',
                    'dept_sect_officeplant': 'Dept. Head',
                    'admin_officeplant': 'Admin',
                    'dept_sect_csapit1': 'Sect. Head',
                    'operator_csapit1': 'Operator',
                    'gl_csapit1': 'GL',
                    'spare_csapit1': 'Spare',
                    'dept_sect_csapit2': 'Sect. Head',
                    'operator_csapit2': 'Operator',
                    'gl_csapit2': 'GL',
                    'spare_csapit2': 'Spare',
                    'dept_sect_csapit3': 'Sect. Head',
                    'operator_csapit3': 'Operator',
                    'gl_csapit3': 'GL',
                    'spare_csapit3': 'Spare',
                    'gl_officecsapit1': 'GL',
                    'admin_officecsapit1': 'Admin',
                    'vendor': 'Vendor/Tamu',

                    // HCGA
                    'admin_ga_plant': 'ADMIN GA',
                    'helper_plant': 'HELPER',
                    'security_plan': 'SECURITY',
                    'driver_plant': 'DRIVER',
                    'security_spbi': 'SECURITY',
                    'electrical_ga': 'ELECTRICAL',
                    'driver_mess': 'DRIVER',
                    'admin_ga_meicu': 'ADMIN GA',
                    'gl_ga_meicu': 'GL GA',
                    'security_meicu': 'SECURITY',
                    'security_pit1': 'SECURITY PIT 2 ROSELA',
                    'security_pit3': 'SECURITY PIT 3',
                    'driver_meicu': 'DRIVER',
                    'helper_meicu': 'HELPER',

                    'revisi_desc': 'KETERANGAN REVISI',

                    //COE
                    'mpccr_admccr' : 'Admin',

                    //ENG
                    'warehouse_pldp' : 'PLDP',

                    //PLANT
                    'trakindo_workshop' : 'INDOPARTA'
                };

                let viewContainer = $('#viewDataContainer');
                viewContainer.html('');

                let categoryData = customLabels[userTeam] || {};
                let rows = [];

                for (let category in categoryData) {
                    categoryData[category].forEach(field => {
                        if (response[field] !== undefined) {
                            rows.push({
                                waktu: response['waktu'] ?? '-',
                                category: category,
                                tempat: placeLabels[field] || formatLabel(field),
                                total: response[field] ?? '-'
                            });
                        }
                    });
                }

                let mergedData = {};
                rows.forEach(row => {
                    let key = row.waktu;
                    if (!mergedData[key]) {
                        mergedData[key] = [];
                    }
                    mergedData[key].push(row);
                });

                Object.keys(mergedData).forEach(waktu => {
                    let group = mergedData[waktu];
                    let firstRow = true;
                    let totalRowSpan = group.length;

                    group.forEach((row, rowIndex) => {
                        let tr = `<tr>`;

                        if (firstRow) {
                            tr += `<td rowspan="${totalRowSpan}">${row.waktu}</td>`;
                        }

                        if (rowIndex === 0 || row.category !== group[rowIndex - 1].category) {
                            let categoryCount = group.filter(item => item.category === row.category).length;
                            tr += `<td rowspan="${categoryCount}">${row.category}</td>`;
                        }

                        tr += `
                            <td>${row.tempat}</td>
                            <td>${row.total}</td>
                        </tr>`;

                        viewContainer.append(tr);
                        firstRow = false;
                    });
                });

                $('#viewcateringModal').modal('show');
            },
            error: function () {
                alert('Gagal mengambil data!');
            }
        });
    });
});

function formatLabel(text) {
    return text.replace(/_/g, ' ').toUpperCase();
}

var cateringId;
$('.edit').click(function() {
    cateringId = $(this).data('id');
    $('#cateringModal').attr({
    'data-mode': 'edit',
    'data-id': cateringId
    });

    $('#copyPreviousData').closest('.form-check').hide();

    $.ajax({
        type: 'GET',
        url: '{{ url('/catering/get') }}/' + cateringId,
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            let userTeam = "{{ auth()->user()->tim_pic }}";

            let customLabels = {
                'COE': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'section': 'section',
                    'tamu_ho': 'tamu_ho',
                    'gl_ss6': 'gl_ss6',
                    'mpss6_glss6': 'mpss6_glss6',
                    'mpss6_sysdev': 'mpss6_sysdev',
                    'mpss6_driver': 'mpss6_driver',
                    'mpict_glict': 'mpict_glict',
                    'mpict_engineer': 'mpict_engineer',
                    'mpict_driver': 'mpict_driver',
                    'mpccr_admccr': 'mpccr_admccr',
                    'mpccr_asstmoco': 'mpccr_asstmoco',
                    'mpccr_glmoco': 'mpccr_glmoco',
                    'mpccr_driver': 'mpccr_driver',
                    'mpccr_admccr_pit': 'mpccr_admccr_pit',
                    'visitor': 'visitor'
                },
                'HCGA': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'pjo': 'pjo',
                    'sect_head': 'sect_head',
                    'gl_hc': 'gl_hc',
                    'admin_hc': 'admin_hc',
                    'admin_ga_plant': 'admin_ga_plant',
                    'helper_plant': 'helper_plant',
                    'security_plant': 'security_plant',
                    'alpen': 'alpen',
                    'driver_plant': 'driver_plant',
                    'security_spbi': 'security_spbi',
                    'admin_ga': 'admin_ga',
                    'gl_ga': 'gl_ga',
                    'electrical_ga': 'electrical_ga',
                    'driver_mess': 'driver_mess',
                    'carpenter': 'carpenter',
                    'gardener': 'gardener',
                    'mekanic_trac': 'mekanic_trac',
                    'security_pos': 'security_pos',
                    'security_patrol': 'security_patrol',
                    'driver_lv_cuti': 'driver_lv_cuti',
                    'helper_mess': 'helper_mess',
                    'admin_ga_meicu': 'admin_ga_meicu',
                    'gl_ga_meicu': 'gl_ga_meicu',
                    'security_meicu': 'security_meicu',
                    'driver_meicu': 'driver_meicu',
                    'cv_ade': 'cv_ade',
                    'helper_meicu': 'helper_meicu',
                    'laundry': 'laundry',
                    'visitor': 'visitor',
                    'sertifikasi_hcga': 'sertifikasi_hcga',
                    'driver_bus_jumat': 'driver_bus_jumat',
                    'driver_bus_jumat_mess': 'driver_bus_jumat_mess',
                    'admin_spbi': 'admin_spbi',
                    'driver_bus': 'driver_bus',
                    'test_praktek': 'test_praktek',
                    'security_laundry': 'security_laundry',
                    'security_pit1' : 'security_pit1',
                    'security_pit3' : 'security_pit3',
                    'security_anjungan' : 'security_anjungan',
                    'marbot': 'marbot',
                    'test_praktek_csapit': 'test_praktek_csapit',
                    'bagong': 'bagong',
                    'vendor_meicu': 'vendor_meicu',
                    'visitor_meicu': 'visitor_meicu',
                },
                'ENG' : {
                    'tanggal' : 'tanggal',
                    'waktu' : 'waktu',
                    'dept_head' : 'dept_head',
                    'sect_head' : 'sect_head',
                    'gl_eng' : 'gl_eng',
                    'driver' : 'driver',
                    'crew_ssr' : 'crew_ssr',
                    'office_pldp' : 'office_pldp',
                    'admin_office' : 'admin_office',
                    'drill' : 'drill',
                    'driver_drill' : 'driver_drill',
                    'helper_survey' : 'helper_survey',
                    'driver_survey' : 'driver_survey',
                    'gl_survey' : 'gl_survey',
                    'magang' : 'magang',
                    'warehouse_pldp' : 'warehouse_pldp',
                    'pitcontrol' : 'pitcontrol',
                    'vendor_jmi' : 'vendor_jmi',
                    'gl_civil' : 'gl_civil',
                    'visitor': 'visitor'
                },
                'SHE': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'dept_head': 'dept_head',
                    'sect_head': 'sect_head',
                    'gl_k3': 'gl_k3',
                    'dokter': 'dokter',
                    'gl_ert': 'gl_ert',
                    'gl_ko': 'gl_ko',
                    'medic': 'medic',
                    'ert': 'ert',
                    'admin': 'admin',
                    'sample_makan': 'sample_makan',
                    'helper_hcga': 'helper_hcga',
                    'crew_she': 'crew_she',
                    'magang': 'magang',
                    'driver': 'driver',
                    'grounded': 'grounded',
                    'spare': 'spare',
                    'kontainer_medic': 'kontainer_medic',
                    'visitor': 'visitor'
                },
                'FALOG': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'dept_head': 'dept_head',
                    'sect_head': 'sect_head',
                    'gl_fa': 'gl_fa',
                    'admin_fa': 'admin_fa',
                    'gl_logistik': 'gl_logistik',
                    'admin_logistik': 'admin_logistik',
                    'swi': 'swi',
                    'vendor': 'vendor',
                    'spare': 'spare',
                    'pldp': 'pldp',
                    'koperasi_mess': 'koperasi_mess',
                    'mechanic_koperasi': 'mechanic_koperasi',
                    'koperasi_office': 'koperasi_office',
                    'opt_fuel_truck': 'opt_fuel_truck',
                    'fuelman': 'fuelman',
                    'gl': 'gl',
                    'admin_fuel': 'admin_fuel',
                    'spare_csa': 'spare_csa',
                    'driver_fa_log': 'driver_fa_log',
                    'driverlv_fuel': 'driverlv_fuel',
                    'visitor': 'visitor'
                },
                'PROD': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'dept_sect_csapit1': 'dept_sect_csapit1',
                    'dept_sect_csapit2': 'dept_sect_csapit2',
                    'dept_sect_csapit3': 'dept_sect_csapit3',
                    'operator_csapit1': 'operator_csapit1',
                    'admin_csapit1': 'admin_csapit1',
                    'skillup_csapit1': 'skillup_csapit1',
                    'gl_csapit1': 'gl_csapit1',
                    'spare_csapit1': 'spare_csapit1',
                    'operator_csapit2': 'operator_csapit2',
                    'gl_csapit2': 'gl_csapit2',
                    'spare_csapit2': 'spare_csapit2',
                    'operator_csapit3': 'operator_csapit3',
                    'admin_csapit2': 'admin_csapit2',
                    'admin_csapit2': 'admin_csapit2',
                    'driverlv_csapit2': 'driverlv_csapit2',
                    'gl_csapit3': 'gl_csapit3',
                    'spare_csapit3': 'spare_csapit3',
                    'dept_sect_officeplant': 'dept_sect_officeplant',
                    'admin_officeplant': 'admin_officeplant',
                    'gl_officecsapit1': 'gl_officecsapit1',
                    'admin_officecsapit1': 'admin_officecsapit1',
                    'operator_csahrm': 'operator_csahrm',
                    'gl_csahrm': 'gl_csahrm',
                    'spare_csahrm': 'spare_csahrm',
                    'driverlv_pitstop': 'driverlv_pitstop',
                    'gl_pitstop': 'gl_pitstop',
                    'spare_pitstop': 'spare_pitstop',
                    'visitor': 'visitor'
                },
                'PLANT': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'dept_head': 'dept_head',
                    'sect_head': 'sect_head',
                    'dept_head_pitstop': 'dept_head_pitstop',
                    'sect_head_pitstop': 'sect_head_pitstop',
                    'new_office': 'new_office',
                    'sect_head_plant': 'sect_head_plant',
                    'siswa_magang': 'siswa_magang',
                    'base_control': 'base_control',
                    'wheel_ps': 'wheel_ps',
                    'track': 'track',
                    'support': 'support',
                    'tyre': 'tyre',
                    'fabrikasi': 'fabrikasi',
                    'tool_room': 'tool_room',
                    'pldp': 'pldp',
                    'fmdp_track': 'fmdp_track',
                    'fmdp_wheel': 'fmdp_wheel',
                    'fmdp_support': 'fmdp_support',
                    'gmi_mercy': 'gmi_mercy',
                    'mastratech': 'mastratech',
                    'trakindo': 'trakindo',
                    'siswa_magang_pitstop': 'siswa_magang_pitstop',
                    'new_hire': 'new_hire',
                    'mutasi': 'mutasi',
                    'driver': 'driver',
                    'spare': 'spare',
                    'congkelman_apn': 'congkelman_apn',
                    'training': 'training',
                    'vendor_plant_pitstop': 'vendor_plant_pitstop',
                    'office_pitstop': 'office_pitstop',
                    'plant_engineer': 'plant_engineer',
                    'skill_up_lt': 'skill_up_lt',
                    'wheel_ws_workshop': 'wheel_ws_workshop',
                    'fabrikasi_workshop': 'fabrikasi_workshop',
                    'planner': 'planner',
                    'plant_engineer_workshop': 'plant_engineer_workshop',
                    'mastratech_workshop': 'mastratech_workshop',
                    'fmdp_ws_workshop': 'fmdp_ws_workshop',
                    'siswa_magang_ws': 'siswa_magang_ws',
                    'driver_workshop': 'driver_workshop',
                    'gmi': 'gmi',
                    'swi': 'swi',
                    'track_ws': 'track_ws',
                    'spare_workshop': 'spare_workshop',
                    'helper_workshop': 'helper_workshop',
                    'trakindo_workshop': 'trakindo_workshop',
                    'backup_opp': 'backup_opp',
                    'visitor': 'visitor'
                },
                'A1': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'rebusan_a1': 'rebusan_a1',
                    'spare_a1': 'spare_a1',
                    'visitor_a1': 'visitor_a1',
                    ...Object.fromEntries(Array.from({ length: 38 }, (_, i) => [`kamar_${i + 1}`, `kamar_${i + 1}`]))
                },
                'C3': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'rebusan_c3': 'rebusan_c3',
                    'spare_c3': 'spare_c3',
                    'visitor_c3': 'visitor_c3',
                    ...Object.fromEntries(Array.from({ length: 20 }, (_, i) => [`kamar_${i + 1}`, `kamar_${i + 1}`]))
                },
                'MARBOT': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'total': 'total',
                    'marbot': 'marbot',
                    'total_laundry': 'total_laundry',
                    'security_laundry': 'security_laundry'
                },
                'AMM': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'mess_b1': 'mess_b1',
                    'mess_b2': 'mess_b2',
                    'mess_b3': 'mess_b3',
                    'mess_b4': 'mess_b4',
                    'mess_b5': 'mess_b5',
                    'mess_b6': 'mess_b6',
                    'mess_b7': 'mess_b7',
                    'mess_b8': 'mess_b8',
                    'mess_b9': 'mess_b9',
                    'mess_b10': 'mess_b10',
                    'spare_amm': 'spare_amm',
                },
               'MESS': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'mess_a1': 'mess_a1',
                    'mess_a2': 'mess_a2',
                    'mess_c3': 'mess_c3',
                    'mess_b1': 'mess_b1',
                    'mess_b2': 'mess_b2',
                    'mess_b3': 'mess_b3',
                    'mess_b4': 'mess_b4',
                    'mess_b5': 'mess_b5',
                    'mess_b6': 'mess_b6',
                    'mess_b7': 'mess_b7',
                    'mess_b8': 'mess_b8',
                    'mess_b9': 'mess_b9',
                    'mess_b10': 'mess_b10',
                    'spare_mess': 'spare_mess',
                    'rebusan_b1': 'rebusan_b1',
                    'rebusan_b2': 'rebusan_b2',
                    'rebusan_b3': 'rebusan_b3',
                    'rebusan_b4': 'rebusan_b4',
                    'rebusan_b5': 'rebusan_b5',
                    'rebusan_b6': 'rebusan_b6',
                    'rebusan_b7': 'rebusan_b7',
                    'rebusan_b8': 'rebusan_b8',
                    'rebusan_b9': 'rebusan_b9',
                    'rebusan_b10': 'rebusan_b10',
                    'rebusan_a1': 'rebusan_a1',
                    'rebusan_a2': 'rebusan_a2',
                    'rebusan_c3': 'rebusan_c3',
                },
                'MESS_PUTRI': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'total': 'total',
                    'mess_gl': 'mess_gl',
                    'rebusan_gl': 'rebusan_gl',
                    'mess_admin': 'mess_admin',
                    'rebusan_admin': 'rebusan_admin',
                    'helper_mess': 'helper_mess'
                },
                'MESS_MEICU': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'total': 'total',
                    'ruko_1': 'ruko_1',
                    'ruko_2': 'ruko_2',
                    'ruko_3': 'ruko_3',
                    'ruko_4': 'ruko_4',
                    'ruko_5': 'ruko_5',
                    'rebusan_ruko1': 'rebusan_ruko1',
                    'rebusan_ruko2': 'rebusan_ruko2',
                    'rebusan_ruko3': 'rebusan_ruko3',
                    'rebusan_ruko4': 'rebusan_ruko4',
                    'rebusan_ruko5': 'rebusan_ruko5',
                    'test_praktek': 'test_praktek',
                    'magang': 'magang',
                }

            };

            for (let i = 1; i <= 10; i++) {
                customLabels[`B${i}`] = {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'rebusan': 'rebusan',
                    'spare': 'spare',
                    'visitor': 'visitor',
                    ...Object.fromEntries(Array.from({ length: 32 }, (_, j) => [`kamar_${j + 1}`, `kamar_${j + 1}`]))
                };
            }

            let selectedFields = customLabels[userTeam] || {};

            $('#cateringModal input, #cateringModal select').val('');

            // Loop untuk mengisi input sesuai dengan response dari database
            for (let field in selectedFields) {
                let inputId = selectedFields[field];
                let value = response[field] ?? '';

                // Jika input bertipe select, set nilai terpilih
                if ($('#' + inputId).is('select')) {
                    $('#' + inputId).val(value);
                } else {
                    $('#' + inputId).val(value);
                }
            }

            // Check if the modal is in "edit" mode, and hide the checkbox
            if ($('#cateringModal').attr('data-mode') === 'edit') {
                // Hide checkboxes here by targeting them by class or ID
                $('#cateringModal .checkbox-class').hide(); // Replace '.checkbox-class' with the actual class or ID
            }
            $('#cateringModal').modal('show');
        },
        error: function() {
            alert('Gagal mengambil data!');
        }
    });
});

function setDropdownSelected(selector, value) {
    $(selector).val(value);
    $(selector + ' option').filter(function() {
        return $(this).val() == value;
    }).prop('selected', true);
}

$('#copyPreviousData').change(function() {
    if ($(this).is(':checked')) {
        let tanggal = $('#tanggal').val();
        let waktu = $('#waktu').val();

        if (!tanggal || !waktu) {
            alert('Harap pilih Tanggal dan Waktu terlebih dahulu.');
            $(this).prop('checked', false);
            return;
        }

        $.ajax({
            type: 'GET',
            url: '{{ url('/catering/getPrevious') }}',
            data: { tanggal: tanggal, waktu: waktu },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                    $('#copyPreviousData').prop('checked', false);
                    return;
                }

                let userTeam = "{{ auth()->user()->tim_pic }}";
                let customLabels = {
                    'COE': {
                        'waktu': 'waktu',
                        'section': 'section',
                        'tamu_ho': 'tamu_ho',
                        'gl_ss6': 'gl_ss6',
                        'mpss6_glss6': 'mpss6_glss6',
                        'mpss6_sysdev': 'mpss6_sysdev',
                        'mpss6_driver': 'mpss6_driver',
                        'mpict_glict': 'mpict_glict',
                        'mpict_engineer': 'mpict_engineer',
                        'mpict_driver': 'mpict_driver',
                        'mpccr_admccr': 'mpccr_admccr',
                        'mpccr_asstmoco': 'mpccr_asstmoco',
                        'mpccr_glmoco': 'mpccr_glmoco',
                        'mpccr_driver': 'mpccr_driver',
                        'mpccr_admccr_pit': 'mpccr_admccr_pit',
                        'visitor': 'visitor'
                    },
                    'HCGA': {
                        'waktu': 'waktu',
                        'pjo': 'pjo',
                        'sect_head': 'sect_head',
                        'gl_hc': 'gl_hc',
                        'admin_hc': 'admin_hc',
                        'admin_ga_plant': 'admin_ga_plant',
                        'helper_plant': 'helper_plant',
                        'security_plant': 'security_plant',
                        'alpen': 'alpen',
                        'driver_plant': 'driver_plant',
                        'security_spbi': 'security_spbi',
                        'admin_ga': 'admin_ga',
                        'gl_ga': 'gl_ga',
                        'electrical_ga': 'electrical_ga',
                        'driver_mess': 'driver_mess',
                        'carpenter': 'carpenter',
                        'gardener': 'gardener',
                        'mekanic_trac': 'mekanic_trac',
                        'security_pos': 'security_pos',
                        'security_patrol': 'security_patrol',
                        'driver_lv_cuti': 'driver_lv_cuti',
                        'helper_mess': 'helper_mess',
                        'admin_ga_meicu': 'admin_ga_meicu',
                        'gl_ga_meicu': 'gl_ga_meicu',
                        'security_meicu': 'security_meicu',
                        'driver_meicu': 'driver_meicu',
                        'cv_ade': 'cv_ade',
                        'helper_meicu': 'helper_meicu',
                        'laundry': 'laundry',
                        'visitor': 'visitor',
                        'sertifikasi_hcga': 'sertifikasi_hcga',
                        'driver_bus_jumat': 'driver_bus_jumat',
                        'admin_spbi': 'admin_spbi',
                        'driver_bus': 'driver_bus',
                        'test_praktek': 'test_praktek',
                        'security_laundry': 'security_laundry',
                        'security_pit1' : 'security_pit1',
                        'security_pit3' : 'security_pit3',
                        'security_anjungan' : 'security_anjungan',
                        'marbot': 'marbot',
                        'test_praktek_csapit': 'test_praktek_csapit',
                        'bagong': 'bagong',
                        'vendor_meicu': 'vendor_meicu',
                        'visitor_meicu': 'visitor_meicu',
                    },
                    'ENG' : {
                        'tanggal' : 'tanggal',
                        'waktu' : 'waktu',
                        'dept_head' : 'dept_head',
                        'sect_head' : 'sect_head',
                        'gl_eng' : 'gl_eng',
                        'driver' : 'driver',
                        'crew_ssr' : 'crew_ssr',
                        'office_pldp' : 'office_pldp',
                        'admin_office' : 'admin_office',
                        'drill' : 'drill',
                        'driver_drill' : 'driver_drill',
                        'helper_survey' : 'helper_survey',
                        'driver_survey' : 'driver_survey',
                        'gl_survey' : 'gl_survey',
                        'magang' : 'magang',
                        'warehouse_pldp' : 'warehouse_pldp',
                        'CSA PIT 3' : 'pitstop',
                        'Vendor JMI' : 'vendor_jmi',
                        'Mess Tambang' : 'gl_civil',
                        'visitor': 'visitor'
                    },
                    'SHE': {
                        'waktu': 'waktu',
                        'dept_head': 'dept_head',
                        'sect_head': 'sect_head',
                        'gl_k3': 'gl_k3',
                        'dokter': 'dokter',
                        'gl_ert': 'gl_ert',
                        'gl_ko': 'gl_ko',
                        'medic': 'medic',
                        'ert': 'ert',
                        'admin': 'admin',
                        'sample_makan': 'sample_makan',
                        'helper_hcga': 'helper_hcga',
                        'crew_she': 'crew_she',
                        'magang': 'magang',
                        'driver': 'driver',
                        'grounded': 'grounded',
                        'spare': 'spare',
                        'kontainer_medic': 'kontainer_medic',
                        'visitor': 'visitor'
                    },
                    'FALOG': {
                        'waktu': 'waktu',
                        'dept_head': 'dept_head',
                        'sect_head': 'sect_head',
                        'gl_fa': 'gl_fa',
                        'admin_fa': 'admin_fa',
                        'gl_logistik': 'gl_logistik',
                        'admin_logistik': 'admin_logistik',
                        'swi': 'swi',
                        'vendor': 'vendor',
                        'spare': 'spare',
                        'pldp': 'pldp',
                        'koperasi_mess': 'koperasi_mess',
                        'mechanic_koperasi': 'mechanic_koperasi',
                        'koperasi_office': 'koperasi_office',
                        'opt_fuel_truck': 'opt_fuel_truck',
                        'fuelman': 'fuelman',
                        'gl': 'gl',
                        'admin_fuel': 'admin_fuel',
                        'spare_csa': 'spare_csa',
                        'driver_fa_log': 'driver_fa_log',
                        'driverlv_fuel': 'driverlv_fuel',
                        'visitor': 'visitor'
                    },
                    'PROD': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'dept_sect_csapit1': 'dept_sect_csapit1',
                    'dept_sect_csapit2': 'dept_sect_csapit2',
                    'dept_sect_csapit3': 'dept_sect_csapit3',
                    'operator_csapit1': 'operator_csapit1',
                    'admin_csapit1': 'admin_csapit1',
                    'skillup_csapit1': 'skillup_csapit1',
                    'gl_csapit1': 'gl_csapit1',
                    'spare_csapit1': 'spare_csapit1',
                    'operator_csapit2': 'operator_csapit2',
                    'gl_csapit2': 'gl_csapit2',
                    'spare_csapit2': 'spare_csapit2',
                    'operator_csapit3': 'operator_csapit3',
                    'admin_csapit2': 'admin_csapit2',
                    'driverlv_csapit2': 'driverlv_csapit2',
                    'gl_csapit3': 'gl_csapit3',
                    'spare_csapit3': 'spare_csapit3',
                    'dept_sect_officeplant': 'dept_sect_officeplant',
                    'admin_officeplant': 'admin_officeplant',
                    'gl_officecsapit1': 'gl_officecsapit1',
                    'admin_officecsapit1': 'admin_officecsapit1',
                    'operator_csahrm': 'operator_csahrm',
                    'gl_csahrm': 'gl_csahrm',
                    'spare_csahrm': 'spare_csahrm',
                    'driverlv_pitstop': 'driverlv_pitstop',
                    'gl_pitstop': 'gl_pitstop',
                    'spare_pitstop': 'spare_pitstop',
                    'visitor': 'visitor'
                    },
                    'PLANT': {
                        'waktu': 'waktu',
                        'dept_head': 'dept_head',
                        'sect_head': 'sect_head',
                        'dept_head_pitstop': 'dept_head_pitstop',
                        'sect_head_pitstop': 'sect_head_pitstop',
                        'new_office': 'new_office',
                        'sect_head_plant': 'sect_head_plant',
                        'siswa_magang': 'siswa_magang',
                        'base_control': 'base_control',
                        'wheel_ps': 'wheel_ps',
                        'track': 'track',
                        'support': 'support',
                        'tyre': 'tyre',
                        'fabrikasi': 'fabrikasi',
                        'tool_room': 'tool_room',
                        'pldp': 'pldp',
                        'fmdp_track': 'fmdp_track',
                        'fmdp_wheel': 'fmdp_wheel',
                        'fmdp_support': 'fmdp_support',
                        'gmi_mercy': 'gmi_mercy',
                        'mastratech': 'mastratech',
                        'trakindo': 'trakindo',
                        'siswa_magang_pitstop': 'siswa_magang_pitstop',
                        'new_hire': 'new_hire',
                        'mutasi': 'mutasi',
                        'driver': 'driver',
                        'spare': 'spare',
                        'congkelman_apn': 'congkelman_apn',
                        'training': 'training',
                        'vendor_plant_pitstop': 'vendor_plant_pitstop',
                        'office_pitstop': 'office_pitstop',
                        'plant_engineer': 'plant_engineer',
                        'skill_up_lt': 'skill_up_lt',
                        'wheel_ws_workshop': 'wheel_ws_workshop',
                        'fabrikasi_workshop': 'fabrikasi_workshop',
                        'planner': 'planner',
                        'plant_engineer_workshop': 'plant_engineer_workshop',
                        'mastratech_workshop': 'mastratech_workshop',
                        'fmdp_ws_workshop': 'fmdp_ws_workshop',
                        'siswa_magang_ws': 'siswa_magang_ws',
                        'driver_workshop': 'driver_workshop',
                        'gmi': 'gmi',
                        'swi': 'swi',
                        'track_ws': 'track_ws',
                        'spare_workshop': 'spare_workshop',
                        'helper_workshop': 'helper_workshop',
                        'trakindo_workshop': 'trakindo_workshop',
                        'backup_opp': 'backup_opp',
                        'visitor': 'visitor'
                    },
                    'A1': {
                        'waktu': 'waktu',
                        'rebusan_a1': 'rebusan_a1',
                        'spare_a1': 'spare_a1',
                        'visitor_a1': 'visitor_a1',
                        ...Object.fromEntries(Array.from({ length: 38 }, (_, i) => [`kamar_${i + 1}`, `kamar_${i + 1}`]))
                    },
                    'C3': {
                        'waktu': 'waktu',
                        'rebusan_c3': 'rebusan_c3',
                        'spare_c3': 'spare_c3',
                        'visitor_c3': 'visitor_c3',
                        ...Object.fromEntries(Array.from({ length: 20 }, (_, i) => [`kamar_${i + 1}`, `kamar_${i + 1}`]))
                    },
                    'MARBOT': {
                        'waktu': 'waktu',
                        'total': 'total',
                        'marbot': 'marbot',
                        'total_laundry': 'total_laundry',
                        'security_laundry': 'security_laundry'
                    },
                    'AMM': {
                        'tanggal': 'tanggal',
                        'waktu': 'waktu',
                        'mess_b1': 'mess_b1',
                        'mess_b2': 'mess_b2',
                        'mess_b3': 'mess_b3',
                        'mess_b4': 'mess_b4',
                        'mess_b5': 'mess_b5',
                        'mess_b6': 'mess_b6',
                        'mess_b7': 'mess_b7',
                        'mess_b8': 'mess_b8',
                        'mess_b9': 'mess_b9',
                        'mess_b10': 'mess_b10',
                        'spare_amm': 'spare_amm',
                    },
                    'MESS': {
                        'tanggal': 'tanggal',
                        'waktu': 'waktu',
                        'mess_a1': 'mess_a1',
                        'mess_a2': 'mess_a2',
                        'mess_c3': 'mess_c3',
                        'mess_b1': 'mess_b1',
                        'mess_b2': 'mess_b2',
                        'mess_b3': 'mess_b3',
                        'mess_b4': 'mess_b4',
                        'mess_b5': 'mess_b5',
                        'mess_b6': 'mess_b6',
                        'mess_b7': 'mess_b7',
                        'mess_b8': 'mess_b8',
                        'mess_b9': 'mess_b9',
                        'mess_b10': 'mess_b10',
                        'spare_mess': 'spare_mess',
                        'rebusan_b1': 'rebusan_b1',
                        'rebusan_b2': 'rebusan_b2',
                        'rebusan_b3': 'rebusan_b3',
                        'rebusan_b4': 'rebusan_b4',
                        'rebusan_b5': 'rebusan_b5',
                        'rebusan_b6': 'rebusan_b6',
                        'rebusan_b7': 'rebusan_b7',
                        'rebusan_b8': 'rebusan_b8',
                        'rebusan_b9': 'rebusan_b9',
                        'rebusan_b10': 'rebusan_b10',
                        'rebusan_a1': 'rebusan_a1',
                        'rebusan_a2': 'rebusan_a2',
                        'rebusan_c3': 'rebusan_c3',
                    },
                    'MESS_PUTRI': {
                        'waktu': 'waktu',
                        'total': 'total',
                        'mess_gl': 'mess_gl',
                        'rebusan_gl': 'rebusan_gl',
                        'mess_admin': 'mess_admin',
                        'rebusan_admin': 'rebusan_admin',
                        'helper_mess': 'helper_mess'
                    },
                    'MESS_MEICU': {
                        'waktu': 'waktu',
                        'total': 'total',
                        'ruko_1': 'ruko_1',
                        'ruko_2': 'ruko_2',
                        'ruko_3': 'ruko_3',
                        'ruko_4': 'ruko_4',
                        'ruko_5': 'ruko_5',
                        'rebusan_ruko1': 'rebusan_ruko1',
                        'rebusan_ruko2': 'rebusan_ruko2',
                        'rebusan_ruko3': 'rebusan_ruko3',
                        'rebusan_ruko4': 'rebusan_ruko4',
                        'rebusan_ruko5': 'rebusan_ruko5',
                        'test_praktek': 'test_praktek',
                        'magang': 'magang',
                    }

                };

                for (let i = 1; i <= 10; i++) {
                    customLabels[`B${i}`] = {
                        'waktu': 'waktu',
                        'rebusan': 'rebusan',
                        'spare': 'spare',
                        'visitor': 'visitor',
                        ...Object.fromEntries(Array.from({ length: 32 }, (_, j) => [`kamar_${j + 1}`, `kamar_${j + 1}`]))
                    };
                }
                let selectedFields = customLabels[userTeam] || {};

                for (let field in selectedFields) {
                    let inputId = selectedFields[field];
                    let value = response[field] ?? '';

                    if ($('#' + inputId).is('select')) {
                        $('#' + inputId).val(value);
                    } else {
                        $('#' + inputId).val(value);
                    }
                }
            },
            error: function() {
                Swal.fire({
                       icon: 'error',
                       title: 'Gagal!',
                       text: 'Data sebelumnya tidak di temukan.'
                   });
                $('#copyPreviousData').prop('checked', false);
            }
        });
    }
});

$(document).ready(function() {

    $(document).on('click', '#btn-yes-add', function(event) {
        var $modal = $('#cateringModal');
        var mode = $modal.data('mode') || 'add';
        let cateringId = $('#cateringModal').attr('data-id');

        if (mode === 'edit' && !cateringId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Catering ID tidak ditemukan!',
            });
            return;
        }

        var formData = $('#cateringForm').serialize();

        var url = mode === 'edit'
            ? `{{ url("/catering/myedit") }}/${cateringId}`
            : `{{ route("catering.store") }}`;

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            beforeSend: function() {
                $('#btn-yes-add').prop('disabled', true);
            },
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: mode === 'edit' ? 'Catering berhasil diperbarui!' : 'Catering berhasil ditambahkan!',
                    }).then(() => {
                        // Bersihkan modal sebelum refresh
                        window.location.href = window.location.href;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Terjadi kesalahan saat menyimpan data.',
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memproses data!',
                });
            },
            complete: function() {
                $('#btn-yes-add').prop('disabled', false);
            }
        });
    });
});

//DELETE
document.querySelectorAll('.delete').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var cateringId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post('{{ route('delete.catering') }}', {
                   catering_id: cateringId
               })
               .then(function (response) {
                   Swal.fire({
                       icon: 'success',
                       title: 'Sukses!',
                       text: response.data.message
                   }).then(() => {
                       location.reload();
                   });
               })
               .catch(function (error) {
                   Swal.fire({
                       icon: 'error',
                       title: 'Gagal!',
                       text: 'Terjadi kesalahan saat mengirim data.'
                   });
               });
           }
       });
   });
});

//SEND
$(document).ready(function() {
    $('.send').click(function(e) {
        e.preventDefault();

        var cateringId = $(this).data('id');
        var selectedDepartemen = "{{ auth()->user()->tim_pic }}";
        console.log(`cateringId: ${cateringId}`);

        Swal.fire({
            title: 'Kirim Revisi?',
            text: "Yakin ingin mengirim revisi untuk datini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/catering/send',
                    data: {
                        catering_id: cateringId,
                        departemen: selectedDepartemen,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        Swal.showLoading();
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: response.message
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengirim revisi.'
                        });
                    }
                });
            }
        });
    });
});

// //HIDE BUTTON ADD
// document.addEventListener('DOMContentLoaded', function () {
//         function checkButtonVisibility() {
//             const now = new Date();
//             const hours = now.getHours();

//             const openModalBtn = document.getElementById('btn-open-modal');

//             // sembunyikan tombol dari jam 7:00 - 7:59
//             if (hours >= 16 || hours < 7) {
//                 if (openModalBtn) openModalBtn.style.display = 'none';
//             } else {
//                 if (openModalBtn) openModalBtn.style.display = 'inline-block';
//             }
//         }

//         checkButtonVisibility();
//         setInterval(checkButtonVisibility, 60000);
//     });

document.addEventListener('DOMContentLoaded', function () {
    function checkButtonVisibility() {
        const now = new Date();
        const hours = now.getHours();

        const openModalBtn = document.getElementById('btn-open-modal');
        const editBtn = document.getElementById('btn-hide-edit');
        const deleteBtn = document.getElementById('btn-hide-delete');
        const sendBtn = document.getElementById('btn-hide-send');

        // hide tombol Add di jam 16:00 - 06:59
        if (hours >= 16 || hours < 7) {
            if (openModalBtn) openModalBtn.style.display = 'none';
        } else {
            if (openModalBtn) openModalBtn.style.display = 'inline-block';
        }

        // hide tombol Edit/Delete/Kirim Revisi di jam 19:00 - 06:59
        if (hours >= 19 || hours < 7) {
            if (editBtn) editBtn.style.display = 'none';
            if (deleteBtn) deleteBtn.style.display = 'none';
            if (sendBtn) sendBtn.style.display = 'none';
        } else {
            if (editBtn) editBtn.style.display = 'block';
            if (deleteBtn) deleteBtn.style.display = 'block';
            if (sendBtn) sendBtn.style.display = 'block';
        }
    }

    checkButtonVisibility();
    setInterval(checkButtonVisibility, 60000);
});


</script>


@endsection

