<html>
<head>
  <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/iCheck/square/blue.css') }}">
  <!------ Include the above in your HEAD tag ---------->
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
    <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">

</head> 
<body>
<h1 class="text-center"><b style="color:#da0b45;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">Event</b> <b style="color:#fff;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">Organizer</b></h1>
<?php 
  $tahun = substr($profil['tanggal_lahir'],0,4);
  $bulan = substr($profil['tanggal_lahir'],5,2);
  $tanggal = substr($profil['tanggal_lahir'],7,2);
  $tgl = $tahun."-".$bulan."-".$tanggal;
?>
<div class="container" style="padding-top:10px;">
	<div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                <li class="active"><a href="#step-1">
                    <h4 class="list-group-item-heading">Data Diri</h4>
                    <p class="list-group-item-text">Lengkapi Data Diri Anda</p>
                </a></li>
                <li class="disabled"><a href="#step-2">
                    <h4 class="list-group-item-heading">Data Event Organizer</h4>
                    <p class="list-group-item-text">Lengkapi Data Event Organizer Anda</p>
                </a></li>
            </ul>
        </div>
  </div>
  <form action="{{ route('registrasiEO.store') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row setup-content" id="step-1">
        <div class="col-xs-12">
            <div class="col-md-12 well text-center">
                   <div class="register-box-body">
                      {{-- <p class="login-box-msg">Profil</p> --}}
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="nama" id="nama" value="{{ Auth::user()->toArray()['display_name'] }}" placeholder="nama">
                                <span class="fa fa-user form-control-feedback"></span>
                                @if($errors->has('nama'))
                                  <div class="text-danger">
                                      {{ $errors->first('nama')}}
                                  </div>
                                @endif
                              </div>

                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="panggilan" id="panggilan" value="{{ isset($profil['panggilan']) ? $profil['panggilan'] : '' }}" placeholder="panggilan">
                                <span class="fa fa-user form-control-feedback"></span>
                                @if($errors->has('panggilan'))
                                  <div class="text-danger">
                                      {{ $errors->first('panggilan')}}
                                  </div>
                                @endif
                              </div>

                              <div class="form-group has-feedback">
                                <div class="radio text-left">
                                  <label><input type="radio" name="jenis_kelamin" value="Laki-Laki"  {{isset($profil['jenis_kelamin']) == 'Laki-Laki' ? 'checked' : ''}}>Laki-laki</label>
                                </div>
                                <div class="radio text-left">
                                  <label><input type="radio" name="jenis_kelamin" value="Perempuan" {{isset($profil['jenis_kelamin']) == 'Perempuan' ? 'checked' : ''}}>Perempuan</label>
                                </div>
                                @if($errors->has('jenis_kelamin'))
                                  <div class="text-danger">
                                      {{ $errors->first('jenis_kelamin')}}
                                  </div>
                                @endif
                              </div>

                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ isset($profil['tempat_lahir']) ? $profil['tempat_lahir'] : '' }}" placeholder="tempat lahir">
                                <span class="fa fa-map-marker form-control-feedback"></span>
                                @if($errors->has('tempat_lahir'))
                                  <div class="text-danger">
                                      {{ $errors->first('tempat_lahir')}}
                                  </div>
                                @endif
                              </div>

                              <div class="form-group has-feedback">
                              <input required type="date" value="{{$profil['tanggal_lahir']}}" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="tanggal lahir">
                                <span class="fa fa-calendar-o form-control-feedback"></span>
                                @if($errors->has('tanggal_lahir'))
                                  <div class="text-danger">
                                      {{ $errors->first('tanggal_lahir')}}
                                  </div>
                                @endif
                              </div>

                              <div class="form-group has-feedback">
                                <div class="radio text-left">
                                  <label><input type="radio" name="golongan_darah" value="A"  {{isset($profil['golongan_darah']) && $profil['golongan_darah'] == 'A' ? 'checked' : ''}}>A</label>
                                </div>
                                <div class="radio text-left">
                                  <label><input type="radio" name="golongan_darah" value="B" {{isset($profil['golongan_darah']) && $profil['golongan_darah'] == 'B' ? 'checked' : ''}}>B</label>
                                </div>
                                <div class="radio text-left">
                                  <label><input type="radio" name="golongan_darah" value="O" {{isset($profil['golongan_darah']) && $profil['golongan_darah'] == 'O' ? 'checked' : ''}}>O</label>
                                </div>
                                <div class="radio text-left">
                                  <label><input type="radio" name="golongan_darah" value="AB" {{isset($profil['golongan_darah']) && $profil['golongan_darah'] == 'AB' ? 'checked' : ''}}>AB</label>
                                </div>
                                @if($errors->has('golongan_darah'))
                                  <div class="text-danger">
                                      {{ $errors->first('golongan_darah')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="{{isset($profil['pekerjaan']) ? $profil['pekerjaan'] : ''}}" placeholder="pekerjaan">
                                <span class="fa fa-laptop form-control-feedback"></span>
                                @if($errors->has('pekerjaan'))
                                  <div class="text-danger">
                                      {{ $errors->first('pekerjaan')}}
                                  </div>
                                @endif
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                              <div class="form-group has-feedback">
                                <select required class="form-control" name="provinsi" id="provinsi" value="{{ old('provinsi') }}">
                                  <option selected disabled>-pilih provinsi-</option>
                                  @foreach ($provinsi as $k => $v)
                                <option value="{{$v['id']}}" {{isset($profil['provinsi']) && ($profil['provinsi']) == $v['id'] ? 'selected' : ''}}>{{$v['nama']}}</option>
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
                                  @if ($kota != null)
                                      @foreach ($kota as $k => $v)
                                        <option value="{{$v['id']}}" {{isset($profil['kota'])  && ($profil['kota']) == $v['id'] ? 'selected' : ''}}>{{$v['nama']}}</option>  
                                      @endforeach
                                  @endif
                                </select>
                                @if($errors->has('kota'))
                                  <div class="text-danger">
                                      {{ $errors->first('kota')}}
                                  </div>
                                @endif
                              </div>

                              <div class="form-group has-feedback">
                              <textarea required class="form-control" value="" name="alamat" id="alamat" value="{{ old('alamat') }}" placeholder="Masukan Alamat Anda">{{isset($profil['alamat']) ? $profil['alamat'] : ''}}</textarea>
                                <span class="fa fa-address-card form-control-feedback"></span>
                                @if($errors->has('alamat'))
                                  <div class="text-danger">
                                      {{ $errors->first('alamat')}}
                                  </div>
                                @endif
                              </div>

                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="kode_pos" id="kode_pos" value="{{isset($profil['kode_pos']) ? $profil['kode_pos'] : ''}}" placeholder="Kode Pos">
                                <span class="fa fa-address-card form-control-feedback"></span>
                                @if($errors->has('kode_pos'))
                                  <div class="text-danger">
                                      {{ $errors->first('kode_pos')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="no_hp_kontak" id="no_hp_kontak" value="{{isset($profil['no_hp_kontak']) ? $profil['no_hp_kontak'] : ''}}" placeholder="No Hp Kontak">
                                <span class="fa fa-address-book-o form-control-feedback"></span>
                                @if($errors->has('no_hp_kontak'))
                                  <div class="text-danger">
                                      {{ $errors->first('no_hp_kontak')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="no_wa_kontak" id="no_wa_kontak" value="{{isset($profil['whatsapp']) ? $profil['whatsapp'] : ''}}" placeholder="No Whatsapp Kontak">
                                <span class="fa fa-whatsapp form-control-feedback"></span>
                                @if($errors->has('no_wa_kontak'))
                                  <div class="text-danger">
                                      {{ $errors->first('no_wa_kontak')}}
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
                                <div class="col-md-6" style="float:right;">
                                  <button id="activate-step-2" class="btn btn-primary btn-block btn-flat">Selanjutnya</button>
                                  {{-- <input class="btn btn-primary btn-block btn-flat" type="submit" value="Register"> --}}
                                  <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button> -->
                                </div>
                    
                                <!-- /.col -->
                              </div>                      
                    </div>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-2">
        <div class="col-xs-12">
            <div class="col-md-12 well">
                   <div class="register-box-body">
                      <p class="login-box-msg">Registrasi Event Organizer Portalsepeda</p>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="nama_eo" id="nama" value="{{ Auth::user()->toArray()['display_name'] }}" placeholder="Nama anda">
                                <span class="fa fa-user form-control-feedback"></span>
                                @if($errors->has('nama'))
                                  <div class="text-danger">
                                      {{ $errors->first('nama')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input required type="email" class="form-control" name="email_eo" id="email" value="{{ Auth::user()->toArray()['user_email']}}" placeholder="Email">
                                <span class="fa fa-envelope form-control-feedback"></span>
                                @if($errors->has('email'))
                                  <div class="text-danger">
                                      {{ $errors->first('email')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="kontak_eo" id="kontak" value="{{ old('kontak') }}" placeholder="Kontak">
                                <span class="fa fa-phone form-control-feedback"></span>
                                @if($errors->has('kontak'))
                                  <div class="text-danger">
                                      {{ $errors->first('kontak')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="no_hp_kontak_eo" id="no_hp_kontak" value="{{ old('no_hp_kontak') }}" placeholder="No Hp Kontak">
                                <span class="fa fa-address-book-o form-control-feedback"></span>
                                @if($errors->has('no_hp_kontak'))
                                  <div class="text-danger">
                                      {{ $errors->first('no_hp_kontak')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="no_wa_kontak_eo" id="no_wa_kontak" value="{{ old('no_wa_kontak') }}" placeholder="No Whatsapp Kontak">
                                <span class="fa fa-whatsapp form-control-feedback"></span>
                                @if($errors->has('no_wa_kontak'))
                                  <div class="text-danger">
                                      {{ $errors->first('no_wa_kontak')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input type="file" class="form-control" name="logo_eo" id="logo_eo" value="{{ old('logo_eo') }}" placeholder="Logo EO">
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
                                <select required class="form-control" name="provinsi_eo" onclick="EoProvinsi(this)" value="{{ old('provinsi') }}">
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
                                <select required class="form-control" name="kota_eo" id="kotaEo" value="{{ old('kota') }}">
                                  <option selected disabled>-pilih kota-</option>
                                </select>
                                @if($errors->has('kota'))
                                  <div class="text-danger">
                                      {{ $errors->first('kota')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <textarea required class="form-control" name="alamat_eo" id="alamat" value="{{ old('alamat') }}" placeholder="Masukan Alamat Anda"></textarea>
                                <span class="fa fa-address-card form-control-feedback"></span>
                                @if($errors->has('nama'))
                                  <div class="text-danger">
                                      {{ $errors->first('nama')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input required type="text" class="form-control" name="kode_pos_eo" id="kode_pos" value="{{ old('kode_pos') }}" placeholder="Kode Pos">
                                <span class="fa fa-address-card form-control-feedback"></span>
                                @if($errors->has('kode_pos'))
                                  <div class="text-danger">
                                      {{ $errors->first('kode_pos')}}
                                  </div>
                                @endif
                              </div>
                              <div class="form-group has-feedback">
                                <input type="text" class="form-control" name="alamat_web" id="alamat_web" value="{{ old('alamat_web') }}" placeholder="Alamat Web">
                                <span class="fa fa-globe form-control-feedback"></span>
                                @if($errors->has('alamat_web'))
                                  <div class="text-danger">
                                      {{ $errors->first('alamat_web')}}
                                  </div>
                                @endif
                              </div>
                            </div>
                          </div>
                              <div class="row">
                                <div class="col-md-6" style="float:right;">
                                  <input class="btn btn-primary btn-block btn-flat" type="submit" value="Register">
                                </div>
                    
                                <!-- /.col -->
                              </div>
                    
                      </form>
                      
                    </div>
            </div>
        </div>
    </div>
    </form>
  
    <div class="footer">
      <p  class="text-center">powered by <a href="https://portalsepeda.com"><span style="letter-spacing: 1px;color:#da0b45;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">portal</span><span style="color:#fff;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;letter-spacing: 1px;">sepeda</span></a></p>
    </div>
</div>

{{-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> --}}

<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<!-- iCheck -->
{{-- <script src="{{ asset('assets/vendor/iCheck/icheck.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script> --}}
<script>

  $("#provinsi").on('change', function(){
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
          }
      }); 
  });

  function EoProvinsi(a){
     var id = $(a).find(':selected').val();
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
              
              $("#kotaEo").html(data);
          }
      }); 
  }
</script>
<script>
$(document).ready(function() {
    
    var navListItems = $('ul.setup-panel li a'),
        allWells = $('.setup-content');

    allWells.hide();

    navListItems.click(function(e)
    {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this).closest('li');
        
        if (!$item.hasClass('disabled')) {
            navListItems.closest('li').removeClass('active');
            $item.addClass('active');
            allWells.hide();
            $target.show();
        }
    });
    
    $('ul.setup-panel li.active a').trigger('click');
    
    // DEMO ONLY //
    $('#activate-step-2').on('click', function(e) {
        $('ul.setup-panel li:eq(1)').removeClass('disabled');
        $('ul.setup-panel li a[href="#step-2"]').trigger('click');
        $(this).remove();
    })    
});


</script>
</body>
</html>