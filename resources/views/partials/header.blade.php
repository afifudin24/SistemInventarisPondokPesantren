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

