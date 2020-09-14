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
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b style="color:#011e3d;">Registrasi EO</b> <b style="color:#da0b45;">Portal</b><b style="color:#fff;">Sepeda</b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Registrasi Event Orginizer Portalsepeda</p>

    <form action="{{ route('registrasiEO.store') }}" method="post">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="form-group has-feedback">
              <input required type="text" class="form-control" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Nama anda">
              <span class="fa fa-user form-control-feedback"></span>
              @if($errors->has('nama'))
                <div class="text-danger">
                    {{ $errors->first('nama')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <input required type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Email">
              <span class="fa fa-envelope form-control-feedback"></span>
              @if($errors->has('email'))
                <div class="text-danger">
                    {{ $errors->first('email')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <input required type="text" class="form-control" name="kontak" id="kontak" value="{{ old('kontak') }}" placeholder="Kontak">
              <span class="fa fa-phone form-control-feedback"></span>
              @if($errors->has('kontak'))
                <div class="text-danger">
                    {{ $errors->first('kontak')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <input required type="text" class="form-control" name="no_hp_kontak" id="no_hp_kontak" value="{{ old('no_hp_kontak') }}" placeholder="No Hp Kontak">
              <span class="fa fa-address-book-o form-control-feedback"></span>
              @if($errors->has('no_hp_kontak'))
                <div class="text-danger">
                    {{ $errors->first('no_hp_kontak')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <input required type="text" class="form-control" name="no_wa_kontak" id="no_wa_kontak" value="{{ old('no_wa_kontak') }}" placeholder="No Whatsapp Kontak">
              <span class="fa fa-whatsapp form-control-feedback"></span>
              @if($errors->has('no_wa_kontak'))
                <div class="text-danger">
                    {{ $errors->first('no_wa_kontak')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <input required type="file" class="form-control" name="logo_eo" id="logo_eo" value="{{ old('logo_eo') }}" placeholder="Logo EO">
              <span class="fa fa-picture-o form-control-feedback"></span>
              @if($errors->has('logo_eo'))
                <div class="text-danger">
                    {{ $errors->first('logo_eo')}}
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6 col-lg-6">
            <div class="form-group has-feedback">
              <select required class="form-control" name="provinsi" id="provinsi" value="{{ old('provinsi') }}">
                <option selected disabled>-pilih provinsi-</option>
                @foreach ($provinsi as $k => $v)
              <option value="{{$v['id']}}">{{$v['nama']}}</option>
                @endforeach
              </select>
              @if($errors->has('provinsi'))
                <div class="text-danger">
                    {{ $errors->first('provinsi')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <select required class="form-control" name="kota" id="kota" value="{{ old('kota') }}">
                <option selected disabled>-pilih kota-</option>
              </select>
              @if($errors->has('kota'))
                <div class="text-danger">
                    {{ $errors->first('kota')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <textarea required class="form-control" name="alamat" id="alamat" value="{{ old('alamat') }}" placeholder="Masukan Alamat Anda"></textarea>
              <span class="fa fa-address-card form-control-feedback"></span>
              @if($errors->has('nama'))
                <div class="text-danger">
                    {{ $errors->first('nama')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <input required type="text" class="form-control" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" placeholder="Kode Pos">
              <span class="fa fa-address-card form-control-feedback"></span>
              @if($errors->has('kode_pos'))
                <div class="text-danger">
                    {{ $errors->first('kode_pos')}}
                </div>
              @endif
            </div>
            <div class="form-group has-feedback">
              <input required type="text" class="form-control" name="alamat_web" id="alamat_web" value="{{ old('alamat_web') }}" placeholder="Alamat Web">
              <span class="fa fa-globe form-control-feedback"></span>
              @if($errors->has('alamat_web'))
                <div class="text-danger">
                    {{ $errors->first('alamat_web')}}
                </div>
              @endif
            </div>
          </div>
          <!-- <div class="form-group has-feedback">
            <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Retype password">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div> -->
        </div>
            <div class="row">
              <div class="col-md-6">
                <a class="btn btn-danger btn-block btn-flat" >Kembali</a>
                {{-- <input class="btn btn-primary btn-block btn-flat" type="submit" value="Register"> --}}
                <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button> -->
              </div>
              <div class="col-md-6">
                <input class="btn btn-primary btn-block btn-flat" type="submit" value="Register">
                <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button> -->
              </div>
  
              <!-- /.col -->
            </div>
  
    </form>

    {{-- <div class="text-center" style="margin-top:20px;">
        Sudah punya akun anggota?<a href="/login" class="text-center"> Login</a>
    </div> --}}
    
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<!-- iCheck -->
<script src="{{ asset('assets/vendor/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script>
  $("#provinsi").on('change', function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

      var id = $("#provinsi").find(':selected').val();
      var urls = "{{URL::to('/registrasiEO/ajaxKota')}}";
      $.ajax({
        url: urls,
        method:"post", 
        data: {
          "_token": "{{ csrf_token() }}",
          "id": id
        },
        success: function(result){
      var data = "<option disabled selected>-pilih kota-</option>";
      $.each(result.getKota, function(k,v){
          data += '<option value="'+v.id+'" data-id="'+v.id+'">'+v.nama+'</option>'
      })
      
      $("#kota").html(data);
    }}); 
  });
</script>
</body>
</html>
