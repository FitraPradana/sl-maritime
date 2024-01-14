<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="PML - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SLM - @yield('title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}template_hrsm/assets/img/people.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/buttons.dataTables.min.css">


    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/bootstrap-datetimepicker.min.css">

    <!-- Tagsinput CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <!-- Chart CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/plugins/morris/morris.css">

    {{-- Croppie --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">


    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}template_hrsm/assets/css/style.css">




    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    {{-- [if lt IE 9]
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		[endif] --}}
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Loader -->
        @yield('loader')
        <!-- Loader -->

        <!-- Header -->
        <div class="header">

            {{-- <img id="Image2" src="{{ asset('/') }}template_hrsm/headernew6_slm.jpg" style="height:85px;width:100%;"> --}}

            <!-- Logo -->
            <div class="header-left">
                <a href="#" class="logo">
                    {{-- <img src="{{ asset('/') }}template_hrsm/logo-slm-animasi-3.gif" width="150" height="50" alt=""> --}}
                    {{-- <img src="{{ asset('/') }}template_hrsm/headernew6_slm.jpg" width="100%" height="100%" alt=""> --}}
                </a>
            </div>
            <!-- /Logo -->

            <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <!-- Header Title -->
            <div class="page-title-box">
                {{-- <h3>Patria Maritime Lines - Apps</h3> --}}
                <h3>Apps</h3>
            </div>
            <!-- /Header Title -->

            <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

            <!-- Header Menu -->
            <ul class="nav user-menu">

                <!-- Search -->
                <!-- <li class="nav-item">
      <div class="top-nav-search">
       <a href="javascript:void(0);" class="responsive-search">
        <i class="fa fa-search"></i>
      </a>
       <form action="search.html">
        <input class="form-control" type="text" placeholder="Search here">
        <button class="btn" type="submit"><i class="fa fa-search"></i></button>
       </form>
      </div>
     </li> -->
                <!-- /Search -->



                <!-- Notifications -->
                {{-- @include('layouts.notification') --}}
                <!-- /Notifications -->

                <!-- Message Notifications -->
                {{-- @include('layouts.message_notification') --}}
                <!-- /Message Notifications -->

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <span class="user-img"><img src="{{ asset('/') }}template_hrsm/assets/img/people.png" alt="">
                            <span class="status online"></span></span>

                        @if (empty(Auth::user()))
                            <span>Guest</span>
                        @else
                            <span>{{ Auth::user()->name }}</span>
                        @endif

                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">My Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="{{ url('lock-screen') }}">Lock Screen</a>
                        <a class="dropdown-item" href="{{ route('cpanel_logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">My Profile</a>
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="{{ url('lock-screen') }}">Lock Screen</a>
                    <a class="dropdown-item" href="{{ url('logout') }}">Logout</a>
                </div>
            </div>
            <!-- /Mobile Menu -->

        </div>
        <!-- /Header -->

        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        @yield('content')
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    @include('sweetalert::alert')


</body>

<!-- jQuery -->
<script src="{{ asset('/') }}template_hrsm/assets/js/jquery-3.5.1.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('/') }}template_hrsm/assets/js/popper.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/bootstrap.min.js"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('/') }}template_hrsm/assets/js/jquery.slimscroll.min.js"></script>

<!-- Datatable JS -->
<script src="{{ asset('/') }}template_hrsm/assets/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/buttons.html5.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/buttons.print.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/jszip.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/pdfmake.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/vfs_fonts.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/buttons.colVis.min.js"></script>


<!-- Select2 JS -->
<script src="{{ asset('/') }}template_hrsm/assets/js/select2.min.js"></script>


<!-- Tagsinput JS -->
<script src="{{ asset('/') }}template_hrsm/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>


<!-- Chart JS -->
{{-- <script src="{{ asset('/') }}assets/plugins/morris/morris.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/raphael/raphael.min.js"></script> --}}
{{-- <script src="assets/js/chart.js"></script> --}}

{{-- Sweet Alert 2 --}}
<script src="{{ asset('/') }}template_hrsm/assets/js/sweetalert2@11.js"></script>

{{-- Html5 Scan QrCode --}}
<script src="{{ asset('/') }}template_hrsm/assets/js/html5-qrcode.min.js"></script>

{{-- Croppie --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>


<!-- Datetimepicker JS -->
<script src="{{ asset('/') }}template_hrsm/assets/js/moment.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/js/bootstrap-datetimepicker.min.js"></script>


<!-- Select2 JS -->
<script src="{{ asset('/') }}template_hrsm/assets/js/select2.min.js"></script>


<!-- Tagsinput JS -->
<script src="{{ asset('/') }}template_hrsm/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('/') }}template_hrsm/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>


<!-- Custom JS -->
<script src="{{ asset('/') }}template_hrsm/assets/js/app.js"></script>

@yield('under_body')


</html>
