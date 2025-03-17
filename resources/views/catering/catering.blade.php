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
              <button type="button" class="btn bi bi-plus btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#cateringModal"> Add MK Catering Reguler</button>
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
                                            <th>Kategori</th>
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
                            'A1', 'C3', 'MESS_MEICU', 'MESS_PUTRI',
                            'B1', 'B2', 'B3', 'B4', 'MB5',
                            'B6', 'B7', 'B8', 'B9', 'B10'
                        ]))

                        <form id="cateringForm" class="row g-3 needs-validation">
                            @csrf
                            <input type="hidden" name="table_name" value="{{ $tableName ?? '' }}">

                            @php
                                $userTeam = auth()->user()->tim_pic;

                                $customLabels = [
                                    'COE' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
                                        'section' => ['label' => 'Section', 'name' => 'section','type' => 'text', 'category' => 'Office Plant'],
                                        'gl_ss6' => ['label' => 'GL SS6', 'name' => 'gl_ss6','type' => 'text', 'category' => 'Office Plant'],
                                        'mpss6_glss6' => ['label' => 'GL SS6', 'name' => 'mpss6_glss6','type' => 'text', 'category' => 'PITSTOP | MP SS6'],
                                        'mpss6_sysdev' => ['label' => 'Sysdev SS6', 'name' => 'mpss6_sysdev','type' => 'text', 'category' => 'PITSTOP | MP SS6'],
                                        'mpss6_driver' => ['label' => 'Driver SS6', 'name' => 'mpss6_driver','type' => 'text', 'category' => 'PITSTOP | MP SS6'],
                                        'mpict_glict' => ['label' => 'GL ICT', 'name' => 'mpict_glict','type' => 'text', 'category' => 'CSA PIT 1 | MPICT'],
                                        'mpict_engineer' => ['label' => 'Engineer', 'name' => 'mpict_engineer','type' => 'text', 'category' => 'CSA PIT 1 | MP ICT'],
                                        'mpict_driver' => ['label' => 'Driver SS6', 'name' => 'mpict_driver','type' => 'text', 'category' => 'CSA PIT 1 | MP ICT'],
                                        'mpccr_admccr' => ['label' => 'Adm CCR', 'name' => 'mpccr_admccr', 'type' => 'text','category' => 'Office Plant | MP CCR'],
                                        'mpccr_asstmoco' => ['label' => 'Asst. Moco', 'name' => 'mpccr_asstmoco', 'type' => 'text','category' => 'Office Plant | MP CCR'],
                                        'mpccr_glmoco' => ['label' => 'GL Moco', 'name' => 'mpccr_glmoco', 'type' => 'text','category' => 'Office Plant | MP CCR'],
                                        'mpccr_driver' => ['label' => 'Driver CCR', 'name' => 'mpccr_driver', 'type' => 'text','category' => 'Office Plant | MP CCR'],
                                        'mpccr_admccr_pit' => ['label' => 'Adm CCR', 'name' => 'mpccr_admccr_pit', 'type' => 'text','category' => 'PIT 3 Container | PIT Control | MP CCR'],
                                    ],
                                    'ENG' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
                                        'dept_head' => ['label' => 'Dept Head', 'name' => 'dept_head','type' => 'text', 'category' => 'Office'],
                                        'sect_head' => ['label' => 'Section', 'name' => 'sect_head','type' => 'text', 'category' => 'Office'],
                                        'gl_eng' => ['label' => 'GL', 'name' => 'gl_eng','type' => 'text', 'category' => 'Office'],
                                        'driver' => ['label' => 'Driver', 'name' => 'driver','type' => 'text', 'category' => 'Office'],
                                        'crew_ssr' => ['label' => 'Crew SSR', 'name' => 'crew_ssr','type' => 'text', 'category' => 'Office'],
                                        'office_pldp' => ['label' => 'PLDP', 'name' => 'office_pldp','type' => 'text', 'category' => 'Office'],
                                        'drill' => ['label' => 'Drill & PIT Control', 'name' => 'drill','type' => 'text', 'category' => 'CSA PIT 2'],
                                        'driver_drill' => ['label' => 'Driver Drill & PIT Control', 'name' => 'driver_drill', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'driver_survey' => ['label' => 'Driver Survey', 'name' => 'driver_survey', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'helper_survey' => ['label' => 'Driver Survey', 'name' => 'helper_survey', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'gl_survey' => ['label' => 'GL Surver', 'name' => 'gl_survey', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'magang' => ['label' => 'Magang', 'name' => 'magang', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'driver_survey' => ['label' => 'Driver Survey', 'name' => 'driver_survey', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'warehouse_pldp' => ['label' => 'PLDP', 'name' => 'warehouse_pldp', 'type' => 'text','category' => 'Warehouse'],
                                    ],
                                    'SHE' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
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
                                    ],
                                    'FALOG' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
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
                                        'spare_csa' => ['label' => 'Spare', 'name' => 'spare_csa', 'type' => 'text', 'category' => 'CSA FUEL'],
                                    ],
                                    'PROD' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
                                        'dept_sect_csapit1' => ['label' => 'Dept. Head/ Sect. Head', 'name' => 'dept_sect_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'operator_csapit1' => ['label' => 'Operator', 'name' => 'operator_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'gl_csapit1' => ['label' => 'GL', 'name' => 'gl_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'spare_csapit1' => ['label' => 'Spare', 'name' => 'spare_csapit1', 'type' => 'text', 'category' => 'CSA PIT 1'],
                                        'dept_sect_csapit2' => ['label' => 'Dept. Head/ Sect. Head', 'name' => 'dept_sect_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'operator_csapit2' => ['label' => 'Operator', 'name' => 'operator_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'gl_csapit2' => ['label' => 'GL', 'name' => 'gl_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'spare_csapit2' => ['label' => 'Spare', 'name' => 'spare_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],
                                        'dept_sect_csapit3' => ['label' => 'Dept. Head/ Sect. Head', 'name' => 'dept_sect_csapit3', 'type' => 'text', 'category' => 'CSA PIT 3'],
                                        'operator_csapit3' => ['label' => 'Operator', 'name' => 'operator_csapit3', 'type' => 'text', 'category' => 'CSA PIT 3'],
                                        'gl_csapit3' => ['label' => 'GL', 'name' => 'gl_csapit3', 'type' => 'text', 'category' => 'CSA PIT 3'],
                                        'spare_csapit3' => ['label' => 'Spare', 'name' => 'spare_csapit3', 'type' => 'text', 'category' => 'CSA PIT 3'],
                                        'dept_sect_officeplant' => ['label' => 'Dept. Head/ Sect. Head', 'name' => 'dept_sect_officeplant', 'type' => 'text', 'category' => 'Office Plant'],
                                        'admin_officeplant' => ['label' => 'Admin', 'name' => 'admin_officeplant', 'type' => 'text', 'category' => 'Office Plant'],
                                        'gl_officecsapit1' => ['label' => 'GL', 'name' => 'gl_officecsapit1', 'type' => 'text', 'category' => 'Office CSA PIT 1'],
                                        'admin_officecsapit1' => ['label' => 'Admin', 'name' => 'admin_officecsapit1', 'type' => 'text', 'category' => 'Office CSA PIT 1'],
                                    ],
                                    'HCGA' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
                                        'pjo' => ['label' => 'PJO', 'name' => 'pjo', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'sect_head' => ['label' => 'Sect. Head', 'name' => 'sect_head', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'gl_hc' => ['label' => 'GL HC', 'name' => 'gl_hc', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'admin_hc' => ['label' => 'Admin HC', 'name' => 'admin_hc', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'admin_ga_plant' => ['label' => 'Admin GA', 'name' => 'admin_ga_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'helper_plant' => ['label' => 'Helper', 'name' => 'helper_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'security_plant' => ['label' => 'Security', 'name' => 'security_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'alpen' => ['label' => 'Alpen', 'name' => 'alpen', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'driver_plant' => ['label' => 'Driver', 'name' => 'driver_plant', 'type' => 'text', 'category' => 'OFFICE PLANT'],
                                        'security_spbi' => ['label' => 'Security', 'name' => 'security_spbi', 'type' => 'text', 'category' => 'SPBI'],
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
                                        'admin_ga_meicu' => ['label' => 'Admin GA', 'name' => 'admin_ga_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'gl_ga_meicu' => ['label' => 'GL GA', 'name' => 'gl_ga_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'security_meicu' => ['label' => 'Security', 'name' => 'security_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'driver_meicu' => ['label' => 'Driver', 'name' => 'driver_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'cv_ade' => ['label' => 'CV.ADE', 'name' => 'cv_ade', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'helper_meicu' => ['label' => 'Helper', 'name' => 'helper_meicu', 'type' => 'text', 'category' => 'OFFICE GA MEICU'],
                                        'laundry' => ['label' => 'Laundry', 'name' => 'laundry', 'type' => 'text', 'category' => 'LAUNDRY KARTIKA'],
                                    ],
                                    'PLANT' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
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
                                        'trakindo_workshop' => ['label' => 'Trakindo', 'name' => 'trakindo_workshop', 'type' => 'text', 'category' => 'WORKSHOP'],
                                        'backup_opp' => ['label' => 'Backup OPP', 'name' => 'backup_opp', 'type' => 'text', 'category' => 'WORKSHOP']
                                    ],
                                    'MESS_PUTRI' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
                                        'total' => ['label' => 'Total', 'name' => 'total','type' => 'text', 'category' => 'Total MK'],
                                    ],
                                    'MESS_MEICU' => [
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
                                        'total' => ['label' => 'Total', 'name' => 'total','type' => 'text', 'category' => 'Total MK'],
                                    ],
                                    'C3' => array_merge([
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],

                                    ],
                                    array_reduce(range(1, 20), function($carry, $i) {
                                        $carry["kamar_$i"] = ['label' => "Kamar $i", 'name' => "kamar_$i", 'type' => 'number', 'category' => 'Kamar'];
                                        return $carry;
                                    }, [])
                                    ),
                                    'A1' => array_merge([
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],

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
                                            'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
                                        ],
                                        array_combine(
                                            array_map(fn($i) => "kamar_$i", range(1, 32)),
                                            array_map(fn($i) => ['label' => "Kamar $i", 'name' => "kamar_$i", 'type' => 'number', 'category' => 'Kamar'], range(1, 32))
                                        )
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
                            <span class="badge rounded-pill text-bg-primary">Waiting Approval GA</span>
                        @elseif($catering->status == 2)
                            <span class="badge rounded-pill text-bg-info text-start">Validasi <br> GA/GL</span>
                        @endif
                    <td>
                    <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewcateringModal" data-id="{{ $catering->id }}"><i class="fa fa-expand"></i>View</a></li>
                        <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#cateringModal" data-id="{{ $catering->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                        <li><a class="dropdown-item delete" href="#" data-id="{{ $catering->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                    </ul>
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
    $('.truncate-text').each(function() {
        var maxLength = 100;
        var originalText = $(this).text();

        if (originalText.length > maxLength) {
            var truncatedText = originalText.substring(0, maxLength) + '...';
            $(this).text(truncatedText);
        }
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
                        'Office Plant': ['section', 'gl_ss6'],
                        'PITSTOP | MP SS6': ['mpss6_glss6', 'mpss6_sysdev', 'mpss6_driver'],
                        'CSA PIT 1 | MPICT': ['mpict_glict', 'mpict_engineer', 'mpict_driver'],
                        'Office Plant | MP CCR': ['mpccr_admccr', 'mpccr_asstmoco', 'mpccr_glmoco', 'mpccr_driver'],
                        'PIT 3 Container | PIT Control | MP CCR': ['mpccr_admccr_pit']
                    },
                    'ENG' : {
                        'TANGGAL': ['tanggal'],
                        'Office' : ['dept_head', 'sect_head', 'gl_eng', 'driver', 'crew_ssr', 'office_pldp'],
                        'CSA PIT 2' : ['drill', 'driver_drill','helper_survey', 'driver_survey', 'gl_survey', 'magang'],
                        'Warehouse' : ['warehouse_pldp']
                    },
                    'SHE': {
                        'TANGGAL': ['tanggal'],
                        'CSA PIT 1': ['dept_head', 'sect_head', 'gl_k3', 'dokter', 'gl_ert', 'gl_ko','medic', 'ert', 'admin', 'sample_makan', 'helper_hcga', 'crew_she','magang', 'driver', 'grounded', 'spare'],
                        'Mess Tambang': ['kontainer_medic']
                    },
                    'FALOG': {
                        'TANGGAL': ['tanggal'],
                        'WAREHOUSE': ['dept_head', 'sect_head', 'gl_fa', 'admin_fa','gl_logistik', 'admin_logistik', 'swi', 'vendor','spare', 'pldp','driver_fa_log'],
                        'KOPPA MART MESS TAMBANG': ['koperasi_mess'],
                        'WORKSHOP KOPERASI MESS TAMBANG': ['mechanic_koperasi'],
                        'FALOG': ['koperasi_office'],
                        'KOPPA MART OFFICE': ['opt_fuel_truck'],
                        'CSA FUEL': ['fuelman', 'gl', 'admin_fuel', 'spare_csa']
                    },
                    'PROD': {
                        'TANGGAL': ['tanggal'],
                        'Office Plant': ['dept_sect_officeplant', 'admin_officeplant'],
                        'CSA PIT 1': ['dept_sect_csapit1', 'operator_csapit1', 'gl_csapit1', 'spare_csapit1'],
                        'CSA PIT 2': ['dept_sect_csapit2', 'operator_csapit2', 'gl_csapit2', 'spare_csapit2'],
                        'CSA PIT 3': ['dept_sect_csapit3', 'operator_csapit3', 'gl_csapit3', 'spare_csapit3'],
                        'Office CSA PIT 1': ['gl_officecsapit1', 'admin_officecsapit1']
                    },
                    'HCGA': {
                        'TANGGAL': ['tanggal'],
                        'OFFICE PLANT': ['pjo', 'sect_head', 'gl_hc', 'admin_hc', 'admin_ga_plant', 'helper_plant', 'security_plant', 'alpen', 'driver_plant'],
                        'SPBI': ['security_spbi'],
                        'OFFICE GA MESS TAMBANG': ['admin_ga', 'gl_ga', 'electrical_ga', 'driver_mess', 'carpenter', 'gardener'],
                        'MEKANIK TRAC': ['mekanic_trac'],
                        'POS SECURITY MESS TAMBANG': ['security_pos', 'security_patrol', 'driver_lv_cuti'],
                        'MESS TAMBANG': ['helper_mess'],
                        'OFFICE GA MEICU': ['admin_ga_meicu', 'gl_ga_meicu', 'security_meicu', 'driver_meicu', 'cv_ade', 'helper_meicu'],
                        'LAUNDRY KARTIKA': ['laundry']
                    },
                    'PLANT': {
                        'TANGGAL': ['tanggal'],
                        'OFFICE PLANT': ['new_office', 'sect_head_plant', 'siswa_magang', 'base_control'],
                        'PITSTOP': ['dept_head_pitstop', 'sect_head_pitstop', 'wheel_ps', 'track', 'support', 'tyre', 'fabrikasi', 'tool_room', 'pldp',
                                    'fmdp_track', 'fmdp_wheel', 'fmdp_support', 'gmi_mercy', 'mastratech', 'trakindo', 'siswa_magang_pitstop',
                                    'new_hire', 'mutasi', 'driver', 'spare', 'congkelman_apn', 'training', 'vendor_plant_pitstop', 'office_pitstop',
                                    'plant_engineer'],
                        'WORKSHOP': ['dept_head', 'sect_head', 'wheel_ws_workshop', 'fabrikasi_workshop', 'planner', 'plant_engineer_workshop',
                                    'mastratech_workshop', 'fmdp_ws_workshop', 'siswa_magang_ws', 'driver_workshop', 'gmi', 'swi', 'track_ws',
                                    'spare_workshop', 'helper_workshop', 'trakindo_workshop'],
                        'CSA PIT 1': ['skill_up_lt'],
                    },
                    'A1': {
                        'TANGGAL': ['tanggal'],
                        'KAMAR': [
                            'kamar_1', 'kamar_2', 'kamar_3', 'kamar_4', 'kamar_5', 'kamar_6', 'kamar_7', 'kamar_8', 'kamar_9', 'kamar_10',
                            'kamar_11', 'kamar_12', 'kamar_13', 'kamar_14', 'kamar_15', 'kamar_16', 'kamar_17', 'kamar_18', 'kamar_19', 'kamar_20',
                            'kamar_21', 'kamar_22', 'kamar_23', 'kamar_24', 'kamar_25', 'kamar_26', 'kamar_27', 'kamar_28', 'kamar_29', 'kamar_30',
                            'kamar_31', 'kamar_32', 'kamar_33', 'kamar_34', 'kamar_35', 'kamar_36', 'kamar_37', 'kamar_38'
                        ]
                    },
                    'C3': {
                        'TANGGAL': ['tanggal'],
                        'KAMAR': [
                            'kamar_1', 'kamar_2', 'kamar_3', 'kamar_4', 'kamar_5', 'kamar_6', 'kamar_7', 'kamar_8', 'kamar_9', 'kamar_10',
                            'kamar_11', 'kamar_12', 'kamar_13', 'kamar_14', 'kamar_15', 'kamar_16', 'kamar_17', 'kamar_18', 'kamar_19', 'kamar_20'
                        ]
                    },
                    'MESS_PUTRI': {
                        'TANGGAL': ['tanggal'],
                        'MEKILO': [
                            'total'
                        ]
                    },
                    'MESS_MEICU': {
                        'TANGGAL': ['tanggal'],
                        'MEKILO': [
                            'total'
                        ]
                    },
                };

                // Loop untuk menambahkan B1 sampai B10
                for (let i = 1; i <= 10; i++) {
                    customLabels[`B${i}`] = {
                        'TANGGAL': ['tanggal'],
                        'KAMAR': Array.from({ length: 38 }, (_, j) => `kamar_${j + 1}`)
                    };
                }


                let placeLabels = {
                    'admin_fuel': 'ADMIN',
                    'spare_csa': 'SPARE',
                    'dept_sect_officeplant': 'Dept. Head/ Sect. Head',
                    'admin_officeplant': 'Admin',
                    'dept_sect_csapit1': 'Dept. Head/ Sect. Head',
                    'operator_csapit1': 'Operator',
                    'gl_csapit1': 'GL',
                    'spare_csapit1': 'Spare',
                    'dept_sect_csapit2': 'Dept. Head/ Sect. Head',
                    'operator_csapit2': 'Operator',
                    'gl_csapit2': 'GL',
                    'spare_csapit2': 'Spare',
                    'dept_sect_csapit3': 'Dept. Head/ Sect. Head',
                    'operator_csapit3': 'Operator',
                    'gl_csapit3': 'GL',
                    'spare_csapit3': 'Spare',
                    'gl_officecsapit1': 'GL',
                    'admin_officecsapit1': 'Admin',
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
                    'driver_meicu': 'DRIVER',
                    'helper_meicu': 'HELPER',
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

                // Kelompokkan berdasarkan Waktu
                let mergedData = {};
                rows.forEach(row => {
                    let key = row.waktu;
                    if (!mergedData[key]) {
                        mergedData[key] = [];
                    }
                    mergedData[key].push(row);
                });

                // Render tabel dengan merge row untuk kolom Waktu
                Object.keys(mergedData).forEach(waktu => {
                    let group = mergedData[waktu];
                    let firstRow = true;
                    let totalRowSpan = group.length;

                    group.forEach((row, rowIndex) => {
                        let tr = `<tr>`;

                        // Merge kolom Waktu hanya pada baris pertama grup
                        if (firstRow) {
                            tr += `<td rowspan="${totalRowSpan}">${row.waktu}</td>`;
                        }

                        // Merge kolom Kategori hanya pada perubahan kategori dalam grup
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
                    'mpccr_admccr_pit': 'mpccr_admccr_pit'
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
                    'laundry': 'laundry'
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
                    'drill' : 'drill',
                    'driver_drill' : 'driver_drill',
                    'helper_survey' : 'helper_survey',
                    'driver_survey' : 'driver_survey',
                    'gl_survey' : 'gl_survey',
                    'magang' : 'magang',
                    'warehouse_pldp' : 'warehouse_pldp'
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
                    'kontainer_medic': 'kontainer_medic'
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
                    'driver_fa_log': 'driver_fa_log'
                },
                'PROD': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'dept_sect_csapit1': 'dept_sect_csapit1',
                    'dept_sect_csapit2': 'dept_sect_csapit2',
                    'dept_sect_csapit3': 'dept_sect_csapit3',
                    'operator_csapit1': 'operator_csapit1',
                    'gl_csapit1': 'gl_csapit1',
                    'spare_csapit1': 'spare_csapit1',
                    'operator_csapit2': 'operator_csapit2',
                    'gl_csapit2': 'gl_csapit2',
                    'spare_csapit2': 'spare_csapit2',
                    'operator_csapit3': 'operator_csapit3',
                    'gl_csapit3': 'gl_csapit3',
                    'spare_csapit3': 'spare_csapit3',
                    'dept_sect_officeplant': 'dept_sect_officeplant',
                    'admin_officeplant': 'admin_officeplant',
                    'gl_officecsapit1': 'gl_officecsapit1',
                    'admin_officecsapit1': 'admin_officecsapit1'
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
                    'backup_opp': 'backup_opp'
                },
                'A1': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    ...Object.fromEntries(Array.from({ length: 38 }, (_, i) => [`kamar_${i + 1}`, `kamar_${i + 1}`]))
                },
                'C3': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    ...Object.fromEntries(Array.from({ length: 20 }, (_, i) => [`kamar_${i + 1}`, `kamar_${i + 1}`]))
                },
                'MESS_PUTRI' : {
                    'tanggal' : 'tanggal',
                    'waktu' : 'waktu',
                    'total' : 'total',
                },
                'MESS_MEICU' : {
                    'tanggal' : 'tanggal',
                    'waktu' : 'waktu',
                    'total' : 'total',
                },
            };

            for (let i = 1; i <= 10; i++) {
                customLabels[`B${i}`] = {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
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


$(document).ready(function() {
    $(document).on('click', '#btn-yes-add', function(event) {
        //event.preventDefault();

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
                    // }).then(() => {
                    //     $('#cateringModal').modal('hide');
                    //     $('#cateringModal').find('input, textarea, select').val('');

                    // });
                }).then(() => {
                       location.reload();
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

</script>


@endsection

