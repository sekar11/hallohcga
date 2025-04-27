<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Mi-Touch')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">

  <!-- moment.js -->

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.25/sorting/datetime-moment.js"></script>

  <script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>




  {{-- range waktu   --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>


  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
     <a href="/dashboard" class="logo d-flex align-items-center">
        <img src="assets/img/HalloHCGA.png" alt="Logo" class="img-fluid">
        {{-- <span class="d-none d-sm-block">HalloHCGA</span> --}}
    </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3 me-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          @if (auth()->check())
          <span class="dropdown-toggle ps-2">{{ auth()->user()->nama }} | {{ auth()->user()->dept }} </span>

          @endif
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ auth()->user()->nama }}</h6>
              <span>{{ auth()->user()->dept }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/profile">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="nav-item whatsapp-button">
              <a href="#" id="whatsappButton">
                <i class="bi bi-whatsapp"></i>
                <span>Call Center</span>
              </a>
            </li>
          </ul>

        </li>
      </ul>
    </nav>
  </header>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      @if(auth()->user()->id_role == 0 || auth()->user()->id_role == 3 || auth()->user()->id_role == 4)
        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-dash" data-bs-toggle="collapse" href="#">
          <i class="bi bi bi-grid"></i><span>Dashboard</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-dash" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/dashboard">
              <i class="bi bi-circle"></i><span>Digital Complain</span>
            </a>
          </li>
        </ul>
        <ul id="forms-dash" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/dashboard_phair">
              <i class="bi bi bi-circle"></i><span>Ph Air</span>
            </a>
          </li>
        </ul>
        <ul id="forms-dash" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="/dashboard_catering">
                <i class="bi bi bi-circle"></i><span>MK Catering</span>
              </a>
            </li>
          </ul>
      </li>
      @endif

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-pel" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Digital Complain</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-pel" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/complain">
              <i class="bi bi-circle"></i><span>Digital Complain</span>
            </a>
          </li>
        </ul>
      </li>

      @if(auth()->user()->id_role == 0)
       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-user" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>User Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-user" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/user">
              <i class="bi bi-circle"></i><span>User</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
          <a class="nav-link " href="/phair">
          <i class="bi bi-droplet-half"></i>
            <span>Ph Air</span>
          </a>
        </li>
      </li>
      @endif

      @if(auth()->user()->id_role == 0 || auth()->user()->id_role == 6 || auth()->user()->id_role == 7 )
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#ga-request" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>GA Request</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="ga-request" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#add-catering" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-circle"></i><span>MK Catering </span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="add-catering" class="nav-content collapse">
                        @if(auth()->user()->id_role == 0 || auth()->user()->id_role == 6)
                            <li>
                                <a href="/catering">
                                    <i class="bi bi-dash"></i><span>Add Data Mekilo</span>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->id_role == 0)
                            <li>
                                <a href="/lapcateringdept">
                                    <i class="bi bi-dash"></i><span>Laporan Mekilo Departemen</span>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->id_role == 0 || auth()->user()->id_role == 7)
                            <li>
                                <a href="/lapcatering">
                                    <i class="bi bi-dash"></i><span>Laporan Catering</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </li>
        @endif


      @if(auth()->user()->id_role == 5)
      <li class="nav-item">
          <a class="nav-link " href="/phair">
          <i class="bi bi-droplet-half"></i>

            <span>Ph Air</span>
          </a>
        </li><!-- End Dashboard Nav -->
      </li>
      @endif
      <!-- End Forms Nav -->
    </ul>


  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright | 2025.
    </div>
    {{-- <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div> --}}
  </footer><!-- End Footer -->

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
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- <!-- begin::Global Config(global config for global JS sciprts) -->
    @include('include.loadjs ')
  <!--end::Page Scripts --> --}}

  @include('sweetalert::alert')


<!-- JavaScript -->
<script>
  document.getElementById("whatsappButton").addEventListener("click", function () {
    // const phoneNumber = "6282181032904";
    const phoneNumber = "6282162340485";
    const message = "Halo, saya terdapat permasalahan yang harus segera diatasi.";
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, "_blank");
  });
</script>


</body>

</html>


