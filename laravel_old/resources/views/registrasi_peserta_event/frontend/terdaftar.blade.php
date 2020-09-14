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
    {{-- <h1 class="text-center"><b style="color:#011e3d;text-transform:uppercase;">{{$nama}}</b></h1>
    <p class="text-center" style="text-transform:uppercase;">{{$event->deskripsi_event}}</p> --}}
    <div class="container" style="padding-top:10px;">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #011e3d;color:#fff;border-bottom: 5px solid #da0b45;"><h3>Portal Sepeda</h3></div>
                    <div class="panel-body">
                        Anda sudah terdaftar menjadi peserta event
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