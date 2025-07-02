@extends('include/mainlayout')
@section('title', 'rkb')
@section('content')
    <div class="pagetitle">
     <h1>RKB</h1>
     <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item active">RKB</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> RKB</h5>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"> Add Data</button>
              <br>
                            
                <!-- Modal View -->
                <div class="modal fade" id="viewuserModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Detail RKB</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <h6><strong>Tanggal:</strong> <span id="view-request-date"></span></h6>
                        <h6><strong>Requested By:</strong> <span id="view-requested-by"></span></h6>
                        <h6><strong>No RKB:</strong> <span id="view-norkb"></span></h6>
                        <h6><strong>Total Harga:</strong> <span id="view-total-harga"></span></h6>
                        <h6><strong>Status:</strong> <span id="view-status"></span></h6>
                        <hr>
                        <h6><strong>Daftar Barang:</strong> </h6>
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>No</th>
                            <th>Nama Barang</th>  
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="view-items-body">
                        
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                </div>

                <!-- HTML Form Tambah Permintaan rkb-->
                <div class="modal fade modal_add" id="userModal" tabindex="-1" aria-hidden="true" data-mode="add">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Tambah Permintaan Barang</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3" id="form-add-item">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="norkb_add" name="norkb" placeholder="norkb">
                                            <label for="norkb_add">No RKB</label>
                                        </div>
                                    </div>
                                    <div id="snack-container">
                                        <div class="row mb-3 snack-item">
                                            <div class="col-md-6 mb-3">                                       
                                                <div class="form-floating">
                                                    <select class="form-control" id="jenis_add" name="jenis">
                                                        <option value="">Pilih Jenis Barang</option>
                                                        <option value="stock">Stock</option>
                                                        <option value="non stock">Non Stock</option>
                                                    </select>
                                                    <label for="jenis_add">Jenis Barang<span class="text-danger">*</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-floating searchable-dropdown">
                                                    <input type="text" class="form-control search-input" placeholder="Cari barang..." autocomplete="off">
                                                    <label>Cari Barang<span class="text-danger">*</label>
                                                    <ul class="dropdown-list">
                                                        @foreach($items as $item)
                                                            <li
                                                                data-id="{{ $item->stock > 0 ? $item->id : '' }}"
                                                                data-stock="{{ $item->stock }}"
                                                                class="{{ $item->stock == 0 ? 'disabled-item' : '' }}"
                                                                style="padding: 8px; cursor: {{ $item->stock > 0 ? 'pointer' : 'not-allowed' }}; color: {{ $item->stock > 0 ? 'inherit' : '#aaa' }};">
                                                                {{ $item->name }}
                                                                @if($item->stock == 0)
                                                                    <small class="text-danger d-block">*stok tidak tersedia</small>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <input type="hidden" name="nama_barang[]" class="selected-id">
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control jumlah-stock" name="stock[]" placeholder="Jumlah" min="0" required>
                                                    <label>Jumlah<span class="text-danger">*</label>
                                                    <input type="hidden" class="stok-db" name="stok_db[]">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <select class="form-select unit-id" name="unit_id[]" required>
                                                        <option value="">-- Pilih Satuan --</option>
                                                        @foreach($units as $unit)
                                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="unit_id" >Satuan Barang <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="harga_add" name="harga[]" placeholder="harga">
                                                <label for="harga_add">Harga</label>
                                            </div>
                                            
                                    </div>
                                    <hr>
                                        </div>
                                    </div>
                                    <div class="add-snack-line mt-3">
                                        <div class="minus-icon" id="remove-snack-btn">-</div>
                                        <div class="line"></div>
                                        <div class="plus-icon" id="add-snack-btn">+</div>
                                    </div>
   
                                    <input type="hidden" name="request_id" id="request_id">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-yes-add">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <div id="loading-spinner" >
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Approval Action -->
                <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <form id="approvalForm">
                        @csrf
                        <input type="hidden" name="request_id" id="approval_request_id">

                        <div class="modal-header">
                        <h5 class="modal-title" id="approvalModalLabel">Pilih Aksi Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body text-center">
                       
                        <p>Silakan pilih aksi yang ingin dilakukan untuk permintaan ini:</p>
                        <div class="d-grid gap-2">

                            <button type="button" class="btn btn-warning text-dark btn-approval-action" data-action="waiting approval sh">
                                ⏳ Waiting Approval SH
                            </button>

                            <button type="button" class="btn btn-warning text-dark btn-approval-action" data-action="waiting approval sm">
                                ⏳ Waiting Approval SM
                            </button>

                            <button type="button" class="btn btn-info text-dark btn-approval-action" data-action="ready">
                                📦 Ready
                            </button>

                            <button type="button" class="btn btn-primary text-white btn-approval-action" data-action="partial">
                                📦 Partial
                            </button>

                            <button type="button" class="btn btn-success btn-approval-action" data-action="done">
                                ✔ Done
                            </button>

                            <div id="loading-spinner-approve" style="display:none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                            </div>

                        </div>


                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>

                <!--begin::Modal Approval; GA GL-->
                <!-- <div class="modal fade modal_approve" id="appproveModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Keterangan Approval</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="kt-form kt-form--label-right form_approve" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <textarea class="form-control" id="keterangan_approval" name="keterangan_approval" rows="8"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn-approval">Kirim</button>
                                <div id="loading-spinner" >
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="modal fade" id="approvalItemsModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Approval Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th class="th-jumlah-datang" style="display:none;">Jumlah Data Partial</th>
                                <th class="th-sisa-barang" style="display:none;">Sisa Barang</th>
                                <th class="th-tambah-datang" style="display:none;">Tambah Data Partial</th>
                            </tr>
                            </thead>
                            <tbody id="approval-items-body"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="save-approval-items">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table dt_user responsive-table" id="datatable">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Aksi</th>
                            <th scope="col">Status Dokumen RKB</th>
                            <th scope="col">Tanggal </th>
                            <th scope="col">Nama </th>
                            <th scope="col">No RKB</th>
                            <th scope="col">Item</th>
                            <th scope="col">Item Summary</th>
                            <th scope="col">Total Harga</th>                     
                        </tr>
                        </thead>
                        <tbody>
                    
                        @foreach($Rkb as $no => $barang)
                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>  
                                <div class="dropdown">
                                <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                               <ul class="dropdown-menu">
                                @php
                                    $userRole = auth()->user()->id_role;
                                @endphp
                                    @if ($barang->status === 'waiting approval GA' && in_array($userRole, [1, 2, 6]))
                                        <li>
                                            <a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}">
                                                <i class="fa fa-expand"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </a>
                                        </li>
                                    @elseif ($userRole == 0)
                                    <li>
                                        <a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}">
                                            <i class="fa fa-expand"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $barang->id }}">
                                            <i class="fa-regular fa-pen-to-square"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item delete" href="#" data-id="{{ $barang->id }}">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item approval" href="#" data-id="{{ $barang->id }}">
                                            <i class="fa fa-check-circle"></i> Approval
                                        </a>
                                    </li>
                                    @elseif (in_array($barang->status, ['ready', 'done']))
                                        <li>
                                            <a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $barang->id }}">
                                                <i class="fa fa-expand"></i> View
                                            </a>
                                        </li>
                                    @endif
                            </ul>

                            </td>
                               <td>
                                @php
                                    switch ($barang->status) {
                                        case 'Waiting Proses':
                                            $class = 'badge bg-warning text-dark';
                                            $icon = '<i class="fa-solid fa-hourglass-half"></i>';
                                            break;
                                        case 'Waiting Approval SH':
                                            $class = 'badge bg-warning text-dark';
                                            $icon = '<i class="fa-solid fa-hourglass-half"></i>';
                                            break;
                                        case 'Ready':
                                            $class = 'badge bg-info text-dark';
                                            $icon = '<i class="fa-solid fa-box-open"></i>';
                                            break;
                                        case 'Done':
                                            $class = 'badge bg-success';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                            break;
                                        case 'Rejected':
                                            $class = 'badge bg-danger';
                                            $icon = '<i class="fa-solid fa-circle-xmark"></i>';
                                            break;
                                        default:
                                            $class = 'badge bg-secondary';
                                            $icon = '<i class="fa-solid fa-question-circle"></i>';
                                    }
                                @endphp

                                <span class="{{ $class }}">{!! $icon !!} {{ ucfirst($barang->status) }}</span>
                            </td>
                            <td>{{ $barang->request_date }}</td>
                            <td>{{ $barang->requested_name }}</td>
                            <td>{{ $barang->no_rkb }}</td>
                            <td>{{ $barang->total_item }}</td>
                            <td>
                                @if($barang->approve_count > 0)
                                    {{ $barang->approve_count }} Approved, 
                                @endif
                                @if($barang->pending_count > 0)
                                    {{ $barang->pending_count }} Pending, 
                                @endif
                                @if($barang->done_count > 0)
                                    {{ $barang->done_count }} Done
                                @endif
                            </td>
                            <td>{{ $barang->total_harga }}</td>
                            
                        @endforeach 
                        
                    </tbody>
                    </table>
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

    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>

function initSearchableDropdown(container) {
    if (!container) return; 

    const input = container.querySelector('.search-input');
    const list = container.querySelector('.dropdown-list');
    const hiddenInput = container.querySelector('.selected-id');
    const stokDbInput = container.closest('.snack-item').querySelector('.stok-db');

    if (!input || !list || !hiddenInput || !stokDbInput) return;

    list.style.display = 'none';

    input.addEventListener('input', function () {
        const keyword = input.value.toLowerCase();
        list.style.display = 'block';

        list.querySelectorAll('li').forEach(function (item) {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(keyword) ? 'block' : 'none';
        });
    });

    list.querySelectorAll('li').forEach(function (item) {
        item.addEventListener('click', function () {
            if (item.classList.contains('disabled-item')) return;

            input.value = item.textContent.trim();
            hiddenInput.value = item.dataset.id;
            stokDbInput.value = item.dataset.stock;
            list.style.display = 'none';
        });
    });

    document.addEventListener('click', function (e) {
        if (!container.contains(e.target)) {
            list.style.display = 'none';
        }
    });
}


// Inisialisasi pertama
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.searchable-dropdown').forEach(initSearchableDropdown);
});

document.getElementById('add-snack-btn').addEventListener('click', function () {
    const container = document.getElementById('snack-container');
    const firstItem = container.querySelector('.snack-item');
    const clone = firstItem.cloneNode(true); 

    clone.querySelectorAll('input').forEach(input => input.value = '');
    clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

    const originalList = firstItem.querySelector('.dropdown-list');
    const cloneList = clone.querySelector('.dropdown-list');
    if (originalList && cloneList) {
        cloneList.innerHTML = originalList.innerHTML;
    }

    container.appendChild(clone);

    const newDropdownContainer = clone.querySelector('.searchable-dropdown');
    if (newDropdownContainer) {
        initSearchableDropdown(newDropdownContainer);
    }
});


document.getElementById('remove-snack-btn').addEventListener('click', function () {
    const items = document.querySelectorAll('.snack-item');
    if (items.length > 1) {
        items[items.length - 1].remove();
    } else {
        alert("Minimal satu baris harus ada.");
    }
});


document.addEventListener('input', function (e) {
    if (e.target.classList.contains('jumlah-stock')) {
        const jumlahInput = e.target;
        const snackItem = jumlahInput.closest('.snack-item');
        const stokDbInput = snackItem.querySelector('.stok-db');
        const errorMsg = snackItem.querySelector('.error-msg');

        const stok = parseInt(stokDbInput?.value || 0);
        const jumlah = parseInt(jumlahInput.value || 0);

        console.log('Jumlah input:', jumlah);
        console.log('Stok dari DB:', stok);
        console.log('Valid?', jumlah > stok);

        if (jumlah > stok) {
            errorMsg.classList.remove('d-none');
            errorMsg.innerText = 'Jumlah melebihi stok tersedia';
        } else {
            errorMsg.classList.add('d-none');
        }
    }
});

//Active Tab
document.querySelectorAll('.datatable').forEach(function(table) {
  new DataTable(table);
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

const gedungOptions = {
    'Mess': [
        'A1', 'A2', 'B1', 'B2', 'B3', 'B4', 'B7', 'B8', 'B9', 'B10','C3', 'MASJID ASSALAM', 'KOPPA MART', 'FOOD COURT', 'POS SECURITY', 'WTP', 'STP', 'GUDANG GA', 'OFFICE GA', 'WORKSHOP TRAC', 'WORKSHOP KPM', 'WASHPAD'
    ],
    'Office': [
        'WAREHOUSE', 'GENSET', 'OFFICE PLANT', 'WORKSHOP PLANT', 'KOPPA MART', 'MASJID AL KAUTSAR', 'LIMBAH B3'
    ],
    'CSA PIT 1': [
        'OFFICE SHE', 'OFFICE AKADEMI', 'OFFICE ICT', 'CSA FUEL'
    ],
    'CSA PIT 2': [
        'CSA OB', 'CSA HRM'
    ],
    'CSA PIT 3': [
        'CSA OB', 'OFFICE CCR'
    ],
    'CSA FUEL': [
        'SPBI PPA'
    ],
    'PITSTOP': [
        'MUSHOLLA', 'WORKSHOP TRACK', 'AKADEMI', 'FABRIKASI', 'TOOLS', 'TYRE', 'TRACKINDO', 'SUPPORT'
    ],
    'OTHER': [], 
    'LV': [], 
    'LAUNDRY KARTIKA': [],
};


// Jumlah karakter data tabel
$(document).ready(function() {
    $('.truncate-text').each(function() {
        var maxLength =40; 
        var originalText = $(this).text();

        if (originalText.length > maxLength) {
            var truncatedText = originalText.substring(0, maxLength) + '...';
            $(this).text(truncatedText);
        }
    });
});

// $(document).on('click', '.view', function () {
//     const id = $(this).data('id');

//     $.get('/rkb/view/' + id, function (response) {
//         if (response.status === 'success') {
//             const request = response.request;

//             $('#view-request-date').text(request.request_date);
//             $('#view-requested-by').text(request.requested_name);
//             $('#view-norkb').text(request.no_rkb);
//             $('#view-status').text(request.status);
//             $('#view-total-harga').text(response.total_harga);

//             $('#view-items-body').empty();

//             response.items.forEach((item, index) => {
//                 $('#view-items-body').append(`
//                     <tr>
//                         <td>${index + 1}</td>
//                         <td>${item.item_name}</td>
//                         <td>${item.quantity}</td>
//                         <td>${item.unit_name}</td>
//                         <td>${item.harga}</td>
//                         <td>${item.total_harga}</td>
//                         <td>${item.jenis}</td>
//                         <td>${item.status}</td>
//                     </tr>
//                 `);
//             });

           

//         } else {
//             Swal.fire('Gagal', response.message, 'error');
//         }
//     });
// });
$(document).on('click', '.view', function () {
    const id = $(this).data('id');

    $.get('/rkb/view/' + id, function (response) {
        if (response.status === 'success') {
            const request = response.request;

            $('#view-request-date').text(request.request_date);
            $('#view-requested-by').text(request.requested_name);
            $('#view-norkb').text(request.no_rkb);
            $('#view-status').text(request.status);
            $('#view-total-harga').text(response.total_harga);

            $('#view-items-body').empty();

            response.items.forEach((item, index) => {
                const statusBadge = getStatusBadge(item.status);
                $('#view-items-body').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.item_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unit_name}</td>
                        <td>${item.harga}</td>
                        <td>${item.total_harga}</td>
                        <td>${item.jenis}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `);
            });

        } else {
            Swal.fire('Gagal', response.message, 'error');
        }
    });
});

// Function untuk mapping status → badge + icon
function getStatusBadge(status) {
    let badgeClass = 'badge bg-secondary';
    let icon = '<i class="fa-solid fa-question-circle"></i>';

    switch (status) {
        case 'approve':
            badgeClass = 'badge bg-info text-dark';
            icon = '<i class="fa-solid fa-circle-check"></i>';
            break;
        case 'ready':
            badgeClass = 'badge bg-info text-dark';
            icon = '<i class="fa-solid fa-circle-check"></i>';
            break;
        case 'pending':
            badgeClass = 'badge bg-warning text-dark';
            icon = '<i class="fa-solid fa-hourglass-half"></i>';
            break;
        case 'done':
            badgeClass = 'badge bg-success';
            icon = '<i class="fa-solid fa-check-double"></i>';
            break;
        case 'partial':
            badgeClass = 'badge bg-success';
            icon = '<i class="fa-solid fa-check-double"></i>';
            break;
        case 'reject':
            badgeClass = 'badge bg-danger';
            icon = '<i class="fa-solid fa-circle-xmark"></i>';
            break;
        case 'supply':
            badgeClass = 'badge bg-primary';
            icon = '<i class="fa-solid fa-truck"></i>';
            break;
    }

    return `<span class="${badgeClass}">${icon} ${status}</span>`;
}


// EDIT DATA RKB
$('.edit').on('click', function () {
    const id = $(this).data('id');

    $.get('/rkb/edit/' + id, function (response) {
        const data = response.request;
        const items = response.items;
        const allItems = response.all_items;
        const units = response.units;

        if (!data || !Array.isArray(items)) {
            alert('Data tidak lengkap.');
            return;
        }

        // isi field form utama
        $('#norkb_add').val(data.no_rkb);
        $('#request_id').val(id);

        const container = $('#snack-container');
        container.html(''); // clear dulu

        // loop barang yang sudah ada
        items.forEach(function (item) {
            const html = `
            <div class="row mb-3 snack-item">
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <select class="form-control" name="jenis[]" required>
                            <option value="">Pilih Jenis Barang</option>
                            <option value="stock" ${item.jenis === 'stock' ? 'selected' : ''}>Stock</option>
                            <option value="non stock" ${item.jenis === 'non stock' ? 'selected' : ''}>Non Stock</option>
                        </select>
                        <label>Jenis Barang<span class="text-danger">*</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating searchable-dropdown">
                        <input type="text" class="form-control search-input" value="${item.name}" placeholder="Cari barang..." autocomplete="off">
                        <label>Cari Barang<span class="text-danger">*</label>
                        <ul class="dropdown-list" style="display:none;">
                            ${allItems.map(it => `
                                <li 
                                    data-id="${it.id}" 
                                    data-stock="${it.stock}"
                                    class="${it.stock === 0 ? 'disabled-item' : ''}" 
                                    style="padding:8px;cursor:${it.stock > 0 ? 'pointer' : 'not-allowed'};color:${it.stock > 0 ? 'inherit' : '#aaa'};">
                                    ${it.name}
                                    ${it.stock === 0 ? '<small class="text-danger d-block">*stok tidak tersedia</small>' : ''}
                                </li>
                            `).join('')}
                        </ul>
                        <input type="hidden" name="nama_barang[]" class="selected-id" value="${item.item_id}">
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="form-floating">
                        <input type="number" class="form-control jumlah-stock" name="stock[]" value="${item.quantity}" required>
                        <label>Jumlah<span class="text-danger">*</label>
                        <input type="hidden" class="stok-db" name="stok_db[]" value="${item.stok_db || 0}">
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="form-floating">
                        <select class="form-select unit-id" name="unit_id[]" required>
                            ${units.map(unit => `
                                <option value="${unit.id}" ${unit.id === item.unit_id ? 'selected' : ''}>${unit.name}</option>
                            `).join('')}
                        </select>
                        <label>Satuan Barang<span class="text-danger">*</label>
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="harga[]" value="${item.harga}" placeholder="harga">
                        <label>Harga</label>
                    </div>
                </div>
                <hr>
            </div>
            
            `;
            container.append(html);
        });

        $('.searchable-dropdown').each(function () {
            initSearchableDropdown(this);
        });

        $('#userModal').data('mode', 'edit').modal('show');
    });
});


function setDropdownSelected(selector, value) {
    $(selector).val(value);
    $(selector + ' option').filter(function() {
        return $(this).val() == value;
    }).prop('selected', true);
}

$(document).ready(function () {
    $('#btn-yes-add').click(function () {
        const mode = $('#userModal').data('mode');
        const formData = $('#form-add-item').serialize();
        
        $('#btn-yes-add').hide();
        $('#loading-spinner').show();

        if (mode === 'add') {
            let formData = $('#form-add-item').serializeArray();

            $.ajax({
                type: 'POST',
                url: '/rkb/create',
                data: formData,
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data berhasil ditambahkan!',
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menambahkan, periksa kembali data!',
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menambahkan data.',
                    });
                },
                complete: function() {

                    $('#btn-yes-add').show();
                    $('#loading-spinner').hide();
                }
            });
        } else if (mode === 'edit') {
            const requestId = $('#request_id').val();
            let formData = $('#form-add-item').serializeArray();

                
            $.ajax({
                type: 'POST',
                url: '/rkb/myedit/' + requestId,
                data: formData,
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data berhasil diedit!',
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal mengedit data!',
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengedit data.',
                    });
                },
                complete: function() {
                    $('#btn-yes-add').show();
                    $('#loading-spinner').hide();
                }
            });
        }
    });
});


function generateItemListHtml(items) {
    return items.map(item => `
        <li data-id="${item.id}" data-stock="${item.stock}" 
            class="${item.stock == 0 ? 'disabled-item' : ''}" 
            style="padding:8px; cursor:${item.stock > 0 ? 'pointer' : 'not-allowed'}; color:${item.stock > 0 ? 'inherit' : '#aaa'};">
            ${item.name}
            ${item.stock == 0 ? '<small class="text-danger d-block">*stok tidak tersedia</small>' : ''}
        </li>
    `).join('');
}

function generateUnitOptionsHtml(units, selectedId) {
    return units.map(unit => `
        <option value="${unit.id}" ${unit.id == selectedId ? 'selected' : ''}>${unit.name}</option>
    `).join('');
}


//DELETE
document.querySelectorAll('.delete').forEach(function(link) {
   link.addEventListener('click', function(event) {
       event.preventDefault();
       var RkbId = this.getAttribute('data-id'); 
       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post('{{ route('delete.rkb') }}', {
                   barang_id: RkbId
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

// let approvalRequestId = null;
// $(document).on('click', '.approval', function () {
//     approvalRequestId = $(this).data('id');
//     $('#approval_request_id').val(approvalRequestId);
//     $('#approvalModal').modal('show');
// });

// $(document).on('click', '.btn-approval', function () {
//     const action = $(this).data('action');

//     $('#btn-approval').hide();
//     $('#loading-spinner-approve').show();

//     $.ajax({
//         url: `/rkb/approve/${approvalRequestId}`,
//         type: 'POST',
//         data: {
//             _token: '{{ csrf_token() }}',
//             action: action
//         },
//         success: function (response) {
//             if (response.status === 'success') {
//                 Swal.fire('Berhasil', response.message || `Permintaan berhasil di-${action}`, 'success')
//                     .then(() => location.reload());
//             } else {
//                 Swal.fire('Gagal', response.message || 'Gagal memproses permintaan.', 'error');
//             }
//         },
//         error: function () {
//             Swal.fire('Gagal', 'Terjadi kesalahan saat memproses.', 'error');
//         },
//         complete: function() {
//             $('#btn-approval').show();
//             $('#loading-spinner-approve').hide();
//         }
//     });
// });

let approvalRequestId = null;
let selectedAction = null;

$(document).on('click', '.approval', function () {
    approvalRequestId = $(this).data('id');
    console.log( 'berikut id nya ' + approvalRequestId)
    $('#approval_request_id').val(approvalRequestId);
    $('#approvalModal').modal('show');
});

// $(document).on('click', '.btn-approval-action', function () {
//     selectedAction = $(this).data('action'); 
//     $('#approvalModal').modal('hide');      
//     $('#appproveModalgagl').modal('show');   
// });

// $('#btn-approval').on('click', function (e) {
//     e.preventDefault();

//     const keterangan = $('#keterangan_approval').val();
//     // if (!keterangan.trim()) {
//     //     alert('Keterangan wajib diisi.');
//     //     return;
//     // }

//     $('#btn-approval').hide();
//     $('#loading-spinner').show();

//     $.ajax({
//         url: `/rkb/approve/${approvalRequestId}`,
//         type: 'POST',
//         data: {
//             _token: '{{ csrf_token() }}',
//             action: selectedAction,
//             keterangan: keterangan
//         },
//         success: function (response) {
//             if (response.status === 'success') {
//                 Swal.fire('Berhasil', response.message || `Permintaan berhasil di-${selectedAction}`, 'success')
//                     .then(() => location.reload());
//             } else {
//                 Swal.fire('Gagal', response.message || 'Gagal memproses permintaan.', 'error');
//             }
//         },
//         error: function () {
//             Swal.fire('Gagal', 'Terjadi kesalahan saat memproses.', 'error');
//         },
//         complete: function () {
//             $('#btn-approval').show();
//             $('#loading-spinner').hide();
//             $('#appproceModalgagl').modal('hide');
//         }
//     });
// });



$(document).on('click', '.btn-approval-action', function () {
    selectedAction = $(this).data('action');
    approvalRequestId = $('#approval_request_id').val();
    console.log(`Request ID: ${approvalRequestId}, Action: ${selectedAction}`);

    $.get(`/rkb/items/${approvalRequestId}`, function (response) {
    if (response.status === 'success') {
        const items = response.items;
        let tbody = '';
        let hasPartial = false;

       items.forEach(item => {
            if (item.status === 'partial') hasPartial = true;

            const sisaBarang = item.quantity - item.jumlah_datang;

            tbody += `
            <tr data-id="${item.id}">
                <td>${item.item_name}</td>
                <td><input type="number" class="form-control form-control-sm quantity" value="${item.quantity}" readonly></td>
                <td><input type="number" class="form-control form-control-sm harga" value="${item.harga}"></td>
                <td>
                    <select class="form-select form-select-sm status">
                        <option value="approve" ${item.status === 'approve' ? 'selected' : ''}>Approve</option>
                        <option value="pending" ${item.status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="reject" ${item.status === 'reject' ? 'selected' : ''}>Reject</option>
                        <option value="ready" ${item.status === 'ready' ? 'selected' : ''}>Ready</option>
                        <option value="done" ${item.status === 'done' ? 'selected' : ''}>Done</option>
                        <option value="partial" ${item.status === 'partial' ? 'selected' : ''}>Partial</option>
                        <option value="supply" ${item.status === 'supply' ? 'selected' : ''}>Supply</option>
                    </select>
                </td>
                <td><input type="number" class="form-control form-control-sm jumlah-datang" value="${item.jumlah_datang}" readonly></td>
                
                <td><input type="number" class="form-control form-control-sm sisa-barang" value="${sisaBarang}" readonly style="display:${item.status === 'partial' ? 'block' : 'none'};"></td>
                <td><input type="number" class="form-control form-control-sm tambah-datang" placeholder="Jumlah Datang" style="display:${item.status === 'partial' ? 'block' : 'none'};"></td>
            </tr>`;
        });


        // Isi tbody
        $('#approval-items-body').html(tbody);

        // Tampilkan th jika ada partial di awal
        if (hasPartial) {
            $('.th-jumlah-datang, .th-tambah-datang, .th-sisa-barang').show();
        } else {
            $('.th-jumlah-datang, .th-tambah-datang, .th-sisa-barang').hide();
        }

        $('#approvalItemsModal').modal('show');

    } else {
        Swal.fire('Error', 'Data item tidak ditemukan', 'error');
    }
});

});


$('#save-approval-items').on('click', function () {
    const items = [];

    // $('#approval-items-body tr').each(function () {
    //     items.push({
    //         id: $(this).data('id'),
    //         quantity: $(this).find('.quantity').val(),
    //         harga: $(this).find('.harga').val(),
    //         status: $(this).find('.status').val()
    //     });
    // });

    $('#approval-items-body tr').each(function () {
        items.push({
            id: $(this).data('id'),
            quantity: $(this).find('.quantity').val(),
            harga: $(this).find('.harga').val(),
            status: $(this).find('.status').val(),
            jumlah_datang: $(this).find('.status').val() === 'partial'
                ? $(this).find('.tambah-datang').val()
                : $(this).find('.quantity').val()
        });
    });


    $.ajax({
        url: `/rkb/approve/${approvalRequestId}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            action: selectedAction,
            items: items
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire('Berhasil', response.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Gagal', response.message, 'error');
            }
        },
        error: function () {
            Swal.fire('Gagal', 'Terjadi kesalahan server', 'error');
        }
    });
});

$(document).on('change', '.status', function () {
    const row = $(this).closest('tr');
    if ($(this).val() === 'partial') {
        // Show kolom input di baris ini
        row.find('.jumlah-datang, .tambah-datang, .sisa-barang').show();
        // Show header kolom
        $('.th-jumlah-datang, .th-tambah-datang, .th-sisa-barang').show();
    } else {
        row.find('.jumlah-datang, .tambah-datang, .sisa-barang').hide().val('');

        // Cek kalau gak ada satupun status partial, sembunyikan kembali header kolom
        if ($('.status option:selected[value="partial"]').length === 0) {
            $('.th-jumlah-datang, .th-tambah-datang, .th-sisa-barang').hide();
        }
    }
});


$(document).on('input', '.tambah-datang', function () {
    const row = $(this).closest('tr');
    const quantity = parseInt(row.find('.quantity').val()) || 0;
    const jumlahDatang = parseInt(row.find('.jumlah-datang').val()) || 0;
    const tambahDatang = parseInt($(this).val()) || 0;

    const totalDatang = jumlahDatang + tambahDatang;
    const sisa = quantity - totalDatang;

    row.find('.sisa-barang').val(sisa >= 0 ? sisa : 0);
});




    </script>
   

@endsection

