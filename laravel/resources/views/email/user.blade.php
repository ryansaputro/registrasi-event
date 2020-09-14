<link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
<style>
  html,body{
    font-family: 'Lato', Helvetica, sans-serif
  }
</style>
<div class="col-md-12" style="background: url({{asset('assets/img/head.png')}});height: 200px;background-repeat: no-repeat;background-position: center;background-size: 100% 300px;">
</div>
<div style="padding:20px;">{{$data['isi']}}</div>
<div style="padding:20px;">
@php
  $thn = substr($data['diri']['tanggal_lahir'] ,0,4);
  $bln = substr($data['diri']['tanggal_lahir'] ,4,2);
  $tgl = substr($data['diri']['tanggal_lahir'] ,6,2);
  $lahir = $tgl.'-'.$bln.'-'.$thn;
@endphp
  <table class="table table-bordered" style="padding-left:5%;">
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td> {{$data['diri']['nama']}}</td>
      </tr>
      <tr>
        <td>Panggilan</td>
        <td>:</td>
        <td> {{$data['diri']['panggilan']}}</td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td> {{$data['diri']['jenis_kelamin']}}</td>
      </tr>
      <tr>
        <td>Tempat Lahir</td>
        <td>:</td>
        <td> {{$data['diri']['tempat_lahir']}}</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td>{{$lahir}}</td>
      </tr>
      <tr>
        <td>Golongan Darah</td>
        <td>:</td>
        <td> {{$data['diri']['golongan_darah']}}</td>
      </tr>
      <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td> {{$data['diri']['pekerjaan']}}</td>
      </tr>
      <tr>
        <td>Provinsi</td>
        <td>:</td>
        <td>{{$data['diri']['provinsi']}}</td>
      </tr>
      <tr>
        <td>Kota</td>
        <td>:</td>
        <td>{{$data['diri']['kota']}}</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td> {{$data['diri']['alamat']}}</td>
      </tr>
      <tr>
        <td>Kode Pos</td>
        <td>:</td>
        <td> {{$data['diri']['kode_pos']}}</td>
      </tr>
      <tr>
        <td>No Handphone</td>
        <td>:</td>
        <td> {{$data['diri']['no_hp_kontak']}}</td>
      </tr>
      <tr>
        <td>No. Whatsapp</td>
        <td>:</td>
        <td> {{$data['diri']['no_wa_kontak']}}</td>
      </tr>
      <tr>
        <td>Email</td>
        <td>:</td>
        <td> {{$data['diri']['email']}}</td>
      </tr>
      <tr>
        <td>Nama Kontak Emergensi</td>
        <td>:</td>
        <td> {{$data['event']['nama_kontak']}}</td>
      </tr>
      <tr>
        <td>Hubungan Kontak</td>
        <td>:</td>
        <td> {{$data['event']['hubungan_kontak']}}</td>
      </tr>
      <tr>
        <td>No. Telpon Emergensi</td>
        <td>:</td>
        <td> {{$data['event']['no_telp']}}</td>
      </tr>
  </table>
</div>
<div style="padding:20px;">{{$data['penutup']}} <a href="{{$data['link']}}">{{md5($data['link'])}}</a> {{$data['_penutup']}}</div>
<div style="padding:20px;">Salam,<br>{{$data['eo']}}</div>
<div class="col-md-12" style="background: url({{asset('assets/img/foot.png')}});height: 300px;background-repeat: no-repeat;background-position: center;background-size: 100% 300px;">
