@extends('include/mainlayout')
@section('title', 'Laporan Complain')
@section('content')
    <div class="pagetitle">
      <h1>Laporan Digital Complain</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item active">Laporan Digital Complain</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i>  Laporan Digital Complain</h5>

              <!-- Modal View -->
                <div class="modal fade modal-view" id="viewComplainModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-6" id="btn-view">View Complain</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="complain-details">
                                    <div class="detail">
                                        <label for="nama_complain">Nama:</label>
                                        <span id="nama_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="divisi_complain">Departemen:</label>
                                        <span id="dept_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="tanggal_complain">Tanggal Complain:</label>
                                        <span id="tanggal_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="area">Area:</label>
                                        <span id="area_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="gedung_complain">Gedung:</label>
                                        <span id="gedung_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="lokasi_complain">Lokasi:</label>
                                       <span id="lokasi_complain" class="info-text"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="permasalahan_complain">Permasalahan :</label>
                                       <span id="permasalahan_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="fotodeviasi_complain">Foto Deviasi :</label>
                                        <span id="fotodeviasi_complain"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="pending">Keterangan Pending :</label>
                                        <span id="pending"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="aprroval">Crew PIC :</label>
                                        <span id="crew_pic"> </span>
                                    </div>
                                     <div class="detail">
                                        <label for="revisi_by">Revisi by GA/GL:</label>
                                        <span id="revisi_by_gagl"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="revisi_desc">Keterangan Revisi GA/GL:</label>
                                        <span id="revisi_desc"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="reject_by">Reject by GA/GL:</label>
                                        <span id="reject_by"> </span>
                                    </div>
                                    <div class="detail">
                                        <label for="reject_desc">Keterangan Reject GA/GL:</label>
                                        <span id="reject_desc"> </span>
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

              <!-- Table with stripped rows -->
              <div class="container">
               <form id="filterForm">
                    <div class="row" method="GET" action="report-complain/search">
                        <div class="col-md-3 mb-2">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $aate ?? '' }}">
                        </div>

                        <div class="col-md-3 mb-2">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                        </div>

                        <div class="col-md-4 mb-2">
                        <label for="end_date"></label><br>
                            <button type="submit" id="searchBtn" class="btn btn-primary btn-sm">
                              <i class="fas fa-filter"></i> Filter
                          </button>
                        </div>
                    </div>
                </form>
                  <div class = "">
                  <div class= "col-md-3 mb-4">
                  <label for="statusFilter">Status:</label>
                  <select id="statusFilter" class="form-select">
                      <option value="">All</option>
                      <option value="Create">Create</option>
                      <option value="Pending Atasan">Pending Atasan</option>
                      <option value="Pending HR:PD">Pending HR:PD</option>
                      <option value="Pending Manager">Pending Manager</option>
                      <option value="Pending Direksi">Pending Direksi</option>
                      <option value="Pending HRGA">Pending HRGA</option>
                      <option value="Revisi Atasan">Revisi Atasan</option>
                      <option value="Revisi HR:PD">Revisi HR:PD</option>
                      <option value="Revisi Manager">Revisi Manager</option>
                      <option value="Revisi Direksi">Revisi Direksi</option>
                      <option value="Revisi HRGA">Revisi HRGA</option>
                      <option value="Aprroved">Approved</option>
                  </select>
                  </div>

              <table class="table dt_complain" id="datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Departemen</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Area</th>
                    <th scope="col">Gedung</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Permasalahan</th>
                    <th scope="col">Foto Deviasi</th>
                    <th scope="col">Skala</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                {{-- //sekar --}}
                @foreach($complainData as $no => $complain)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $complain->nama}}</td>
                    <td>{{ $complain->departemen}}</td>
                    <td>{{ $complain->tanggal}}</td>
                    <td>{{ $complain->area}}</td>
                    {{-- <td class="truncate-text">{{ $complain->informasi}}</td> --}}
                    <td>{{ $complain->gedung}}</td>
                    <td>{{ $complain->lokasi}}</td>
                    <td>{{ $complain->permasalahan}}</td>
                    <td>
                        <img src="{{ asset('storage/' . $complain->foto_deviasi) }}" alt="Foto Deviasi" style="max-width: 100px; max-height: 100px;">
                    </td>
                    <td>{{ $complain->skala ? $complain->skala : '-' }}</td>
                    <td>
                        @if($complain->kode_status == 1)
                            <span class="badge rounded-pill text-bg-primary">Create</span>
                        @elseif($complain->kode_status == 2)
                            <span class="badge rounded-pill text-bg-info text-start">Pending GA/GL</span>
                        @elseif($complain->kode_status == 3)
                            <span class="badge rounded-pill text-bg-info text-start">Pending Crew PIC</span>
                        @elseif($complain->kode_status == 4)
                            <span class="badge rounded-pill text-bg-info text-start">Waiting<br>Approval GA/GL</span>
                        @elseif($complain->kode_status == 5)
                            <span class="badge rounded-pill text-bg-info text-start">Revisi<br>Crew</span>
                        @elseif($complain->kode_status == 6)
                            <span class="badge rounded-pill bg-danger text-start">Reject Crew</span>
                        @elseif($complain->kode_status == 7)
                            <span class="badge rounded-pill bg-success text-light">Done</span>
                        @elseif($complain->kode_status == 8)
                            <span class="badge rounded-pill bg-danger text-start">Reject GA/GL</span>
                        @elseif($complain->kode_status == 9)
                            <span class="badge rounded-pill text-bg-warning text-start">Revisi GA/GL</span>
                        @elseif($complain->kode_status == 10)
                        <span class="badge rounded-pill text-bg-warning text-start">Pending Revisi <br> Crew </span>
                        @elseif($complain->kode_status == 11)
                        <span class="badge rounded-pill text-bg-warning text-start">Revisi<br>Manager</span>
                        @elseif($complain->kode_status == 12)
                        <span class="badge rounded-pill text-bg-warning text-start">Revisi<br>Direksi</span>
                        @elseif($complain->kode_status == 13)
                        <span class="badge rounded-pill text-bg-warning text-start">Revisi<br>HRGA</span>
                        @else
                            <span class="badge rounded-pill bg-danger">Unknown Status</span>
                        @endif
                    </td>
                    <td>
                    <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewComplainModal" data-id="{{ $complain->id }}"><i class="fa fa-expand"></i>View</a></li>
                    </ul>
                    </td>
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


<script>

var myTable = $('#datatable').DataTable();
if (myTable) {
    myTable.destroy();
}
var dataTable = $('#datatable').DataTable({
    dom: 'Bfrtip',
    buttons: [
        {
            text: '<i class="bi bi-file-earmark-excel"></i> Excel',
            className: 'btn btn-success',
            action: function (e, dt, node, config) {
                var tableData = [];
                var promises = [];

                // Iterasi setiap baris di datatable
                dataTable.rows().every(function () {
                    var row = this.data();
                    var imgTag = row[11]; // Anggap kolom ke-12 (index 11) berisi URL gambar

                    if (imgTag) {
                        // Tambahkan promise untuk mengonversi gambar ke base64
                        var promise = convertImageToBase64(imgTag).then(function (base64Img) {
                            row[11] = base64Img; // Ganti URL gambar dengan base64
                        });

                        // Simpan promise ke array
                        promises.push(promise);
                    }

                    tableData.push(row);
                });

                // Tunggu hingga semua gambar selesai dikonversi
                Promise.all(promises).then(function () {
                    console.log('All images converted to base64.');

                    // Kirim data ke backend melalui route Laravel
                    exportToExcel(tableData);
                });
            }
        }
    ]
});

// Fungsi untuk mengonversi gambar menjadi base64
function convertImageToBase64(imageUrl) {
    return new Promise(function (resolve, reject) {
        var img = new Image();
        img.src = imageUrl;

        // Pastikan gambar dimuat terlebih dahulu sebelum konversi
        img.onload = function () {
            var canvas = document.createElement("canvas");
            var ctx = canvas.getContext("2d");

            // Set ukuran canvas sesuai ukuran gambar
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);

            // Mengembalikan base64 gambar setelah dimuat
            var base64Img = canvas.toDataURL("image/jpeg");
            resolve(base64Img);
        };

        img.onerror = function () {
            reject('Error loading image');
        };
    });
}

// Fungsi untuk mengirim data ke backend melalui route Laravel
function exportToExcel(data) {
    var startDate = $('#start_date').val();  // Ambil nilai start_date
    var endDate = $('#end_date').val();  // Ambil nilai end_date
    console.log(starDate)
    $.ajax({
        url: '/report/export',
        method: 'GET',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token untuk Laravel
            tableData: data,  // Kirim data tabel
            start_date: startDate,  // Kirim start_date
            end_date: endDate  // Kirim end_date
        },
        success: function (response) {
            // Unduh file Excel dari backend
            window.location.href = response.downloadUrl;
        },
        error: function (xhr) {
            console.error('Error exporting to Excel:', xhr.responseText);
        }
    });
}




$('#statusFilter').on('change', function () {
    var statusValue = $(this).val();
    dataTable.column(9).search(statusValue).draw();
});

$(document).ready(function() {
    // Hide the "Aksi" column
    $('#datatable').DataTable().column(10).visible(false);
});

//VIEW sekar
var complainId;
$('.view').click(function() {
    complainId = $(this).data('id');
    $('#viewComplainModal').attr('data-mode', 'edit');

    $.ajax({
        type: 'GET',
        url: '{{ url('/complain/get') }}/' + complainId,
        success: function(response) {
            $('#viewComplainModal').find('#nrp').text(response.nrp);
            $('#viewComplainModal').find('#name').text(response.name);
            $('#viewComplainModal').find('#jabatan').text(response.jabatan);
            $('#viewComplainModal').find('#departemen').text(response.departemen);
            $('#viewComplainModal').find('#divisi').text(response.divisi);
            $('#viewComplainModal').find('#jenis_complain').text(response.jenis);
            $('#viewComplainModal').find('#informasi_complain').text(response.informasi);
            $('#viewComplainModal').find('#nama_complain').text(response.nama);
            $('#viewComplainModal').find('#narasumber').text(response.narasumber);
            $('#viewComplainModal').find('#alasan_complain').text(response.alasan);
            $('#viewComplainModal').find('#sharing_complain').text(response.sharing);
            $('#viewComplainModal').find('#waktu_complain').text(response.waktu);
            $('#viewComplainModal').find('#tempat_complain').text(response.tempat);
            $('#viewComplainModal').find('#biaya_complain').text(response.biaya);
            $('#viewComplainModal').find('#approval').text(response.send_name);
            $('#viewComplainModal').find('#revisi_desc').text(response.revisi_desc);
            $('#viewComplainModal').find('#revisi_by').text(response.revisi_name);
            $('#viewComplainModal').find('#reject_by').text(response.reject_name);
            $('#viewComplainModal').find('#reject_desc').text(response.reject_desc);

            $('#viewComplainModal').modal('show');
        },
        error: function(error) {
            // Tampilkan pesan kesalahan jika diperlukan
        }
    });
});


    </script>


@endsection

