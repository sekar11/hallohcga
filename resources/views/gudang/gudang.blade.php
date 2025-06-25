@extends('include/mainlayout')
@section('title', 'gudang')
@section('content')
    <div class="pagetitle">
      <h1>Stok Gudang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item active">Stok Gudang</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> Stok Gudang</h5>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"> Add Data</button>
              <br>

              
                {{-- TABS --}}
                <ul class="nav nav-tabs mt-4" id="cateringTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="atk-tab" data-bs-toggle="tab" data-bs-target="#atk" type="button" role="tab" aria-controls="atk" aria-selected="true">
                        Alat Tulis Kantor
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="mep-tab" data-bs-toggle="tab" data-bs-target="#mep" type="button" role="tab" aria-controls="mep" aria-selected="false">
                        MEP
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="plumber-tab" data-bs-toggle="tab" data-bs-target="#plumber" type="button" role="tab" aria-controls="plumber" aria-selected="false">
                        Plumber
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sembako-tab" data-bs-toggle="tab" data-bs-target="#sembako" type="button" role="tab" aria-controls="sembako" aria-selected="false">
                        Sembako
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="peralatan-tab" data-bs-toggle="tab" data-bs-target="#peralatan" type="button" role="tab" aria-controls="peralatan" aria-selected="false">
                        Peralatan
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="perabotan-tab" data-bs-toggle="tab" data-bs-target="#perabotan" type="button" role="tab" aria-controls="perabotan" aria-selected="false">
                        Perabotan
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="seragam-tab" data-bs-toggle="tab" data-bs-target="#seragam" type="button" role="tab" aria-controls="seragam" aria-selected="false">
                        Seragam
                    </button>
                    </li>
                </ul>

              <!-- Modal View -->
                <div class="modal fade modal-view" id="viewuserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-6" id="btn-view">View Stok Barang</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="user-details">
                                    <div class="detail">
                                        <label for="kategori">Kategori :</label>
                                        <span id="kategori-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="name">Nama Barang:</label>
                                        <span id="name-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="stok">Stok Awal:</label>
                                        <span id="stok-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="area">Minimal Stok:</label>
                                        <span id="min_stok-view"></span>
                                    </div>
                                   
                                    <div class="detail">
                                        <label for="ph">Maksimal Stok:</label>
                                        <span id="max_stok-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="satuan">Satuan:</label>
                                        <span id="satuan-view"></span>
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
                <div class="modal-dialog modal-lg"> <!-- Modal Lebar -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="btn-add">Tambah Barang</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form class="row g-3 needs-validation" id="form-add-item">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="category_id">Kategori</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Barang" required>
                                        <label for="name">Nama Barang</label>  
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" list="stockOptions" id="stock" name="stock" placeholder="Stok Awal" min="0" required style="appearance: none;">
                                        <label for="stock">Stok</label>
                                        <datalist id="stockOptions">
                                            @for($i = 1; $i <= 100; $i++)
                                                <option value="{{ $i }}"></option>
                                            @endfor
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" list="stockOptions" id="min_stock" name="min_stock" placeholder="Minimal Stok" min="0" required style="appearance: none;">
                                        <label for="min_stock">Minimal Stok</label>
                                        <datalist id="stockOptions">
                                            @for($i = 1; $i <= 100; $i++)
                                                <option value="{{ $i }}"></option>
                                            @endfor
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" list="stockOptions" id="max_stock" name="max_stock" placeholder="Maxmal Stok" min="0" required style="appearance: none;">
                                        <label for="max_stock">Maximal Stok</label>
                                        <datalist id="stockOptions">
                                            @for($i = 1; $i <= 100; $i++)
                                                <option value="{{ $i }}"></option>
                                            @endfor
                                        </datalist>
                                    </div>
                                </div>
                                {{-- Select Satuan --}}
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="unit_id" name="unit_id" required>
                                            <option value="">-- Pilih Satuan --</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="unit_id">Satuan Barang</label>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-yes-add">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Add -->

             <!--begin::Modal Tambah Stok-->
              <div class="modal fade TambahStokModal" id="TambahStokModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Tambah Stok Barang</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </button>
                          </div>
                          <div class="modal-body">
                                <form class="kt-form kt-form--label-right form_tambah_stok" autocomplete="off">
                                    @csrf
                                    <input type="hidden" name="tambah_id" id="tambah_id">
                                    <div class="form-group">
                                        <h6><strong>Kategori    :</strong> <span id="view-kategori"></span></h6>
                                        <h6><strong>Nama Barang :</strong> <span id="view-nama-barang"></span></h6>
                                        <h6><strong>Stok Awal   :</strong> <span id="view-stok-awal"></span></h6>
                                        <label class="form-control-label">Jumlah <span style="color:red">*</span></label>
                                        <input class="form-control" id="tambah" name="tambah" type="number" min="1">
                                    </div>
                                </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" id="btn-yes-tambah-stok">Kirim</button>
                          </div>
                      </div>
                  </div>
              </div>
              <!--end::Modal Tambah Stok--->

              
              <!-- Table with stripped rows -->
              
              <!-- End Table with stripped rows -->

              <div class="tab-content" id="cateringTabsContent">
                    <!-- ATK Tab -->
                    <div class="tab-pane fade show active" id="atk" role="tabpanel" aria-labelledby="atk-tab">
                        <div class="table-responsive">
                            <table class="table dt_user responsive-table" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Awal</th>
                                    <th scope="col">Minimal Stok</th>
                                    <th scope="col">Maximal Stok</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($StokGudang as $no => $barang)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $barang->category_name }}</td>
                                    <td>{{ $barang->name }}</td>
                                    <td>{{ $barang->stock }}</td>
                                    <td>{{ $barang->min_stock}}</td>
                                    <td>{{ $barang->max_stock }}</td>
                                    <td>{{ $barang->unit_name }}</td>
                                    <td>
                                    @php
                                        $halfMin = $barang->min_stock * 0.5;

                                        if ($barang->stock < $halfMin) {
                                            $status = 'Need RKB';
                                            $class = 'badge bg-danger text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                                        } elseif ($barang->stock >= $halfMin && $barang->stock < $barang->min_stock) {
                                            $status = 'Warning';
                                            $class = 'badge bg-warning text-dark text-center w-100';
                                            $icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                                        } elseif ($barang->stock >= $barang->min_stock && $barang->stock <= $barang->max_stock) {
                                            $status = 'Cukup';
                                            $class = 'badge bg-secondary text-center w-100';
                                            $icon = '<i class="fa-solid fa-boxes-stacked"></i>';
                                        } else {
                                            $status = 'Aman';
                                            $class = 'badge bg-success text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                        }
                                    @endphp

                                        <span class="{!! $class !!}">{!! $icon !!} {{ $status }}</span>
                                    </td>
                                    <td>  
                                        <div class="dropdown">
                                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}"><i class="fa fa-expand"></i>View</a></li>
                                            <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                            <li><a class="dropdown-item tambah" href="#" data-bs-toggle="modal" data-bs-target="#TambahStokModal" data-id="{{ $barang->id }}"><i class="fa-regular bi bi-folder-plus"></i>Tambah Stok</a></li>
                                            <li><a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                        </ul>
                                    </td>
                                @endforeach 
                                
                            </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- MEP Tab -->
                    <div class="tab-pane fade" id="mep" role="tabpanel" aria-labelledby="mep-tab">
                        <div class="table-responsive">
                            <table class="table dt_user responsive-table datatable" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Awal</th>
                                    <th scope="col">Minimal Stok</th>
                                    <th scope="col">Maximal Stok</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($StokMEP as $no => $barang)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $barang->category_name }}</td>
                                    <td>{{ $barang->name }}</td>
                                    <td>{{ $barang->stock }}</td>
                                    <td>{{ $barang->min_stock}}</td>
                                    <td>{{ $barang->max_stock }}</td>
                                    <td>{{ $barang->unit_name }}</td>
                                    <td>
                                    @php
                                        $halfMin = $barang->min_stock * 0.5;

                                        if ($barang->stock < $halfMin) {
                                            $status = 'Need RKB';
                                            $class = 'badge bg-danger text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                                        } elseif ($barang->stock >= $halfMin && $barang->stock < $barang->min_stock) {
                                            $status = 'Warning';
                                            $class = 'badge bg-warning text-dark text-center w-100';
                                            $icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                                        } elseif ($barang->stock >= $barang->min_stock && $barang->stock <= $barang->max_stock) {
                                            $status = 'Cukup';
                                            $class = 'badge bg-secondary text-center w-100';
                                            $icon = '<i class="fa-solid fa-boxes-stacked"></i>';
                                        } else {
                                            $status = 'Aman';
                                            $class = 'badge bg-success text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                        }
                                    @endphp

                                        <span class="{!! $class !!}">{!! $icon !!} {{ $status }}</span>
                                    </td>
                                    <td>  
                                        <div class="dropdown">
                                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}"><i class="fa fa-expand"></i>View</a></li>
                                            <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                            <li><a class="dropdown-item tambah" href="#" data-bs-toggle="modal" data-bs-target="#TambahStokModal" data-id="{{ $barang->id }}"><i class="fa-regular bi bi-folder-plus"></i>Tambah Stok</a></li>
                                            <li><a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                        </ul>
                                    </td>
                                @endforeach 
                                
                            </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- Plumber Tab -->
                    <div class="tab-pane fade" id="plumber" role="tabpanel" aria-labelledby="plumber-tab">
                        <div class="table-responsive">
                            <table class="table dt_user responsive-table datatable" id="datatable-plumber">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Awal</th>
                                    <th scope="col">Minimal Stok</th>
                                    <th scope="col">Maximal Stok</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($StokPlumber as $no => $barang)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $barang->category_name }}</td>
                                    <td>{{ $barang->name }}</td>
                                    <td>{{ $barang->stock }}</td>
                                    <td>{{ $barang->min_stock}}</td>
                                    <td>{{ $barang->max_stock }}</td>
                                    <td>{{ $barang->unit_name }}</td>
                                    <td>
                                    @php
                                        $halfMin = $barang->min_stock * 0.5;

                                        if ($barang->stock < $halfMin) {
                                            $status = 'Need RKB';
                                            $class = 'badge bg-danger text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                                        } elseif ($barang->stock >= $halfMin && $barang->stock < $barang->min_stock) {
                                            $status = 'Warning';
                                            $class = 'badge bg-warning text-dark text-center w-100';
                                            $icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                                        } elseif ($barang->stock >= $barang->min_stock && $barang->stock <= $barang->max_stock) {
                                            $status = 'Cukup';
                                            $class = 'badge bg-secondary text-center w-100';
                                            $icon = '<i class="fa-solid fa-boxes-stacked"></i>';
                                        } else {
                                            $status = 'Aman';
                                            $class = 'badge bg-success text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                        }
                                    @endphp

                                        <span class="{!! $class !!}">{!! $icon !!} {{ $status }}</span>
                                    </td>
                                    <td>  
                                        <div class="dropdown">
                                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}"><i class="fa fa-expand"></i>View</a></li>
                                            <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                            <li><a class="dropdown-item tambah" href="#" data-bs-toggle="modal" data-bs-target="#TambahStokModal" data-id="{{ $barang->id }}"><i class="fa-regular bi bi-folder-plus"></i>Tambah Stok</a></li>
                                            <li><a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                        </ul>
                                    </td>
                                @endforeach 
                                
                            </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Plumber Tab -->
                    <div class="tab-pane fade" id="sembako" role="tabpanel" aria-labelledby="sembako-tab">
                        <div class="table-responsive">
                            <table class="table dt_user responsive-table datatable" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Awal</th>
                                    <th scope="col">Minimal Stok</th>
                                    <th scope="col">Maximal Stok</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($StokSembako as $no => $barang)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $barang->category_name }}</td>
                                    <td>{{ $barang->name }}</td>
                                    <td>{{ $barang->stock }}</td>
                                    <td>{{ $barang->min_stock}}</td>
                                    <td>{{ $barang->max_stock }}</td>
                                    <td>{{ $barang->unit_name }}</td>
                                    <td>
                                    @php
                                        $halfMin = $barang->min_stock * 0.5;

                                        if ($barang->stock < $halfMin) {
                                            $status = 'Need RKB';
                                            $class = 'badge bg-danger text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                                        } elseif ($barang->stock >= $halfMin && $barang->stock < $barang->min_stock) {
                                            $status = 'Warning';
                                            $class = 'badge bg-warning text-dark text-center w-100';
                                            $icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                                        } elseif ($barang->stock >= $barang->min_stock && $barang->stock <= $barang->max_stock) {
                                            $status = 'Cukup';
                                            $class = 'badge bg-secondary text-center w-100';
                                            $icon = '<i class="fa-solid fa-boxes-stacked"></i>';
                                        } else {
                                            $status = 'Aman';
                                            $class = 'badge bg-success text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                        }
                                    @endphp

                                        <span class="{!! $class !!}">{!! $icon !!} {{ $status }}</span>
                                    </td>
                                    <td>  
                                        <div class="dropdown">
                                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}"><i class="fa fa-expand"></i>View</a></li>
                                            <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                            <li><a class="dropdown-item tambah" href="#" data-bs-toggle="modal" data-bs-target="#TambahStokModal" data-id="{{ $barang->id }}"><i class="fa-regular bi bi-folder-plus"></i>Tambah Stok</a></li>
                                            <li><a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                        </ul>
                                    </td>
                                @endforeach 
                                
                            </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- peralatan Tab -->
                    <div class="tab-pane fade" id="peralatan" role="tabpanel" aria-labelledby="peralatan-tab">
                        <div class="table-responsive">
                            <table class="table dt_user responsive-table datatable" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Awal</th>
                                    <th scope="col">Minimal Stok</th>
                                    <th scope="col">Maximal Stok</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($StokPeralatan as $no => $barang)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $barang->category_name }}</td>
                                    <td>{{ $barang->name }}</td>
                                    <td>{{ $barang->stock }}</td>
                                    <td>{{ $barang->min_stock}}</td>
                                    <td>{{ $barang->max_stock }}</td>
                                    <td>{{ $barang->unit_name }}</td>
                                    <td>
                                    @php
                                        $halfMin = $barang->min_stock * 0.5;

                                        if ($barang->stock < $halfMin) {
                                            $status = 'Need RKB';
                                            $class = 'badge bg-danger text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                                        } elseif ($barang->stock >= $halfMin && $barang->stock < $barang->min_stock) {
                                            $status = 'Warning';
                                            $class = 'badge bg-warning text-dark text-center w-100';
                                            $icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                                        } elseif ($barang->stock >= $barang->min_stock && $barang->stock <= $barang->max_stock) {
                                            $status = 'Cukup';
                                            $class = 'badge bg-secondary text-center w-100';
                                            $icon = '<i class="fa-solid fa-boxes-stacked"></i>';
                                        } else {
                                            $status = 'Aman';
                                            $class = 'badge bg-success text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                        }
                                    @endphp

                                        <span class="{!! $class !!}">{!! $icon !!} {{ $status }}</span>
                                    </td>
                                    <td>  
                                        <div class="dropdown">
                                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}"><i class="fa fa-expand"></i>View</a></li>
                                            <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                            <li><a class="dropdown-item tambah" href="#" data-bs-toggle="modal" data-bs-target="#TambahStokModal" data-id="{{ $barang->id }}"><i class="fa-regular bi bi-folder-plus"></i>Tambah Stok</a></li>
                                            <li><a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                        </ul>
                                    </td>
                                @endforeach 
                                
                            </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- perabotan Tab -->
                    <div class="tab-pane fade" id="perabotan" role="tabpanel" aria-labelledby="perabotan-tab">
                        <div class="table-responsive">
                            <table class="table dt_user responsive-table datatable" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Awal</th>
                                    <th scope="col">Minimal Stok</th>
                                    <th scope="col">Maximal Stok</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($StokPerabotan as $no => $barang)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $barang->category_name }}</td>
                                    <td>{{ $barang->name }}</td>
                                    <td>{{ $barang->stock }}</td>
                                    <td>{{ $barang->min_stock}}</td>
                                    <td>{{ $barang->max_stock }}</td>
                                    <td>{{ $barang->unit_name }}</td>
                                    <td>
                                    @php
                                        $halfMin = $barang->min_stock * 0.5;

                                        if ($barang->stock < $halfMin) {
                                            $status = 'Need RKB';
                                            $class = 'badge bg-danger text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                                        } elseif ($barang->stock >= $halfMin && $barang->stock < $barang->min_stock) {
                                            $status = 'Warning';
                                            $class = 'badge bg-warning text-dark text-center w-100';
                                            $icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                                        } elseif ($barang->stock >= $barang->min_stock && $barang->stock <= $barang->max_stock) {
                                            $status = 'Cukup';
                                            $class = 'badge bg-secondary text-center w-100';
                                            $icon = '<i class="fa-solid fa-boxes-stacked"></i>';
                                        } else {
                                            $status = 'Aman';
                                            $class = 'badge bg-success text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                        }
                                    @endphp

                                        <span class="{!! $class !!}">{!! $icon !!} {{ $status }}</span>
                                    </td>
                                    <td>  
                                        <div class="dropdown">
                                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}"><i class="fa fa-expand"></i>View</a></li>
                                            <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                            <li><a class="dropdown-item tambah" href="#" data-bs-toggle="modal" data-bs-target="#TambahStokModal" data-id="{{ $barang->id }}"><i class="fa-regular bi bi-folder-plus"></i>Tambah Stok</a></li>
                                            <li><a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                        </ul>
                                    </td>
                                @endforeach 
                                
                            </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- seragam Tab -->
                    <div class="tab-pane fade" id="seragam" role="tabpanel" aria-labelledby="seragam-tab">
                        <div class="table-responsive">
                            <table class="table dt_user responsive-table datatable" id="datatable">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok Awal</th>
                                    <th scope="col">Minimal Stok</th>
                                    <th scope="col">Maximal Stok</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($StokSeragam as $no => $barang)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $barang->category_name }}</td>
                                    <td>{{ $barang->name }}</td>
                                    <td>{{ $barang->stock }}</td>
                                    <td>{{ $barang->min_stock}}</td>
                                    <td>{{ $barang->max_stock }}</td>
                                    <td>{{ $barang->unit_name }}</td>
                                    <td>
                                    @php
                                        $halfMin = $barang->min_stock * 0.5;

                                        if ($barang->stock < $halfMin) {
                                            $status = 'Need RKB';
                                            $class = 'badge bg-danger text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-exclamation"></i>';
                                        } elseif ($barang->stock >= $halfMin && $barang->stock < $barang->min_stock) {
                                            $status = 'Warning';
                                            $class = 'badge bg-warning text-dark text-center w-100';
                                            $icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                                        } elseif ($barang->stock >= $barang->min_stock && $barang->stock <= $barang->max_stock) {
                                            $status = 'Cukup';
                                            $class = 'badge bg-secondary text-center w-100';
                                            $icon = '<i class="fa-solid fa-boxes-stacked"></i>';
                                        } else {
                                            $status = 'Aman';
                                            $class = 'badge bg-success text-center w-100';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                        }
                                    @endphp

                                        <span class="{!! $class !!}">{!! $icon !!} {{ $status }}</span>
                                    </td>
                                    <td>  
                                        <div class="dropdown">
                                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}"><i class="fa fa-expand"></i>View</a></li>
                                            <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                                            <li><a class="dropdown-item tambah" href="#" data-bs-toggle="modal" data-bs-target="#TambahStokModal" data-id="{{ $barang->id }}"><i class="fa-regular bi bi-folder-plus"></i>Tambah Stok</a></li>
                                            <li><a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                                        </ul>
                                    </td>
                                @endforeach 
                                
                            </tbody>
                            </table>
                        </div>
                    </div>            
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

// var StokGudangId; view
$(document).on('click', '.view', function () {
    const StokGudangId = $(this).data('id');
    
    $('#viewuserModal').attr('data-mode', 'view');

    const url = "{{ route('edit.stok-gudang', ':id') }}".replace(':id', StokGudangId);

    $.ajax({
        type: 'GET',
        url: url,
        success: function(response) {
            $('#viewuserModal').find('#kategori-view').text(response.category_name);
            $('#viewuserModal').find('#name-view').text(response.name);
            $('#viewuserModal').find('#stok-view').text(response.stock);
            $('#viewuserModal').find('#min_stok-view').text(response.min_stock);
            $('#viewuserModal').find('#max_stok-view').text(response.max_stock);
            $('#viewuserModal').find('#satuan-view').text(response.unit_name);

            $('#viewuserModal').modal('show');
        },
        error: function(error) {
            console.error("Error:", error.responseText);
        }
    });
});

//EDIT
$(document).on('click', '.edit', function () {
    StokGudangId = $(this).data('id');
    $('#userModal').attr('data-mode', 'edit');

    $.ajax({
        type: 'GET',
        url: '{{ url('/stok-gudang/get') }}/' + StokGudangId,
        success: function (response) {
            $('#userModal').find('#category_id').val(response.category_id).trigger('change');
            $('#userModal').find('#name').val(response.name);
            $('#userModal').find('#unit_id').val(response.unit_id).trigger('change');
            $('#userModal').find('#stock').val(response.stock);
            $('#userModal').find('#min_stock').val(response.min_stock);
            $('#userModal').find('#max_stock').val(response.max_stock);

            $('#userModal').modal('show');
        },
        error: function (error) {
            console.error("Error:", error.responseText);
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
$('#btn-yes-add').click(function() {
    var mode = $('#userModal').data('mode');
    
    if (mode === 'add') {
        $.ajax({
            type: 'POST',
            url: '{{ url('/stok-gudang/create') }}',
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
            url: '{{ url('/stok-gudang/myedit') }}/' + StokGudangId,
            data: $('form').serialize() + '&user_id=' + StokGudangId,
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
$(document).on('click', '.delete', function(event) {
    event.preventDefault();
    var StokGudangId = $(this).data('id');

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin akan menghapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post('{{ route('delete.stok-gudang') }}', {
                barang_id: StokGudangId
            })
            .then(function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: response.data.message
                }).then(() => {
                    location.reload();
                });
            })
            .catch(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
            });
        }
    });
});

//TAMBAH STOK$
$(document).on('click', '.tambah', function () {
    var id = $(this).data('id');
    $('#tambah_id').val(id); // simpan ID ke input hidden

    $.ajax({
        url: '/stok-gudang/get-barang/' + id,
        method: 'GET',
        success: function (data) {
            $('#view-kategori').text(data.kategori);
            $('#view-nama-barang').text(data.nama_barang);
            $('#view-stok-awal').text(data.stok_awal);
        },
        error: function () {
            alert('Gagal mengambil data barang');
        }
    });
});


$(document).ready(function() {
    $('.tambah').click(function() {
        var tambahId = $(this).data('id');

        $('#btn-yes-tambah-stok').off('click').on('click', function() { // Gunakan off().on() agar event tidak bertambah
            var data = $('.form_tambah_stok').serialize();

            $('#btn-yes-tambah-stok').hide();
            $.ajax({
                type: 'POST',
                url: '/stok-gudang/tambah?tambah_id=' + tambahId,
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
                    $('#btn-yes-tambah-stok').show();
                }
            });
        });
    });
});

    </script>
   

@endsection

