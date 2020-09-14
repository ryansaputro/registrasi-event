<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Data Anggota Koperasi Tirta Karya">
    <meta name="NCI" content="ORZDev">

    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}">
	<title>Data Simpanan Sukarela - Print</title>
	<!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
	<!-- Custom styles for this template -->
    <!-- <link href="{{ asset('assets/css/navbar-fixed-top.css') }}" rel="stylesheet"> -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"> -->

    <!-- Custom styles for laravel -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="panel-header">
	<ul class="nav nav-tabs" >
		<li class="active"><a href="#"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
		<li id="print"><a><i class="fa fa-print" aria-hidden="true"></i> Print</a></li>	
	</ul>
</div>
<br>
<div class="container">
	<div class="row header_tab">
		<table class="kop" width="100%" style="margin-bottom:20px;">
			<tr>
				<td rowspan="3" width="120px"><img src="{{ asset('assets/img/logokoperasi.png')}}" style="width:130px;height:100px;" alt=""></td>
				<td><b>"KOPERASI TIRTA KARYA"</b></td>
			</tr>
			<tr>
				<td><b>Koperasi Karyawan PDAM Tirta Wening Kota Bandung</b></td>
			</tr>
			<tr>
				<td style="font-size:9pt;"><b>Jl. Badak Singa No.10 Bandung Telp.022-2536279 Fax.022-2536279</b></td>
			</tr>
		</table>
		<table class="title" width="100%" style="margin-bottom:20px;">
			<tr>
				<td colspan="2" style="text-align:center;"><b>SIMPANAN SUKARELA</b></td>
			</tr>
		</table>	
	</div>
	<div>
		<table class="table table-bordered" width="100%">
			<thead>
				<th style="text-align:center;">No Simpanan</th>
				<th style="text-align:center;">NIK</th>
				<th style="text-align:center;">Jumlah Simpan</th>
				<th style="text-align:center;">Tgl Simpan</th>
				<th style="text-align:center;">Status Simpan</th>
			</thead>
			<tbody>
				@foreach ($get as $key => $value)
				<tr>
					<td class="text-center">{{ $value->no_simpanan_sukarela }}</td>
					<td>{{ $value->nik }}</td>
					<td style="text-align:right;">Rp.{{ number_format($value->jumlah_simpan, 0, ",", ".") }},-</td>
					<td>{{ $value->tgl_transaksi }}</td>
                    @if($value->is_simpan == "1")
					<td class="text-center">Berhasil</td>
                    @endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/jQuery.print.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>

<script>
	// $(document).ready(function(){
	// 	$('#print').trigger('click');
	// });
	// Disini Fungsi Jquery Print
	$(function(){
		$('#print').on('click', function() {
			//Print ele2 with default options
			$.print(".container");
		});
	});
</script>
</body>
</html>