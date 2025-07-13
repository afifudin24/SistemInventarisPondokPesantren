<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Inventaris Barang - Ponpes Al Falah Rawalo</title>

    @vite(['resources/css/dashboard.css', 'resources/vendors/mdi/css/materialdesignicons.min.css', 'resources/vendors/ti-icons/css/themify-icons.css', 'resources/vendors/css/vendor.bundle.base.css','resources/vendors/font-awesome/css/font-awesome.min.css', 'resources/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css', 'resources/js/app.js'])
    <!-- @vite('resources/css/app.css')
@vite('resources/js/app.js') -->


    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('images/ponpesalfalah.jpeg')}}" />
  </head>
  <body>
    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <!-- <a class="navbar-brand brand-logo" href="index.html"><img src="{{asset('images/ponpesalfalah.jpeg')}}" alt="logo" /></a> -->
          {{-- <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('images/ponpesalfalah.jpeg')}}" alt="logo" /></a> --}}
           <a class="navbar-brand brand-logo fs-4" href="">
          SIB | AL - FALAH
           </a>
<a class="navbar-brand brand-logo-mini fs-5" href="">SIB</a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>

          <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
          <i class="mdi mdi-bell mx-0"></i>
          <span class="count">{{$notifikasi->count()}}</span>
        </a>
    <div class="dropdown-menu navbar-dropdown preview-list " style="margin-left: -100px" aria-labelledby="notificationDropdown">
          <p class="mb-0 font-weight-normal float-left dropdown-header">Notifikasi</p>
          @if($notifikasi->count() > 0)
  @foreach($notifikasi as $nt)
    @if($nt->jenis == 'user_baru')
      <a class="dropdown-item preview-item" href="/notifikasi/buka/{{$nt->id}}">
        <div class="preview-thumbnail">
          <div class="preview-icon bg-info">
            <i class="ti-user mx-0"></i>
          </div>
        </div>
        <div class="preview-item-content">
          <h6 class="preview-subject font-weight-normal">{{ $nt->pesan }}</h6>
          <p class="font-weight-light small-text mb-0 text-muted">{{ $nt->tanggal }}</p>
        </div>
      </a>
    @endif
  @endforeach
@else
  <div class="dropdown-item text-center text-muted small">
    Tidak ada notifikasi
  </div>
@endif

          <!-- <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success">
                <i class="ti-arrow-right mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Application Error</h6>
              <p class="font-weight-light small-text mb-0 text-muted"> Just now </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-warning">
                <i class="ti-settings mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">Settings</h6>
              <p class="font-weight-light small-text mb-0 text-muted"> Private message </p>
            </div>
          </a>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-info">
                <i class="ti-user mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal">New user registration</h6>
              <p class="font-weight-light small-text mb-0 text-muted"> 2 days ago </p>
            </div>
          </a> -->
        </div>
      </li>
            <li class="nav-item nav-profile dropdown">

                <a href='/profil' class='text-decoration-none'>


                <div class="nav-profile-text">
                  <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
                </div>
                </a>

            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>




          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <div class="container-fluid page-body-wrapper">

