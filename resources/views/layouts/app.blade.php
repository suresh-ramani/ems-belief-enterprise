<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @if (isset($title))
    <title>{{ $title }} | {{ config("app.name") }}</title>
  @else
    <title>{{ config("app.name") }}</title>
  @endif

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">

  <style>
    .colored-toast.swal2-icon-success {
        background-color: #16a34a !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #dc2626 !important;
    }

    .colored-toast.swal2-icon-warning {
        background-color: #ea580c !important;
    }

    .colored-toast.swal2-icon-info {
        background-color: #0284c7 !important;
    }

    .colored-toast.swal2-icon-question {
        background-color: #0891b2 !important;
    }

    .colored-toast .swal2-title {
        color: white;
    }

    .colored-toast .swal2-close {
        color: white;
    }

    .colored-toast .swal2-html-container {
        color: white;
    }
  </style>

  @stack('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
          <img src="/assets/dist/img/user1-128x128.jpg" alt="" class="img-size-32 mr-1 img-circle">
          {{ auth()->user()->name }}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="javascript:void(0)" class="dropdown-item">
            <i class="fas fa-cogs mr-2"></i> Settings
          </a>
          <div class="dropdown-divider"></div>
          <form action="{{ route('logout') }}" method="post">
            @csrf
            <a href="javascript:void(0)" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route("home") }}" class="brand-link text-center">
        Belief Enterprise
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route("home") }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @if(auth()->user()->isSuperAdmin())
          <li class="nav-item">
            <a href="{{ route("industries.index") }}" class="nav-link {{ request()->routeIs('industries.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Industries
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route("meters.index") }}" class="nav-link {{ request()->routeIs('meters.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-bolt"></i>
              <p>
                Meters
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route("users.index") }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $breadcrumb['title'] }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              
              

              @foreach ($breadcrumb['links'] as $link)
                @if(isset($link['url']))
                    <li class="breadcrumb-item"><a href="{{ $link['url'] }}">{{ $link['title'] }}</a></li>    
                @endif
                
                @if(isset($link['active']) && $link['active'])
                    <li class="breadcrumb-item active">{{ $link['title'] }}</li>
                @endif
              @endforeach

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      @yield('content')
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; {{ now()->format("Y") }} Belief Enterprise. All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast',
    },
    showConfirmButton: false,
    timerProgressBar: true,
    timer: 5000,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
  })

  function show_notify(title, status){
          if(status=="success"){
              Toast.fire({
                  icon: 'success',
                  text:title,
              })
          }else if(status=="error"){
              Toast.fire({
                  icon: 'error',
                  text:title,
              })
          }else if(status=="warning"){
              Toast.fire({
                  icon: 'warning',
                  text:title,
              })
          }else{
              Toast.fire({
                  icon: 'info',
                  text:title,
              })   
          }
      }
</script>

@if(session()->has("status"))
    <script type="text/javascript">
        show_notify("{!! session()->get('message') !!}", "{!! session()->get('status') !!}");
    </script>
@endif

@stack('script')

</body>
</html>
