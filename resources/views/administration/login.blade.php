<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="login">

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-end">
            <div class="col-lg-8 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <h1 class="login-title">LOGIN</h1>
              <h4 class="login-subtitle align-items-center" style="text-align: center; display: flex; justify-content: center; align-items: center;">
                "Bright Future of PPA"
             </h4>

              <!-- Gambar dan label akan disembunyikan pada layar kecil melalui CSS -->
              <div class="d-flex justify-content-center py-4 logo-container">
                <a href="#" class="logo d-flex w-auto">
                  <img class="loginku" src="" alt="">
                </a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="">
                <div class="">
                  <form class="row g-3 needs-validation" method="POST" action='/'>
                    @csrf
                    <img class="form-login" src="assets/img/HalloHCGA.png" alt="">

                    <div class="col-11 form-input">
                      <input type="text" name="username" class="form-control" id="username" placeholder="username">
                      <div class="invalid-feedback">Please enter your username!</div>
                      @error('username')
                          <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>

                    <div class="col-11 form-input">
                      <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                          <i class="bi bi-eye-fill"></i>
                        </button>
                      </div>
                      <div class="invalid-feedback">Please enter your password!</div>
                      @error('password')
                          <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>

                    <div class="col-11 form-input">
                      <button class="btn btn-primary w-100 btn-sm form-a" type="submit">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            var passwordField = $('#password');
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

    document.addEventListener('DOMContentLoaded', function() {
    var images = ['assets/img/mess.jpg', 'assets/img/web-2.jpg', 'assets/img/web-3.jpg','assets/img/web-1.jpg','assets/img/web-5.jpg','assets/img/web-4.jpg'];
    var randomImage = images[Math.floor(Math.random() * images.length)];
    document.querySelector('.loginku').src = randomImage;
    });
  </script>

</body>

</html>
