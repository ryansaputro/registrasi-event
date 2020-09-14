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
	<title>Data User - Print</title>
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
				<th style="text-align:center;">ID</th>
				<th style="text-align:center;">NIK</th>
				<th style="text-align:center;">No KTP</th>
				<th style="text-align:center;">Nama</th>
				<th style="text-align:center;">Jabatan</th>
				<th style="text-align:center;">Divisi</th>
				<th style="text-align:center;">Alamat</th>
				<th style="text-align:center;">No TLP</th>
				<th style="text-align:center;">TTL</th>
				<th style="text-align:center;">Jenis Kelamin</th>
				<th style="text-align:center;">Status Marital</th>
				<th style="text-align:center;">Email</th>
				<th style="text-align:center;">Status Anggota</th>
			</thead>
			<tbody>
				@foreach ($get as $key => $value)
				<tr>
					<td style="text-align:center;">{{ $value->id_anggota }}</td>
					<td>{{ $value->nik }}</td>
					<td>{{ $value->no_ktp }}</td>
					<td>{{ $value->full_name }}</td>
					<td>{{ $value->nama_jabatan }}</td>
					<td>{{ $value->nama_divisi }}</td>
					<td>{{ $value->alamat }} {{ $value->kodepos }}</td>
					<td>{{ $value->notelp }}</td>
					<td>{{ $value->tempat_lahir }} {{ $value->tgl_lahir }}</td>
					<td>{{ $value->jenis_kelamin }}</td>
					<td>{{ $value->status_marital }}</td>
					<td>{{ $value->email }}</td>
					<td>{{ $value->nama_status_aktif }}</td>
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
	// Disini Fungsi Jquery Print
	$(function(){
		$('#print').on('click', function() {
			//Print with default options
			$.print(".container");
		});
	});
</script>
</body>
</html>