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
        }
    </style>
</head>
<body>
    <div class="container" style="padding-top:10px;border:2px solid #6464;">
        <div class="col-md-12 header" style="background: url({{asset('assets/img/head.png')}});background-repeat: no-repeat;background-position: center;"></div>
        <!--./header-->
        
        <div class="step_all" style="padding:20px;">
            <p>Terimakasih atas transfer untuk pembayaran event {{strtoupper($data->nama_event)}}, anda resmi mendapatkan nomor peserta {{$regisMember->id}}.</p>
            <p>Status kepesertaan anda dapat dilihat pada <a href="{{URL::to('/event/'.strtolower(str_replace(' ', '-', $data->kode_event)).'/'.md5($id_users['id_member']))}}">{{md5(URL::to('/event/'.str_replace(' ', '-', $data->nama_event).'/'.$id_users['id_member']))}}</a></p>
            
            <p>{{date('d F Y')}}</p>

            {{strtoupper($data->nama_event)}}
        </div>
        <!--/.step_all-->
        <div class="col-md-12 footer" style="background: url({{asset('assets/img/foot.png')}});background-repeat: no-repeat;background-position: center;"></div>
        <!--/.footer-->

</body>

</html>