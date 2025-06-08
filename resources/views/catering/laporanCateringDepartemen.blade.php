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
              <br>

              <form method="GET" action="{{ route('lapcateringdept.lapcateringdept') }}" class="mb-3 form-responsive">
                <div class="row">
                    <div class="col-md-2">
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', now()->addDay()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', now()->addDay()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-1">
                        <select class="form-control" id="departemen" name="departemen">
                            <option value="HCGA" selected>Pilih Area</option>
                        </select>
                    </div>
                    <div class="col-md-auto d-flex gap-1">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    </div>
                    <div class="col-md-auto d-flex gap-1">
                        <button type="button" class="btn btn-primary bi bi-plus btn-sm"
                            data-bs-toggle="modal" data-bs-target="#cateringModal">
                            Add MK Reguler
                        </button>
                    </div>

                     <div class="col-md-auto d-flex gap-1">
                        <button type="button" class="btn btn-primary bi bi-plus btn-sm"
                            data-bs-toggle="modal" data-bs-target="#cateringSnackModal">
                            Add Snack
                        </button>
                    </div>

                    <div class="col-md-auto d-flex gap-1">
                        <button type="button" class="btn btn-primary bi bi-plus btn-sm"
                            data-bs-toggle="modal" data-bs-target="#cateringSpesialModal">
                            Add MK Spesial
                        </button>
                    </div>


                </div>
               </form>

               {{-- TABS --}}
                <ul class="nav nav-tabs mt-4" id="cateringTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="reguler-tab" data-bs-toggle="tab" data-bs-target="#reguler" type="button" role="tab" aria-controls="reguler" aria-selected="true">
                        MK Reguler
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="spesial-tab" data-bs-toggle="tab" data-bs-target="#spesial" type="button" role="tab" aria-controls="spesial" aria-selected="false">
                        MK Spesial
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="snack-tab" data-bs-toggle="tab" data-bs-target="#snack" type="button" role="tab" aria-controls="snack" aria-selected="false">
                        Snack
                    </button>
                    </li>
                </ul>

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

                <!-- Modal View Data Snack-->
                <div class="modal fade modal-view" id="viewsnackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Detail Data Snack</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Waktu</th>
                                            <th>Area</th>
                                            <th>Gedung</th>
                                            <th>Lokasi</th>
                                            <th>Jenis</th>
                                            <th>Total</th>
                                            <th>Catering</th>
                                            <th>Harga</th>
                                            <th>Revisi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="viewDataSnack">
                                        <!-- Data akan diisi dengan JavaScript -->
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal View Data Spesial-->
                <div class="modal fade modal-view" id="viewspesialModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Detail Data Spesial</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Waktu</th>
                                            <th>Area</th>
                                            <th>Gedung</th>
                                            <th>Lokasi</th>
                                            <th>Jenis</th>
                                            <th>Total</th>
                                            <th>Catering</th>
                                            <th>Harga</th>
                                            <th>Revisi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="viewDataSpesial">

                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add MK REGULAR -->
                <div class="modal fade modal_add" id="cateringModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mode="add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="btn-add">Add MK Catering Reguler</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(in_array(request('departemen'), [
                            'COE', 'HCGA', 'ENG', 'SHE', 'FALOG', 'PROD', 'PLANT',
                            'Mess A1', 'Mess C3', 'MESS_MEICU', 'Mess Putri','MESS','AMM'
                        ]))

                        <form id="cateringForm" class="row g-3 needs-validation">
                            @csrf

                            <input type="hidden" name="table_name" value="{{ $tableName ?? '' }}">
                            <input type="hidden" name="departemen" value="{{ request('departemen') }}">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="copyPreviousData">
                                    <label class="form-check-label" for="copyPreviousData">
                                        Apakah data sama seperti sebelumnya?
                                    </label>
                                </div>
                            </div>
                            @php
                               // $userTeam = auth()->user()->tim_pic;
                               $userTeam = request('departemen');
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
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Pagi','Siang','Sore','Malam','Tambahan Pagi','Tambahan Siang','Tambahan Sore','Tambahan Malam'], 'category' => 'Waktu'],
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
                                        'warehouse_pldp' => ['label' => 'PLDP', 'name' => 'warehouse_pldp', 'type' => 'text','category' => 'CSA PIT 2'],
                                        'pitcontrol' => ['label' => 'PIT CONTROL', 'name' => 'pitcontrol', 'type' => 'text','category' => 'CSA PIT 3'],
                                        'gl_civil' => ['label' => 'GL CIVIL', 'name' => 'gl_civil', 'type' => 'text','category' => 'Mess Tambang'],
                                        'vendor_jmi' => ['label' => 'Vendor JMI', 'name' => 'vendor_jmi', 'type' => 'text','category' => 'CSA HRM'],
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
                                        'training_csapit2' => ['label' => 'Ruang Training CSA PIT 2', 'name' => 'training_csapit2', 'type' => 'text', 'category' => 'CSA PIT 2'],

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
                                        'marbot_kaustar' => ['label' => 'Marbot Al-Kaustar', 'name' => 'marbot_kaustar', 'type' => 'text', 'category' => 'MARBOT'],
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

                                        'rebusan_b7' => ['label' => 'Rebusan B7', 'name' => 'rebusan_b7', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b8' => ['label' => 'Rebusan B8', 'name' => 'rebusan_b8', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b9' => ['label' => 'Rebusan B9', 'name' => 'rebusan_b9', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'rebusan_b10' => ['label' => 'Rebusan B10', 'name' => 'rebusan_b10', 'type' => 'text', 'category' => 'REBUSAN'],
                                        'spare_mess' => ['label' => 'Spare', 'name' => 'spare_mess', 'type' => 'text', 'category' => 'MK Spare']
                                    ],
                                    'Mess Putri' => [
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
                                    'Mess C3' => array_merge([
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
                                        'rebusan_c3' => ['label' => 'Rebusan', 'name' => 'rebusan_c3', 'type' => 'text', 'category' => 'Tambahan'],
                                        'spare_c3' => ['label' => 'Spare', 'name' => 'spare_c3', 'type' => 'text', 'category' => 'Tambahan'],
                                        'visitor_c3' => ['label' => 'Visitor', 'name' => 'visitor_c3', 'type' => 'text', 'category' => 'Tambahan']
                                    ],
                                    array_reduce(range(1, 20), function($carry, $i) {
                                        $carry["kamar_$i"] = ['label' => "Kamar $i", 'name' => "kamar_$i", 'type' => 'number', 'category' => 'Kamar'];
                                        return $carry;
                                    }, [])
                                    ),
                                    'Mess A1' => array_merge([
                                        'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                        'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
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
                                    array_map(fn($b) => "Mess B$b", range(1, 10)),
                                    array_fill(0, 10, array_merge(
                                        [
                                            'tanggal' => ['label' => 'Tanggal', 'name' => 'tanggal', 'type' => 'date', 'category' => 'Waktu'],
                                            'waktu' => ['label' => 'Waktu', 'name' => 'waktu', 'type' => 'select', 'options' => ['Silahkan Pilih Waktu', 'Pagi', 'Siang', 'Sore', 'Malam', 'Tambahan'], 'category' => 'Waktu'],
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

                <!-- Modal Add SNACK sekar-->
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
                            <form id="cateringSnackForm" class="row g-3 needs-validation" method="POST" enctype="multipart/form-data" accept="image/*" capture="environment">
                            @csrf
                            <div class="row mt-4">
                                <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="tanggal_snack_add" name="tanggal_snack_add" placeholder="Tanggal">
                                    <label for="message-text">Tanggal </label>
                                </div>
                                </div>
                                <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="departemen_snack_add" name="departemen_snack_add">
                                                <option value=""> - Pilih Departemen - </option>
                                                <option value="COE">COE</option>
                                                <option value="FALOG">FA-LOG</option>
                                                <option value="ENG">ENG</option>
                                                <option value="HCGA">HCGA</option>
                                                <option value="PRO">PRODUKSI</option>
                                                <option value="PLANT">PLANT</option>
                                                <option value="SHE">SHE</option>
                                            </select>
                                            <label>Departemen</label>
                                        </div>
                                    </div>
                            </div>
                            <div id="snack-container">
                            <div class="snack-group">
                                <!-- Baris 1 -->
                                <div class="row mt-3 snack-item">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select" name="waktu_snack_add[]">
                                                <option value=""> - Pilih Waktu - </option>
                                                <option value="Pagi">Pagi</option>
                                                <option value="Siang">Siang</option>
                                                <option value="Sore">Sore</option>
                                                <option value="Malam">Malam</option>
                                            </select>
                                            <label>Waktu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-control" id="area_snack_add[]" name="area_snack_add[]">
                                        <option value="">Pilih Area</option>
                                        <option value="Mess">MESS</option>
                                        <option value="Office">Office</option>
                                        <option value="CSA 1">CSA 1</option>
                                        <option value="CSA 2">CSA 2</option>
                                        <option value="CSA 3">CSA 3</option>
                                        <option value="CSA FUEL">CSA FUEL</option>
                                        <option value="PITSTOP">PITSTOP</option>
                                        <option value="OTHER">Lainnya</option>
                                    </select>

                                    <label for="area_snack_add">Area</label>
                                </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-control" id="gedung_snack_add[]" name="gedung_snack_add[]">
                                        <option value="">Pilih Gedung</option>
                                    </select>
                                    <label for="gedung_snack_add">Gedung</label>
                                </div>

                                </div>
                                <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="lokasi_snack_add[]" name="lokasi_snack_add[]" placeholder="Lokasi">
                                    <label for="message-text">Lokasi</label>
                                </div>
                                </div>

                                </div>

                                <!-- Baris 2 -->
                                <div class="row mt-3 mb-3 g-3 snack-item">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select" name="snack_add[]">
                                                <option value="">- Pilih Snack -</option>
                                                <option value="Snack Biasa">Snack Biasa</option>
                                                <option value="Snack Spesial">Snack Spesial</option>
                                                <option value="Parcel Buah Biasa">Parcel Buah Biasa</option>
                                                <option value="Parcel Buah Spesial">Parcel Buah Spesial</option>
                                                <option value="Pempek">Pempek</option>
                                                <option value="Kopi">Kopi Iglo</option>
                                                <option value="Teh">Teh Iglo</option>
                                                <option value="Wedang Jahe">Wedang Jahe</option>
                                                <option value="Aqua Cup 220 ml">Aqua Cup 220 ml</option>
                                                <option value="Aqua botol 330 ml">Aqua botol 330 ml</option>
                                                <option value="Aqua botol 660 ml">Aqua botol 660 ml</option>
                                            </select>
                                            <label>Mk Snack</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="jumlah_snack_add[]" placeholder="Jumlah">
                                            <label>Jumlah</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select" name="catering_snack_add[]">
                                                <option value="">- Pilih Catering -</option>
                                                <option value="Fitri">Catering Fitri</option>
                                                <option value="Bintang">Catering Bintang</option>
                                                <option value="Wastu">Catering Wastu</option>
                                            </select>
                                            <label>Catering</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="harga_snack_add[]" placeholder="Harga">
                                            <label>Harga</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="keterangan_snack_add[]" placeholder="Keterangan" style="height: 100px"></textarea>
                                            <label>Keterangan Meeting</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Garis pemisah -->
                                <hr class="snack-item mt-3">
                            </div>
                        </div>

                        {{-- <div class="add-snack-line mt-3">
                            <div class="minus-icon" id="remove-snack-btn">-</div>
                            <div class="line"></div>
                            <div class="plus-icon" id="add-snack-btn">+</div>
                        </div> --}}

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

                {{-- -- Modal Add MK Spesial sekar--> --}}
                <div class="modal fade modal_add_snack" id="cateringSpesialModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mode="add">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="btn-add">Add MK Spesial</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> --}}
                            <input type="hidden" name="id" id="id"/>
                            <form id="cateringSpesialForm" class="row g-3 needs-validation" method="POST" enctype="multipart/form-data" accept="image/*" capture="environment">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="tanggal_spesial_add" name="tanggal_spesial_add" placeholder="Tanggal">
                                    <label for="message-text">Tanggal </label>
                                </div>
                                </div>
                                <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select" id="departemen_spesial_add" name="departemen_spesial_add">
                                                <option value=""> - Pilih Departemen - </option>
                                                <option value="COE">COE</option>
                                                <option value="FALOG">FA-LOG</option>
                                                <option value="ENG">ENG</option>
                                                <option value="HCGA">HCGA</option>
                                                <option value="PRO">PRODUKSI</option>
                                                <option value="PLANT">PLANT</option>
                                                <option value="SHE">SHE</option>
                                            </select>
                                            <label>Departemen</label>
                                        </div>
                                    </div>
                            </div>
                            <div id="spesial-container">
                            <div class="spesial-group">
                                <!-- Baris 1 -->
                                <div class="row mt-3 spesial-item">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select" name="waktu_spesial_add[]">
                                                <option value=""> - Pilih Waktu - </option>
                                                <option value="Pagi">Pagi</option>
                                                <option value="Siang">Siang</option>
                                                <option value="Sore">Sore</option>
                                                <option value="Malam">Malam</option>
                                            </select>
                                            <label>Waktu</label>
                                        </div>
                                    </div>
                                 <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-control" id="area_spesial_add[]" name="area_spesial_add[]">
                                        <option value="">Pilih Area</option>
                                        <option value="Mess">MESS</option>
                                        <option value="Office">Office</option>
                                        <option value="CSA 1">CSA 1</option>
                                        <option value="CSA 2">CSA 2</option>
                                        <option value="CSA 3">CSA 3</option>
                                        <option value="CSA FUEL">CSA FUEL</option>
                                        <option value="PITSTOP">PITSTOP</option>
                                        <option value="OTHER">Lainnya</option>
                                    </select>

                                    <label for="area_spesial_add">Area</label>
                                </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-control" id="gedung_spesial_add[]" name="gedung_spesial_add[]">
                                        <option value="">Pilih Gedung</option>
                                    </select>
                                    <label for="gedung_spesial_add">Gedung</label>
                                </div>

                                </div>
                                <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="lokasi_spesial_add[]" name="lokasi_spesial_add[]" placeholder="Lokasi">
                                    <label for="message-text">Lokasi</label>
                                </div>
                                </div>

                                </div>

                                <!-- Baris 2 -->
                                <div class="row mt-3 mb-3 g-3 spesial-item">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                        <select class="form-select" name="spesial_add[]">
                                            <option value="">- Pilih MK Spesial -</option>
                                            <option value="MK Spesial">MK Spesial</option>
                                            <option value="Nasi Liwet">Nasi Liwet</option>
                                            <option value="Ayam Bakar">Ayam Bakar</option>
                                            <option value="Prasmanan">Prasmanan</option>
                                        </select>
                                        <label>Mk Spesial</label>
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="jumlah_spesial_add[]" placeholder="Jumlah">
                                            <label>Jumlah</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-select" name="catering_spesial_add[]">
                                                <option value="">- Pilih Catering -</option>
                                                <option value="Fitri">Catering Fitri</option>
                                                <option value="Bintang">Catering Bintang</option>
                                                <option value="Wastu">Catering Wastu</option>
                                            </select>
                                            <label>Catering</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="harga_spesial_add[]" placeholder="Harga">
                                            <label>Harga</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="keterangan_spesial_add[]" placeholder="Keterangan" style="height: 100px"></textarea>
                                            <label>Keterangan Meeting</label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="spesial-item mt-3">
                            </div>
                        </div>
                        {{--
                        <div class="add-spesial-line mt-3">
                            <div class="minus-icon" id="remove-spesial-btn">-</div>
                            <div class="line"></div>
                            <div class="plus-icon" id="add-spesial-btn">+</div>
                        </div> --}}

                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-yes-add-spesial">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <div id="loading-spinner" >
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal Add --}}


                <!--begin::Modal Revisi GA GL-->
                <div class="modal fade modal_revisi" id="revisiModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Revisi Complain</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="kt-form kt-form--label-right form_revisi" action="/catering/revisi"  method="POST" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <label for="message-text" class="form-control-label">Pesan Revisi <span style="color:red">*</span></label>
                                        <textarea class="form-control" id="revisi" name="revisi" rows="8"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn-yes-revisi">Kirim</button>
                                <div id="loading-spinner" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal Revisi-->

                <!--begin::Revisi SNACK-->
                <div class="modal fade modal_snack" id="revisisnackModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Revisi Snack</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="kt-form kt-form--label-right form_revisi_snack" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <label for="message-text" class="form-control-label">Keterangan Revisi <span style="color:red">*</span></label>
                                        <textarea class="form-control" id="revisisnack" name="revisisnack" rows="8"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn-yes-revisi-snack">Kirim</button>
                                <div id="loading-spinner" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal Revisi-->

                 <!--begin::Revisi SPESIAL-->
                <div class="modal fade modal_spesial" id="revisispesialModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Revisi Spesial</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="kt-form kt-form--label-right form_revisi_spesial" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <label for="message-text" class="form-control-label">Keterangan Revisi <span style="color:red">*</span></label>
                                        <textarea class="form-control" id="revisispesial" name="revisispesial" rows="8"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn-yes-revisi-spesial">Kirim</button>
                                <div id="loading-spinner" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal Revisi-->

                <!--begin::Modal Done GA/GL-->
                <div class="modal fade modal_validasi" id="approvalModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Approval</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="kt-form kt-form--label-right form_approval" action="/catering/validasigagl" method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <!-- Input Kategori -->
                                <div class="form-group">
                                    <label for="kategori" class="form-control-label" style="font-size: smaller;">Keterangan <span style="color:red">*</span></label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                </div>

                            </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn-yes-approval">Kirim</button>
                                <div id="loading-spinner-approval" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal Validasi Crew-->

                <!--begin::Modal Approve Snack-->
                <div class="modal fade modal_validasi" id="approvalSnackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form class="kt-form kt-form--label-right form_approvalsnack" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="catering_snack_approve">
                                <option value="">- Pilih Catering -</option>
                                <option value="Fitri">Catering Fitri</option>
                                <option value="Bintang">Catering Bintang</option>
                                <option value="Wastu">Catering Wastu</option>
                                </select>
                                <label>Catering</label>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="harga_snack_approve" placeholder="Harga">
                                <label>Harga</label>
                            </div>
                            </div>
                        </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-yes-approvalsnack">Kirim</button>
                        <div id="loading-spinner-approvalsnack" style="display:none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <!--end::Modal Approve Snack-->

                <!--begin::Modal Approve Spesial-->
                <div class="modal fade modal_validasi" id="approvalSpesialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form class="kt-form kt-form--label-right form_approvalspesial" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="catering_spesial_approve">
                                <option value="">- Pilih Catering -</option>
                                <option value="Fitri">Catering Fitri</option>
                                <option value="Bintang">Catering Bintang</option>
                                <option value="Wastu">Catering Wastu</option>
                                </select>
                                <label>Catering</label>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="harga_spesial_approve" placeholder="Harga">
                                <label>Harga</label>
                            </div>
                            </div>
                        </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-yes-approvalspesial">Kirim</button>
                        <div id="loading-spinner-approvalspesial" style="display:none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <!--end::Modal Approve Snack-->

                <!-- Table with stripped rows -->
            <div class="tab-content" id="cateringTabsContent">
                    <!-- Reguler Tab -->
                <div class="tab-pane fade show active" id="reguler" role="tabpanel" aria-labelledby="reguler-tab">
                <div class="table-responsive">
                    <table class="table dt_catering responsive" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Total Order</th>
                                <th scope="col">Total Order Sebelumnya</th>
                                <th scope="col">Visitor</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cateringData as $no => $catering)
                            <tr>
                                <td>
                                    <input type="checkbox" class="rowCheckbox" value="{{ $catering->id }}">
                                </td>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $catering->tanggal }}</td>
                                <td>{{ $catering->created_name }}</td>
                                <td>{{ $catering->waktu}}</td>
                                <td>{{ $catering->total}}</td>
                                <td>{{ $catering->total_hari_sebelumnya}}</td>
                                <td class="truncate-text">{{ $catering->visitor }}</td>
                                <td>
                                    @if($catering->status == 1)
                                        <span class="badge rounded-pill text-bg-info">Waiting Approval GA</span>
                                    @elseif($catering->status == 2)
                                        <span class="badge rounded-pill text-bg-success text-start">On Catering</span>
                                    @elseif($catering->status == 3)
                                        <span class="badge rounded-pill text-bg-warning text-start">Revisi</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewcateringModal" data-id="{{ $catering->id }}"><i class="fa fa-expand"></i> View</a></li>
                                            <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#cateringModal" data-id="{{ $catering->id }}"><i class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                            <li><a class="dropdown-item delete" href="#" data-id="{{ $catering->id }}"><i class="fa-solid fa-trash"></i> Delete</a></li>
                                            <li><a class="dropdown-item approval" href="#" data-bs-toggle="modal" data-bs-target="#approvalModalgagl" data-id="{{ $catering->id }}"><i class="fa-regular fa-square-check"></i> Approve</a></li>
                                            <li><a class="dropdown-item revisi" href="#" data-bs-toggle="modal" data-bs-target="#revisiModalgagl" data-id="{{ $catering->id }}"><i class="fa-regular fa-message"></i> Revisi</a></li>
                                            <li><a class="dropdown-item send" href="#" data-id="{{ $catering->id }}"><i class="fa-regular fa-paper-plane"></i>Kirim Revisi</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button id="btnApproveSelected" class="btn btn-danger mt-3">Approve Selected</button>
                </div>

                <!-- Spesial Tab -->
                    <div class="tab-pane fade" id="spesial" role="tabpanel" aria-labelledby="spesial-tab">
                        <div class="table-responsive">
                        <table class="table dt_spesial responsive datatable" id='datatable'>
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Area</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Total</th>
                                <th scope="col">Catering</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- //sekar --}}
                            @foreach($spesialData as $no => $spesial)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $spesial->tanggal}}</td>
                                <td>{{ $spesial->departemen}}</td>
                                <td>{{ $spesial->waktu}}</td>
                                <td>{{ $spesial->area}}</td>
                                <td>{{ $spesial->lokasi}}</td>
                                <td>{{ $spesial->jenis}}</td>
                                <td>{{ $spesial->jumlah}}</td>
                                <td>{{ $spesial->catering}}</td>
                                <td>{{ $spesial->harga}}</td>
                                <td>
                                    @if($spesial->status == 1)
                                        <span class="badge rounded-pill text-bg-info">Waiting Approval GA</span>
                                    @elseif($spesial->status == 2)
                                        <span class="badge rounded-pill text-bg-success text-start">On Catering</span>
                                    @elseif($spesial->status == 3)
                                        <span class="badge rounded-pill text-bg-warning text-start">Revisi</span>
                                    @endif
                                <td>
                                <div class="dropdown">
                                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item viewspesial" href="#" data-bs-toggle="modal" data-bs-target="#viewspesialModal" data-id="{{ $spesial->id }}"><i class="fa fa-expand"></i>View</a></li>
                                    <li><a class="dropdown-item editspesial" href="#" data-bs-toggle="modal" data-bs-target="#cateringSpesialModal" data-id="{{ $spesial->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                    <li><a class="dropdown-item deletespesial" href="#" data-id="{{ $spesial->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                                    <li><a class="dropdown-item approvalspesial" href="#" data-bs-toggle="modal" data-bs-target="#approvalSpesialModal" data-id="{{ $spesial->id }}"><i class="fa-regular fa-pen-to-square"></i>Approval</a></li>
                                    <li><a class="dropdown-item revisispesial" href="#" data-bs-toggle="modal" data-bs-target="#revisispesialModalgagl" data-id="{{ $spesial->id }}"><i class="fa-regular fa-message"></i> Revisi</a></li>
                                    {{-- <li><a class="dropdown-item sendrevisi" href="#" data-id="{{ $spesial->id }}"><i class="fa-regular fa-paper-plane"></i>Kirim Revisi</a></li> --}}
                                </ul>

                            </tr>
                            @endforeach 

                        </tbody>
                        </table>
                        </div>
                    </div>

                    <!-- Snack Tab -->
                    <div class="tab-pane fade" id="snack" role="tabpanel" aria-labelledby="snack-tab">
                        <div class="table-responsive">
                        <table class="table dt_snack responsive datatable" id='datatable'>
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Area</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Total</th>
                                <th scope="col">Catering</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- //sekar --}}
                            @foreach($snackData as $no => $snack)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $snack->tanggal}}</td>
                                <td>{{ $snack->departemen}}</td>
                                <td>{{ $snack->waktu}}</td>
                                <td>{{ $snack->area}}</td>
                                <td>{{ $snack->lokasi}}</td>
                                <td>{{ $snack->jenis}}</td>
                                <td>{{ $snack->jumlah}}</td>
                                <td>{{ $snack->catering}}</td>
                                <td>{{ $snack->harga}}</td>
                                <td>
                                    @if($snack->status == 1)
                                        <span class="badge rounded-pill text-bg-info">Waiting Approval GA</span>
                                    @elseif($snack->status == 2)
                                        <span class="badge rounded-pill text-bg-success text-start">On Catering</span>
                                    @elseif($snack->status == 3)
                                        <span class="badge rounded-pill text-bg-warning text-start">Revisi</span>
                                    @endif
                                <td>
                                <div class="dropdown">
                                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item viewsnack" href="#" data-bs-toggle="modal" data-bs-target="#viewsnackModal" data-id="{{ $snack->id }}"><i class="fa fa-expand"></i>View</a></li>
                                    <li><a class="dropdown-item editsnack" href="#" data-bs-toggle="modal" data-bs-target="#cateringSnackModal" data-id="{{ $snack->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                    <li><a class="dropdown-item deletesnack" href="#" data-id="{{ $snack->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>
                                    <li><a class="dropdown-item approvalsnack" href="#" data-bs-toggle="modal" data-bs-target="#approvalSnackModal" data-id="{{ $snack->id }}"><i class="fa-regular fa-pen-to-square"></i>Approve</a></li>
                                    <li><a class="dropdown-item revisisnack" href="#" data-bs-toggle="modal" data-bs-target="#revisisnackModalgagl" data-id="{{ $snack->id }}"><i class="fa-regular fa-message"></i> Revisi</a></li>
                                    {{-- <li><a class="dropdown-item sendrevisisnack" href="#" data-id="{{ $snack->id }}"><i class="fa-regular fa-paper-plane"></i>Kirim Revisi</a></li> --}}
                                </ul>
                            </tr>
                            @endforeach

                        </tbody>
                        </table>
                        </div>
                    </div>
            <div>
                <!-- Tombol Approval -->


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

document.addEventListener("DOMContentLoaded", function () {
    // Set tanggal default ke besok jika tidak ada nilai request
    let startDateInput = document.getElementById("start_date");
    let endDateInput = document.getElementById("end_date");

    if (!startDateInput.value) {
        let tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        let tomorrowStr = tomorrow.toISOString().split('T')[0];

        startDateInput.value = tomorrowStr;
        endDateInput.value = tomorrowStr;
    }

    // Isi dropdown departemen
    const departemenList = [
        "COE", "HCGA", "ENG", "FALOG", "PROD", "PLANT", "SHE",
        "Mess Putri", "MESS_MEICU","AMM", "MESS"
    ];

    const select = document.getElementById("departemen");
    let selectedDepartemen = "{{ request('departemen', 'HCGA') }}"; // Ambil dari request atau default ke HCGA

    select.innerHTML = ""; // Kosongkan dulu

    departemenList.forEach(dept => {
        const option = document.createElement("option");
        option.value = dept;
        option.textContent = dept;
        if (dept === selectedDepartemen) {
            option.selected = true;
        }
        select.appendChild(option);
    });
});

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
                        'Office' : ['dept_head', 'sect_head', 'gl_eng', 'driver', 'crew_ssr', 'office_pldp', 'admin_office'],
                        'CSA PIT 2' : ['drill', 'driver_drill','helper_survey', 'driver_survey', 'gl_survey', 'magang', 'warehouse_pldp'],
                        //'Warehouse' : ['warehouse_pldp'],
                        'CSA PIT 3' : ['pitcontrol'],
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
                        'CSA PIT 2': ['dept_sect_csapit2', 'operator_csapit2', 'gl_csapit2', 'spare_csapit2', 'admin_csapit2','driverlv_csapit2','training_csapit2'],
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
                        'MESS TAMBANG': ['helper_mess', 'driver_bus','driver_bus_jumat_mess'],
                        'OFFICE GA MEICU': ['admin_ga_meicu', 'gl_ga_meicu', 'security_meicu', 'driver_meicu', 'cv_ade', 'helper_meicu','bagong', 'vendor_meicu', 'visitor_meicu'],
                        'LAUNDRY KARTIKA': ['laundry', 'security_laundry'],
                        'SECURITY' : ['security_pit1', 'security_pit3', 'security_anjungan'],
                        'MARBOT': ['marbot','marbot_kaustar'],
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
                                    'spare_workshop', 'helper_workshop', 'trakindo_workshop','backup_opp'],
                        'CSA PIT 1': ['skill_up_lt'],
                        'Vendor/Tamu': ['visitor']
                    },
                    'MARBOT': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'LAUNDRY KARTIKA': ['marbot', 'total_laundry', 'security_laundry']
                    },
                    'Mess A1': {
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
                    'Mess C3': {
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
                            'mess_b1', 'mess_b2', 'mess_b3', 'mess_b4', 'mess_b7', 'mess_b8', 'mess_b9', 'mess_b10', 'spare_amm',
                        ],
                    },
                    'MESS': {
                        'TANGGAL': ['tanggal'],
                        'REVISI': ['revisi_desc'],
                        'TOTAL': ['total'],
                        'MK': [
                            'mess_a1','mess_a2','mess_c3','mess_b1', 'mess_b2', 'mess_b3', 'mess_b4',
                            'mess_b7', 'mess_b8', 'mess_b9', 'mess_b10', 'spare_mess',
                        ],
                        'REBUSAN': [
                            'rebusan_b1', 'rebusan_b2', 'rebusan_b3', 'rebusan_b4',
                            'rebusan_b7', 'rebusan_b8', 'rebusan_b9', 'rebusan_b10','rebusan_a1','rebusan_a2','rebusan_c3'
                        ],
                    },
                    'Mess Putri': {
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
                    customLabels[`Mess B${i}`] = {
                        'TANGGAL': ['tanggal'],
                        'TOTAL': ['total'],
                        'KAMAR': Array.from({ length: 38 }, (_, j) => `kamar_${j + 1}`),
                        'TAMBAHAN': ['rebusan', 'spare','visitor'],
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
                    'security_pit1': 'SECURITY PIT 2 ROSELA',
                    'security_pit3': 'SECURITY PIT 3',
                    'driver_meicu': 'DRIVER',
                    'helper_meicu': 'HELPER',

                    //COE
                    'mpccr_admccr' : 'ADMIN',

                    'warehouse_pldp' : 'PLDP',

                    'trakindo_workshop' : 'INDOPARTA'
                };

                function formatLabel(text) {
                    return text.replace(/_/g, ' ').toUpperCase();
                }
    $.ajaxSetup({ cache: false });
    var cateringId;
    $('.view').click(function () {
        let cateringId = $(this).data('id');
        let departemen = $('#departemen').val();

        $.ajax({
            type: 'GET',
            url: '{{ url('/lapcateringdept/get') }}/' + cateringId,
            data: {
                departemen: departemen,
                _: new Date().getTime()
            },
            success: function (response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }

                let userTeam = departemen; // Gunakan departemen yang dipilih user


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



var cateringId;
$('.edit').click(function() {
    cateringId = $(this).data('id');
    let departemen = $('#departemen').val();
    console.log(departemen);
    $('#cateringModal').attr({
        'data-mode': 'edit',
        'data-id': cateringId
    });

    $.ajax({
        type: 'GET',
        url: '/lapcateringdept/get/' + cateringId,
        data: { departemen: departemen },
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            console.log('Response Data:', response);

            let userTeam = departemen;

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
                    'marbot_kaustar' : 'marbot_kaustar',
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
                    'admin_csapit2': 'admin_csapit2',
                    'training_csapit2': 'training_csapit2',
                    'driverlv_csapit2': 'driverlv_csapit2',
                    'operator_csapit3': 'operator_csapit3',
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
                'MARBOT': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'total': 'total',
                    'marbot': 'marbot',
                    'total_laundry': 'total_laundry',
                    'security_laundry': 'security_laundry'
                },
                'Mess A1': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'rebusan_a1': 'rebusan_a1',
                    'spare_a1': 'spare_a1',
                    'visitor_a1': 'visitor_a1',
                    ...Object.fromEntries(Array.from({ length: 38 }, (_, i) => [`kamar_${i + 1}`, `kamar_${i + 1}`]))
                },
                'Mess C3': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'rebusan_c3': 'rebusan_c3',
                    'spare_c3': 'spare_c3',
                    'visitor_c3': 'visitor_c3',
                    ...Object.fromEntries(Array.from({ length: 20 }, (_, i) => [`kamar_${i + 1}`, `kamar_${i + 1}`]))
                },
                'AMM': {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'mess_b1': 'mess_b1',
                    'mess_b2': 'mess_b2',
                    'mess_b3': 'mess_b3',
                    'mess_b4': 'mess_b4',

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
                        'mess_b7': 'mess_b7',
                        'mess_b8': 'mess_b8',
                        'mess_b9': 'mess_b9',
                        'mess_b10': 'mess_b10',
                        'spare_mess': 'spare_mess',
                        'rebusan_b1': 'rebusan_b1',
                        'rebusan_b2': 'rebusan_b2',
                        'rebusan_b3': 'rebusan_b3',
                        'rebusan_b4': 'rebusan_b4',
                        'rebusan_b7': 'rebusan_b7',
                        'rebusan_b8': 'rebusan_b8',
                        'rebusan_b9': 'rebusan_b9',
                        'rebusan_b10': 'rebusan_b10',
                        'rebusan_a1': 'rebusan_a1',
                        'rebusan_a2': 'rebusan_a2',
                        'rebusan_c3': 'rebusan_c3',
                    },
                'Mess Putri' : {
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
                customLabels[`Mess B${i}`] = {
                    'tanggal': 'tanggal',
                    'waktu': 'waktu',
                    'rebusan': 'rebusan',
                    'spare': 'spare',
                    'visitor': 'visitor',
                    ...Object.fromEntries(Array.from({ length: 32 }, (_, j) => [`kamar_${j + 1}`, `kamar_${j + 1}`]))
                };
            }

            let selectedFields = customLabels[userTeam] || {};

            if ($.isEmptyObject(selectedFields)) {
                console.error('Departemen tidak ditemukan dalam customLabels:', userTeam);
                return;
            }

            $('#cateringModal input, #cateringModal select').val('');

            for (let field in selectedFields) {
                let inputId = selectedFields[field];
                let value = response[field] ?? '';

                if ($('#' + inputId).is('select')) {
                    $('#' + inputId).val(value).trigger('change');
                } else {
                    $('#' + inputId).val(value);
                }
            }

            $('#cateringModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.error('Response Text:', xhr.responseText);
            alert('Gagal mengambil data! Cek console untuk detail.');
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
        let departemen = $('#departemen').val();

        if (!tanggal || !waktu) {
            alert('Harap pilih Tanggal dan Waktu terlebih dahulu.');
            $(this).prop('checked', false);
            return;
        }

        $.ajax({
            type: 'GET',
            url: '{{ url('/lapdeptcatering/getPrevious') }}',
            data: { tanggal: tanggal, waktu: waktu, departemen : departemen },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                    $('#copyPreviousData').prop('checked', false);
                    return;
                }

                let userTeam = departemen;
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
                    'marbot_kaustar' : 'marbot_kaustar',
                    'test_praktek_csapit': 'test_praktek_csapit',
                    'bagong': 'bagong',
                    'vendor_meicu': 'vendor_meicu',
                    'visitor_meicu': 'visitor_meicu',
                    },
                    'ENG' : {
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
                    'admin_csapit2': 'admin_csapit2',
                    'training_csapit2': 'training_csapit2',
                    'driverlv_csapit2': 'driverlv_csapit2',
                    'operator_csapit3': 'operator_csapit3',
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
                    'PLANT':
                    {
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
                        'mess_b7': 'mess_b7',
                        'mess_b8': 'mess_b8',
                        'mess_b9': 'mess_b9',
                        'mess_b10': 'mess_b10',
                        'spare_mess': 'spare_mess',
                        'rebusan_b1': 'rebusan_b1',
                        'rebusan_b2': 'rebusan_b2',
                        'rebusan_b3': 'rebusan_b3',
                        'rebusan_b4': 'rebusan_b4',
                        'rebusan_b7': 'rebusan_b7',
                        'rebusan_b8': 'rebusan_b8',
                        'rebusan_b9': 'rebusan_b9',
                        'rebusan_b10': 'rebusan_b10',
                        'rebusan_a1': 'rebusan_a1',
                        'rebusan_a2': 'rebusan_a2',
                        'rebusan_c3': 'rebusan_c3',
                    },

                    'Mess Putri': {
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

       // var formData = $('#cateringForm').serialize();

       var departemen = $('#departemen').val();
        if (!departemen) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Filter Departemen terlebih dahulu!',
            });
            return;
        }

        var formData = $('#cateringForm').serialize() + '&departemen=' + encodeURIComponent(departemen);

        var url = mode === 'edit'
            ? `{{ url("/lapcateringdept/myedit") }}/${cateringId}`
            : `{{ route("lapcateringdept.store") }}`;

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
       let departemen = $('#departemen').val();
       console.log(departemen);

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post('{{ route('delete.lapcateringdept') }}', {
                   catering_id: cateringId,
                   departemen: departemen
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

// Appprove
$('.approval').click(function() {
    var cateringId = $(this).data('id');
    var selectedDepartemen = $('#departemen').val();
    console.log(selectedDepartemen);

    $('#btn-yes-approval').off('click').on('click', function() {
        var form = $('.form_approval')[0];
        var formData = new FormData(form);
        formData.append('catering_id', cateringId);
        formData.append('departemen', selectedDepartemen); // Kirim departemen yang dipilih

        $('#btn-yes-approval').hide();
        $('#loading-spinner-approval').show();

        $.ajax({
            type: 'POST',
            url: '/lapcateringdept/approval',
            data: formData,
            processData: false,
            contentType: false,
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
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            },
            complete: function() {
                $('#btn-yes-approval').show();
                $('#loading-spinner-approval').hide();
            }
        });
    });
});

//REVISI GAGL
$(document).ready(function() {
    $('.revisi').click(function() {
        var cateringId = $(this).data('id');
        var selectedDepartemen = $('#departemen').val();
        console.log(cateringId)

        $('#btn-yes-revisi').off('click').on('click', function() {
            var data = $('.form_revisi').serialize();
            data += '&departemen=' + encodeURIComponent(selectedDepartemen);

            $('#btn-yes-revisi').hide();
            $('#loading-spinner').show();

            $.ajax({
                type: 'POST',
                url: '/lapcateringdept/revisi?catering_id=' + cateringId,
                data: data,
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
                },
                complete: function() {
                    $('#btn-yes-revisi').show();
                    $('#loading-spinner').hide();
                }
            });
        });
    });
});

$(document).ready(function() {
    // Jika checkbox header dicentang, semua checkbox di baris ikut dicentang
    $('#selectAll').change(function() {
        $('.rowCheckbox').prop('checked', $(this).prop('checked'));
    });

    // Jika ada perubahan pada checkbox baris, update status checkbox header
    $('.rowCheckbox').change(function() {
        if ($('.rowCheckbox:checked').length == $('.rowCheckbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    // Klik tombol Approve Selected
    $('#btnApproveSelected').click(function() {
        let selectedIds = [];
        let departemen = $('#departemen').val(); // Ambil nilai departemen dari input form

        $('.rowCheckbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Ada Data Terpilih',
                text: 'Silakan pilih data yang ingin di-approve.'
            });
            return;
        }

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dipilih akan disetujui!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Approve!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/lapcateringdept/approve-selected',
                    data: {
                        ids: selectedIds,
                        departemen: departemen, // Kirim juga departemen
                        _token: '{{ csrf_token() }}'
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
                            text: 'Terjadi kesalahan saat meng-approve data.'
                        });
                    }
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
        var selectedDepartemen =  $('#departemen').val();;

        Swal.fire({
            title: 'Kirim Revisi?',
            text: "Yakin ingin mengirim revisi untuk data ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/lapcateringdept/send',
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


// SNACK
// Tambah baris snack
$('#add-snack-btn').click(function() {
    var newItem = $('.snack-group').first().clone();
    newItem.find('input, select').val('');
    newItem.find('input[type="checkbox"]').prop('checked', false);
    $('#snack-container').append(newItem);
});

// Hapus baris snack
$('#remove-snack-btn').click(function() {
    if ($('.snack-group').length > 1) {
        $('.snack-group').last().remove();
    } else {
        alert('Minimal satu grup snack harus ada!');
    }
});

//$('#cateringSnackModal').data('mode', 'edit');
// Add Data
$(document).ready(function() {
    $(document).on('click', '#btn-yes-add-snack', function(event) {
        var $modal = $('#cateringSnackModal');
        var mode = $modal.attr('data-mode') || 'add';
        let cateringId = $('#cateringSnackModal').attr('data-id');

        console.log(mode);

        if (mode === 'edit' && !cateringId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Snack ID tidak ditemukan!',
            });
            return;
        }

      // console.log($("input[name='jumlah_snack_add[]']:checked").val());

    var formData = $('#cateringSnackForm').serialize();

        var url = mode === 'edit'
            ? `{{ url("/snack_dept/myedit") }}/${cateringId}`
            : `{{ url("/snack_dept/store") }}`;

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            beforeSend: function() {
                $('#btn-yes-add-snack').prop('disabled', true);
            },
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: mode === 'edit' ? 'Snack berhasil diperbarui!' : 'Catering berhasil ditambahkan!',
                    }).then(() => {
                        // Bersihkan modal sebelum refresh
                        window.location.href = window.location.href;
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
                $('#btn-yes-add-snack').prop('disabled', false);
            }
        });
    });
});

var snackId;
$('.editsnack').click(function() {
    snackId = $(this).data('id');
    $('#cateringSnackModal').attr({
        'data-mode': 'edit',
        'data-id': snackId
    });

    $.ajax({
        type: 'GET',
        url: '{{ url('/snack_dept/get') }}/' + snackId,
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            // Mapping field database ke id input
            let fieldMap = {
                'tanggal': 'tanggal_snack_add',
                'departemen': 'departemen_snack_add',
                'waktu': 'waktu_snack_add',
                'lokasi': 'lokasi_snack_add',
                'jenis': 'snack_add',
                'jumlah': 'jumlah_snack_add',
                'catering': 'catering_snack_add',
                'harga': 'harga_snack_add',
                'keterangan': 'keterangan_snack_add',

            };

            // Clear semua input & select
            $('#cateringSnackModal input, #cateringSnackModal select').val('');

            // Isi input sesuai mapping
            for (let key in fieldMap) {
                let inputId = fieldMap[key];
                let value = response[key] ?? '';
                $('#' + inputId).val(value);
            }

            // Menyesuaikan waktu, lokasi, snack jika ada dalam response
            $("select[name='waktu_snack_add[]']").val(response.waktu);
            // $("select[name='lokasi_snack_add[]']").val(response.lokasi);
            $("select[name='snack_add[]']").val(response.jenis);
            $("select[name='catering_snack_add[]']").val(response.catering);
            $("select[name='departemen_snack_add[]']").val(response.departemen);
            $("input[name='jumlah_snack_add[]']").val(response.jumlah);
            $("input[name='harga_snack_add[]']").val(response.harga);
            $("input[name='lokasi_snack_add[]']").val(response.lokasi);
            $("textarea[name='keterangan_snack_add[]']").val(response.keterangan);

            $("select[name='area_snack_add[]']").one('change', function() {
                $("select[name='gedung_snack_add[]']").val(response.gedung);
            });

            $("select[name='area_snack_add[]']").val(response.area).trigger('change');

            // Tampilkan modal
            $('#cateringSnackModal').modal('show');
        },
        error: function() {
            alert('Gagal mengambil data!');
        }
    });
});

// Approve Snack sekar
$('.approvalsnack').click(function() {
    var snackId = $(this).data('id');


    $('#btn-yes-approvalsnack').off('click').on('click', function() {
        var form = $('.form_approvalsnack')[0];
        var formData = new FormData(form);
        formData.append('snack_id', snackId);

        $('#btn-yes-approvalsnack').hide();
        $('#loading-spinner-approvalsnack').show();

        $.ajax({
            type: 'POST',
            url: '/snack/approval',
            data: formData,
            processData: false,
            contentType: false,
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
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            },
            complete: function() {
                $('#btn-yes-approvalsnack').show();
                $('#loading-spinner-approvalsnack').hide();
            }
        });
    });
});

//DELETE SNACK
document.querySelectorAll('.deletesnack').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var snackId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post('{{ route('delete.snack') }}', {
                   snack_id: snackId
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

document.querySelectorAll('.datatable').forEach(function(table) {
  new DataTable(table);
});

$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    var activeTab = $(e.target).attr('id'); // misal: snack-tab
    localStorage.setItem('activeCateringTab', activeTab);
});
$(document).ready(function() {
    var activeTab = localStorage.getItem('activeCateringTab');
    if (activeTab) {
        var tabTrigger = document.getElementById(activeTab);
        if (tabTrigger) {
            var tab = new bootstrap.Tab(tabTrigger);
            tab.show();
        }
    }
});

$('#cateringSnackModal').on('show.bs.modal', function () {
    var mode = $(this).data('mode') || 'edit';

    if (mode === 'edit') {
        $('.catering-harga-group').show();
    } else {
        $('.catering-harga-group').hide();
    }
});

$('#cateringSnackModal').on('hidden.bs.modal', function () {
  $(this).find('form')[0].reset();
});

$(document).ready(function() {
    $('.revisisnack').click(function() {
        var snackId = $(this).data('id');
        var selectedDepartemen = $('#departemen').val();
        console.log(snackId)

        $('#btn-yes-revisi-snack').off('click').on('click', function() {
            var data = $('.form_revisi_snack').serialize();
            data += '&departemen=' + encodeURIComponent(selectedDepartemen);

            $('#btn-yes-revisi-snack').hide();
            $('#loading-spinner').show();

            $.ajax({
                type: 'POST',
                url: '/lapcateringdept/revisisnack?snack_id=' + snackId,
                data: data,
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
                },
                complete: function() {
                    $('#btn-yes-revisi').show();
                    $('#loading-spinner').hide();
                }
            });
        });
    });
})

// SPESIAL
// Tambah baris snack
$('#add-spesial-btn').click(function() {
    var newItem = $('.spesial-group').first().clone();
    newItem.find('input, select').val('');
    newItem.find('input[type="checkbox"]').prop('checked', false);
    $('#spesial-container').append(newItem);
});

// Hapus baris spesial
$('#remove-spesial-btn').click(function() {
    if ($('.spesial-group').length > 1) {
        $('.spesial-group').last().remove();
    } else {
        alert('Minimal satu grup spesial harus ada!');
    }
});

//$('#cateringSpesialModal').data('mode', 'edit');
// Add Data
$(document).ready(function() {
    $(document).on('click', '#btn-yes-add-spesial', function(event) {
        var $modal = $('#cateringSpesialModal');
        var mode = $modal.attr('data-mode') || 'add';
        let cateringId = $('#cateringSpesialModal').attr('data-id');

        if (mode === 'edit' && !cateringId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'MK Spesial ID tidak ditemukan!',
            });
            return;
        }

      // console.log($("input[name='jumlah_spesial_add[]']:checked").val());

    var formData = $('#cateringSpesialForm').serialize();

        var url = mode === 'edit'
            ? `{{ url("/spesial_dept/myedit") }}/${cateringId}`
            : `{{ url("/spesial_dept/store") }}`;

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            beforeSend: function() {
                $('#btn-yes-add-spesial').prop('disabled', true);
            },
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: mode === 'edit' ? 'spesial berhasil diperbarui!' : 'MK Spesial berhasil ditambahkan!',
                    }).then(() => {
                        // Bersihkan modal sebelum refresh
                        window.location.href = window.location.href;
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
                $('#btn-yes-add-spesial').prop('disabled', false);
            }
        });
    });
});

var spesialId;
$('.editspesial').click(function() {
    spesialId = $(this).data('id');
    $('#cateringSpesialModal').attr({
        'data-mode': 'edit',
        'data-id': spesialId
    });

    $.ajax({
        type: 'GET',
        url: '{{ url('/spesial_dept/get') }}/' + spesialId,
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            let fieldMap = {
                'tanggal': 'tanggal_spesial_add',
                'departemen': 'departemen_spesial_add',
                'waktu': 'waktu_spesial_add',
                'lokasi': 'lokasi_spesial_add',
                'jenis': 'spesial_add',
                'jumlah': 'jumlah_spesial_add',
                'catering': 'catering_spesial_add',
                'harga': 'harga_spesial_add',
                'keterangan': 'keterangan_spesial_add',

            };

            $('#cateringSpesialModal input, #cateringSpesialModal select').val('');

            for (let key in fieldMap) {
                let inputId = fieldMap[key];
                let value = response[key] ?? '';
                $('#' + inputId).val(value);
            }

            $("select[name='waktu_spesial_add[]']").val(response.waktu);
            $("select[name='spesial_add[]']").val(response.jenis);
            $("select[name='catering_spesial_add[]']").val(response.catering);
            $("select[name='departemen_spesial_add[]']").val(response.departemen);
            $("input[name='jumlah_spesial_add[]']").val(response.jumlah);
            $("input[name='harga_spesial_add[]']").val(response.harga);
            $("input[name='lokasi_spesial_add[]']").val(response.lokasi);

            $("textarea[name='keterangan_snack_add[]']").val(response.keterangan);

            $("select[name='area_spesial_add[]']").one('change', function() {
                $("select[name='gedung_spesial_add[]']").val(response.gedung);
            });

            $("select[name='area_spesial_add[]']").val(response.area).trigger('change');

            $('#cateringSpesialModal').modal('show');
        },
        error: function() {
            alert('Gagal mengambil data!');
        }
    });
});

// VALIDASI crew sekar
$('.approvalspesial').click(function() {
    var spesialId = $(this).data('id');

    $('#btn-yes-approvalspesial').off('click').on('click', function() {
        var form = $('.form_approvalspesial')[0];
        var formData = new FormData(form);
        formData.append('spesial_id', spesialId);

        $('#btn-yes-approvalspesial').hide();
        $('#loading-spinner-approvalspesial').show();

        $.ajax({
            type: 'POST',
            url: '/spesial/approval',
            data: formData,
            processData: false,
            contentType: false,
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
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            },
            complete: function() {
                $('#btn-yes-approvalspesial').show();
                $('#loading-spinner-approvalspesial').hide();
            }
        });
    });
});

//DELETE SNACK
document.querySelectorAll('.deletesnack').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var snackId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post('{{ route('delete.snack') }}', {
                   snack_id: snackId
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

//DELETE SPESIAL
document.querySelectorAll('.deletespesial').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var spesialId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post('{{ route('delete.spesial') }}', {
                   spesial_id: spesialId
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

$(document).ready(function() {
    $('.revisispesial').click(function() {
        var spesialId = $(this).data('id');
        var selectedDepartemen = $('#departemen').val();
        console.log(spesialId)

        $('#btn-yes-revisi-spesial').off('click').on('click', function() {
            var data = $('.form_revisi_spesial').serialize();
            data += '&departemen=' + encodeURIComponent(selectedDepartemen);

            $('#btn-yes-revisi-spesial').hide();
            $('#loading-spinner').show();

            $.ajax({
                type: 'POST',
                url: '/lapcateringdept/revisispesial?spesial_id=' + spesialId,
                data: data,
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
                },
                complete: function() {
                    $('#btn-yes-revisi-spesial').show();
                    $('#loading-spinner').hide();
                }
            });
        });
    });
})

var spesialId;
   $(document).on('click', '.viewspesial', function () {
    const spesialId = $(this).data('id');


    $.ajax({
        type: 'GET',
        url: '{{ url('/spesial_dept/get') }}/' + spesialId + '?_=' + new Date().getTime(),
        cache: false,
        success: function (response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            const viewContainer = $('#viewDataSpesial');
            viewContainer.html('');

            // Bangun satu baris data
            const tableContent = `
                <tr>
                    <td>${response.tanggal ?? '-'}</td>
                    <td>${response.keterangan ?? '-'}</td>
                    <td>${response.waktu ?? '-'}</td>
                    <td>${response.area ?? '-'}</td>
                    <td>${response.gedung ?? '-'}</td>
                    <td>${response.lokasi ?? '-'}</td>
                    <td>${response.jenis ?? '-'}</td>
                    <td>${response.jumlah ?? '-'}</td>
                    <td>${response.catering ?? '-'}</td>
                    <td>${response.harga ?? '-'}</td>
                    <td>${response.revisi_desc ?? '-'}</td>
                </tr>
            `;

            viewContainer.html(tableContent);
            $('#viewspesialModal').modal('show');
        },
        error: function () {
            alert('Gagal mengambil data!');
        }
    });
});

var snackId;
$(document).on('click', '.viewsnack', function () {
    const snackId = $(this).data('id');

    $.ajax({
        type: 'GET',
        url: '{{ url('/snack_dept/get') }}/' + snackId + '?_=' + new Date().getTime(),
        cache: false,
        success: function (response) {
            if (response.error) {
                alert(response.error);
                return;
            }

            const viewContainer = $('#viewDataSnack');
            viewContainer.html('');

            // Bangun satu baris data
            const tableContent = `
                <tr>
                    <td>${response.tanggal ?? '-'}</td>
                    <td>${response.keterangan ?? '-'}</td>
                    <td>${response.waktu ?? '-'}</td>
                    <td>${response.area ?? '-'}</td>
                    <td>${response.gedung ?? '-'}</td>
                    <td>${response.lokasi ?? '-'}</td>
                    <td>${response.jenis ?? '-'}</td>
                    <td>${response.jumlah ?? '-'}</td>
                    <td>${response.catering ?? '-'}</td>
                    <td>${response.harga ?? '-'}</td>
                    <td>${response.revisi_desc ?? '-'}</td>
                </tr>
            `;

            viewContainer.html(tableContent);
            $('#viewsnackModal').modal('show');
        },
        error: function () {
            alert('Gagal mengambil data!');
        }
    });
});

//GEDUNG ADD
    const gedungOptions = {
        'Mess': [
            'A1', 'A2', 'B1', 'B2', 'B3', 'B4', 'B7', 'B8', 'B9', 'B10','C3', 'MASJID ASSALAM', 'KOPPA MART', 'FOOD COURT','GUDANG GA', 'OFFICE GA'
        ],
        'Office': [
            'OFFICE PLANT','WAREHOUSE', 'GENSET', 'WORKSHOP PLANT', 'KOPPA MART', 'MASJID AL KAUTSAR',
        ],
        'CSA 1': [
            'OFFICE SHE', 'OFFICE AKADEMI', 'OFFICE ICT', 'CSA FUEL'
        ],
        'CSA 2': [
            'CSA OB', 'CSA HRM'
        ],
        'CSA 3': [
            'CSA OB', 'OFFICE CCR'
        ],
        'CSA FUEL': [
            'SPBI PPA'
        ],
        'PITSTOP': [
            'MUSHOLLA', 'WORKSHOP TRACK', 'AKADEMI', 'FABRIKASI', 'TOOLS', 'TYRE', 'TRACKINDO', 'SUPPORT'
        ],
        'OTHER': []
    };

    document.getElementById('area_snack_add[]').addEventListener('change', function() {
        const selectedArea = this.value;
        const gedungSelect = document.getElementById('gedung_snack_add[]');

        gedungSelect.innerHTML = '<option value="">Pilih Gedung</option>';

        if (selectedArea && selectedArea !== 'OTHER') {
            gedungOptions[selectedArea].forEach(gedung => {
                const option = document.createElement('option');
                option.value = gedung;
                option.textContent = gedung;
                gedungSelect.appendChild(option);
            });


            gedungSelect.disabled = false;
        } else {

            gedungSelect.disabled = true;
        }
    });

    document.getElementById('area_spesial_add[]').addEventListener('change', function() {
        const selectedArea = this.value;
        const gedungSelect = document.getElementById('gedung_spesial_add[]');

        gedungSelect.innerHTML = '<option value="">Pilih Gedung</option>';

        if (selectedArea && selectedArea !== 'OTHER') {
            gedungOptions[selectedArea].forEach(gedung => {
                const option = document.createElement('option');
                option.value = gedung;
                option.textContent = gedung;
                gedungSelect.appendChild(option);
            });


            gedungSelect.disabled = false;
        } else {

            gedungSelect.disabled = true;
        }
    });





</script>


@endsection

