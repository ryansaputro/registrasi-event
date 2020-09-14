<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/iCheck/square/blue.css') }}">
    <!------ Include the above in your HEAD tag ---------->
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="pendaftaran event">
    <meta name="author" content="ryan saputro"> {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="https://portalsepeda.com/wp-content/uploads/2019/03/cropped-Capture-2-2.png">
    <title>Registrasi Event | Portal Sepeda</title>
    <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
    <style>
        .error{
            color:red;
        }

        body{
            background: whitesmoke;
        }

        @media only screen and (min-width: 768px) {
            .infoEvent{
                height: 725px;
            }
            .ukuranJersey{
                margin-top: -20px;
            }
            .sk{
                margin-left:-15px !important;
            }
            .labelSk{
                font-weight: 500;
                padding-top: 20px;
                cursor: pointer;
            }
            
            
        }

        #cover-spin {
            position:fixed;
            width:100%;
            left:0;right:0;top:0;bottom:0;
            background-color: rgba(255,255,255,0.7);
            z-index:9999;
            display:none;
        }

        @-webkit-keyframes spin {
            from {-webkit-transform:rotate(0deg);}
            to {-webkit-transform:rotate(360deg);}
        }

        @keyframes spin {
            from {transform:rotate(0deg);}
            to {transform:rotate(360deg);}
        }

        #cover-spin::after {
            content:'';
            display:block;
            position:absolute;
            left:48%;top:40%;
            width:40px;height:40px;
            border-style:solid;
            border-color:black;
            border-top-color:transparent;
            border-width: 4px;
            border-radius:50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }
    </style>
</head>

<body>
<!--sukses notifikasi-->
@if(session()->has('success'))
    <div class="alert alert-success" style="text-align:center;">
        {{ session()->get('success') }}
    </div>
<!--gagal notifikasi-->
@elseif(session()->has('failed'))
    <div class="alert alert-danger" style="text-align:center;">
        {{ session()->get('failed') }}
    </div>
@endif
<!--error notifikasi-->
@if ($errors->any())
  <div class="alert alert-danger">
     @foreach ($errors->all() as $error)
           {{$error}}<br>
      @endforeach
  </div>
@endif
  @php
    if (strpos($profil['tanggal_lahir'], '-') !== false) {
        $tgl = $profil['tanggal_lahir'];
    }else{
        $tahun = substr($profil['tanggal_lahir'],0,4);
        $bulan = substr($profil['tanggal_lahir'],4,2);
        $tanggal = substr($profil['tanggal_lahir'],6,2);
        $tgl = $tahun."-".$bulan."-".$tanggal;
    }
    $nama = $event->nama_event;
    
    
    $end = date('Y-m-d', strtotime('-15 years'));
  @endphp

    <div id="ajaxError">
	    
	</div>
    <!--loading-->
    <div id="cover-spin"></div>
    <!--loading-->
    <h1 class="text-center"><b style="color:#011e3d;text-transform:uppercase;">{{$nama}}</b></h1>
    <p class="text-center" style="text-transform:uppercase;">{{$event->deskripsi_event}}</p>
    <div class="container" style="padding-top:10px;">
        {{-- <form id="registrasi" action="{{ route('event.registrasi', ["kode_event" => $kode_event, "id_peserta" => $id_peserta ]) }}" method="post" class="form-peserta" enctype="multipart/form-data"> --}}
        <form id="registrasi" method="post" class="form-peserta" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-md-12">
                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #011e3d;color:#fff;border-bottom: 5px solid #da0b45;"><h3>Data Diri</h3></div>
                        <div class="panel-body">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label for="nama">Nama:</label>
                                    <input required type="text" class="form-control" name="nama" id="nama" value="{{ $profil['display_name'] }}" placeholder="nama">
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
                                <label for="jenis_kelamin">Jenis Kelamin:</label>
                                <br>
                                    <label class="radio-inline">
                                        <input type="radio" name="jenis_kelamin" value="Laki-Laki" {{isset($profil['jenis_kelamin']) && $profil['jenis_kelamin'] =='Laki-Laki' ? 'checked' : ''}}>Laki-laki
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="jenis_kelamin" value="Perempuan" {{isset($profil['jenis_kelamin']) && $profil['jenis_kelamin'] =='Perempuan' ? 'checked' : ''}}>Perempuan
                                    </label>
    
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
                                <input required type="date" value="{{$tgl}}" class="form-control" max="{{$end}}" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="tanggal lahir">
                                    <span class="fa fa-calendar-o form-control-feedback"></span> @if($errors->has('tanggal_lahir'))
                                    <div class="text-danger">
                                        {{ $errors->first('tanggal_lahir')}}
                                    </div>
                                    @endif
                                </div>
    
                                <div class="form-group has-feedback">
                                        <label for="golongan_darah">Golongan Darah:</label>
                                        <br>
                                        <label class="radio-inline">
                                            <input type="radio" name="golongan_darah" value="A" {{isset($profil['golongan_darah']) && $profil[ 'golongan_darah']=='A' ? 'checked' : ''}}>A</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="golongan_darah" value="B" {{isset($profil['golongan_darah']) && $profil[ 'golongan_darah']=='B' ? 'checked' : ''}}>B</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="golongan_darah" value="O" {{isset($profil['golongan_darah']) && $profil[ 'golongan_darah']=='O' ? 'checked' : ''}}>O</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="golongan_darah" value="AB" {{isset($profil['golongan_darah']) && $profil[ 'golongan_darah']=='AB' ? 'checked' : ''}}>AB</label>
                                    @if($errors->has('golongan_darah'))
                                    <div class="text-danger">
                                        {{ $errors->first('golongan_darah')}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                    <input required type="text" minlength="5" maxlength="5" class="form-control" name="kode_pos" id="kode_pos" value="{{isset($profil['kode_pos']) ? $profil['kode_pos'] : ''}}" placeholder="Kode Pos">
                                    <span class="fa fa-address-card form-control-feedback"></span> @if($errors->has('kode_pos'))
                                    <div class="text-danger">
                                        {{ $errors->first('kode_pos')}}
                                    </div>
                                    @endif
                                </div>
    
                            </div>
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                    <label for="no_hp_kontak">No Handphone:</label>
                                    <input required type="text" minlength="10" maxlength="12" class="form-control" name="no_hp_kontak" id="no_hp_kontak" value="{{isset($profil['no_hp_kontak']) ? $profil['no_hp_kontak'] : ''}}" placeholder="No Hp Kontak">
                                    <span class="fa fa-address-book-o form-control-feedback"></span> @if($errors->has('no_hp_kontak'))
                                    <div class="text-danger">
                                        {{ $errors->first('no_hp_kontak')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="whatsapp">No. Whatsapp:</label>
                                    <input required type="text" minlength="10" maxlength="12" class="form-control" name="no_wa_kontak" id="no_wa_kontak" value="{{isset($profil['no_wa_kontak']) ? $profil['no_wa_kontak'] : ''}}" placeholder="No Whatsapp Kontak">
                                    <span class="fa fa-whatsapp form-control-feedback"></span> @if($errors->has('no_wa_kontak'))
                                    <div class="text-danger">
                                        {{ $errors->first('no_wa_kontak')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="email">Email:</label>
                                    <input required readonly type="text" class="form-control" name="email" id="email" value="{{ $profil['user_email'] }}" placeholder="No Whatsapp Kontak">
                                    <span class="fa fa-envelope-o form-control-feedback"></span> @if($errors->has('email'))
                                    <div class="text-danger">
                                        {{ $errors->first('email')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="email">Syarat & Ketentuan:</label>
                                    <br>
                                    <a data-toggle="modal" href="#myModal">baca syarat & ketentuan</a>
                                    <div class="col-md-12" style="float:left;text-align:left;">
                                        <label class="labelSk"><input type="checkbox" name="sk" {{ old('sk') ? 'checked' : ''}} class="sk"/>Saya setuju</label>
                                    </div>
                                    @if($errors->has('email'))
                                    <div class="text-danger">
                                        {{ $errors->first('email')}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--/.panel-body-->
                    </div>
                    <!--/.panel-panel-default-->
                </div>
            </div>
            <!--/col-md-12-->
            <div class="col-md-12"><div class="col-md-12"><p class="pull-right" style="color:#011e3d;">Mohon isi data dengan benar dan perhatikan informasi event yang anda ikuti sudah benar!</p></div></div>     
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #011e3d;color:#fff;border-bottom: 5px solid #da0b45;"><h3>Kontak Darurat</h3></div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">
                                    <label for="nama_kontak">Nama Kontak Darurat:</label>
                                <input required type="text" class="form-control" value="{{old('nama_kontak')}}" name="nama_kontak" id="nama_kontak" placeholder="nama kontak">
                                <span class="fa fa-user form-control-feedback"></span> @if($errors->has('nama_kontak'))
                                <div class="text-danger">
                                    {{ $errors->first('nama_kontak')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group has-feedback">
                                    <label for="hubungan_kontak">Hubungan Kontak:</label>
                                <input required type="text" class="form-control" value="{{old('hubungan_kontak')}}" name="hubungan_kontak" id="hubungan_kontak" placeholder="hubungan kontak">
                                <span class="fa fa-handshake-o form-control-feedback"></span> @if($errors->has('hubungan_kontak'))
                                <div class="text-danger">
                                    {{ $errors->first('hubungan_kontak')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group has-feedback">
                                    <label for="no_telp">No. Telpon Darurat:</label>
                                <input required type="text" class="form-control" value="{{old('no_telp')}}" minlength="10" maxlength="15" name="no_telp" id="no_telp" placeholder="no telp">
                                <span class="fa fa-phone form-control-feedback"></span> @if($errors->has('no_telp'))
                                <div class="text-danger">
                                    {{ $errors->first('no_telp')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        <!--/.panel-body-->
                    </div>
                    <!--/.panel-default-->
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #011e3d;color:#fff;border-bottom: 5px solid #da0b45;"><h3>Info Tambahan</h3></div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">
                                <label for="komunitas">Komunitas:</label>
                                <input type="text" list="komunitas" required  value="{{old('komunitas')}}" class="form-control"  placeholder="Masukkan Komunitas anda" name="komunitas">
                                <datalist id="komunitas">
                                    @foreach($komunitas AS $k => $v)
                                    <option value="{{$v->name_community}}">
                                    @endforeach
                                </datalist>
                                <span class="fa fa-users form-control-feedback"></span> 
                                @if($errors->has('email'))
                                <div class="text-danger">
                                    {{ $errors->first('komunitas')}}
                                </div>
                                @endif
                            </div>
                            @if(count($model) > 0)
                            <input type="hidden" name="AdaJersey" value="ada">
                            <div class="form-group has-feedback">
                                <label for="jersey">Jersey:</label>
                                @foreach($model AS $k => $v)
                                    <br>
                                    <label class="radio-inline">
                                        <input type="radio" {{old('model') == $v->model ? 'checked' : ''}} name="model" onclick="JersyChange(this)" value="{{$v->model}}">{{$v->model}}
                                    </label>

                                    @if($errors->has('jersey'))
                                    <div class="text-danger">
                                        {{ $errors->first('jersey')}}
                                    </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="form-group has-feedback">
                                <label for="ukuran">Ukuran:</label>
                                <div class="ukuranJersey"></div>
                            </div>
                            <a style="color: #da0b45;font-size: 14px; font-weight:600;margin-bottom: 30px;" href="{{asset('laravel/public/images/event/mockup/'.$event->desain_mockup)}}" target="_blank"><u>lihat jersey</u></a>
                            @else
                                <input type="hidden" name="AdaJersey" value="tidak">
                            @endif
                        </div>
                        <!--/.panel-body-->
                    </div>
                    <!--/.panel-default-->
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="panel panel-default infoEvent">
                        <div class="panel-heading" style="background: #011e3d;color:#fff;border-bottom: 5px solid #da0b45;"><h3>Informasi Event</h3></div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label for="nama_event">Nama Event:</label>
                                    <div style="font-size:20px;resize:none;background-color: #da0b45;color:#fff;font-weight:500;border:1px solid #d2d6de;padding:10px;">{{$event->nama_event}}</div>
                                    {{-- <textarea required class="form-control" wrap="hard" readonly style="height:41px !important;font-size:20px;resize:none;background-color: #da0b45;color:#fff;font-weight:500;" name="deskripsi_event" id="deskripsi_event">{{$event->nama_event}}</textarea> --}}
                                    {{-- <input required type="text" class="form-control" readonly style="background-color: #da0b45;color:#fff;font-weight:400;" name="nama_event" id="nama_event" value="{{$event->nama_event}}"> --}}
                                    </span> @if($errors->has('nama_event'))
                                    <div class="text-danger">
                                        {{ $errors->first('nama_event')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                    <input required type="text" class="form-control" readonly style="padding:10px;background-color: #fff;color:#da0b45;font-weight:700;" name="tanggal_mulai" id="tanggal_mulai" value="{{$event->tanggal_mulai}}">
                                    <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tanggal_mulai'))
                                    <div class="text-danger">
                                        {{ $errors->first('tanggal_mulai')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                    <input required type="text" class="form-control" readonly style="background-color: #fff;color:#da0b45;font-weight:700;" name="tanggal_akhir" id="tanggal_akhir" value="{{$event->tanggal_akhir}}">
                                    <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tanggal_akhir'))
                                    <div class="text-danger">
                                        {{ $errors->first('tanggal_akhir')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                <label for="tempat_event">Tempat Event:</label>
                                    <input required type="text" class="form-control" readonly style="background-color: #fff;color:#da0b45;font-weight:700;" name="tempat_event" id="tempat_event" value="{{$event->tempat_event}}">
                                    <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tempat_event'))
                                    <div class="text-danger">
                                        {{ $errors->first('tempat_event')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                <label for="waktu_kumpul">Waktu Kumpul:</label>
                                    <input required type="text" class="form-control" readonly style="background-color: #fff;color:#da0b45;font-weight:700;" name="waktu_kumpul" id="waktu_kumpul" value="{{$event->waktu_kumpul}}">
                                    <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('waktu_kumpul'))
                                    <div class="text-danger">
                                        {{ $errors->first('waktu_kumpul')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                <label for="tempat_kumpul">Tempat Kumpul:</label>
                                    <input required type="text" class="form-control" readonly style="background-color: #fff;color:#da0b45;font-weight:700;" name="tempat_kumpul" id="tempat_kumpul" value="{{$event->tempat_kumpul}}">
                                    <span class="fa fa-map-marker form-control-feedback"></span> @if($errors->has('tempat_kumpul'))
                                    <div class="text-danger">
                                        {{ $errors->first('tempat_kumpul')}}
                                    </div>
                                    @endif
                                </div>
    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                        <label for="provinsi">Provinsi:</label>
                                    <select disabled style="background-color: #fff;color:#da0b45;font-weight:700;"  required class="form-control" name="provinsi" id="provinsi_event" value="{{ old('provinsi') }}">
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
                                    <select disabled style="background-color: #fff;color:#da0b45;font-weight:700;"  required class="form-control" name="kota" id="kota_event" value="{{ old('kota') }}">
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
                                    <select disabled style="background-color: #fff;color:#da0b45;font-weight:700;"  required class="form-control" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}">
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
                                    <select disabled style="background-color: #fff;color:#da0b45;font-weight:700;"  required class="form-control" name="desa" id="desa" value="{{ old('desa') }}">
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
                                <textarea required class="form-control" value="" rows="5" readonly style="background-color: #fff;color:#da0b45;font-weight:500;" name="deskripsi_event" id="deskripsi_event">{{$event->deskripsi_event}}</textarea>
                                    <span class="fa fa-address-card form-control-feedback"></span> @if($errors->has('deskripsi_event'))
                                    <div class="text-danger">
                                        {{ $errors->first('deskripsi_event')}}
                                    </div>
                                    @endif
                                </div>
                                @if($isFreeActive !== null)
                                <div class="form-group has-feedback">
                                <label for="tanggal_akhir">Biaya Pendaftaran:</label>
                                    <input required type="text" class="form-control" readonly style="background-color: #fff;color:#da0b45;font-weight:700;" name="tanggal_akhir" id="tanggal_akhir" value="Rp. {{number_format($isFreeActive->harga,0, ',-', '.')}},- ">
                                    <input type="hidden" name="harga" value="{{$isFreeActive->harga}}">
                                    @if($errors->has('tanggal_akhir'))
                                    <div class="text-danger">
                                        {{ $errors->first('tanggal_akhir')}}
                                    </div>
                                    @endif
                                </div>
                                @endif
    
                            </div>
                        </div>
                        <!--/.panel-body-->
                    </div>
                    <!--/.panel-default-->
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4 pull-right">
                    @if($isFreeActive == null)
                        <button type="submit" class="btn btn-block registrasi" style="background: #da0b45;color:#fff;font-size:20px;margin-bottom:30px;">Registrasi</button>
                    @else
                        <button type="submit" class="btn btn-block registrasi" style="background: #da0b45;color:#fff;font-size:20px;margin-bottom:30px;">Registrasi</button>
                    @endif
                    
                </div>
            </div>

            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                    <h4 class="modal-title">Syarat & Ketentuan</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12" style="border:1px solid whitesmoke;margin-bottom:10px;">
                        {!! $event->syarat_dan_ketentuan !!}
                    </div>
                    <!--<div class="row" style="margin-top:10px;">-->
                        <!--<div class="col-md-6" style="float:left;text-align:left;">-->
                        <!--    <label><input type="checkbox" name="sk" onclick="CekSk(this)"/>Saya setuju</label>-->
                        <!--</div>-->
                        <!--<div class="col-md-6 next_button" style="float:right;">-->
                            
                        <!--</div>-->
    
                        <!-- /.col -->
                    <!--</div>-->
                </div>
                <div class="modal-footer" style="border:none !important;">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Keluar</button>
                </div>
                </div>

            </div>
            </div>

        </form>
    </div>
    <?php 
        if(old('model')){
            $model = '1';
        }else{
            $model = '0';
        }
    ?>
    {{--
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> --}}

    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script>
         if ($(".form-peserta").length > 0) {
                // var formData = new FormData(this);
            	$(".form-peserta").validate({
            		rules: {
            			nama: {
            				required: true,
            			},
            			panggilan: {
            				required: true,
            			},
            			jenis_kelamin: {
            				required: true,
            			},
            			tempat_lahir: {
            				required: true,
            			},
            			tanggal_lahir: {
            				required: true,
            				date: true,
                            // maxDate: Date.parse("2000-03-02")
            			},
            			golongan_darah: {
            				required: true,
            			},
            			pekerjaan: {
            				required: true,
            			},
            			provinsi: {
            				required: true,
            			},
            			kota: {
            				required: true,
            			},
            			alamat: {
            				required: true,
            			},
            			kode_pos: {
            				required: true,
            				digits: true,
            				minlength: 5,
            				maxlength: 5,
            				number: true,
            			},
            			no_hp_kontak: {
            				required: true,
            				digits: true,
            				minlength: 10,
            				maxlength: 15,
            				number: true,
            			},
            			no_wa_kontak: {
            				required: true,
            				digits: true,
            				minlength: 10,
            				maxlength: 15,
            				number: true,
            			},
            			email: {
                            required: true,
                            email: true
            			},
            			sk: {
            				required: true,
            			},
            			nama_kontak: {
            				required: true,
            			},
            			hubungan_kontak: {
            				required: true,
            			},
            			no_telp: {
            				required: true,
            				digits: true,
            				minlength: 10,
            				maxlength: 15,
            				number: true,
            			},
            			komunitas: {
            				required: true,
            			},
            			model: {
            				required: true,
            			},
            		},
            		messages: {
            			name: {
            				required: "Please enter name",
            				maxlength: "Your last name maxlength should be 50 characters long."
            			},
            			mobile_number: {
            				required: "Please enter contact number",
            				minlength: "The contact number should be 10 digits",
            				digits: "Please enter only numbers",
            				maxlength: "The contact number should be 12 digits",
            			},
            			email: {
            				required: "Please enter valid email",
            				email: "Please enter valid email",
            				maxlength: "The email name should less than or equal to 50 characters",
            			},
            		},
            		submitHandler: function (form) {
            			$.ajaxSetup({
            				headers: {
            					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            				}
            			});
            			var form = $('.form-peserta')[0];
            			$('#send_form').html('Sending..');
            			$.ajax({
            				url:"{{URL::to('/payment')}}",
            				type: "POST",
            				data: new FormData(form),
            				enctype: 'multipart/form-data',
                            processData: false,  // Important!
                            contentType: false,
                            cache: false,
            				beforeSend: function () {
                    			// Show image container
                    			$('#cover-spin').show(0);
                    		},
            				success: function (response) {
            				    if(response.status == true){
            				        window.location.href = "https://eo.portalsepeda.com/dashboard";
            				    }
            				}, error : function(response, textStatus, errorThrown){
                                alert("error")
                                var htmls = "";
                                
                                $.each(response.responseJSON.errors, function(k, v){
                                    $.each(v, function(x,y){
                                        htmls +=  y+ '<br>';
                                    });
                                });
                                
                                $('#ajaxError').addClass('alert alert-danger');
                                $('#ajaxError').html(htmls);
                                $('#cover-spin').hide();
                            }
            			});
            		}
            	})
            }
           


        // $('.form-peserta').on('submit', function(){
        //     $('#cover-spin').show();
        // });

        // function register(a){
        //     var urls = "{{URL::to('/payment')}}";
        //     data = $('#registrasi').serialize();
        //     $.ajax({
        //         url: urls,
        //         method: "post",
        //         data: data,
        //         beforeSend: function(){
        //             // Show image container
        //             $('#cover-spin').show(0);
        //         },
        //         success: function(result) {
        //             if(result.status_code == '00'){
        //                window.location.href = result.redirect_url;
        //             }
        //         },
        //         complete:function(data){
        //             // Hide image container
        //             $('#cover-spin').hide();
        //         }
        //     });
            
        // }

        $(document).ready(function(){
        //     $('#myModal').modal({'show':'show', backdrop: 'static', keyboard: false});
                var data = "{{ $model }}";
                if(data == '1'){
                    JersyChange($('input[name="model"]:checked'));    
                }
        });

        function JersyChange(a){
            var urls = "{{URL::to('/jersey/size')}}";
            $.ajax({
                url: urls,
                method: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kode_event": "{{$event->kode_event}}",
                    "model": $('input[name="model"]:checked').val(),
                },
                beforeSend: function(){
                    // Show image container
                    $('#cover-spin').show(0);
                },
                success: function(result) {
                    var check = "{{old('ukuran')}}";
                    var data = "";
                    $.each(result.data, function(k, v) {
                        if(check == v.size){
                            data += '<br><label class="radio-inline">'+
                                    '<input type="radio" name="ukuran" checked  value="'+v.size+'">'+v.size+' ('+v.ukuran+')'+
                                '</label>';    
                        }else{
                            data += '<br><label class="radio-inline">'+
                                    '<input type="radio" name="ukuran"  value="'+v.size+'">'+v.size+' ('+v.ukuran+')'+
                                '</label>';
                        }
                        
                    });

                    $(".ukuranJersey").html(data);
                },
                complete:function(data){
                    // Hide image container
                    $('#cover-spin').hide();
                }
            });
            
        }

        function CekSk(a){
            var cek = $(a).is(':checked') ? '1' : '0';
            if(cek == '1'){
            $('.selanjutnya').css('display', 'inherit');
            var btn = '<button data-dismiss="modal" id="activate-step-2" type="button" class="btn btn-primary btn-block btn-flat selanjutnya">Selanjutnya</button>';

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

    </script>
</body>

</html>