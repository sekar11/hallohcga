@extends('include/mainlayout')
@section('title', 'user')
@section('content')
    <div class="pagetitle">
      <h1>User Management</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item active">User Management</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> User Management</h5>
              <button type="button" class="btn bi bi-plus btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"> Add user</button>
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
                                        <label for="username">Username:</label>
                                        <span id="username-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="email">Email:</label>
                                        <span id="email-view"></span>
                                    </div>
                                   
                                    <div class="detail">
                                        <label for="departemen">Departemen:</label>
                                        <span id="departemen-view"></span>
                                    </div>
                                   
                                    <div class="detail">
                                        <label for="phone_number">No. HP:</label>
                                        <span id="phone_number-view"></span>
                                    </div>
                                    <div class="detail">
                                        <label for="alamat">Perusahaan:</label>
                                        <span id="alamat-view"></span>
                                    </div>  
                                     <div class="detail">
                                        <label for="id_role">Status User:</label>
                                        <span id="id_role-view"></span>
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
                        <h1 class="modal-title fs-5" id="btn-add">Add User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <form class="row g-3 needs-validation" method="POST" action="/user/create">
                        @csrf
                            <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nrp" name="nrp" placeholder="Name">
                                <label for="message-text">NRP </label>  
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Name">
                                <label for="message-text">Username </label>  
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Name">
                                <label for="message-text">Nama </label>  
                            </div>
                            </div>
                             <div class="col-md-6">
                             <div class="form-floating">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                <label for="message-text">Email </label>
                            </div>
                            </div>
                            <div class="col-md-6">
                             <div class="form-floating">
                                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No. HP">
                                <label for="message-text">No. HP </label>
                            </div>
                            </div>
                            <div class="col-md-6">
                             <div class="form-floating">
                                <input type="text" class="form-control" id="dept" name="dept" placeholder="Departemen">
                                <label for="message-text">Departemen </label>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text"class="form-control" id="perusahaan" name="perusahaan" placeholder="alamat">
                                <label for="message-text">Perusahaan</label>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-control" id="id_role" name="id_role">
                                    <option value="" selected>Select Level</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Level 1</option>
                                    <option value="2">Level 2</option>
                                    <option value="3">Level 3</option>
                                </select>
                             <label for="jenis_user">Status user<span style="color:red">*</span></label>
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
              <div class="container">
              <table class="table dt_user responsive" id="datatable">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">NRP</th>
                    <th scope="col">Nama</th>
                    <th scope="col" class="hide-mobile">Email</th>
                    <th scope="col" class="hide-mobile">Departemen</th>
                    <th scope="col" class="hide-mobile">No. Telepon</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                {{-- //sekar --}}
                @foreach($userData as $no => $user)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $user->nrp }}</td>
                    <td>{{ $user->nama }}</td>
                    <td class="hide-mobile">{{ $user->email }}</td>
                    <td class="hide-mobile">{{ $user->dept}}</td>
                    <td class="hide-mobile">{{ $user->no_hp }}</td>
                    <td>  
                    <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view" href="#" data-bs-toggle="modal" data-bs-target="#viewuserModal" data-id="{{ $user->id }}"><i class="fa fa-expand"></i>View</a></li>
                        <li><a class="dropdown-item edit" href="#" data-bs-toggle="modal" data-bs-target="#userModal" data-id="{{ $user->id }}"><i class="fa-regular fa-pen-to-square"></i>Edit</a></li>
                        <li><a class="dropdown-item delete" href="#" data-id="{{ $user->id }}"><i class="fa-solid fa-trash"></i>Delete</a></li>              
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
var userId; 
$('.view').click(function() {
    userId = $(this).data('id');
     $('#viewuserModal').attr('data-mode', 'edit');
    
    $.ajax({
        type: 'GET',
        url: '{{ url('/user/get') }}/' + userId,
        success: function(response) {
            $('#viewuserModal').find('#nrp-view').text(response.nrp);
            $('#viewuserModal').find('#name-view').text(response.nama);
            $('#viewuserModal').find('#username-view').text(response.username);
            $('#viewuserModal').find('#email-view').text(response.email);
            $('#viewuserModal').find('#password-view').text(response.password);
            $('#viewuserModal').find('#departemen-view').text(response.dept);
            $('#viewuserModal').find('#phone_number-view').text(response.no_hp);
            $('#viewuserModal').find('#alamat-view').text(response.perusahaan);
            $('#viewuserModal').find('#id_role-view').text(getLevelText(response.id_role));
            function getLevelText(id_role) {
                switch (id_role) {
                    case '1':
                        return 'Level 1';
                    case '2':
                        return 'Level 2';
                    case '3':
                        return 'Level 3';
                    default:
                        return 'Admin';
                }
            }

    
            $('#viewuserModal').modal('show');
        },
        error: function(error) {
            
        }
    });
});

//EDIT
var userId; 
$('.edit').click(function() {
    userId = $(this).data('id');
    $('#userModal').attr('data-mode', 'edit');
    
    $.ajax({
        type: 'GET',
        url: '{{ url('/user/get') }}/' + userId,
        success: function(response) {
          
            $('#userModal #nrp').val(response.nrp);
            $('#userModal #nama').val(response.nama);
            $('#userModal #username').val(response.username);
            $('#userModal #email').val(response.email);
            $('#userModal #dept').val(response.dept);
            $('#userModal #no_hp').val(response.no_hp);
            $('#userModal #perusahaan').val(response.perusahaan);
            
            // Set selected option in the dropdown
            setDropdownSelected('#id_role', response.id_role);

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
            url: '{{ url('/user/create') }}',
            data: $('form').serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'user berhasil di tambahkan!',
                    }).then(() => {
                       location.reload()
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'user gagal di tambahkan.',
                    });
                }
            },
        });
    } else if (mode === 'edit') {  
        $.ajax({
            type: 'POST',
            url: '{{ url('/user/myedit') }}/' + userId,
            data: $('form').serialize() + '&user_id=' + userId,
            success: function(response) {
                if (response.status === 'success') {
                    // Display a SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'user berhasil di edit!',
                    }).then(() => {
                        location.reload()
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'user gagal di edit.',
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
       var userId = this.getAttribute('data-id');

       Swal.fire({
           title: 'Konfirmasi',
           text: 'Apakah Anda yakin akan menghapus data ini?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Ya, Kirim!',
           cancelButtonText: 'Batal'
       }).then((result) => {
           if (result.isConfirmed) {
               axios.post('{{ route('delete.user') }}', {
                   user_id: userId
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

