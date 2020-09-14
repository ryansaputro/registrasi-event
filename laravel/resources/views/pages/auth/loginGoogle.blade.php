<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ryan Saputro">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="portal sepeda, event, registrasi event, agenda gowes" />
	<link rel="icon" type="image/png" href="https://portalsepeda.com/wp-content/uploads/2019/03/cropped-Capture-2-2.png">
    <title>Event Organizer | Portalsepeda</title>
    <style>
        .row{
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

        @media only screen and (max-width: 600px) {
            .row{
                margin-right: 0px !important;
                margin-left: 0px !important;
            }
            .back{
                width: 100%;
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                height: 100vh;
            }

            .title{
                margin-top: 40%;
                color: #fff;
                position: absolute;
                text-align: center;
                margin-left: 10%;
                font-size: 32px;
                font-weight: 600;
            }
            
            .title-right{
                color: #fff;
                position: absolute;
                text-align: center;
                margin-top: 95%;
                margin-left: 27%;
                font-size: 20px;
                font-weight: 600;
            }
            
            .desc{
                color: #fff;
                position: absolute;
                text-align: center;
                margin-top: 55%;
                padding-left: 13%;
                font-size: 14px;
                padding-right: 15%;
            }
            
            .btn-google{
                background: white;
                padding: 10px !important;
                width: 300px !important;
                font-size: 14px !important;
                color: #999 !important;
                position: absolute !important;
                margin-top: 103% !important;
                margin-left: 0% !important;
                font-weight: 600 !important;
            }

            .google{
                height: 5vw;
            }

                    .header{
            color:#d91d48;
            padding:15px;
        }

        .footer{
            color: #fff;
            padding: 38px 15px 15px 0px;
            margin-top: 140%;
            text-align: center;
        }

        }
        
        @media only screen and (min-width: 768px) {
            .back{
                background-size:cover;
                background-repeat:no-repeat;
                background-position: bottom;
                width:100% !important;
                position:absolute;
                height: 100%;
                background-position: center;
            }
            
            .desktop{
                border-right: 5px solid #f3eaea54;
                height:75%;
                margin-top: 7%;
            }
            
            .title{
                color: #fff;
                position: absolute;
                text-align: center;
                margin-top: 10%;
                margin-left: 20%;
                font-size:45px;
                font-weight:600;
            }
            
            .title-right{
                color: #fff;
                position: absolute;
                text-align: center;
                margin-top: 25%;
                margin-left: 35%;
                font-size: 25px;
                font-weight: 600;
            }
            
            .desc{
                color: #fff;
                position: absolute;
                text-align: center;
                margin-top: 20%;
                padding-left: 20%;
                font-size: 18px;
                padding-right: 15%;
            }
            
            .btn-google{
                background: white;
                padding: 10px !important;
                width: 320px !important;
                font-size: 20px !important;
                color: #999 !important;
                position: absolute !important;
                margin-top: 35% !important;
                margin-left: 22% !important;
                font-weight: 600 !important;
            }

            .kotak{
                margin-top: 90px;
                height: 60%;
                box-shadow: 500px 310px 100px 180px #7170705c;
            }
            .google{
                height: 2vw;
            }

                    .header{
            color:#d91d48;
            padding:15px;
        }

        .footer{
            color: #fff;
            padding: 38px 15px 15px 0px;
            margin-top: -13px;
            text-align: center;
        }

        }
        @media only screen and (min-width: 1440px) {
           .back{
                background-size:cover;
                background-repeat:no-repeat;
                background-position: bottom;
                width:100% !important;
                position:absolute;
                height: 100%;
                background-position: center;
            }
            
            .desktop{
                border-right: 5px solid #f3eaea54;
                height:75%;
                margin-top: 7%;
            }
            
            .title{
                color: #fff;
                position: absolute;
                text-align: center;
                margin-top: 25%;
                margin-left: 20%;
                font-size:45px;
                font-weight:600;
            }
            
            .title-right{
                color: #fff;
                position: absolute;
                text-align: center;
                margin-top: 40%;
                margin-left: 35%;
                font-size: 25px;
                font-weight: 600;
            }
            
            .desc{
                color: #fff;
                position: absolute;
                text-align: center;
                margin-top: 35%;
                padding-left: 20%;
                font-size: 18px;
                padding-right: 15%;
            }
            
            .btn-google{
                background: white;
                padding: 10px !important;
                width: 320px !important;
                font-size: 20px !important;
                color: #999 !important;
                position: absolute !important;
                margin-top: 50% !important;
                margin-left: 22% !important;
                font-weight: 600 !important;
            }

            .kotak{
                margin-top: 90px;
                height: 80%;
                box-shadow: 500px 310px 100px 180px #7170705c;
            }
            .google{
                height: 2vw;
            }

                    .header{
            color:#d91d48;
            padding:15px;
        }

        .footer{
            color: #fff;
            padding: 38px 15px 15px 0px;
            margin-top: -13px;
            text-align: center;
        }

        }
        
        
        
    </style>
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="row back" style="width:100%;background-image:url(https://eo.portalsepeda.com/laravel/public/images/background/background.jpg);">
        <div class="col-md-12">
            <h3 class="header"><strong>Event Organizer</strong></h3>
        </div>
        <div class="col-md-10 col-md-offset-1 kotak">
            <div class="col-md-6 desktop">
                <h1 class="title">Selamat Datang</h1>
                <p class="desc">Bergabung bersama kami untuk mengatur dan membuat event sepeda anda</p>
            </div>
            <div class="col-md-6">
                <h1 class="title-right">Login / Sign in</h1>
                <a href="{{ route('login.provider', 'google') }}" class="btn btn-google"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/588px-Google_%22G%22_Logo.svg.png" class="google" style="padding-right: 40px;">Sign in With Google</a>
            </div>
        </div>
        <div class="col-md-12">
            <h3 class="footer">from <strong>portal</strong><strong style="color:#d91d48;">sepeda</strong></h3>
        </div>
    </div>
</body>
</html>