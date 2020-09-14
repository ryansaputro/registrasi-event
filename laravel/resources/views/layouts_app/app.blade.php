<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="Laravel AJAX CRUD with Server Side Validation by Orzdev">
  <meta name="author" content="Orzdev">
  {{-- CSRF TOKEN --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/png" href="https://portalsepeda.com/wp-content/uploads/2019/03/cropped-Capture-2-2.png">
  <title>Event Organizer | Portal Sepeda</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"> -->
  <link href="{{ asset('assets/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet">
  <!-- Datepicker -->
  <link href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
  
  <!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}" /> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/additional-css.css') }}">
  <!--Datetimepicker-->
  <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets/css/skins/_all-skins.min.css') }}">

  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="{{ asset('assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400&display=swap" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> --}}
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
  <!-- <link rel="stylesheet" href="{{ asset('assets/css/fontgoogle.css') }}"> -->
</head>
<body class="hold-transition sidebar-mini fixed skin-red-light">
  <!-- Site wrapper -->
  <div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="dashboard" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <h4 class="text-center"><b style="color:#da0b45;font-weight:600;">Event Organizer</b></h4>
          {{-- <span class="logo-mini"><img src="{{ asset('assets/img/logo.png') }}" style="height:30px"/></span> --}}
          <!-- logo for regular state and mobile devices -->
          {{-- <span class="logo-lg" style="margin-right:30px;"><img src="{{ asset('assets/img/logo.png') }}" style="height:25px;margin-bottom:5px;margin-right:3px;"/><b>SIK</b>TIKA</span> --}}
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          {{-- <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a> --}}
          {{-- <form class="sidebar-form">
            @csrf
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form> --}}
          <div class="search">
            <i class="fa fa-search" onclick="search()" aria-hidden="true"></i> <span onclick="search()" class="text-search">Type in to Search...</span>
          </div>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  {{-- <div class="image" style="background-image: url({{ asset('laravel/public/images/eo/logo/245/'.Session::get('data')['foto']) }});height: 45px;width: 45px;background-size: cover;background-repeat: no-repeat;border-radius: 50px;position: absolute;margin-left: -50px;margin-top: -13px;">
                  </div> --}}
                  <i class="fa fa-caret-down fa-2x" aria-hidden="true"></i>
                  <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                  {{-- <img src="{{ asset('assets/img/profil/') }}/{{ Session::get('data')['foto'] }}" class="user-image" alt="Anggota Image"> --}}
                  {{-- <span class="hidden-xs">{{ Session::get('data')['full_name'] }}</span> --}}
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    {{-- <img src="{{ asset('assets/img/profil/') }}/{{ Session::get('data')['foto'] }}" class="img-circle" alt="Anggota Image"> --}}
                    <div class="image" style="background-image: url({{ asset('laravel/public/images/eo/logo/'.Session::get('data')['foto']) }});height: 100px;background-size: cover;background-repeat: no-repeat;">
                    </div>
                    <p>
                      {{ Session::get('data')['full_name'] }}
                      {{-- <small>NIK : {{ Session::get('data')['nik'] }}</small> --}}
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="row">
                      <div class="col-xs-4 text-center">
                        <a href="#">Menu1</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Menu2</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Menu3</a>
                      </div>
                    </div>
                    <!-- /.row -->
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="/logout" class="btn btn-default btn-flat">Logout</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              {{-- <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li> --}}
            </ul>
          </div>
        </nav>
    </header>
    <!-- =============================================== -->
        @include('layouts_app._sidebar')
    <!-- Left side column. contains the sidebar -->
    
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height:200px !important;">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2019 <a href="https://portalsepeda.com">portalsepeda.com</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  @include('layouts_app._modal')

<!-- jQuery 3 -->
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<!-- <script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script> -->
<!-- Datatables -->
<script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
<!-- Sweetalert2 -->
<script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- date-range-picker -->
  <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- Datepicker -->
<script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!--Datetimepicker-->
<script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/js/demo.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- Datetime custom -->
<script src="{{ asset('assets/js/jqClock.min.js') }}"></script>
<script src="{{ asset('assets/js/orzDate.js') }}"></script>
<!-- Numbering Rupiah -->
<!-- <script src="https://tyugaev.github.io/number-divider/lib/number-divider.min.js"></script> -->
<script src="{{ asset('assets/js/number-divider.js') }}"></script>
<script src="{{ asset('assets/js/number-divider.min.js') }}"></script>

<!--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });

  function search(){
    var htmls = '<form class="sidebar-form" style="margin-top: -5px;width: 300px;border: none;border-bottom: 2px solid;transition: width 2s;">'+
                '@csrf'+
                '<div class="input-group">'+
                  '<input type="text" name="q" class="form-control" placeholder="Search...">'+
                  '<span class="input-group-btn">'+
                    '<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>'+
                    '</button>'+
                  '</span>'+
                '</div>'+
              '</form>';
        htmls += '<span style="cursor: pointer;" onclick="back(this)" >'+
                    '<i class="fa fa-ban" aria-hidden="true" style="margin-left: 345px;margin-top: 8px;color: red;"></i> cancel'+
                  '</span>';
    $('.search').html(htmls).show('slow');
  }

  function back(a){
    var htmls = '<i class="fa fa-search" onclick="search()" aria-hidden="true"></i> <span class="text-search" onclick="search()">Type in to Search...</span>';
    $('.search').html(htmls).show('slow');
  }
</script>

@stack('scripts')
</body>
</html>
