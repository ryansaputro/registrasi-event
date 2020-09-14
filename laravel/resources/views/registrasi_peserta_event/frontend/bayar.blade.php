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
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
    <style>
        html,body{
            font-family: 'Lato', Helvetica, sans-serif
        }
        @media only screen and (max-width: 320px){
            .footer{
                 background-size:100% 100px !important;
                 height: 160px;
            }
            .header{
                 background-size:100% 100px !important;
                 height: 160px;
            }

            .step_all{
                padding:20px;
                margin-top:0%;
            }
        }
        @media only screen and (max-width: 768px){
            .footer{
                 background-size:100% 100px !important;
                 height: 160px;
            }
            .header{
                 background-size:100% 100px !important;
                 height: 160px;
            }

            .step_all{
                padding:20px;
                margin-top:0%;
            }
        }
        @media only screen and (min-width: 769px){
            .footer{
                 background-size:100% auto !important;
                 height: 300px;
            }
            .header{
                 background-size:100% auto !important;
                 height: 300px;
            }

            .step_1{
                margin-top: 30%;
            }

            .step_all{
                padding:20px;
                margin-top:29%;
            }
        }
    </style>
</head>

<body>

    <div class="container" style="padding-top:10px;border:2px solid #6464;">
        <div class="col-md-12 header" style="background: url({{asset('assets/img/head.png')}});background-repeat: no-repeat;background-position: center;">
        </div>
        <div class="step_all" style="padding:20px;">
            <p>Verifikasi pendaftaran telah berhasil dilakukan.</p>
            <p>Terimakasih anda telah melakukan pendaftaran dan verifikasi, untuk selanjutnya sila lakukan pembayaran dengan melakukan transfer pembayaran ke no rekening <b>{{$eo->no_rekening}}</b> Bank <b>{{$eo->nama_bank}}</b> an <b>{{$eo->pemilik_rekening}}</b>.</p>
            <p>Jika telah melakukan pembayaran, bukti transfer/pembayaran tolong diupload melalui halaman <a href="{{URL::to('/event/'.str_replace(' ', '-', strtolower($eo->kode_event)).'/'.md5($id_users->ID))}}">{{md5(URL::to('/event/'.str_replace(' ', '-', $eo->kode_event).'/'.$eo->id_member))}}</a> atau mengirimkan bukti ke no WA {{$eo->no_wa_kontak}} an {{$eo->nama}}</p>
            {{-- <h4 class="step_1"><label style="background:green;color:#fff;background: green;color: #fff;padding: 20px;border-radius: 20px;">1</label>Konfirmasi telah berhasil</h4>
                <h4 class="step_2"><label style="background:green;color:#fff;background: #999;color: #fff;padding: 20px;border-radius: 20px;">2</label>Biaya pembayaran event Rp.{{number_format($isFreeActive->harga, 0, '.', ',')}},-</h4>
                <h4 class="step_3"><label style="background:green;color:#fff;background: #999;color: #fff;padding: 20px;border-radius: 20px;">3</label>Silahkan melakukan pembayaran di Bank <b>{{$eo->nama_bank}}</b> nomor rekening <b>{{$eo->no_rekening}}</b> atas nama <b>{{$eo->pemilik_rekening}}</b></h4> --}}
        </div>
        <div class="col-md-12 footer" style="background: url({{asset('assets/img/foot.png')}});background-repeat: no-repeat;background-position: center;">
    </div>

</body>

</html>