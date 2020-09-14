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

<h1>REGISTRASI EVENT ORGANIZER</h1>
  <table class="table table-bordered" style="padding-left:5%;">
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td> {{$data->nama}}</td>
      </tr>
      <tr>
        <td>Kontak</td>
        <td>:</td>
        <td> {{$data->kontak}}</td>
      </tr>
      <tr>
        <td>HP Kontak</td>
        <td>:</td>
        <td> {{$data->no_hp_kontak}}</td>
      </tr>
      <tr>
        <td>Whatsapp Kontak</td>
        <td>:</td>
        <td> {{$data->no_wa_kontak}}</td>
      </tr
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{$data->alamat}}</td>
      </tr>
      <tr>
        <td>Kode Pos</td>
        <td>:</td>
        <td> {{$data->kode_pos}}</td>
      </tr>
      <tr>
        <td>Website</td>
        <td>:</td>
        <td> {{$data->alamat_web}}</td>
      </tr>
      <tr>
        <td>No Rekening</td>
        <td>:</td>
        <td>{{$data->no_rekening}}</td>
      </tr>
      <tr>
        <td>Pemilik Rekening</td>
        <td>:</td>
        <td>{{$data->pemilik_rekening}}</td>
      </tr>
      <tr>
        <td>Nama Bank</td>
        <td>:</td>
        <td> {{$data->nama_bank}}</td>
      </tr>
    </table>
</div>
<div style="padding:20px;">Terima kasih telah mendaftar sebagai Event Organizer portal sepeda</div>
<div style="padding:20px;">Salam,<br>Sobat Portal</div>
<div class="col-md-12" style="background: url({{asset('assets/img/foot.png')}});height: 300px;background-repeat: no-repeat;background-position: center;background-size: 100% 300px;">
