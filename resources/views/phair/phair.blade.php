@extends('include/mainlayout')
@section('title', 'phair')
@section('content')
    <div class="pagetitle">
      <h1>Ph Air</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Ph Air</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> Ph Air</h5>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary mb-2 d-block d-sm-inline" data-bs-toggle="modal" data-bs-target="#userModal"> Add PH AIR</button>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary mb-2 d-block d-sm-inline" data-bs-toggle="modal" data-bs-target="#addData"> Add Flow Meter</button>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary mb-2 d-block d-sm-inline" data-bs-toggle="modal" data-bs-target="#addDataPAC"> Add Dosing</button>
              <br><br>

                {{-- TABS --}}
                <ul class="nav nav-tabs mt-4" id="PHTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="phair-tab" data-bs-toggle="tab" data-bs-target="#phair" type="button" role="tab" aria-controls="phair" aria-selected="true">
                        PH AIR
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dosing-tab" data-bs-toggle="tab" data-bs-target="#dosing" type="button" role="tab" aria-controls="dosing" aria-selected="false">
                        Clean Water
                    </button>
                    </li>
                     <li class="nav-item" role="presentation">
                    <button class="nav-link" id="raw-tab" data-bs-toggle="tab" data-bs-target="#raw" type="button" role="tab" aria-controls="raw" aria-selected="false">
                        Raw Water
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dosing-pac-tab" data-bs-toggle="tab" data-bs-target="#dosing-pac" type="button" role="tab" aria-controls="dosing-pac" aria-selected="false">
                        Dosing
                    </button>
                    </li>
                </ul>

                <!-- Modal View PH Air-->
                <div class="modal fade modal-view" id="viewuserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-6" id="btn-view">View User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="user-details">
                                    <div class="detail">
                                        <label for="nrp">NRP :</label>
                                        <span id="nrp-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="name">Nama:</label>
                                        <span id="name-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Tanggal:</label>
                                        <span id="tanggal-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="area">MESS:</label>
                                        <span id="mess-view"></span>
                                    </div>
                                   
                                    <div class="detail">
                                        <label for="ph">WT:</label>
                                        <span id="wt-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="ph">WTP:</label>
                                        <span id="wtp-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="ph">STP:</label>
                                        <span id="stp-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="ph">PIT 1:</label>
                                        <span id="pit1-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="ph">PIT 2:</label>
                                        <span id="pit2-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="ph">PIT 3:</label>
                                        <span id="pit3-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="ph">Workshop:</label>
                                        <span id="workshop-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="ph">Warehouse:</label>
                                        <span id="warehouse-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="ph">Office Plant:</label>
                                        <span id="office-view"></span>
                                    </div>
                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal View -->

                <!-- Modal View Dosing-->
                <div class="modal fade modal-view" id="viewaddData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-6" id="btn-view-dosing">View User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="user-details">
                                    <div class="detail">
                                        <label for="nrp">NRP :</label>
                                        <span id="nrp-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="name">Nama:</label>
                                        <span id="name-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Shift:</label>
                                        <span id="shift-view-dosing"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Tanggal:</label>
                                        <span id="tanggal-view-dosing"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Lokasi:</label>
                                        <span id="lokasi-view"></span>
                                    </div>
                                     <div class="detail">
                                        <label for="jenis">jenis:</label>
                                        <span id="jenis-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Meter Awal (m&sup3;): </label>
                                        <span id="meter-awal-view"></span> 
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Meter Akhir (m&sup3;):</label>
                                        <span id="meter-akhir-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Pemakaian (m&sup3;): </label>
                                        <span id="meter-pemakaian-view"></span>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal View -->

                <!-- Modal View Dosing PAC-->
                <div class="modal fade modal-view" id="viewaddDataPac" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-6" id="btn-view-dosing">View User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="user-details">
                                    <div class="detail">
                                        <label for="nrp">NRP :</label>
                                        <span id="nrp-view-pac"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="name">Nama:</label>
                                        <span id="name-view-pac"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Shift:</label>
                                        <span id="shift-view-dosing-pac"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Tanggal:</label>
                                        <span id="tanggal-view-dosing-pac"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi">Lokasi:</label>
                                        <span id="lokasi-view-pac"></span>
                                    </div>
                                   
                                    <div class="detail">
                                        <label for="pac">PAC:</label>
                                        <span id="pac-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="soda">Soda Ash:</label>
                                        <span id="soda-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="kaporit">Kaporit:</label>
                                        <span id="kaporit-view"></span>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal View -->

                <!-- Modal Add -->
                <div class="modal fade modal_add" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mode="add">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="btn-add">Add Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <form class="row g-3 needs-validation">
                            @csrf
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal">
                                    <label for="message-text">Tanggal </label>  
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-control" id="lokasi" name="lokasi">
                                        <option value="">Pilih Lokasi</option>
                                        <option value="MESS">MESS</option>
                                        <option value="WT">WT</option>
                                        <option value="WTP">WTP</option>
                                        <option value="STP">STP</option>
                                        <option value="PIT_1">PIT 1</option>
                                        <option value="PIT_2">PIT 2</option>
                                        <option value="PIT_3">PIT 3</option>
                                        <option value="WORKSHOP">Workshop</option>
                                        <option value="WAREHOUSE">Warehouse</option>
                                        <option value="OFFICE_PLANT">Office Plant</option>
                                    </select>
                                    <label for="lokasi">Lokasi</label>
                                </div>
                                </div>

                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="ph" name="ph" placeholder="ph">
                                    <label for="message-text">Ph Air </label>
                                </div>
                                </div>   
                            </form>             
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-yes-add">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add Dosing-->
                <div class="modal fade modal_add" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mode="add">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="btn-add">Add Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <form class="row g-3 needs-validation">
                            @csrf
                                
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="tanggal_dosing" name="tanggal_dosing" placeholder="Tanggal">
                                    <label for="message-text">Tanggal </label>  
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-control" id="lokasi_dosing" name="lokasi_dosing">
                                        <option value="">Pilih Lokasi</option>
                                        <option value="MESS">MESS</option>
                                        <option value="WT">WT</option>
                                        <option value="WTP">WTP</option>
                                        <option value="STP">STP</option>
                                        <option value="PIT_1">PIT 1</option>
                                        <option value="PIT_2">PIT 2</option>
                                        <option value="PIT_3">PIT 3</option>
                                        <option value="WORKSHOP">Workshop</option>
                                        <option value="WAREHOUSE">Warehouse</option>
                                        <option value="OFFICE_PLANT">Office Plant</option>
                                    </select>
                                    <label for="lokasi">Lokasi</label>
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-control" id="jenis" name="jenis">
                                        <option value="">Pilih Jenis</option>
                                        <option value="Clean Water">Clean Water</option>
                                        <option value="Raw Water">Raw Water</option>
                                    </select>
                                    <label for="jenis">Jenis</label>
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-control" id="shift" name="shift">
                                        <option value="">Pilih Shift</option>
                                        <option value="Malam">Malam</option>
                                        <option value="Siang">Siang</option>
                                    </select>
                                    <label for="Shift">Shift</label>
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="meter_awal" name="meter_awal" placeholder="meter_awal">
                                    <label for="message-text">Flow Meter Awal</label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3">m&sup3</span>
                                </div>
                                </div>  
                                
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="meter_akhir" name="meter_akhir" placeholder="meter_akhir">
                                    <label for="message-text">Flow Meter Akhir</label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3">m&sup3</span>
                                </div>
                                </div> 
                            </form>             
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-yes-add-dosing">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add Dosing-->
                <div class="modal fade modal_add" id="addDataPAC" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mode="add">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="btn-add">Add Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <form class="row g-3 needs-validation">
                            @csrf    
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="tanggal_dosing_pac" name="tanggal_dosing_pac" placeholder="Tanggal">
                                    <label for="message-text">Tanggal </label>  
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-control" id="lokasi_dosing_pac" name="lokasi_dosing_pac">
                                        <option value="">Pilih Lokasi</option>
                                        <option value="MESS">MESS</option>
                                        <option value="WT">WT</option>
                                        <option value="WTP">WTP</option>
                                        <option value="STP">STP</option>
                                        <option value="PIT_1">PIT 1</option>
                                        <option value="PIT_2">PIT 2</option>
                                        <option value="PIT_3">PIT 3</option>
                                        <option value="WORKSHOP">Workshop</option>
                                        <option value="WAREHOUSE">Warehouse</option>
                                        <option value="OFFICE_PLANT">Office Plant</option>
                                    </select>
                                    <label for="lokasi">Lokasi</label>
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <select class="form-control" id="shift_pac" name="shift_pac">
                                        <option value="">Pilih Shift</option>
                                        <option value="Malam">Malam</option>
                                        <option value="Siang">Siang</option>
                                    </select>
                                    <label for="Shift">Shift</label>
                                </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="pac" name="pac" placeholder="pac">
                                    <label for="message-text">PAC (Poly Aluminium Chloride)</label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3">Kg</span>
                                </div>
                                </div> 
                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="soda" name="soda" placeholder="soda">
                                    <label for="message-text">Soda Ash (Sodium Carbonate / Na₂CO₃)</label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3">Kg</span>
                                </div>
                                </div> 

                                <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="kaporit" name="kaporit" placeholder="kaporit">
                                    <label for="message-text">Kaporit (Calcium Hypochlorite / Ca(ClO)₂)</label>
                                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3">Kg</span>
                                </div>
                                </div>
                            </form>             
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-yes-add-dosing-pac">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="PHTabsContent">
                <!-- Table PH AIR -->
                <div class="tab-pane fade show active" id="phair" role="tabpanel" aria-labelledby="phair-tab">
                    <div class="table-responsive">
                        <table class="table dt_user responsive-table datatable" id="datatable">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NRP</th>
                                <th scope="col">Nama Crew</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Mess</th>
                                <th scope="col">WT</th>
                                <th scope="col">WTP</th>
                                <th scope="col">STP</th>
                                <th scope="col">PIT 1</th>
                                <th scope="col">PIT 2</th>
                                <th scope="col">PIT 3</th>
                                <th scope="col">Workshop</th>
                                <th scope="col">Warehouse</th>
                                <th scope="col">Office Plant</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- //sekar --}}
                            @foreach($PhAir as $no => $ph)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $ph->nrp }}</td>
                                <td>{{ $ph->nama }}</td>
                                <td>{{ $ph->tanggal }}</td>
                                <td>{{ $ph->MESS}}</td>
                                <td>{{ $ph->WT }}</td>
                                <td>{{ $ph->WTP }}</td>
                                <td>{{ $ph->STP }}</td>
                                <td>{{ $ph->PIT_1 }}</td>
                                <td>{{ $ph->PIT_2}}</td>
                                <td>{{ $ph->PIT_3}}</td>
                                <td>{{ $ph->WORKSHOP}}</td>
                                <td>{{ $ph->WAREHOUSE }}</td>
                                <td>{{ $ph->OFFICE_PLANT }}</td>
                                <td>  
                                <div class="dropdown">
                                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $ph->id }}"><i class="fa fa-expand"></i>View</a></li>
                                    <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $ph->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                    <li><a class="dropdown-item delete" href="#" data-id="{{ $ph->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                </ul>
                            @endforeach 
                            
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table PH AIR -->
              
                
                <!-- Table FLOW METER -->
                <div class="tab-pane fade" id="dosing" role="tabpanel" aria-labelledby="dosing-tab">
                    <div class="table-responsive">
                        <table class="table dt_dosing responsive-table datatable">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NRP</th>
                                <th scope="col">Nama Crew</th>
                                <th scope="col">Shift</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Meter Awal (m&sup3;)</th>
                                <th scope="col">Meter Akhir (m&sup3;)</th>
                                <th scope="col">Total Pemakaian (m&sup3;)</th>
                                <!-- <th scope="col">PAC</th>
                                <th scope="col">Soda Ash</th>
                                <th scope="col">Kaporit</th> -->
                                <th scope="col">Aksi</th> 
                            </tr>
                            </thead>
                            <tbody>
                           
                            @foreach($Dosing as $no => $dosing)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $dosing->nrp }}</td>
                                <td>{{ $dosing->nama }}</td>
                                <td>{{ $dosing->shift }}</td>
                                <td>{{ $dosing->tanggal }}</td>
                                <td>{{ $dosing->lokasi}}</td>
                                <td>{{ $dosing->jenis}}</td>
                                <td>{{ $dosing->meter_awal}}</td>
                                <td>{{ $dosing->meter_akhir}}</td>
                                <td>{{ $dosing->meter_akhir - $dosing->meter_awal }}</td>
                                <!-- <td>{{ $dosing->pac}}</td>
                                <td>{{ $dosing->soda_ash}}</td>
                                <td>{{ $dosing->kaporit}}</td> -->
                                <td>  
                                <div class="dropdown">
                                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item viewdosing" href="#" data-bs-toggle="modal" data-bs-target="#viewaddData" data-id="{{ $dosing->id }}"><i class="fa fa-expand"></i>View</a></li>
                                    <li><a class="dropdown-item editdosing" href="#" data-bs-toggle="modal" data-bs-target="#addData" data-id="{{ $dosing->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                    <li><a class="dropdown-item deletedosing" href="#" data-id="{{ $dosing->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                </ul></td>
                            
                            @endforeach 
                            
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table PH AIR -->

                 <!-- Table FLOW METER -->
                <div class="tab-pane fade" id="raw" role="tabpanel" aria-labelledby="raw-tab">
                    <div class="table-responsive">
                        <table class="table dt_raw responsive-table datatable">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NRP</th>
                                <th scope="col">Nama Crew</th>
                                <th scope="col">Shift</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Meter Awal (m&sup3;)</th>
                                <th scope="col">Meter Akhir (m&sup3;)</th>
                                <th scope="col">Total Pemakaian (m&sup3;)</th>
                             
                                <th scope="col">Aksi</th> 
                            </tr>
                            </thead>
                            <tbody>
                           
                            @foreach($Raw as $no => $dosing)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $dosing->nrp }}</td>
                                <td>{{ $dosing->nama }}</td>
                                <td>{{ $dosing->shift }}</td>
                                <td>{{ $dosing->tanggal }}</td>
                                <td>{{ $dosing->lokasi}}</td>
                                <td>{{ $dosing->jenis}}</td>
                                <td>{{ $dosing->meter_awal}}</td>
                                <td>{{ $dosing->meter_akhir}}</td>
                                <td>{{ $dosing->meter_akhir - $dosing->meter_awal }}</td>
                                <td>  
                                <div class="dropdown">
                                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item viewdosing" href="#" data-bs-toggle="modal" data-bs-target="#viewaddData" data-id="{{ $dosing->id }}"><i class="fa fa-expand"></i>View</a></li>
                                    <li><a class="dropdown-item editdosing" href="#" data-bs-toggle="modal" data-bs-target="#addData" data-id="{{ $dosing->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                    <li><a class="dropdown-item deletedosing" href="#" data-id="{{ $dosing->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                </ul></td>
                            
                            @endforeach 
                            
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table PH AIR -->

                <!-- Table FLOW METER -->
                <div class="tab-pane fade" id="dosing" role="tabpanel" aria-labelledby="dosing-tab">
                    <div class="table-responsive">
                        <table class="table dt_dosing responsive-table datatable" >
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NRP</th>
                                <th scope="col">Nama Crew</th>
                                <th scope="col">Shift</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Meter Awal (m&sup3;)</th>
                                <th scope="col">Meter Akhir (m&sup3;)</th>
                                <th scope="col">Total Pemakaian (m&sup3;)</th>
                                <!-- <th scope="col">PAC</th>
                                <th scope="col">Soda Ash</th>
                                <th scope="col">Kaporit</th> -->
                                <th scope="col">Aksi</th> 
                            </tr>
                            </thead>
                            <tbody>
                           
                            @foreach($Dosing as $no => $dosing)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $dosing->nrp }}</td>
                                <td>{{ $dosing->nama }}</td>
                                <td>{{ $dosing->shift }}</td>
                                <td>{{ $dosing->tanggal }}</td>
                                <td>{{ $dosing->lokasi}}</td>
                                <td>{{ $dosing->jenis}}</td>
                                <td>{{ $dosing->meter_awal}}</td>
                                <td>{{ $dosing->meter_akhir}}</td>
                                <td>{{ $dosing->meter_akhir - $dosing->meter_awal }}</td>
                                <!-- <td>{{ $dosing->pac}}</td>
                                <td>{{ $dosing->soda_ash}}</td>
                                <td>{{ $dosing->kaporit}}</td> -->
                                <td>  
                                <div class="dropdown">
                                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item viewdosing" href="#" data-bs-toggle="modal" data-bs-target="#viewaddData" data-id="{{ $dosing->id }}"><i class="fa fa-expand"></i>View</a></li>
                                    <li><a class="dropdown-item editdosing" href="#" data-bs-toggle="modal" data-bs-target="#addData" data-id="{{ $dosing->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                    <li><a class="dropdown-item deletedosing" href="#" data-id="{{ $dosing->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                </ul>
                            
                            @endforeach 
                            
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table PH AIR -->

                 <!-- Table FLOW METER -->
                <div class="tab-pane fade" id="dosing-pac" role="tabpanel" aria-labelledby="dosing-pac">
                    <div class="table-responsive">
                        <table class="table dt_dosing responsive-table datatable">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NRP</th>
                                <th scope="col">Nama Crew</th>
                                <th scope="col">Shift</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">PAC</th>
                                <th scope="col">Soda Ash</th>
                                <th scope="col">Kaporit</th>
                                <th scope="col">Aksi</th> 
                            </tr>
                            </thead>
                            <tbody>
                           
                            @foreach($DosingPac as $no => $dosingpac)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $dosingpac->nrp }}</td>
                                <td>{{ $dosingpac->nama }}</td>
                                <td>{{ $dosingpac->shift }}</td>
                                <td>{{ $dosingpac->tanggal }}</td>
                                <td>{{ $dosingpac->lokasi}}</td>
                                <td>{{ $dosingpac->pac}}</td>
                                <td>{{ $dosingpac->soda_ash}}</td>
                                <td>{{ $dosingpac->kaporit}}</td>
                                <td>  
                                <div class="dropdown">
                                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item viewdosingpac" href="#" data-bs-toggle="modal" data-bs-target="#viewaddDataPac" data-id="{{ $dosingpac->id }}"><i class="fa fa-expand"></i>View</a></li>
                                    <li><a class="dropdown-item editdosingpac" href="#" data-bs-toggle="modal" data-bs-target="#addDataPAC" data-id="{{ $dosingpac->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                    <li><a class="dropdown-item deletedosingpac" href="#" data-id="{{ $dosingpac->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                </ul>
                            
                            @endforeach 
                            
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table PH AIR -->

            </div>
               

            </div>
          </div>

        </div>
      </div>
    </section>
  
    {{-- <script src="app/javascript/user.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

<script>

document.querySelectorAll('.datatable').forEach(function(table) {
  new DataTable(table);
});


document.addEventListener("DOMContentLoaded", function() {
    const today = new Date().toISOString().split('T')[0]; // Ambil tanggal hari ini dalam format YYYY-MM-DD
    document.getElementById('tanggal').value = today;
});

// Jumlah karakter data tabel
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

var phAirId;
$(document).ready(function() {
    $('.view').click(function() {
        phAirId = $(this).data('id');
        console.log(`ID yang diklik: ${phAirId}`);

        $('#viewuserModal').attr('data-mode', 'view');

        var url = "{{ route('edit.phair', ':id') }}".replace(':id', phAirId);

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $('#viewuserModal').find('#nrp-view').text(response.nrp);
                $('#viewuserModal').find('#name-view').text(response.nama);
                $('#viewuserModal').find('#tanggal-view').text(response.tanggal);
                $('#viewuserModal').find('#mess-view').text(response.MESS);
                $('#viewuserModal').find('#wt-view').text(response.WT);
                $('#viewuserModal').find('#wtp-view').text(response.WTP);
                $('#viewuserModal').find('#stp-view').text(response.STP);
                $('#viewuserModal').find('#pit1-view').text(response.PIT_1);
                $('#viewuserModal').find('#pit2-view').text(response.PIT_2);
                $('#viewuserModal').find('#pit3-view').text(response.PIT_3);
                $('#viewuserModal').find('#workshop-view').text(response.WORKSHOP);
                $('#viewuserModal').find('#warehouse-view').text(response.WAREHOUSE);
                $('#viewuserModal').find('#office-view').text(response.OFFICE_PLANT);

                $('#viewuserModal').modal('show');
            },
            error: function(error) {
                console.error("Error:", error.responseText);
            }
        });
    });
});


//EDIT
var phAirId; 
var baseUrlGet = "{{ url('/phair/get') }}";
$('.edit').click(function() {
    phAirId = $(this).data('id');
    $('#userModal').attr('data-mode', 'edit');
    
    $.ajax({
        type: 'GET',
        url: baseUrlGet + '/' + phAirId,
        success: function(response) {
        
            $('#userModal #tanggal').val(response.tanggal);
            $('#userModal #lokasi').val(response.lokasi);
            $('#userModal').find('#lokasi').val(response.mess).trigger('change');
            setTimeout(function() {
                $('#userModal').find('#ph').val(response.mess);
            }, 200);
            $('#userModal #area').val(response.area);
            $('#userModal #ph').val(response.ph);
            
            $('#userModal').modal('show');
        },
        error: function(error) {
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
var baseUrl = "{{ url('/phair/create') }}";
var baseUrlEdit = "{{ url('/phair/myedit') }}";
$('#btn-yes-add').click(function() {
    var mode = $('#userModal').data('mode');
    
    if (mode === 'add') {
        $.ajax({
            type: 'POST',
             url: baseUrl,
            data: $('form').serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di tambahkan!',
                    }).then(() => {
                       location.reload()
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di tambahkan!',
                    }).then(() => {
                       location.reload()
                    });
                }
            },
        });
    } else if (mode === 'edit') {  
        $.ajax({
            type: 'POST',
            url: baseUrlEdit + '/' + phAirId,
            data: $('form').serialize() + '&user_id=' + phAirId,
            success: function(response) {
                if (response.status === 'success') {
                    // Display a SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di edit!',
                    }).then(() => {
                        location.reload()
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di edit!',
                    }).then(() => {
                        location.reload()
                    });
                }
            },
        });
    }

    $('#userModal').modal('hide');
    
});
});

//DELETE
const deleteUrl = "{{ route('delete.phair') }}"
document.querySelectorAll('.delete').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var phAirId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post(deleteUrl, {
                   ph_id: phAirId
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
    $('#lokasi').change(function() {
        const selectedArea = $(this).val();
        const gedungSelect = $('#area');

        gedungSelect.html('<option value="">Pilih Area</option>');

        if (selectedArea && gedungOptions[selectedArea]) {
            gedungOptions[selectedArea].forEach(function(area) {
                gedungSelect.append('<option value="' + area+ '">' + area + '</option>');
            });

            gedungSelect.prop('disabled', false);
        } else {
            gedungSelect.prop('disabled', true);
        }
    });
});

const gedungOptions = {
    'Mess': [
        'A1', 'A2', 'B1', 'B2', 'B3', 'B4', 'B7', 'B8', 'B9', 'B10','C3', 'Gedung yang Belum di Tunggu'
    ]
};

document.getElementById('lokasi').addEventListener('change', function() {
    const selectedArea = this.value;
    const gedungSelect = document.getElementById('area');

    gedungSelect.innerHTML = '<option value="">Pilih Area</option>';

    if (selectedArea && selectedArea !== 'OTHER') {
        gedungOptions[selectedArea].forEach(gedung => {
            const option = document.createElement('option');
            option.value = area;
            option.textContent = gedung;
            gedungSelect.appendChild(option);
        });


        gedungSelect.disabled = false;
    } else {

        gedungSelect.disabled = true;
    }
});

//DOSING
$(document).ready(function() {
var baseUrl = "{{ url('/phair-dosing/create') }}";
var base = "{{ url('/phair-dosing/myedit') }}";
$('#btn-yes-add-dosing').click(function() {
    var mode = $('#addData').data('mode');
    
    if (mode === 'add') {
        $.ajax({
            type: 'POST',
             url: baseUrl,
            data: $('form').serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di tambahkan!',
                    }).then(() => {
                       location.reload()
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di tambahkan!',
                    }).then(() => {
                       location.reload()
                    });
                }
            },
        });
    } else if (mode === 'edit') {  
        $.ajax({
            type: 'POST',
            url: base + '/' + dosingId,
            data: $('form').serialize() + '&user_id=' + dosingId,
            success: function(response) {
                if (response.status === 'success') {
                    // Display a SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di edit!',
                    }).then(() => {
                        location.reload()
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di edit!',
                    }).then(() => {
                        location.reload()
                    });
                }
            },
        });
    }

    $('#addData').modal('hide');
    
});
});

//EDIT
var dosingId; 
var baseUrl = "{{ url('/phair-dosing/get') }}";
$('.editdosing').click(function() {
    dosingId = $(this).data('id');
    $('#addData').attr('data-mode', 'edit');
    
    $.ajax({
        type: 'GET',
        url: baseUrl + '/' + dosingId,
        success: function(response) {
        
            $('#addData #tanggal_dosing').val(response.tanggal);
            $('#addData #lokasi_dosing').val(response.lokasi).trigger('change');
            $('#addData #meter_awal').val(response.meter_awal);
            $('#addData #meter_akhir').val(response.meter_akhir);
            $('#addData #jenis').val(response.jenis).trigger('change');
            $('#addData #shift').val(response.shift).trigger('change');
            $('#addData #soda').val(response.soda_ash);
            $('#addData #pac').val(response.pac);
            $('#addData #kaporit').val(response.kaporit);
            
            $('#addData').modal('show');
        },
        error: function(error) {
        }
    });
});

//DELETE
const deleteDosing = "{{ route('delete.dosing') }}"
document.querySelectorAll('.deletedosing').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var dosingId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post(deleteDosing, {
                   dosing_id: dosingId
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

var dosingId;
$(document).ready(function() {
    $('.viewdosing').click(function() {
        dosingId = $(this).data('id');
        console.log(`ID yang diklik: ${dosingId}`);

        $('#viewaddData').attr('data-mode', 'view');

        var url = "{{ route('edit.dosing', ':id') }}".replace(':id', dosingId);

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $('#viewaddData').find('#nrp-view').text(response.nrp);
                $('#viewaddData').find('#name-view').text(response.nama);
                $('#viewaddData').find('#tanggal-view-dosing').text(response.tanggal);
                $('#viewaddData').find('#shift-view-dosing').text(response.shift);
                $('#viewaddData').find('#lokasi-view').text(response.lokasi);
                $('#viewaddData').find('#jenis-view').text(response.jenis);
                // $('#viewaddData').find('#pac-view').text(response.pac);
                $('#viewaddData').find('#meter-awal-view').text(response.meter_awal);
                $('#viewaddData').find('#meter-akhir-view').text(response.meter_akhir);
                $('#viewaddData').find('#meter-pemakaian-view').text(response.meter_akhir)

                let pemakaian = parseFloat(response.meter_akhir) - parseFloat(response.meter_awal);
                $('#viewaddData').find('#meter-pemakaian-view').text(pemakaian);

                // $('#viewaddData').find('#soda-view').text(response.soda_ash);
                // $('#viewaddData').find('#kaporit-view').text(response.kaporit);
              
                $('#viewaddData').modal('show');
            },
            error: function(error) {
                console.error("Error:", error.responseText);
            }
        });
    });
});

$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    var activeTab = $(e.target).attr('id');
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

$(document).ready(function () {
    $('#shift').on('change', function () {
        const shift = $(this).val();

        if (shift === 'Malam') {
            $('#meter_awal').prop('readonly', true);

            const tanggal = $('#tanggal_dosing').val();
            const lokasi = $('#lokasi_dosing').val();
            const jenis = $('#jenis').val();

            if (tanggal && lokasi && jenis) {
                $.ajax({
                    url: '/dosing/get-meter-akhir-siang',
                    method: 'GET',
                    data: {
                        tanggal: tanggal,
                        lokasi: lokasi,
                        jenis: jenis
                    },
                    success: function (response) {
                        $('#meter_awal').val(response.meter_akhir || 0);
                    },
                    error: function () {
                        alert('Gagal mengambil data meter akhir shift siang.');
                    }
                });
            }

        } else {
            $('#meter_awal').prop('readonly', false).val('');
        }
    });
});

// //DOSING PAC
$(document).ready(function() {
var baseUrlPac = "{{ url('/phair-dosing-pac/create') }}";
var basePac = "{{ url('/phair-dosing-pac/myedit') }}";
$('#btn-yes-add-dosing-pac').click(function() {
    var mode = $('#addDataPAC').data('mode');
    
    if (mode === 'add') {
        $.ajax({
            type: 'POST',
             url: baseUrlPac,
            data: $('form').serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di tambahkan!',
                    }).then(() => {
                       location.reload()
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di tambahkan!',
                    }).then(() => {
                       location.reload()
                    });
                }
            },
        });
    } else if (mode === 'edit') {  
        $.ajax({
            type: 'POST',
            url: basePac + '/' + dosingIdPAC,
            data: $('form').serialize() + '&user_id=' + dosingIdPAC,
            success: function(response) {
                if (response.status === 'success') {
                    // Display a SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di edit!',
                    }).then(() => {
                        location.reload()
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data berhasil di edit!',
                    }).then(() => {
                        location.reload()
                    });
                }
            },
        });
    }

    $('#addDataPAC').modal('hide');
    
});
});

//EDIT
var dosingIdPAC; 
var baseUrlPAC = "{{ url('/phair-dosing-pac/get') }}";
$('.editdosingpac').click(function() {
    dosingIdPAC = $(this).data('id');
    $('#addDataPAC').attr('data-mode', 'edit');
    
    $.ajax({
        type: 'GET',
        url: baseUrlPAC + '/' + dosingIdPAC,
        success: function(response) {
        
            $('#addDataPAC #tanggal_dosing_pac').val(response.tanggal);
            $('#addDataPAC #lokasi_dosing_pac').val(response.lokasi).trigger('change');
            $('#addDataPAC #shift_pac').val(response.shift).trigger('change');
            $('#addDataPAC #soda').val(response.soda_ash);
            $('#addDataPAC #pac').val(response.pac);
            $('#addDataPAC #kaporit').val(response.kaporit);
            
            $('#addDataPAC').modal('show');
        },
        error: function(error) {
        }
    });
});

//DELETE
const deleteDosingPac = "{{ route('delete.dosing-pac') }}"
document.querySelectorAll('.deletedosingpac').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var dosingId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post(deleteDosingPac, {
                   dosing_id: dosingId
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

var dosingIdPac;
$(document).ready(function() {
    $('.viewdosingpac').click(function() {
        dosingIdPac = $(this).data('id');
        console.log(`ID yang diklik: ${dosingId}`);

        $('#viewaddDataPac').attr('data-mode', 'view');

        var url = "{{ route('edit.dosing-pac', ':id') }}".replace(':id', dosingIdPac);

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                $('#viewaddDataPac').find('#nrp-view-pac').text(response.nrp);
                $('#viewaddDataPac').find('#name-view-pac').text(response.nama);
                $('#viewaddDataPac').find('#tanggal-view-dosing-pac').text(response.tanggal);
                $('#viewaddDataPac').find('#shift-view-dosing-pac').text(response.shift);
                $('#viewaddDataPac').find('#lokasi-view-pac').text(response.lokasi);
                $('#viewaddDataPac').find('#pac-view').text(response.pac);
                $('#viewaddDataPac').find('#soda-view').text(response.soda_ash);
                $('#viewaddDataPac').find('#kaporit-view').text(response.kaporit);
              
                $('#viewaddDataPac').modal('show');
            },
            error: function(error) {
                console.error("Error:", error.responseText);
            }
        });
    });
});
</script>
   

@endsection

