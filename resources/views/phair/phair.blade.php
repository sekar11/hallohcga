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
              <button type="button" class="btn bi bi-plus btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"> Add Data</button>
              <br><br>

              <!-- Modal View -->
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
                                        <label for="lokasi">Lokasi:</label>
                                        <span id="lokasi-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="area">Area:</label>
                                        <span id="area-view"></span>
                                    </div>
                                   
                                    <div class="detail">
                                        <label for="ph">Ph Air:</label>
                                        <span id="ph-view"></span>
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
                        <form class="row g-3 needs-validation" method="POST" action="/user/create">
                        @csrf
                            <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal">
                                <label for="message-text">Tanggal </label>  
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-control" id="lokasi" name="lokasi">
                                    <option value="">Pilih Lokasi</option>
                                    <option value="Mess">MESS</option>
                                    <option value="WT">WT</option>
                                    <option value="WTP">WTP</option>
                                    <option value="STP">STP</option>
                                    <option value="PIT 1">PIT 1</option>
                                    <option value="PIT 2">PIT 2</option>
                                    <option value="PIT 3">PIT 3</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Warehouse">Warehouse</option>
                                    <option value="Office Plant">Office Plant</option>
                                </select>
                                <label for="lokasi">Lokasi</label>
                            </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-control" id="area" name="area">
                                    <option value="">Pilih Area</option>

                                </select>
                                <label for="area">Area</label>
                            </div>
                            </div>
                            <div class="col-md-6">
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
              {{-- End Modal Add --}}
              
              <!-- Table with stripped rows -->
              <div class="table-responsive">
              <table class="table dt_user responsive-table" id="datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">NRP</th>
                    <th scope="col">Nama Crew</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Area</th>
                    <th scope="col">Ph Air</th>
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
                    <td>{{ $ph->lokasi }}</td>
                    <td>{{ $ph->area}}</td>
                    <td>{{ $ph->ph }}</td>
                    <td>  
                    <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $ph->id }}"><i class="fa fa-expand"></i>View</a></li>
                        <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#phModal" data-id="{{ $ph->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                        <li><a class="dropdown-item delete" href="#" data-id="{{ $ph->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
                    </ul>
                
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
  
    {{-- <script src="app/javascript/user.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

<script>

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

//VIEW sekar
var phAirId; 
$('.view').click(function() {
    phAirId = $(this).data('id');
     $('#viewuserModal').attr('data-mode', 'edit');
    
    $.ajax({
        type: 'GET',
        url: '{{ url('/phair/get') }}/' + phAirId,
        success: function(response) {
            $('#viewuserModal').find('#nrp-view').text(response.nrp);
            $('#viewuserModal').find('#name-view').text(response.nama);
            $('#viewuserModal').find('#lokasi-view').text(response.lokasi);
            $('#viewuserModal').find('#area-view').text(response.area);
            $('#viewuserModal').find('#ph-view').text(response.ph);
            $('#viewuserModal').modal('show');
        },
        error: function(error) {
            
        }
    });
});

//EDIT
var phAirId; 
$('.edit').click(function() {
    phAirId = $(this).data('id');
    $('#userModal').attr('data-mode', 'edit');
    
    $.ajax({
        type: 'GET',
        url: '{{ url('/phair/get') }}/' + phAirId,
        success: function(response) {
        
            $('#userModal #tanggal').val(response.tanggal);
            $('#userModal #lokasi').val(response.lokasi);
            $('#userModal').find('#lokasi').val(response.lokasi).trigger('change');
            setTimeout(function() {
                $('#userModal').find('#area').val(response.area);
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
$('#btn-yes-add').click(function() {
    var mode = $('#userModal').data('mode');
    
    if (mode === 'add') {
        $.ajax({
            type: 'POST',
            url: '{{ url('/phair/create') }}',
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
                        icon: 'error',
                        title: 'Error',
                        text: 'Data gagal di tambahkan.',
                    });
                }
            },
        });
    } else if (mode === 'edit') {  
        $.ajax({
            type: 'POST',
            url: '{{ url('/phair/myedit') }}/' + phAirId,
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
                        icon: 'error',
                        title: 'Error',
                        text: 'Data gagal di edit.',
                    });
                }
            },
        });
    }

    $('#userModal').modal('hide');
    
});
});

//DELETE
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
               axios.post('{{ route('delete.phair') }}', {
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
    </script>
   

@endsection

