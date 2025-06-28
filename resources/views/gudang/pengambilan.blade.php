@extends('include/mainlayout')
@section('title', 'pengambilan barang')
@section('content')
    <div class="pagetitle">
      <h1>Pengambilan Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item active">Pengambilan Barang</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> Pengambilan Barang</h5>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"> Add Data</button>
              <br>
                            
                <!-- Modal View -->
                <div class="modal fade" id="viewuserModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Detail Permintaan Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <h6><strong>Tanggal:</strong> <span id="view-request-date"></span></h6>
                        <h6><strong>Requested By:</strong> <span id="view-requested-by"></span></h6>
                        <h6><strong>Area:</strong> <span id="view-area"></span></h6>
                        <h6><strong>Gedung:</strong> <span id="view-gedung"></span></h6>
                        <h6><strong>Lokasi:</strong> <span id="view-lokasi"></span></h6>
                        <h6><strong>Status:</strong> <span id="view-status"></span></h6>
                        <h6><strong>Keterangan Approval:</strong> <span id="view-keterangan"></span></h6>

                        <hr>
                        <h6>Daftar Barang</h6>
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody id="view-items-body">
                        
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                </div>

                <!-- HTML Form Tambah Permintaan Barang -->
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
                                    <!-- Area, Gedung, Lokasi -->
                                    <div class="col-md-4">
                                        
                                        <div class="form-floating">
                                            <select class="form-control" id="area_add" name="area">
                                                <option value="">Pilih Area</option>
                                                <option value="LAUNDRY KARTIKA">LAUNDRY KARTIKA</option>
                                                <option value="LV">LV / SARANA</option>
                                                <option value="Mess">MESS</option>
                                                <option value="Office">Office</option>
                                                <option value="CSA PIT 1">CSA PIT 1</option>
                                                <option value="CSA PIT 2">CSA PIT 2</option>
                                                <option value="CSA PIT 3">CSA PIT 3</option>
                                                <option value="CSA FUEL">CSA FUEL</option>
                                                <option value="PITSTOP">PITSTOP</option>
                                                <option value="OTHER">Lainnya</option>
                                            </select>
                                            <label for="area_add">Area<span class="text-danger">*</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-control" id="gedung_add" name="gedung">
                                                <option value="">Pilih Gedung</option>
                                            </select>
                                            <label for="gedung_add">Gedung</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="lokasi_add" name="lokasi" placeholder="Lokasi">
                                            <label for="lokasi_add">Lokasi</label>
                                        </div>
                                    </div>

                                    <div id="snack-container">
                                        <div class="row mb-3 snack-item">
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control jumlah-stock" name="stock[]" placeholder="Jumlah" min="0" required>
                                                    <label>Jumlah<span class="text-danger">*</label>
                                                    <input type="hidden" class="stok-db" name="stok_db[]">
                                                    <small class="text-danger error-msg d-none">Jumlah melebihi stok tersedia</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
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
                                        </div>
                                    </div>
                                    <div class="add-snack-line mt-3">
                                        <div class="minus-icon" id="remove-snack-btn">-</div>
                                        <div class="line"></div>
                                        <div class="plus-icon" id="add-snack-btn">+</div>
                                    </div>
                                    @if(auth()->user()->id_role == 0)
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                        <textarea class="form-control" placeholder="Masukkan keterangan..." id="keterangan_add" name="keterangan" style="height: 100px"></textarea>
                                        <label for="keterangan_add">Keterangan Approval</label>
                                        </div>
                                    </div>
                                    @endif
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
                            <button type="button" class="btn btn-success btn-approval-action" data-action="ready">✔ Approve</button>
                            <button type="button" class="btn btn-danger btn-approval-action" data-action="rejected">✖ Reject</button>
                            <button type="button" class="btn btn-primary btn-approval-action" data-action="done">📦 Done (Kurangi Stok)</button>
                            <div id="loading-spinner-approve" style="display:none;" >
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
                <div class="modal fade modal_approve" id="appproveModalgagl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                </div>
              

                <div class="table-responsive">
                    <table class="table dt_user responsive-table" id="datatable">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Aksi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal </th>
                            <th scope="col">Nama</th>
                            <th scope="col">Departemen</th>
                            <th scope="col">Area</th>
                            <th scope="col">Gedung</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col" >Keterangan Approval</th>                           
                        </tr>
                        </thead>
                        <tbody>
                    
                        @foreach($PengambilanBarang as $no => $barang)
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
                                        case 'waiting approval GA':
                                            $class = 'badge bg-warning text-dark';
                                            $icon = '<i class="fa-solid fa-hourglass-half"></i>';
                                            break;
                                        case 'ready':
                                            $class = 'badge bg-info text-dark';
                                            $icon = '<i class="fa-solid fa-box-open"></i>';
                                            break;
                                        case 'done':
                                            $class = 'badge bg-success';
                                            $icon = '<i class="fa-solid fa-circle-check"></i>';
                                            break;
                                        case 'rejected':
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
                            <td>{{ $barang->requested_dept }}</td>
                            <td>{{ $barang->area }}</td>
                            <td>{{ $barang->gedung }}</td>
                            <td>{{ $barang->lokasi }}</td>
                            <td class="truncate-text">{{ $barang->keterangan }}</td>
                         

                            
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

document.getElementById('area_add').addEventListener('change', function() {
    const selectedArea = this.value;
    const gedungSelect = document.getElementById('gedung_add');

    gedungSelect.innerHTML = '<option value="">Pilih Gedung</option>';

    if (selectedArea && !['OTHER', 'LV', 'LAUNDRY KARTIKA'].includes(selectedArea)) {
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

$(document).on('click', '.view', function () {
    const id = $(this).data('id');

    $.get('/pengambilan-barang/view/' + id, function (response) {
        if (response.status === 'success') {
            const request = response.request;

            $('#view-request-date').text(request.request_date);
            $('#view-requested-by').text(request.requested_name);
            $('#view-area').text(request.area);
            $('#view-gedung').text(request.gedung);
            $('#view-lokasi').text(request.lokasi);
            $('#view-status').text(request.status);
            $('#view-keterangan').text(request.keterangan);

            $('#view-items-body').empty();

            response.items.forEach((item, index) => {
                $('#view-items-body').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.item_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unit_name}</td>
                    </tr>
                `);
            });
        } else {
            Swal.fire('Gagal', response.message, 'error');
        }
    });
});



//EDIT

$('.edit').on('click', function () {
    const id = $(this).data('id');

    $.get('/pengambilan-barang/edit/' + id, function (response) {
        const data = response.request;
        const items = response.items;
        const allItems = response.all_items;
        const units = response.units;

        if (!data || !Array.isArray(items)) {
            alert('Data tidak lengkap.');
            return;
        }

        $('#area_add').val(data.area);
        $('#gedung_add').val(data.gedung);
        $('#lokasi_add').val(data.lokasi);

        if ($('#keterangan_add').length) {
            $('#keterangan_add').val(data.keterangan ?? '');
        }

        $('#request_id').val(id);

        const container = $('#snack-container');
        container.html('');

        items.forEach(function (item) {
            const html = `
            <div class="row mb-3 snack-item">
                <div class="col-md-4">
                    <div class="form-floating searchable-dropdown">
                        <input type="text" class="form-control search-input" value="${item.name}" placeholder="Cari barang...">
                        <label>Cari Barang</label>
                        <ul class="dropdown-list" style="display:none;">
                            ${allItems.map(it => `
                                <li 
                                    data-id="${it.id}" 
                                    data-stock="${it.stock}"
                                    class="${it.stock === 0 ? 'disabled-item' : ''}" 
                                    style="padding: 8px; cursor: ${it.stock > 0 ? 'pointer' : 'not-allowed'}; color: ${it.stock > 0 ? 'inherit' : '#aaa'};">
                                    ${it.name}
                                    ${it.stock === 0 ? '<small class="text-danger d-block">*stok tidak tersedia</small>' : ''}
                                </li>`).join('')}
                        </ul>
                        <input type="hidden" name="nama_barang[]" class="selected-id" value="${item.item_id}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control jumlah-stock" name="stock[]" value="${item.quantity}" required>
                        <label>Jumlah</label>
                        <input type="hidden" class="stok-db" name="stok_db[]" value="${item.stok_db}">
                        <small class="text-danger error-msg d-none">Jumlah melebihi stok tersedia</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select unit-id" name="unit_id[]" required>
                            ${units.map(unit => `
                                <option value="${unit.id}" ${unit.id === item.unit_id ? 'selected' : ''}>
                                    ${unit.name}
                                </option>`).join('')}
                        </select>
                        <label for="unit_id">Satuan Barang</label>
                    </div>
                </div>
            </div>`;
            
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
            formData.push({
                name: 'keterangan',
                value: $('#keterangan_add').val() || ''
            });

            $.ajax({
                type: 'POST',
                url: '/pengambilan-barang/create',
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

            formData.push({
                name: 'keterangan',
                value: $('#keterangan_add').val() || ''
            });
                
            $.ajax({
                type: 'POST',
                url: '/pengambilan-barang/myedit/' + requestId,
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
       var PengambilanBarangId = this.getAttribute('data-id'); 
       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post('{{ route('delete.pengambilan-barang') }}', {
                   barang_id: PengambilanBarangId
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
//         url: `/pengambilan-barang/approve/${approvalRequestId}`,
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
    $('#approval_request_id').val(approvalRequestId);
    $('#approvalModal').modal('show');
});


$(document).on('click', '.btn-approval-action', function () {
    selectedAction = $(this).data('action'); 
    $('#approvalModal').modal('hide');      
    $('#appproveModalgagl').modal('show');   
});

$('#btn-approval').on('click', function (e) {
    e.preventDefault();

    const keterangan = $('#keterangan_approval').val();
    // if (!keterangan.trim()) {
    //     alert('Keterangan wajib diisi.');
    //     return;
    // }

    $('#btn-approval').hide();
    $('#loading-spinner').show();

    $.ajax({
        url: `/pengambilan-barang/approve/${approvalRequestId}`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            action: selectedAction,
            keterangan: keterangan
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire('Berhasil', response.message || `Permintaan berhasil di-${selectedAction}`, 'success')
                    .then(() => location.reload());
            } else {
                Swal.fire('Gagal', response.message || 'Gagal memproses permintaan.', 'error');
            }
        },
        error: function () {
            Swal.fire('Gagal', 'Terjadi kesalahan saat memproses.', 'error');
        },
        complete: function () {
            $('#btn-approval').show();
            $('#loading-spinner').hide();
            $('#appproceModalgagl').modal('hide');
        }
    });
});



    </script>
   

@endsection

