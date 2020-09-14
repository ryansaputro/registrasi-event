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
    <link href="{{ asset('assets/vendor/datatables/datatables.min.css') }}" rel="stylesheet">
    <style>
        body{
            background: whitesmoke;
        }

        /* Style the tab */
        .tab {
        overflow: hidden;
        border: 1px solid #fff;
        background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
        border-left: 1px solid #da0b45;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
        background-color: #da0b45;
        color: #fff;
        }

        /* Create an active/current tablink class */
        .tab button.active {
        background-color: #da0b45;
        color: #fff;
        }

        /* Style the tab content */
        .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
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

    <div id="cover-spin"></div>
    {{-- <h1 class="text-center"><b style="color:#011e3d;text-transform:uppercase;">{{$nama}}</b></h1>
    <p class="text-center" style="text-transform:uppercase;">{{$event->deskripsi_event}}</p> --}}
    <div class="container" style="padding-top:10px;">
        <div class="col-md-12">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @elseif(session()->has('failed'))
                <div class="alert alert-danger">
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
                <div class="panel panel-default">
                    <?php
                        // print_r($cekMember);    
                    ?>
                    <div class="panel-heading" style="background-image:url(https://test-eo.portalsepeda.com/laravel/public/images/event/<?php echo $event->e_poster?>);background-repeat: no-repeat;background-size: cover;height: 300px;background-position: center;color:#fff;border-bottom: 5px solid #da0b45;"><h3>{{$event->nama_event}}</h3></div>
                    <div class="panel-body">
                        @if(!isset($except))
                            Anda sudah terdaftar menjadi peserta event
                        @endif
                        <br><br>
                        <div class="tab">
                        <button class="tablinks active" onclick="openCity(event, 'daftar_peserta')">Daftar Peserta</button>
                        @if(!isset($except))
                        <button class="tablinks" onclick="openCity(event, 'order_marchendise')">AgendagowesMu</button>
                        @if($pesertaTiket != null)
                            @if($pesertaTiket->is_free == 'tidak')
                                @if(date('Y-m-d') <= $tanggalDaftar->tanggal_bayar)
                                <button class="tablinks" onclick="openCity(event, 'upload_pembayaran')">Upload Pembayaran</button>
                                @endif
                            @endif
                        @endif
                        <!--<button class="tablinks" onclick="openCity(event, 'kontak')">Kontak</button>-->
                        @endif
                        </div>

                        <div id="daftar_peserta" class="tabcontent" style="display: block;">
                        <h3>Daftar Peserta</h3>
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Registrasi</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($listPeserta) > 0)
                                    @foreach($listPeserta AS $k => $v)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$v->created_at}}</td>
                                            <td>{{strtolower($v->display_name)}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        </div>

                        @if(!isset($except))
                        <div id="order_marchendise" class="tabcontent">
                        {{-- <h3>Order Marchendise</h3> --}}
                        <h3>AgendagowesMu</h3>
                        @if($pesertaTiket->is_free == 'tidak' && $dataByr != null) 
                        
                        <div class="container" style="width:100% !important; background-color:#fdfdfd;">
                            <div class="col-md-4" style="margin-top:15px;background-image:url(https://test-eo.portalsepeda.com/laravel/public/images/event/<?php echo $event->e_poster?>);background-repeat: no-repeat;background-size: cover;height: 200px;">
                            </div>
                            <div class="col-md-8">
                                <h4 style="color:#da0b45;"><b>Event yang di ikuti</b></h4>
                                <h3><b>{{$event->nama_event}}</b></h3>
                                <h4 style="color:#da0b45;">Waktu Pelaksanaan:</h4>
                                <h3><b>{{date('D, d M Y', strtotime($event->tanggal_mulai))}}</b></h3>
                                <h3><b>{{date('H.i', strtotime($event->tanggal_mulai))}} WIB</b></h3>
                            </div>
                            <div class="col-md-12" style="border-bottom:3px solid #f5f5f5; margin:10px 0 10px 0;"></div>
                            <div class="col-md-4">
                                <h4>Pembayaran</h4>
                            </div>
                            <div class="col-md-8">
                                <span style="background-color:{{$dataByr->jumlah_approval == 0 ? '#fff' : '#da0b45' }};color:{{$dataByr->jumlah_approval == 0 ? '#646464' : '#fff' }};padding:5px;margin-bottom:5px;border-radius:10px">Berhasil - {{$dataByr->jumlah_approval == 0 ? 'Menunggu disetujui' : 'Telah disetujui' }}</span>
                                <h5 style="color:#da0b45;"><b>Jumlah : Rp. {{number_format($dataByr->jumlah,0,".",".")}}</b></h5>
                            </div>
                            <div class="col-md-12" style="border-bottom:3px solid #f5f5f5; margin:10px 0 10px 0;"></div>
                            <h3 style="color:#da0b45;text-align:center;">Anda terdaftar sebagai peserta</h3>
                            <h5 style="text-align:center;">Check your email <span style="color:#da0b45;">{{$email->user_email}}</span></h5>
                            <div class="col-md-12" style="border-bottom:3px dashed #f5f5f5; margin:10px 0 10px 0;"></div>
                            <div class="col-md-12" style="text-align:center;">
                                <h2>Nomor Peserta</h2>
                                <h1><strong>#{{$pesertaTiket->no_unik}}</strong></h1>
                            </div>
                            <div class="col-md-6" style="text-align:center;">
                                <h5>Model Jersey</h5>
                                <h4><strong>{{$pesertaTiket->model_jersey}}</strong></h4>
                            </div>
                            <div class="col-md-6" style="text-align:center;">
                                <h5>Ukuran Jersey</h5>
                                <h4><strong>{{$pesertaTiket->size_jersey}}</strong></h4>
                            </div>
                            <div class="col-md-12" style="text-align:center;">
                                <p>Cetak Agendamu</p>
                            </div>
                        </div>
                        @elseif($dataByr == '' && $pesertaTiket->is_free == 'ya')
                        <div class="container" style="width:100% !important; background-color:#fdfdfd;">
                            <div class="col-md-4" style="margin-top:15px;background-image:url(https://test-eo.portalsepeda.com/laravel/public/images/event/<?php echo $event->e_poster?>);background-repeat: no-repeat;background-size: cover;height: 200px;">
                            </div>
                            <div class="col-md-8">
                                <h4 style="color:#da0b45;"><b>Event yang di ikuti</b></h4>
                                <h3><b>{{$event->nama_event}}</b></h3>
                                <h4 style="color:#da0b45;">Waktu Pelaksanaan:</h4>
                                <h3><b>{{date('D, d M Y', strtotime($event->tanggal_mulai))}}</b></h3>
                                <h3><b>{{date('H.i', strtotime($event->tanggal_mulai))}} WIB</b></h3>
                            </div>
                            <div class="col-md-12" style="border-bottom:3px solid #f5f5f5; margin:10px 0 10px 0;"></div>
                            <div class="col-md-4">
                                <h4>Pembayaran</h4>
                            </div>
                            <div class="col-md-8">
                                <span style="background-color:#da0b45;color:#fff;padding:5px;margin-bottom:5px;border-radius:10px">Berhasil - Telah disetujui</span>
                                <h5 style="color:#da0b45;"><b>Jumlah : Gratis</b></h5>
                            </div>
                            <div class="col-md-12" style="border-bottom:3px solid #f5f5f5; margin:10px 0 10px 0;"></div>
                            <h3 style="color:#da0b45;text-align:center;">Anda terdaftar sebagai peserta</h3>
                            <h5 style="text-align:center;">Check your email <span style="color:#da0b45;">{{$email->user_email}}</span></h5>
                            <div class="col-md-12" style="border-bottom:3px dashed #f5f5f5; margin:10px 0 10px 0;"></div>
                            <div class="col-md-12" style="text-align:center;">
                                <h2>Nomor Peserta</h2>
                                <h1><strong>#{{$cekMember->no_unik}}</strong></h1>
                            </div>
                            <div class="col-md-6" style="text-align:center;">
                                <h5>Model Jersey</h5>
                                <h4><strong>{{$cekMember->model_jersey}}</strong></h4>
                            </div>
                            <div class="col-md-6" style="text-align:center;">
                                <h5>Ukuran Jersey</h5>
                                <h4><strong>{{$cekMember->size_jersey}}</strong></h4>
                            </div>
                            <div class="col-md-12" style="text-align:center;">
                                <p>Cetak Agendamu</p>
                            </div>
                        </div>
                        @else
                        <h3 style="text-align:center;">Belum ada AgendagowesMu</h3>
                        <?php print_r($dataByr);?>
                        @endif
                        {{-- <p>Under Development</p>  --}}
                        </div>

                        <div id="upload_pembayaran" class="tabcontent">
                        <h3>Upload Pembayaran</h3>
                        <div class="row">
                            @if($dataByr == null)
                                @if($cekMember->konfirmasi == null)
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            Silahkan buka email dan konfirmasi pendaftaran terlebih dahulu untuk melihat step selanjutnya
                                        </div>
                                    </div>
                                @else
                                    @if ($tanggalDaftar == null)
                                        <div class="col-md-12">
                                            <div class="alert alert-danger">
                                                Event yang anda ikuti tidak memungut biaya apapun.
                                            </div>
                                        </div>
                                    @else
                                    {{-- <form action="" method="post" enctype="multipart/form-data"> --}}
                                    <form class="form-peserta" action="{{ route('event.bukti-bayar', ["kode_event" => $kode_event, "id_peserta" => $id_peserta ]) }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bukti">Bukti Transfer:</label>
                                                <input type="file" id="imgInp" class="form-control" id="bukti" placeholder="Masukkan tempat event" name="bukti">
                                                @if ($errors->has('bukti'))
                                                    <span class="help-block text-red">
                                                        <strong>{{ $errors->first('bukti') }}</strong>
                                                    </span>
                                                @endif
                                                <img id="blah" src="https://www.intanonline.com/not-found.png" alt="your image" style="margin-top: 10px; width: 380px;padding-left: 1px;height: auto;"/>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                <label for="bank">Nama Bank:</label>
                                                <select class="form-control" name="bank">
                                                <option disabled selected>-pilih bank-</option>
                                                @foreach($bank AS $k => $v)
                                                    <option value="{{$v->nama_bank}}">{{$v->nama_bank}}</option>
                                                @endforeach
                                                </select>
                                                @if($errors->has('bank'))
                                                <div class="text-danger">
                                                    {{ $errors->first('bank')}}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label for="atas_nama">A/N Rekening:</label>
                                                <input required type="text" class="form-control" name="atas_nama" id="atas_nama" value="" placeholder="atas nama">
                                                <span class="fa fa-user form-control-feedback"></span> @if($errors->has('atas_nama'))
                                                <div class="text-danger">
                                                    {{ $errors->first('atas_nama')}}
                                                </div>
                                                @endif
                                            </div>
                                            {{-- <div class="form-group has-feedback">
                                                <label for="nama">Jumlah:</label>
                                                <input required type="text" class="form-control" name="nama" id="nama" value="" placeholder="nama">
                                                <span class="fa fa-dollars form-control-feedback"></span> @if($errors->has('nama'))
                                                <div class="text-danger">
                                                    {{ $errors->first('nama')}}
                                                </div>
                                                @endif
                                            </div> --}}
                                            <div class="form-group has-feedback pull-right">
                                                <button style="background-color: #da0b45;border-color: #da0b45;" type="submit" name="konfirmasi" class="btn btn-primary">Konfirmasi</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                @endif
                            </div>
                            @else
                            <div class="container" style="width: 99%;">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tableBayar">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Bank</th>
                                                <th>Atas Nama</th>
                                                <th>Jumlah</th>
                                                <th>Bukti</th>
                                                <th>Status Approval</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @if($dataByr->status_approval == '0')
                                                    @php
                                                    $status_approval = 'menunggu';   
                                                    @endphp
                                                
                                                @elseif($dataByr->status_approval == '1')
                                                    @php
                                                    $status_approval = 'disetujui';   
                                                    @endphp
                                                
                                                @elseif($dataByr->status_approval == '2')
                                                    @php
                                                    $status_approval = 'ditolak';   
                                                    @endphp
                                                
                                                @endif
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{$dataByr->created_at}}</td>
                                                    <td>{{$dataByr->bank}}</td>
                                                    <td>{{$dataByr->atas_nama}}</td>
                                                    <td>Rp.{{number_format($dataByr->jumlah, 0, ',', '.')}},-</td>
                                                    <td> <a target="_blank" href="{{asset('images/member/bukti/'.$dataByr->bukti)}}">{{substr($dataByr->bukti, 0, 10)}}...</a></td>
                                                    <td><span style="background: {{$dataByr->status_approval == '1' ? 'green' : 'red'}}; padding:3px; border-radius:5px;color:#fff;">{{$status_approval}}</span></td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div id="kontak" class="tabcontent">
                            <h3>Under Development</h3>
                        </div>
                        @endif
                    </div>
                    <!--/.panel-body-->
                </div>
                <!--/.panel-panel-default-->
            </div>
            <!--/col-md-12-->
    </div>

    {{--
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> --}}

    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
    <script>
        $('.form-peserta').on('submit', function(){
            $('#cover-spin').show();
        });
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "flow-root";
            evt.currentTarget.className += " active";
        }

        //list peserta
        var oTable = $('#datatable').DataTable({});
        var oTable = $('#tableBayar').DataTable({});

        //upload bukti pembayaran
        function readURL(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
        readURL(this);
        });
    </script>
</body>

</html>