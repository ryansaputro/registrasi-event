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
        body{
            background: whitesmoke;
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
    <h1 class="text-center"><b style="color:#011e3d;text-transform:uppercase;">{{$nama}}</b></h1>
    <p class="text-center" style="text-transform:uppercase;">{{$event->deskripsi_event}}</p>
    <div class="container" style="padding-top:10px;">
        <form action="{{ route('event.registrasi', ["kode_event" => $kode_event, "id_peserta" => $id_peserta ]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
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
                            <input required type="date" value="{{$tgl}}" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="tanggal lahir">
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
                                <input required type="text" class="form-control" name="kode_pos" id="kode_pos" value="{{isset($profil['kode_pos']) ? $profil['kode_pos'] : ''}}" placeholder="Kode Pos">
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
                                <input required type="text" class="form-control" name="no_hp_kontak" id="no_hp_kontak" value="{{isset($profil['no_hp_kontak']) ? $profil['no_hp_kontak'] : ''}}" placeholder="No Hp Kontak">
                                <span class="fa fa-address-book-o form-control-feedback"></span> @if($errors->has('no_hp_kontak'))
                                <div class="text-danger">
                                    {{ $errors->first('no_hp_kontak')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group has-feedback">
                                <label for="whatsapp">No. Whatsapp:</label>
                                <input required type="text" class="form-control" name="no_wa_kontak" id="no_wa_kontak" value="{{isset($profil['no_wa_kontak']) ? $profil['no_wa_kontak'] : ''}}" placeholder="No Whatsapp Kontak">
                                <span class="fa fa-whatsapp form-control-feedback"></span> @if($errors->has('no_wa_kontak'))
                                <div class="text-danger">
                                    {{ $errors->first('no_wa_kontak')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group has-feedback">
                                <label for="whatsapp">Email:</label>
                                <input required type="text" class="form-control" name="email" id="email" value="{{ $profil['user_email'] }}" placeholder="No Whatsapp Kontak">
                                <span class="fa fa-envelope-o form-control-feedback"></span> @if($errors->has('email'))
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
            <!--/col-md-12-->
            <div class="col-md-12"><p class="pull-right" style="color:#011e3d;">Mohon isi data dengan benar dan perhatikan informasi event yang anda ikuti sudah benar!</p></div>     
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #011e3d;color:#fff;border-bottom: 5px solid #da0b45;"><h3>Emergensi Kontak</h3></div>
                    <div class="panel-body">
                        <div class="form-group has-feedback">
                                <label for="nama_kontak">Nama Kontak Emergensi:</label>
                            <input required type="text" class="form-control" value="{{ old('nama_kontak') }}" name="nama_kontak" id="nama_kontak" placeholder="nama kontak">
                            <span class="fa fa-user form-control-feedback"></span> @if($errors->has('nama_kontak'))
                            <div class="text-danger">
                                {{ $errors->first('nama_kontak')}}
                            </div>
                            @endif
                        </div>
                        <div class="form-group has-feedback">
                                <label for="hubungan_kontak">Hubungan Kontak:</label>
                            <input required type="text" class="form-control" value="{{ old('hubungan_kontak') }}" name="hubungan_kontak" id="hubungan_kontak" placeholder="hubungan kontak">
                            <span class="fa fa-handshake-o form-control-feedback"></span> @if($errors->has('hubungan_kontak'))
                            <div class="text-danger">
                                {{ $errors->first('hubungan_kontak')}}
                            </div>
                            @endif
                        </div>
                        <div class="form-group has-feedback">
                                <label for="no_telp">No. Telpon Emergensi:</label>
                            <input required type="text" class="form-control" value="{{ old('no_telp') }}" max="12" name="no_telp" id="no_telp" placeholder="no telp">
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
            <div class="col-md-8">
                <div class="panel panel-default">
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
            <div class="col-md-4 pull-right">
                <button class="btn btn-block" style="background: #da0b45;color:#fff;font-size:20px;margin-bottom:30px;">Registrasi</button>
            </div>
        </form>
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