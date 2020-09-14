<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/iCheck/square/blue.css') }}">
	<!------ Include the above in your HEAD tag ---------->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="pendaftaran eo">
	<meta name="author" content="Ryan Saputro">{{-- CSRF TOKEN --}}
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" type="image/png" href="https://portalsepeda.com/wp-content/uploads/2019/03/cropped-Capture-2-2.png">
	<title>Registrasi Event Organizer | Portal Sepeda</title>
	<link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<style>
		.form-group{
		        text-align: left;
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
		        
		        .error{
		            color:red;
		        }
	</style>
</head>

<body>
	<?php $id_provinsi='xxx' ;?>
	<?php $id_provinsi_eo='xxx' ;?>
	<?php $id_kota='xxx' ;?>
	<?php $id_kota_eo='xxx' ;?>
	
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>@endforeach</ul>
	</div>
    	@if(old('provinsi') !='')
    	    <?php $id_provinsi=old('provinsi');?>
    	@else
    	    <?php $id_provinsi='xxx' ;?>
    	@endif 
    	
    	@if(old('provinsi_eo') !='')
    	    <?php $id_provinsi_eo=old('provinsi_eo');?>
    	@else
    	    <?php $id_provinsi_eo='xxx' ;?>
    	@endif 
    	
    	@if(old('kota') !='')
    	    <?php $id_kota=old('kota');?>
    	@else
    	    <?php $id_kota='xxx' ;?>
    	@endif 
    	
    	@if(old('kota_eo') !='')
    	    <?php $id_kota_eo=old('kota_eo');?>
    	@else
    	<?php $id_kota_eo='xxx' ;?>
    	@endif
	@endif
	@php
	    $date = date('Y-m-d',  strtotime(' -20 years'));
	@endphp
	<div id="ajaxError">
	    
	</div>
	<div id="cover-spin"></div>
	<h1 class="text-center"><b style="color:#da0b45;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">Event</b> <b style="color:#fff;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">Organizer</b></h1>
	<?php $tahun=substr($profil['tanggal_lahir'],0,4); $bulan=substr($profil['tanggal_lahir'],4,2); $tanggal=substr($profil['tanggal_lahir'],6,2); $tgl=$tahun. "-".$bulan. "-".$tanggal; ?>
	<div class="container" style="padding-top:10px;">
		<div class="row form-group">
			<div class="col-xs-12">
				<ul class="nav nav-pills nav-justified thumbnail setup-panel">
					<li class="active">
						<a href="#step-1">
							<h4 class="list-group-item-heading">Data Diri</h4>
							<p class="list-group-item-text">Lengkapi Data Diri Anda</p>
						</a>
					</li>
					<li class="disabled">
						<a href="#step-2">
							<h4 class="list-group-item-heading">Data Event Organizer</h4>
							<p class="list-group-item-text">Lengkapi Data Event Organizer Anda</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<?php //print_r($profil);?>
		<form action="javascript:void(0)" method="post" enctype="multipart/form-data" novalidate class="form-peserta">{{ csrf_field() }}
			<div class="row setup-content" id="step-1">
				<div class="col-xs-12">
					<div class="col-md-12 well text-center">
						<div class="register-box-body">{{--
							<p class="login-box-msg">Profil</p>--}}
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group has-feedback">
										<label for="nama">Nama:</label>
										<input required type="text" class="form-control" name="nama" id="nama" value="{{ Auth::user()->toArray()['display_name'] }}" placeholder="nama"> <span class="fa fa-user form-control-feedback"></span>
										@if($errors->has('nama'))
										<div class="text-danger">{{ $errors->first('nama')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="panggilan">Panggilan:</label>
										<input required type="text" class="form-control" name="panggilan" id="panggilan" value="{{ !empty(old('panggilan')) ?  old('panggilan') : isset($profil['panggilan']) ? $profil['panggilan'] : ''  }}" placeholder="panggilan"> <span class="fa fa-user form-control-feedback"></span>
										@if($errors->has('panggilan'))
										<div class="text-danger">{{ $errors->first('panggilan')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="jenis_kelamin">Jenis Kelamin:</label>
										<div class="radio text-left">
											<label>
												<input type="radio" name="jenis_kelamin" value="Laki-Laki" {{ old('jenis_kelamin') =='Laki-Laki' ?'checked' :'' }} {{isset($profil['jenis_kelamin']) ? $profil['jenis_kelamin'] =='Laki-Laki' ? 'checked' :'' : ''}}>Laki-laki</label>
										</div>
										<div class="radio text-left">
											<label>
												<input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') =='Perempuan' ?'checked' :'' }} {{isset($profil['jenis_kelamin']) ? $profil['jenis_kelamin'] =='Perempuan' ? 'checked' :'' : ''}}>Perempuan</label>
										</div>@if($errors->has('jenis_kelamin'))
										<div class="text-danger">{{ $errors->first('jenis_kelamin')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="tempat_lahir">Tempat Lahir:</label>
										<input required type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ isset($profil['tempat_lahir']) ? $profil['tempat_lahir'] : old('tempat_lahir') }}" placeholder="tempat lahir"> <span class="fa fa-map-marker form-control-feedback"></span>
										@if($errors->has('tempat_lahir'))
										<div class="text-danger">{{ $errors->first('tempat_lahir')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="tanggal_lahir">Tanggal Lahir:</label>
										<input required type="date" class="form-control" max="{{$date}}" name="tanggal_lahir" id="tanggal_lahir" value="{{ isset($profil['tanggal_lahir']) ? $profil['tanggal_lahir'] : old('tanggal_lahir') }}"  placeholder="tanggal lahir"> <span class="fa fa-calendar-o form-control-feedback"></span>
										@if($errors->has('tanggal_lahir'))
										<div class="text-danger">{{ $errors->first('tanggal_lahir')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="golongan_darah">Golongan Darah:</label>
										<div class="radio text-left">
											<label>
												<input type="radio" name="golongan_darah" value="A" {{ old('golongan_darah')=='A' ?'checked' :'' }} {{isset($profil['golongan_darah']) && $profil['golongan_darah']=='A' ?'checked' :''}}>A</label>
										</div>
										<div class="radio text-left">
											<label>
												<input type="radio" name="golongan_darah" value="B" {{ old('golongan_darah')=='B' ?'checked' :'' }} {{isset($profil['golongan_darah']) && $profil['golongan_darah']=='B' ?'checked' :''}}>B</label>
										</div>
										<div class="radio text-left">
											<label>
												<input type="radio" name="golongan_darah" value="O" {{ old('golongan_darah')=='O' ?'checked' :'' }} {{isset($profil['golongan_darah']) && $profil['golongan_darah']=='O' ?'checked' :''}}>O</label>
										</div>
										<div class="radio text-left">
											<label>
												<input type="radio" name="golongan_darah" value="AB" {{ old('golongan_darah')=='AB' ?'checked' :'' }} {{isset($profil['golongan_darah']) && $profil['golongan_darah']=='AB' ?'checked' :''}}>AB</label>
										</div>@if($errors->has('golongan_darah'))
										<div class="text-danger">{{ $errors->first('golongan_darah')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="pekerjaan">Pekerjaan:</label>
										<input required type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="{{ !empty(old('pekerjaan')) ?  old('pekerjaan') : isset($profil['pekerjaan']) ? $profil['pekerjaan'] : ''  }}" placeholder="pekerjaan"> <span class="fa fa-laptop form-control-feedback"></span>
										@if($errors->has('pekerjaan'))
										<div class="text-danger">{{ $errors->first('pekerjaan')}}</div>@endif</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group has-feedback">
										<label for="provinsi">Provinsi:</label>
										<select required class="form-control" name="provinsi" id="provinsi" value="{{ old('provinsi') }}">
											<option selected disabled>-pilih provinsi-</option>
											@foreach ($provinsi as $k => $v)
											    <option value="{{$v['id']}}" {{ old('provinsi')==$v['id'] ?'selected' :'' }} {{isset($profil['provinsi']) && ($profil['provinsi'])==$v['id'] ?'selected' :''}}>{{$v['nama']}}</option>
											@endforeach</select>
											@if($errors->has('provinsi'))
										<div class="text-danger">{{ $errors->first('provinsi')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="kota">Kota:</label>
										<select required class="form-control" name="kota" id="kota" value="{{ old('kota') }}">
											<option selected disabled>-pilih kota-</option>
											@if ($kota != null) 
											    @foreach ($kota as $k => $v)
											        <option value="{{$v['id']}}" {{isset($profil['kota']) && ($profil['kota'])==$v['id'] ?'selected' :''}}>{{$v['nama']}}</option>
    											@endforeach 
    										@endif</select>@if($errors->has('kota'))
										<div class="text-danger">{{ $errors->first('kota')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="alamat">Alamat:</label>
										<textarea required class="form-control" value="" name="alamat" id="alamat" value="{{ old('alamat') }}" placeholder="Masukan Alamat Anda">{{isset($profil['alamat']) ? $profil['alamat'] : old('alamat')}}</textarea> <span class="fa fa-address-card form-control-feedback"></span>
										@if($errors->has('alamat'))
										<div class="text-danger">{{ $errors->first('alamat')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="kode_pos">Kode Pos:</label>
										<input required type="text" class="form-control" name="kode_pos" id="kode_pos" minlength="5" maxlength="5" value="{{isset($profil['kode_pos']) ? $profil['kode_pos'] :  old('kode_pos') }}" placeholder="Kode Pos"> <span class="fa fa-address-card form-control-feedback"></span>
										@if($errors->has('kode_pos'))
										<div class="text-danger">{{ $errors->first('kode_pos')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="no_hp_kontak">No Hp Kontak:</label>
										<input required type="text" class="form-control" name="no_hp_kontak" maxlength="15" id="no_hp_kontak" value="{{isset($profil['no_hp_kontak']) ? $profil['no_hp_kontak'] : old('no_hp_kontak')}}" placeholder="No Hp Kontak"> <span class="fa fa-address-book-o form-control-feedback"></span>
										@if($errors->has('no_hp_kontak'))
										<div class="text-danger">{{ $errors->first('no_hp_kontak')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="no_wa_kontak">Whatsapp:</label>
										<input required type="text" class="form-control" name="no_wa_kontak" maxlength="15" id="no_wa_kontak" value="{{isset($profil['no_wa_kontak']) ? $profil['no_wa_kontak'] : old('no_wa_kontak')}}" placeholder="No Whatsapp Kontak"> <span class="fa fa-whatsapp form-control-feedback"></span>
										@if($errors->has('no_wa_kontak'))
										<div class="text-danger">{{ $errors->first('no_wa_kontak')}}</div>@endif</div>
								</div>
								<!-- <div class="form-group has-feedback">
                              <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Retype password">
                              <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            </div> --></div>
							<div class="row">
								<div class="col-md-6" style="float:right;">
									<button id="activate-step-2" class="btn btn-primary btn-block btn-flat">Selanjutnya</button>{{--
									<input class="btn btn-primary btn-block btn-flat" type="submit" value="Register">--}}
									<!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button> -->
								</div>
								<!-- /.col -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row setup-content" id="step-2">
				<div class="col-xs-12">
					<div class="col-md-12 well">
						<div class="register-box-body">
							<p class="login-box-msg">Registrasi Event Organizer Portalsepeda</p>
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="form-group has-feedback">
										<label for="nama">Nama:</label>
										<input required type="text" class="form-control" name="nama_eo" id="nama" value="{{ Auth::user()->toArray()['display_name'] }}" placeholder="Nama anda"> <span class="fa fa-user form-control-feedback"></span>
										@if($errors->has('nama_eo'))
										<div class="text-danger">{{ $errors->first('nama_eo')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="email">E-mail:</label>
										<input required type="email" readonly class="form-control" name="email_eo" id="email" value="{{ Auth::user()->toArray()['user_email']}}" placeholder="Email"> <span class="fa fa-envelope form-control-feedback"></span>
										@if($errors->has('email'))
										<div class="text-danger">{{ $errors->first('email')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="kontak_eo">Kontak:</label>
										<input required type="text" class="form-control" name="kontak_eo" id="kontak" value="{{ old('kontak_eo') }}" placeholder="Kontak"> <span class="fa fa-phone form-control-feedback"></span>
										@if($errors->has('kontak'))
										<div class="text-danger">{{ $errors->first('kontak')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="no_hp_kontak">No Hp Kontak:</label>
										<input required type="text" class="form-control" name="no_hp_kontak_eo" maxlength="15" id="no_hp_kontak" value="{{ old('no_hp_kontak') }}" placeholder="No Hp Kontak"> <span class="fa fa-address-book-o form-control-feedback"></span>
										@if($errors->has('no_hp_kontak'))
										<div class="text-danger">{{ $errors->first('no_hp_kontak')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="no_wa_kontak_eo">Whatsapp:</label>
										<input required type="text" class="form-control" name="no_wa_kontak_eo" maxlength="15" id="no_wa_kontak" value="{{ old('no_wa_kontak') }}" placeholder="No Whatsapp Kontak"> <span class="fa fa-whatsapp form-control-feedback"></span>
										@if($errors->has('no_wa_kontak'))
										<div class="text-danger">{{ $errors->first('no_wa_kontak')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="logo_eo">Logo:</label>
										<input type="file" class="form-control" accept="image/*" name="logo_eo" id="logo_eo" value="{{ old('logo_eo') }}" placeholder="Logo EO"> <span class="fa fa-picture-o form-control-feedback"></span>
										<br>
										<span class="label label-danger">Maksimal ukuran gambar 512kb</span>
										@if($errors->has('logo_eo'))
										<div class="text-danger">{{ $errors->first('logo_eo')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="identitas">Foto KTP/SIM:</label>
										<input type="file" class="form-control" accept="image/*" name="identitas" id="identitas" value="{{ old('identitas') }}"> <span class="fa fa-picture-o form-control-feedback"></span>
										<br>
										<span class="label label-danger">Maksimal ukuran gambar 512kb</span>
										@if($errors->has('identitas'))
										<div class="text-danger">{{ $errors->first('identitas')}}</div>@endif</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="form-group has-feedback">
										<label for="provinsi_eo">Provinsi:</label>
										<select required class="form-control" name="provinsi_eo" id="provinsi_eo" onchange="EoProvinsi(this)" value="{{ old('provinsi_eo') }}">
											<option selected disabled>-pilih provinsi-</option>
											@foreach ($provinsi as $k => $v)
											    <option value="{{$v['id']}}" {{ old('provinsi_eo')==$v['id'] ?'selected' :'' }}>{{$v['nama']}}</option>
											@endforeach</select>@if($errors->has('provinsi'))
										<div class="text-danger">{{ $errors->first('provinsi')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="kotaEo">Kota:</label>
										<select required class="form-control" name="kota_eo" id="kotaEo" value="{{ old('kota_eo') }}">
											<option selected disabled>-pilih kota-</option>
										</select>@if($errors->has('kota_eo'))
										<div class="text-danger">{{ $errors->first('kota_eo')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="alamat">Alamat:</label>
										<textarea required class="form-control" name="alamat_eo" id="alamat" value="" placeholder="Masukan Alamat Anda">{{ old('alamat_eo') }}</textarea> <span class="fa fa-address-card form-control-feedback"></span>
										@if($errors->has('alamat_eo'))
										<div class="text-danger">{{ $errors->first('alamat_eo')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="kode_pos_eo">Kode Pos:</label>
										<input required type="text" class="form-control" name="kode_pos_eo" minlength="5" maxlength="5" id="kode_pos" value="{{ old('kode_pos_eo') }}" placeholder="Kode Pos"> <span class="fa fa-address-card form-control-feedback"></span>
										@if($errors->has('kode_pos'))
										<div class="text-danger">{{ $errors->first('kode_pos')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="alamat_web">Alamat Web:</label>
										<input type="text" class="form-control" name="alamat_web" id="alamat_web" value="{{ old('alamat_web') }}" placeholder="Alamat Web"> <span class="fa fa-globe form-control-feedback"></span>
										@if($errors->has('alamat_web'))
										<div class="text-danger">{{ $errors->first('alamat_web')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="buku_tabungan">Foto Buku Rekening:</label>
										<input type="file" accept="image/*" class="form-control" name="buku_tabungan" id="buku_tabungan" value="{{ old('buku_tabungan') }}" placeholder="Logo EO"> <span class="fa fa-picture-o form-control-feedback"></span>
										<br>
										<span class="label label-danger">Maksimal ukuran gambar 512kb</span>
										@if($errors->has('buku_tabungan'))
										<div class="text-danger">{{ $errors->first('buku_tabungan')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="norek">No Rekening:</label>
										<input required type="text" class="form-control" name="norek" id="norek" value="{{ old('norek') }}" placeholder="No Rekening"> <span class="fa fa-address-book-o form-control-feedback"></span>
										@if($errors->has('norek'))
										<div class="text-danger">{{ $errors->first('norek')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="norek_pemilik">Pemilik Rekening:</label>
										<input required type="text" class="form-control" name="norek_pemilik" id="norek_pemilik" value="{{ old('norek_pemilik') }}" placeholder="Pemilik Rekening"> <span class="fa fa-address-book-o form-control-feedback"></span>
										@if($errors->has('norek_pemilik'))
										<div class="text-danger">{{ $errors->first('norek_pemilik')}}</div>@endif</div>
									<div class="form-group has-feedback">
										<label for="bank">Nama Bank:</label>
										<select class="form-control" name="bank">
											<option disabled selected>-pilih bank-</option>
											<option {{old('bank')=="BCA" ? "selected" : ""}} value="BCA">BCA</option>
											<option {{old('bank')=="BRI" ? "selected" : ""}} value="BRI">BRI</option>
											<option {{old('bank')=="MANDIRI" ? "selected" : ""}} value="MANDIRI">Mandiri</option>
											<option {{old('bank')=="MUAMALAT" ? "selected" : ""}} value="MUAMALAT">Muamalat</option>
											<option {{old('bank')=="PANIN" ? "selected" : ""}} value="PANIN">Panin</option>
											<option {{old('bank')=="BJB" ? "selected" : ""}} value="BJB">BJB</option>
											<option {{old('bank')=="BTN" ? "selected" : ""}} value="BTN">BTN</option>
											<option {{old('bank')=="BANK DKI" ? "selected" : ""}} value="BANK DKI">Bank DKI</option>
											<option {{old('bank')=="BANK JABAR" ? "selected" : ""}} value="BANK JABAR">Bank JABAR</option>
											<option {{old('bank')=="BANK JATIM" ? "selected" : ""}} value="BANK JATIM">Bank JATIM</option>
											<option {{old('bank')=="BANK JATENG" ? "selected" : ""}} value="BANK JATENG">Bank JATENG</option>
										</select> <span class="fa fa-address-book-o form-control-feedback"></span>
										@if($errors->has('bank'))
										<div class="text-danger">{{ $errors->first('bank')}}</div>@endif</div>
								</div>
								<div class="row">
									<div class="col-md-6" style="float:right;">
										<input class="btn btn-primary btn-block btn-flat" id="send_form" type="submit" value="Register">
									</div>
									<!-- /.col -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="footer">
			<p class="text-center">powered by <a href="https://portalsepeda.com"><span style="letter-spacing: 1px;color:#da0b45;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">portal</span><span style="color:#fff;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;letter-spacing: 1px;">sepeda</span></a>
			</p>
		</div>
	</div>
	{{--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>--}}
		<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<!-- iCheck -->
		{{--
		<script src="{{ asset('assets/vendor/iCheck/icheck.min.js') }}"></script>--}} 
		{{--
		<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>--}} 
		{{--
		<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>--}}
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
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
                            // maxDate: Date.parse("{{$date}}")
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
            				maxlength: 12,
            				number: true,
            			},
            			no_wa_kontak: {
            				required: true,
            				number: true,
            			},
            			nama_eo: {
            				required: true,
            			},
            			email_eo: {
            				required: true,
            				maxlength: 50,
            				email: true,
            			},
            			kontak_eo: {
            				required: true,
            			},
            			no_hp_kontak_eo: {
            				required: true,
            				digits: true,
            				minlength: 10,
            				maxlength: 12,
            				number: true,
            			},
            			no_wa_kontak_eo: {
            				required: true,
            				digits: true,
            				minlength: 10,
            				maxlength: 12,
            				number: true,
            			},
            			logo_eo: {
            				required: true,
            			},
            			identitas: {
            				required: true,
            			},
            			provinsi_eo: {
            				required: true,
            			},
            			kota_eo: {
            				required: true,
            			},
            			alamat_eo: {
            				required: true,
            			},
            			kode_pos_eo: {
            				required: true,
            				digits: true,
            				minlength: 5,
            				maxlength: 5,
            				number: true,
            			},
            			buku_tabungan: {
            				required: true,
            			},
            			norek: {
            				required: true,
            				required: true,
            				digits: true,
            				minlength: 10,
            				maxlength: 25,
            				number: true,
            			},
            			norek_pemilik: {
            				required: true,
            			},
            			bank: {
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
            				url:'{{ route('registrasiEO.store') }}',
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
            				        window.location.href = "http://localhost/eo/dashboard";
            				    }
            				}, error : function(response, textStatus, errorThrown){
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
            var prov ='';
            var kota ='';
            var proveo ='';
            var kotaeo ='';
            $('#cover-spin').bind('ajaxStart', function () {
            	$(this).show();
            }).bind('ajaxStop', function () {
            	$(this).hide();
            });
            // $('.form-peserta').on('submit', function () {
            // 	$('#cover-spin').show();
            // });
            $(document).ready(function () {
            	prov = "{{$id_provinsi}}";
            	kota = "{{$id_kota}}";
            	proveo = "{{$id_provinsi_eo}}";
            	kotaeo = "{{$id_kota_eo}}";
            	if (prov !='xxx') {
            		$("#provinsi").trigger('change');
            	}
            	if (proveo !='xxx') {
            		EoProvinsi($('#provinsi_eo'))
            		//   $('#provinsi_eo').trigger('click');
            	}
            })
            $("#provinsi").on('change', function () {
            	kotas = kota;
            	var id = typeof $("#provinsi").find(':selected').val() !='undefined' ? $("#provinsi").find(':selected').val() : prov;
            	var urls = "{{URL::to('/registrasiEO/ajaxKota')}}";
            	$.ajax({
            		url: urls,
            		method: "post",
            		data: {
            			"_token": "{{ csrf_token() }}",
            			"id": id
            		},
            		beforeSend: function () {
            			// Show image container
            			$('#cover-spin').show(0);
            		},
            		success: function (result) {
            			var data = "<option disabled selected>-pilih kota-</option>";
            			$.each(result.getKota, function (k, v) {
            				if (kota == v.id) {
            					data +='<option value="' + v.id +'" selected data-id="' + v.id +'">' + v.nama +'</option>'
            				} else {
            					data +='<option value="' + v.id +'"  data-id="' + v.id +'">' + v.nama +'</option>'
            				}
            			})
            			$("#kota").html(data);
            		},
            		complete: function (data) {
            			// Hide image container
            			$('#cover-spin').hide();
            		}
            	});
            });
            
            function EoProvinsi(a) {
            	var id = typeof $(a).find(':selected').val() !='undefined' ? $(a).find(':selected').val() : proveo;
            	kotaeo = "{{$id_kota_eo}}";
            	var urls = "{{URL::to('/registrasiEO/ajaxKota')}}";
            	$.ajax({
            		url: urls,
            		method: "post",
            		data: {
            			"_token": "{{ csrf_token() }}",
            			"id": id
            		},
            		beforeSend: function () {
            			// Show image container
            			$('#cover-spin').show(0);
            		},
            		success: function (result) {
            			var data = "<option disabled selected>-pilih kota-</option>";
            			$.each(result.getKota, function (k, v) {
            				if (kotaeo == v.id) {
            					data +='<option value="' + v.id +'" selected data-id="' + v.id +'">' + v.nama +'</option>'
            				} else {
            					data +='<option value="' + v.id +'"  data-id="' + v.id +'">' + v.nama +'</option>'
            				}
            			})
            			$("#kotaEo").html(data);
            		},
            		complete: function (data) {
            			// Hide image container
            			$('#cover-spin').hide();
            		}
            	});
            } </script>
            		<script>
            			$(document).ready(function() {
            			    
            			    var navListItems = $('ul.setup-panel li a'),
            			        allWells = $('.setup-content');
            			
            			    allWells.hide();
            			
            			    navListItems.click(function(e)
            			    {
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
            			    
            //DEMO ONLY //
            $('#activate-step-2').on('click', function (e) {
            $('ul.setup-panel li:eq(1)').removeClass('disabled');
            $('ul.setup-panel li a[href="#step-2"]').trigger('click');
            $(this).remove();
            })
            });
            
            </script>
</body>

</html>