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
    <meta name="author" content="Orzdev"> {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.ico') }}">
    <title>SIKTIKA | Registration Page</title>
    <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <style>
        .form-control{
            border-top: none;
            border-left: none;
            border-right: none;
        }
    </style>

</head>

<body>
  @php
    $nama = $event->nama_event;
    $tahun = substr($profil['tanggal_lahir'],0,4);
    $bulan = substr($profil['tanggal_lahir'],5,2);
    $tanggal = substr($profil['tanggal_lahir'],6,2);
    $tgl = $tahun."-".$bulan."-".$tanggal;
  @endphp
    <h1 class="text-center"><b style="color:#da0b45;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">Event</b> <b style="color:#fff;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">{{$nama}}</b></h1>
    <div class="container" style="padding-top:10px;">
        <div class="row form-group">
            <div class="col-xs-12">
                <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                    <li class="active">
                        <a href="#step-1">
                            <h4 class="list-group-item-heading">Syarat dan Ketentuan</h4>
                        <p class="list-group-item-text">Syarat dan Ketentuan Event {{$event->nama_event}}</p>
                        </a>
                    </li>
                    <li class="dt_ disabled">
                        <a href="#step-2">
                            <h4 class="list-group-item-heading">Data Diri Peserta</h4>
                            <p class="list-group-item-text">Lengkapi Data Diri Anda</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <form action="{{ route('event.registrasi', ["kode_event" => $kode_event, "id_peserta" => $id_peserta ]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row setup-content" id="step-1">
                <div class="col-xs-12">
                    <div class="col-md-12 well text-center">
                        <div class="register-box-body">
                            {{--
                            <p class="login-box-msg">Profil</p> --}}
                            <div class="row">
                                <div style="border:1px solid whitesmoke;height:300px;padding:10px;overflow-y: auto;text-align: justify;">
                                  @for($i=1; $i<=15; $i++)  
                                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, cum animi in aspernatur, pariatur atque odio possimus, explicabo porro excepturi dolore! Obcaecati placeat eum consectetur voluptates quo nostrum soluta voluptatum.
                                  @endfor
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-6" style="float:left;text-align:left;">
                                  <label><input type="checkbox" name="sk" onclick="CekSk(this)"/>Saya setuju dengan syarat dan ketentuan tersebut</label>
                                </div>
                                <div class="col-md-6 next_button" style="float:right;">
                                    
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
                            {{-- <p class="login-box-msg">Data Diri</p> --}}
                              <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <h3 style="color:#da0b45;">Data Diri</h3>
                                    <div class="form-group has-feedback">
                                         <label for="nama">Nama:</label>
                                        <input required type="text" class="form-control" name="nama" id="nama" value="{{ Auth::user()->toArray()['display_name'] }}" placeholder="nama">
                                        <span class="fa fa-user form-control-feedback"></span> @if($errors->has('nama'))
                                        <div class="text-danger">
                                            {{ $errors->first('nama')}}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                         <label for="panggilan">Panggilan:</label>
                                        <input required type="text" class="form-control" name="panggilan" id="panggilan" value="{{ isset($profil['panggilan']) ? $profil['panggilan'] : '' }}" placeholder="panggilan">
                                        <span class="fa fa-user form-control-feedback"></span> @if($errors->has('panggilan'))
                                        <div class="text-danger">
                                            {{ $errors->first('panggilan')}}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                    <label for="jenis_kelamin">Jenis Kelamin:{{$profil['jenis_kelamin']}}</label>
                                        <div class="radio text-left">
                                            <label>
                                                <input type="radio" name="jenis_kelamin" value="Laki-Laki" {{isset($profil['jenis_kelamin']) && $profil['jenis_kelamin'] =='Laki-Laki' ? 'checked' : ''}}>Laki-laki</label>
                                        </div>
                                        <div class="radio text-left">
                                            <label>
                                                <input type="radio" name="jenis_kelamin" value="Perempuan" {{isset($profil['jenis_kelamin']) && $profil['jenis_kelamin'] =='Perempuan' ? 'checked' : ''}}>Perempuan</label>
                                        </div>
                                        @if($errors->has('jenis_kelamin'))
                                        <div class="text-danger">
                                            {{ $errors->first('jenis_kelamin')}}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                         <label for="tempat_lahir">Tempat Lahir:</label>
                                        <input required type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ isset($profil['tempat_lahir']) ? $profil['tempat_lahir'] : '' }}" placeholder="tempat lahir">
                                        <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tempat_lahir'))
                                        <div class="text-danger">
                                            {{ $errors->first('tempat_lahir')}}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                         <label for="tanggal_lahir">Tanggal Lahir:</label>
                                    <input required type="date" value="{{$profil['tanggal_lahir']}}" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="tanggal lahir">
                                        <span class="fa fa-calendar-o form-control-feedback"></span> @if($errors->has('tanggal_lahir'))
                                        <div class="text-danger">
                                            {{ $errors->first('tanggal_lahir')}}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                         <label for="golongan_darah">Golongan Darah:</label>
                                        <div class="radio text-left">
                                            <label>
                                                <input type="radio" name="golongan_darah" value="A" {{isset($profil['golongan_darah']) && $profil[ 'golongan_darah']=='A' ? 'checked' : ''}}>A</label>
                                        </div>
                                        <div class="radio text-left">
                                            <label>
                                                <input type="radio" name="golongan_darah" value="B" {{isset($profil['golongan_darah']) && $profil[ 'golongan_darah']=='B' ? 'checked' : ''}}>B</label>
                                        </div>
                                        <div class="radio text-left">
                                            <label>
                                                <input type="radio" name="golongan_darah" value="O" {{isset($profil['golongan_darah']) && $profil[ 'golongan_darah']=='O' ? 'checked' : ''}}>O</label>
                                        </div>
                                        <div class="radio text-left">
                                            <label>
                                                <input type="radio" name="golongan_darah" value="AB" {{isset($profil['golongan_darah']) && $profil[ 'golongan_darah']=='AB' ? 'checked' : ''}}>AB</label>
                                        </div>
                                        @if($errors->has('golongan_darah'))
                                        <div class="text-danger">
                                            {{ $errors->first('golongan_darah')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="pekerjaan">Pekerjaan:</label>
                                        <input required type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="{{isset($profil['pekerjaan']) ? $profil['pekerjaan'] : ''}}" placeholder="pekerjaan">
                                        <span class="fa fa-laptop form-control-feedback"></span> @if($errors->has('pekerjaan'))
                                        <div class="text-danger">
                                            {{ $errors->first('pekerjaan')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="provinsi">Provinsi:</label>
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
                                         <label for="kota">Kota:</label>
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
                                         <label for="alamat">Alamat:</label>
                                        <textarea required class="form-control" value="" name="alamat" id="alamat" value="{{ old('alamat') }}" placeholder="Masukan Alamat Anda">{{isset($profil['alamat']) ? $profil['alamat'] : ''}}</textarea>
                                        <span class="fa fa-address-card form-control-feedback"></span> @if($errors->has('alamat'))
                                        <div class="text-danger">
                                            {{ $errors->first('alamat')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="kode_pos">Kode Pos:</label>
                                        <input required type="text" class="form-control" name="kode_pos" id="kode_pos" value="{{isset($profil['kode_pos']) ? $profil['kode_pos'] : ''}}" placeholder="Kode Pos">
                                        <span class="fa fa-address-card form-control-feedback"></span> @if($errors->has('kode_pos'))
                                        <div class="text-danger">
                                            {{ $errors->first('kode_pos')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="no_hp_kontak">No Hp Kontak:</label>
                                        <input required type="text" class="form-control" name="no_hp_kontak" id="no_hp_kontak" value="{{isset($profil['no_hp_kontak']) ? $profil['no_hp_kontak'] : ''}}" placeholder="No Hp Kontak">
                                        <span class="fa fa-address-book-o form-control-feedback"></span> @if($errors->has('no_hp_kontak'))
                                        <div class="text-danger">
                                            {{ $errors->first('no_hp_kontak')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="whatsapp">Whatsapp:</label>
                                        <input required type="text" class="form-control" name="no_wa_kontak" id="no_wa_kontak" value="{{isset($profil['whatsapp']) ? $profil['whatsapp'] : ''}}" placeholder="No Whatsapp Kontak">
                                        <span class="fa fa-whatsapp form-control-feedback"></span> @if($errors->has('no_wa_kontak'))
                                        <div class="text-danger">
                                            {{ $errors->first('no_wa_kontak')}}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <h3 style="color:#da0b45;">Data Event</h3>
                                    <div class="form-group has-feedback">
                                         <label for="nama_kontak">Nama Kontak:</label>
                                        <input required type="text" class="form-control" name="nama_kontak" id="nama_kontak" placeholder="nama_kontak">
                                        <span class="fa fa-user form-control-feedback"></span> @if($errors->has('nama_kontak'))
                                        <div class="text-danger">
                                            {{ $errors->first('nama_kontak')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="hubungan_kontak">Hubungan Kontak:</label>
                                        <input required type="text" class="form-control" name="hubungan_kontak" id="hubungan_kontak" placeholder="hubungan_kontak">
                                        <span class="fa fa-handshake-o form-control-feedback"></span> @if($errors->has('hubungan_kontak'))
                                        <div class="text-danger">
                                            {{ $errors->first('hubungan_kontak')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="no_telp">No Telp:</label>
                                        <input required type="text" class="form-control" max="12" name="no_telp" id="no_telp" placeholder="no_telp">
                                        <span class="fa fa-phone form-control-feedback"></span> @if($errors->has('no_telp'))
                                        <div class="text-danger">
                                            {{ $errors->first('no_telp')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="nama_event">Nama Event:</label>
                                        <input required type="text" class="form-control" readonly style="background-color: #fff;border-color: white;" name="nama_event" id="nama_event" value="{{$event->nama_event}}">
                                        <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('nama_event'))
                                        <div class="text-danger">
                                            {{ $errors->first('nama_event')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                    <label for="tanggal_mulai">Tanggal Mulai:</label>
                                        <input required type="text" class="form-control" readonly style="background-color: #fff;border-color: white;" name="tanggal_mulai" id="tanggal_mulai" value="{{$event->tanggal_mulai}}">
                                        <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tanggal_mulai'))
                                        <div class="text-danger">
                                            {{ $errors->first('tanggal_mulai')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                    <label for="tanggal_akhir">Tanggal Akhir:</label>
                                        <input required type="text" class="form-control" readonly style="background-color: #fff;border-color: white;" name="tanggal_akhir" id="tanggal_akhir" value="{{$event->tanggal_akhir}}">
                                        <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tanggal_akhir'))
                                        <div class="text-danger">
                                            {{ $errors->first('tanggal_akhir')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                    <label for="tempat_event">Tempat Event:</label>
                                        <input required type="text" class="form-control" readonly style="background-color: #fff;border-color: white;" name="tempat_event" id="tempat_event" value="{{$event->tempat_event}}">
                                        <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tempat_event'))
                                        <div class="text-danger">
                                            {{ $errors->first('tempat_event')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                    <label for="waktu_kumpul">Waktu Kumpul:</label>
                                        <input required type="text" class="form-control" readonly style="background-color: #fff;border-color: white;" name="waktu_kumpul" id="waktu_kumpul" value="{{$event->waktu_kumpul}}">
                                        <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('waktu_kumpul'))
                                        <div class="text-danger">
                                            {{ $errors->first('waktu_kumpul')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                    <label for="tempat_kumpul">Tempat Kumpul:</label>
                                        <input required type="text" class="form-control" readonly style="background-color: #fff;border-color: white;" name="tempat_kumpul" id="tempat_kumpul" value="{{$event->tempat_kumpul}}">
                                        <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tempat_kumpul'))
                                        <div class="text-danger">
                                            {{ $errors->first('tempat_kumpul')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="provinsi">Provinsi:</label>
                                        <select disabled style="background-color: #fff;border-color: white;"  required class="form-control" name="provinsi" id="provinsi_event" value="{{ old('provinsi') }}">
                                            <option selected disabled>-pilih provinsi-</option>
                                            @foreach ($provinsi as $k => $v)
                                            <option value="{{$v['id']}}" {{$event->id_provinsi == $v['id'] ? 'selected' : ''}}>{{$v['nama']}}</option>
                                            @endforeach
                                            </select>
                                        @if($errors->has('provinsi'))
                                        <div class="text-danger">
                                            {{ $errors->first('provinsi')}}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                         <label for="kota">Kota:</label>
                                        <select disabled style="background-color: #fff;border-color: white;"  required class="form-control" name="kota" id="kota_event" value="{{ old('kota') }}">
                                            <option selected disabled>-pilih kota-</option>
                                                @if ($kotaEvent != null)
                                                    @foreach ($kotaEvent as $k => $v)
                                                        <option value="{{$v['id']}}" {{$event->id_kota == $v['id'] ? 'selected' : ''}}>{{$v['nama']}}</option>  
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
                                         <label for="kecamatan">Kecamatan:</label>
                                        <select disabled style="background-color: #fff;border-color: white;"  required class="form-control" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}">
                                            <option selected disabled>-pilih kecamatan-</option>
                                                @if ($kecEvent != null)
                                                    @foreach ($kecEvent as $k => $v)
                                                        <option value="{{$v['id']}}" {{$event->id_kecamatan == $v['id'] ? 'selected' : ''}}>{{$v['nama']}}</option>  
                                                    @endforeach
                                                @endif
                                        </select>
                                        @if($errors->has('kecamatan'))
                                        <div class="text-danger">
                                            {{ $errors->first('kecamatan')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                         <label for="desa">Desa:</label>
                                        <select disabled style="background-color: #fff;border-color: white;"  required class="form-control" name="desa" id="desa" value="{{ old('desa') }}">
                                            <option selected disabled>-pilih desa-</option>
                                                @if ($kelEvent != null)
                                                    @foreach ($kelEvent as $k => $v)
                                                        <option value="{{$v['id']}}" {{$event->id_desa == $v['id'] ? 'selected' : ''}}>{{$v['nama']}}</option>  
                                                    @endforeach
                                                @endif
                                        </select>
                                        @if($errors->has('desa'))
                                        <div class="text-danger">
                                            {{ $errors->first('kota')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback">
                                    <label for="deskripsi_event">Deskripsi Event:</label>
                                    <textarea required class="form-control" value="" readonly style="background-color: #fff;border-color: white;" name="deskripsi_event" id="deskripsi_event">{{$event->deskripsi_event}}</textarea>
                                        <span class="fa fa-address-card form-control-feedback"></span> @if($errors->has('deskripsi_event'))
                                        <div class="text-danger">
                                            {{ $errors->first('deskripsi_event')}}
                                        </div>
                                        @endif
                                    </div>
                                    @if($isFreeActive !== null)
                                    <input type="hidden" name="harga" value="{{$isFreeActive->harga}}">
                                        <strong>Biaya Pendaftaran</strong>
                                            <h2 style="float:right;color:red;">Rp. {{number_format($isFreeActive->harga,0, ',-', '.')}},- </h2>    
                                    @endif
                                </div>
                            </div>                            
                            <!--./row-->
                            <div class="row">
                                <div class="col-md-6" style="float:right;margin-top:20px;margin-bottom:20px;">
                                    <input class="btn btn-primary btn-block btn-flat" type="submit" value="Register">
                                </div>

                                <!-- /.col -->
                            </div>

        </form>

        <div class="footer">
            <p class="text-center">powered by <a href="https://portalsepeda.com"><span style="letter-spacing: 1px;color:#da0b45;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">portal</span><span style="color:#fff;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;letter-spacing: 1px;">sepeda</span></a></p>
        </div>
    </div>

    {{--
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> --}}

    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <!-- iCheck -->
    {{--
    <script src="{{ asset('assets/vendor/iCheck/icheck.min.js') }}"></script> --}} {{--
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script> --}} {{--
    <script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script> --}}
    <script>
      function CekSk(a){
        var cek = $(a).is(':checked') ? '1' : '0';
        if(cek == '1'){
          $('.selanjutnya').css('display', 'inherit');
          var btn = '<button onclick="nextStep(this)" id="activate-step-2" type="button" class="btn btn-primary btn-block btn-flat selanjutnya">Selanjutnya</button>';

          $('.next_button').html(btn);
          // $('.dt_').removeClass('disabled');
          // $('.dt_').addClass('active');
        }else{
          $('.selanjutnya').css('display', 'none');
          $('.dt_').removeClass('active');
          $('.dt_').addClass('disabled');
          $('.next_button').html("");
        }
      }

        $("#provinsi").on('change', function() {
            var id = $("#provinsi").find(':selected').val();
            var urls = "{{URL::to('/registrasiEO/ajaxKota')}}";
            $.ajax({
                url: urls,
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(result) {
                    var data = "<option disabled selected>-pilih kota-</option>";
                    $.each(result.getKota, function(k, v) {
                        data += '<option value="' + v.id + '" data-id="' + v.id + '">' + v.nama + '</option>'
                    })

                    $("#kota").html(data);
                }
            });
        });

        function EoProvinsi(a) {
            var id = $(a).find(':selected').val();
            var urls = "{{URL::to('/registrasiEO/ajaxKota')}}";
            $.ajax({
                url: urls,
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(result) {
                    var data = "<option disabled selected>-pilih kota-</option>";
                    $.each(result.getKota, function(k, v) {
                        data += '<option value="' + v.id + '" data-id="' + v.id + '">' + v.nama + '</option>'
                    })

                    $("#kotaEo").html(data);
                }
            });
        }

        function nextStep(a){
          $('ul.setup-panel li:eq(1)').removeClass('disabled');
          $('ul.setup-panel li a[href="#step-2"]').trigger('click');
        }

        $(document).ready(function() {

            var navListItems = $('ul.setup-panel li a'),
                allWells = $('.setup-content');

            allWells.hide();

            navListItems.click(function(e) {
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
            // $('#activate-step-2').on('click', function(e) {
                // $('ul.setup-panel li:eq(1)').removeClass('disabled');
                // $('ul.setup-panel li a[href="#step-2"]').trigger('click');
            //     // $(this).remove();
            // })

        });

    </script>
</body>

</html>