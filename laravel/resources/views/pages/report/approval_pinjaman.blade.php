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
	<title>Data Approval Pinjaman - Print</title>
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
				<td colspan="2" style="text-align:center;"><b>APPROVAL PINJAMAN</b></td>
			</tr>
		</table>	
	</div>
	<div>
		<table class="table table-bordered" width="100%">
			<thead>
				<th style="text-align:center;">No Pinjaman</th>
				<th style="text-align:center;">NIK</th>
                <th style="text-align:center;">Jenis Pinjaman</th>
                <th style="text-align:center;">Jenis Angsuran</th>
                <th style="text-align:center;">Jml Pinjaman</th>
				<th style="text-align:center;">Tenor</th>
                <th style="text-align:center;">Bunga</th>
				<th style="text-align:center;">Pokok</th>
                <th style="text-align:center;">Jasa</th>
                <th style="text-align:center;">Sisa Pinjaman</th>
                <th style="text-align:center;">Biaya ADM</th>
                <th style="text-align:center;">Biaya CPPU</th>
                <th style="text-align:center;width:150px;">Tgl Pencairan</th>
                <th style="text-align:center;">Status Lunas</th>
			</thead>
			<tbody>
				@foreach ($get as $key => $value)
				<tr>
					<td class="text-center">{{ $value->no_pinjaman }}</td>
                    <td class="text-center">{{ $value->nik }}</td>
                    <td class="text-center">{{ $value->nama_pinjaman }}</td>
					<td class="text-center">{{ $value->jenis_angsuran }}</td>
                    <td style="text-align:right;">Rp.{{ number_format($value->jumlah_pinjaman, 0, ",", ".") }},-</td>
                    <td class="text-center">{{ $value->tenor_pinjaman }} X</td>
                    <td class="text-center">{{$value->persentase_bunga}} %</td>
                    <td style="text-align:right;">Rp.{{ number_format($value->pokok, 0, ",", ".") }},-</td>
                    <td style="text-align:right;">Rp.{{ number_format($value->jasa, 0, ",", ".") }},-</td>
                    <td style="text-align:right;">Rp.{{ number_format($value->saldo_hutang, 0, ",", ".") }},-</td>
                    <td style="text-align:right;">Rp.{{ number_format($value->biaya_adm, 0, ",", ".") }},-</td>
                    <td style="text-align:right;">Rp.{{ number_format($value->biaya_cppu, 0, ",", ".") }},-</td>
                    <td class="text-center">{{ $value->tgl_pencairan }}</td>
                    @if($value->status_lunas == "1")
                        <td class="text-center">Lunas</td>
                    @else
                        <td class="text-center">Belum Lunas</td>
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