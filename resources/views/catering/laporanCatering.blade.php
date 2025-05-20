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

            <form method="GET" action="{{ route('lapcatering.index') }}" class="mb-3 form-responsive">
                <div class="row align-items-end">
                    <!-- Pilih Tanggal -->
                    <div class="col-md-3">
                        <label for="date" class="form-label">Pilih Tanggal:</label>
                        <input type="date" name="date" id="date" class="form-control"
                            value="{{ request('date', now()->format('Y-m-d')) }}">
                    </div>

                    @if(auth()->user()->id_role == 0)
                    <div class="col-md-3">
                        <label for="catering">Pilih Catering:</label>
                        <select id="catering" name="catering" class="form-control">
                            <option value="" disabled {{ request('catering') ? '' : 'selected' }}>Pilih Catering</option>
                            <option value="FITRI" {{ request('catering') == 'FITRI' ? 'selected' : '' }}>FITRI</option>
                            <option value="WASTU" {{ request('catering') == 'WASTU' ? 'selected' : '' }}>WASTU</option>
                            <option value="BINTANG" {{ request('catering') == 'BINTANG' ? 'selected' : '' }}>BINTANG</option>
                        </select>
                    </div>
                    @endif

                    <div class="col-md-6 d-flex gap-2 button-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModalDaily">
                            <i class="fas fa-file-word"></i> Daily Order Report
                        </button>

                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-file-excel"></i> Monthly Report
                        </button>

                        {{-- {{-- <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exportModalInvoice">
                            <i class="fas fa-file-invoice"></i> Invoice
                        </button> --}}

                    </div>

                </div>
            </form>

            <!-- Tabs -->
            <ul class="nav nav-tabs mt-4" id="cateringTabs" role="tablist">
                <li class="nav-item" role="presentation">
                <button class="nav-link active" id="reguler-tab" data-bs-toggle="tab" data-bs-target="#reguler" type="button" role="tab" aria-controls="reguler" aria-selected="true">
                    MK Reguler
                </button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="revisi-tab" data-bs-toggle="tab" data-bs-target="#revisi" type="button" role="tab" aria-controls="revisi" aria-selected="false">
                    MK Tambahan
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

            <!-- Modal View Data Snack-->
                <div class="modal fade modal-view" id="viewsnackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Detail Data Snack</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Area</th>
                                            <th>Gedung</th>
                                            <th>Lokasi</th>
                                            <th>Jenis</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="viewDataSnack">
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

                <!-- Modal View Data Spesial-->
                <div class="modal fade modal-view" id="viewspesialModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Detail Data Spesial</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Area</th>
                                            <th>Gedung</th>
                                            <th>Lokasi</th>
                                            <th>Jenis</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="viewDataSpesial">
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

            <!-- Tab Content -->
            <div class="tab-content" id="cateringTabsContent">
                    <!-- Reguler Tab -->
                    <div class="tab-pane fade show active" id="reguler" role="tabpanel" aria-labelledby="reguler-tab">
                    <div class="mt-4">
                        @if (!empty($cateringData))
                            <h4 class="mt-3">Tanggal: {{ $selectedDate }}</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Lokasi</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @foreach ($cateringData as $category => $locations)
                                        @php $categoryTotal = 0; @endphp
                                        @foreach ($locations as $index => $location)
                                            @php
                                                $total = is_numeric($location['total']) ? $location['total'] : 0;
                                                $categoryTotal += $total;
                                                $grandTotal += $total;
                                            @endphp
                                            <tr>
                                                @if ($index == 0)
                                                    <td rowspan="{{ count($locations) }}">{{ $loop->parent->iteration }}</td>
                                                    <td rowspan="{{ count($locations) }}">{{ $category }}</td>
                                                @endif
                                                <td>{{ $location['name'] }}</td>
                                                <td>{{ is_numeric($location['total']) ? number_format($location['total']) : '-' }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="table-secondary fw-bold">
                                            <td colspan="3" class="text-end">Total {{ $category }}</td>
                                            <td>{{ number_format($categoryTotal) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-dark text-white fw-bold">
                                        <td colspan="3" class="text-end">Grand Total</td>
                                        <td>{{ number_format($grandTotal) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <p class="text-center mt-4">Data tidak ditemukan untuk tanggal yang dipilih.</p>
                        @endif
                    </div>
                    </div>

                    <!-- Tambahan  Tab -->
                    <div class="tab-pane fade" id="revisi" role="tabpanel" aria-labelledby="revisi-tab">
                    <div class="mt-4">
                        @if (!empty($cateringDataRevisi))
                            <h4 class="mt-3">Tanggal: {{ $selectedDate }}</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @foreach ($cateringDataRevisi as $category => $locations)
                                        @php $categoryTotal = 0; @endphp
                                        @foreach ($locations as $index => $location)
                                            @php
                                                $total = is_numeric($location['total']) ? $location['total'] : 0;
                                                $categoryTotal += $total;
                                                $grandTotal += $total;
                                            @endphp
                                            <tr>
                                                @if ($index == 0)
                                                    <td rowspan="{{ count($locations) }}">{{ $loop->parent->iteration }}</td>
                                                    <td rowspan="{{ count($locations) }}">{{ $category }}</td>
                                                @endif
                                                <td>{{ $location['name'] }}</td>
                                                <td>{{ is_numeric($location['total']) ? number_format($location['total']) : '-' }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="table-secondary fw-bold">
                                            <td colspan="3" class="text-end">Total {{ $category }}</td>
                                            <td>{{ number_format($categoryTotal) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-dark text-white fw-bold">
                                        <td colspan="3" class="text-end">Grand Total</td>
                                        <td>{{ number_format($grandTotal) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <p class="text-center mt-4">Data tidak ditemukan untuk tanggal yang dipilih.</p>
                        @endif
                    </div>
                    </div>

                    <!-- spesial Tab -->
                    <div class="tab-pane fade" id="spesial" role="tabpanel" aria-labelledby="spesial-tab">
                        <div class="table-responsive">
                        <table class="table dt_spesial responsive datatable" >
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Area</th>
                                <th scope="col">Gedung</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Total</th>
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
                                <td>{{ $spesial->gedung}}</td>
                                <td>{{ $spesial->lokasi}}</td>
                                <td>{{ $spesial->jenis}}</td>
                                <td>{{ $spesial->jumlah}}</td>
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
                        <table class="table dt_snack responsive datatable" >
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Area</th>
                                <th scope="col">Gedung</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Total</th>
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
                                <td>{{ $snack->area}}</td>
                                <td>{{ $snack->gedung}}</td>
                                <td>{{ $snack->waktu}}</td>
                                <td>{{ $snack->lokasi}}</td>
                                <td>{{ $snack->jenis}}</td>
                                <td>{{ $snack->jumlah}}</td>
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
                                </ul>

                            </tr>
                            @endforeach 

                        </tbody>
                        </table>
                        </div>
                    </div>


            </div>

            <!-- Modal Montly Report-->
            <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportModalLabel">Export Data ke Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('/export-excel') }}" method="GET">
                                @csrf

                                @if(auth()->user()->id_role == 0)
                                <div class="col-md-3">
                                    <label for="catering">Pilih Catering:</label>

                                    <select name="catering_export" class="form-select" required>
                                        <option value="" selected disabled>Pilih Catering</option>
                                        <option value="FITRI">FITRI</option>
                                        <option value="WASTU">WASTU</option>
                                        <option value="BINTANG">BINTANG</option>
                                    </select>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label for="month" class="form-label">Bulan:</label>
                                    <select name="month" class="form-select" required>
                                        <option value="">Pilih Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ date("F", mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="year" class="form-label">Tahun:</label>
                                    <select name="year" class="form-select" required>
                                        <option value="">Pilih Tahun</option>
                                        @for ($y = date('Y') - 2; $y <= date('Y') + 10; $y++)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
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

            <!-- Modal Montly Report-->
            <div class="modal fade" id="exportModalDaily" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportModalLabel">Export Daily Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('/export-daily') }}" method="GET">
                                @csrf

                                @if(auth()->user()->id_role == 0)
                                <div class="mb-3">
                                    <label for="catering">Pilih Catering:</label>

                                    <select name="catering_daily" class="form-select" required>
                                        <option value="" selected disabled>Pilih Catering</option>
                                        <option value="FITRI">FITRI</option>
                                        <option value="WASTU">WASTU</option>
                                        <option value="BINTANG">BINTANG</option>
                                    </select>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label for="tanggal_daily" class="form-label">Tanggal:</label>
                                    <input type="date" name="tanggal_daily" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="catering">Jenis Export:</label>

                                    <select name="jenis_data" class="form-select" required>
                                        <option value="" selected disabled>Pilih Data</option>
                                        <option value="PLAN">PLAN ORDER</option>
                                        <option value="TAMBAHAN">TAMBAHAN ORDER</option>
                                    </select>
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

            <!-- Modal Montly Invoice-->
            <div class="modal fade" id="exportModalInvoice" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exportModalLabel">Export Invoice </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-grid gap-2">
                                @if(auth()->user()->id_role == 0 || auth()->user()->tim_pic == 'FITRI')
                                    <a href="{{ route('invoice.index') }}" class="btn btn-warning mb-2">
                                        <i class="fas fa-file-invoice"></i> Export Invoice Catering Fitri
                                    </a>
                                @endif

                                @if(auth()->user()->id_role == 0 || auth()->user()->tim_pic == 'BINTANG')
                                    <a href="{{ route('invoice.index') }}" class="btn btn-warning mb-2">
                                        <i class="fas fa-file-invoice"></i> Export Invoice Catering Bintang
                                    </a>
                                @endif

                                @if(auth()->user()->id_role == 0 || auth()->user()->tim_pic == 'WASTU')
                                    <a href="{{ route('invoice.index') }}" class="btn btn-warning mb-2">
                                        <i class="fas fa-file-invoice"></i> Export Invoice Catering Wastu
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
$("#exportModal form #catering").change(function() {
    console.log("Catering yang dipilih:", $(this).val());
});


//EXPORT MONTHLY REPORT
$(document).ready(function() {
    $("#exportModal form").on("submit", function(event) {
        event.preventDefault();

        let catering_export = $("select[name='catering_export']").val();
        let year = $("select[name='year']").val();
        let month = $("select[name='month']").val();;

        if (!month || !year) {
            alert("Harap pilih bulan dan tahun!");
            return;
        }

        let url = `/lapcatering/export-excel?month=${month}&year=${year}&catering_export=${catering_export}`;

        window.location.href = url;
    });
});

//EXPORT DAILY REPORT
$("#exportModalDaily form #catering_daily").change(function() {
    console.log("Catering yang dipilih:", $(this).val());
});

$(document).ready(function() {
    $("#exportModalDaily form").on("submit", function(event) {
        event.preventDefault();

        let catering_export = $("select[name='catering_daily']").val();
        let tanggal = $("input[name='tanggal_daily']").val();
        let jenis_data = $("select[name='jenis_data']").val();

        if (!tanggal || !jenis_data) {
            alert("Harap pilih tanggal dan jenis data export!");
            return;
        }

        let url = `/lapcatering/export-daily?tanggal=${tanggal}&jenis_data=${jenis_data}&catering_export=${catering_export}`;

        window.location.href = url;
    });
});
// $(document).ready(function() {
//     $("#exportDaily form").on("submit", function(event) {
//         event.preventDefault();

//         let tanggal = $("input[name='tanggal_export_daily']").val();

//         if (!tanggal) {
//             Swal.fire({
//                 icon: "warning",
//                 title: "Oops...",
//                 text: "Harap pilih tanggal!"
//             });
//             return;
//         }

//         let url = `/export-export-dailycatering?tanggal=${tanggal}`;

//         fetch(url, { method: 'GET' })
//             .then(response => {
//                 if (!response.ok) {
//                     return response.json().then(err => { throw err; });
//                 }
//                 window.location.href = url;
//             })
//             .catch(error => {
//                 Swal.fire({
//                     icon: "error",
//                     title: "Gagal Ekspor",
//                     text: error.message || "Data tidak ditemukan untuk tanggal yang dipilih."
//                 });
//             });
//     });
// });

// JavaScript (JS)
$(document).ready(function () {
    $('.view').click(function () {
        let cateringId = $(this).data('id');
        let departemen = $('#departemen').val();
        let selectedCatering = $('#catering').val();

        $.ajax({
            type: 'GET',
            url: '{{ url('/lapcatering/get') }}/' + cateringId,
            data: {
                departemen: departemen,
                catering: selectedCatering
            },
            success: function (response) {
                if (response.error) {
                    alert(response.error);
                    return;
                }

                let userTeam = departemen;
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
                                tempat: field,
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

//VIEW SNACK
var snackId;
$('.viewsnack').click(function () {
    const snackId = $(this).data('id');

    $.ajax({
        type: 'GET',
        url: '{{ url('/snack/get') }}/' + snackId + '?_=' + new Date().getTime(),
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
                    <td>${response.waktu ?? '-'}</td>
                    <td>${response.area ?? '-'}</td>
                    <td>${response.gedung ?? '-'}</td>
                    <td>${response.lokasi ?? '-'}</td>
                    <td>${response.jenis ?? '-'}</td>
                    <td>${response.jumlah ?? '-'}</td>
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

var spesialId;
   $('.viewspesial').click(function () {
    const spesialId = $(this).data('id');

    $.ajax({
        type: 'GET',
        url: '{{ url('/spesial/get') }}/' + spesialId + '?_=' + new Date().getTime(),
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
                    <td>${response.waktu ?? '-'}</td>
                    <td>${response.area ?? '-'}</td>
                    <td>${response.gedung ?? '-'}</td>
                    <td>${response.lokasi ?? '-'}</td>
                    <td>${response.jenis ?? '-'}</td>
                    <td>${response.jumlah ?? '-'}</td>
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




</script>


@endsection

