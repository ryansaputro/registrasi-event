<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="Laravel AJAX CRUD with Server Side Validation by Orzdev">
  <meta name="author" content="Orzdev">
  {{-- CSRF TOKEN --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.ico') }}">
  <title>SIKTIKA | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Koperasi</b> Tirta Karya</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form action="{{ route('register.store') }}" method="post">
      <div class="form-group has-feedback">
        {{ csrf_field() }}
        <input type="text" class="form-control" name="nik" id="nik" value="{{ old('nik') }}" placeholder="NIK Anggota">
        <span class="glyphicon glyphicon-pawn form-control-feedback"></span>
        @if($errors->has('nik'))
          <div class="text-danger">
              {{ $errors->first('nik')}}
          </div>
        @endif
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Nama anda">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @if($errors->has('nama'))
          <div class="text-danger">
              {{ $errors->first('nama')}}
          </div>
        @endif
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if($errors->has('email'))
          <div class="text-danger">
              {{ $errors->first('email')}}
          </div>
        @endif
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if($errors->has('password'))
          <div class="text-danger">
              {{ $errors->first('password')}}
          </div>
        @endif
      </div>
      <!-- <div class="form-group has-feedback">
        <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div> -->
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <input class="btn btn-primary btn-block btn-flat" type="submit" value="Register">
          <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button> -->
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="text-center" style="margin-top:20px;">
        Sudah punya akun anggota?<a href="/login" class="text-center"> Login</a>
    </div>
    
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('assets/vendor/iCheck/icheck.min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
