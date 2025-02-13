@extends('include/mainlayout')

@section('content')
@if(session('alert'))
    <div class="alert alert-warning" id="alert-box">
        {{ session('alert') }}
    </div>
@endif

@if(session('hide_menu'))
    <style>
        #sidebar, #navbar { display: none; }
    </style>
@endif
    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 flex-column align-items-center">
             <h2 style="text-align: center;">{{ auth()->user()->name }}</h2>
              <h3 style="text-align: center;">{{ auth()->user()->jabatan }}</h3>

               <div class="profile-card profile-overview" id="profile-overview">
                  <h1 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-4 col-md-4 label">Nama</div>
                    <div class="col-lg-8 col-md-8">{{ auth()->user()->nama }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-5 col-md-4 label">Departemen</div>
                    <div class="col-lg-7 col-md-8">{{ auth()->user()->dept }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4 col-md-4 label">Perusahaan</div>
                    <div class="col-lg-8 col-md-8">{{ auth()->user()->perusahaan }}</div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4 col-md-4 label">No.HP</div>
                    <div class="col-lg-8 col-md-8">{{ auth()->user()->no_hp }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4 col-md-4 label">Email</div>
                    <div class="col-lg-8 col-md-8">{{ auth()->user()->email }}</div>
                  </div>
                </div>   
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form method="POST" action="/profile/myedit/{id}">
                  <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                  @csrf
                  <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">NRP</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="nrp" name="nrp" value="{{ auth()->user()->nrp }}">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="name" value="{{ auth()->user()->nama }}">
                      </div>
                    </div>
                     <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="username" type="text" class="form-control" id="username" value="{{ auth()->user()->username }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Departemen</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="departemen" type="text" class="form-control" id="departemen" value="{{ auth()->user()->dept }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Perusahaan</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="perusahaan" type="text" class="form-control" id="perusahaan" value="{{ auth()->user()->perusahaan }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">No HP</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone_number" type="text" class="form-control" id="phone_number" value="{{ auth()->user()->no_hp }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="email" value="{{ auth()->user()->email }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="baju" class="col-md-4 col-lg-3 col-form-label">Ukuran Baju</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="baju" type="baju" class="form-control" id="baju" value="{{ auth()->user()->baju }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="celana" class="col-md-4 col-lg-3 col-form-label">Ukuran Celana</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="celana" type="celana" class="form-control" id="celana" value="{{ auth()->user()->celana }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="rompi" class="col-md-4 col-lg-3 col-form-label">Ukuran Rompi</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="rompi" type="rompi" class="form-control" id="rompi" value="{{ auth()->user()->rompi }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="sepatu" class="col-md-4 col-lg-3 col-form-label">Ukuran Sepatu</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="sepatu" type="sepatu" class="form-control" id="sepatu" value="{{ auth()->user()->sepatu }}">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-sm" id="btn-yes-edit">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade profile-change-password pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form method="POST" id="changePasswordForm" action="{{ url('/profile/changepassword') }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                        <div class="col-md-8 col-lg-9">
                        <div class="input-group">
                            <input name="password" type="password" class="form-control" id="currentPassword">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword1">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                        </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                        <div class="col-md-8 col-lg-9">
                           <div class="input-group">
                            <input name="newpassword" type="password" class="form-control" id="newPassword">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword2">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                          </div>
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="newPasswordConfirmation" class="col-md-4 col-lg-3 col-form-label">Confirm New Password</label>
                        <div class="col-md-8 col-lg-9">
                            <div class="input-group">
                            <input name="newpassword_confirmation" type="password" class="form-control" id="newPasswordConfirmation">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword3">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                          </div>
                            
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" id="btnChangePassword" class="btn btn-primary btn-sm">Change Password</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">Cancel</button>
                    </div>
                </form>


                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
</section>

<script>
    $(document).ready(function() {
        $('#togglePassword1').on('click', function() {
            var passwordField = $('#currentPassword');
            var passwordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="bi bi-eye-slash"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="bi bi-eye"></i>');
            }
        });
        $('#togglePassword2').on('click', function() {
            var passwordField = $('#newPassword');
            var passwordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="bi bi-eye-slash"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="bi bi-eye"></i>');
            }
        });

        $('#togglePassword3').on('click', function() {
            var passwordField = $('#newPasswordConfirmation');
            var passwordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="bi bi-eye-slash"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="bi bi-eye"></i>');
            }
        });
    });

   $(document).ready(function() {
    $('#btn-yes-edit').click(function() {
      event.preventDefault();
        var userId = $('[name="user_id"]').val();

        $.ajax({
            type: 'POST',
            url: '{{ url('/profile/myedit') }}/' + userId,
            data: $('form').serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'User berhasil di edit!',
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'User gagal di edit.',
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengirim data.',
                });
            },
        });
    });
  });

  $(document).ready(function() {
      $('#btnChangePassword').click(function() {
          $.ajax({
              type: 'POST',
              url: $('#changePasswordForm').attr('action'),
              data: $('#changePasswordForm').serialize(),
              success: function(response) {
                  if (response.status === 'success') {
                      Swal.fire({
                          icon: 'success',
                          title: 'Success',
                          text: 'Password changed successfully!',
                      }).then(() => {
                          location.reload();
                      });
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: response.message || 'Failed to change password. Please check your input.',
                      });
                  }
              },
              error: function(xhr, status, error) {
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'An error occurred while sending the data.',
                  });
              },
          });
      });
  });



</script>
@endsection