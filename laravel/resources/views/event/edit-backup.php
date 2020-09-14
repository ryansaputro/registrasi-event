@extends('layouts_app.app')

@section('content')
<style>
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}


#desain_mockup_img{
  background-size: contain !important;
  background-repeat: no-repeat !important;
  background-position-x: center !important;
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Registrasi Event
  </h1>
</section>
<!-- Main content -->
<section class="content">
@if ($errors->any())
  @foreach ($errors->all() as $error)
      <div>{{$error}}</div>
  @endforeach
@endif
  <!-- Default row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Silahkan isi
              <a href="{{ URL::to($eo.'/event/registrasi') }}" class="btn btn-danger btn-sm pull-right" style="margin-top: -6px;" title="Kembali"><i class="fa fa-times"></i> Kembali</a>
          </h3>
        </div>
      </div>
      
        <form class="form-horizontal" action="{{URL::to($eo.'/event/'.$event->kode_event.'/registrasi-edit')}}" enctype="multipart/form-data" method="post">
          @csrf
          <input name="_method" type="hidden" value="PUT">
          <div class="col-md-4 col-lg-4">
            <div class="form-group">
              <label class="col-sm-12" for="kode_event">Kode Event:</label>
              <div class="col-sm-12">
              <input type="text" value="{{$event->kode_event}}" class="form-control" id="kode_event" placeholder="Masukkan kode event" name="kode_event">
                @if ($errors->has('kode_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('kode_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
              @if ($event->e_poster != '')
                <input type="hidden" value="{{$event->e_poster}}" class="form-control" id="e_poster_value" placeholder="Masukkan kode event" name="e_poster_value">
              @endif
              @if ($event->desain_mockup != '')
                <input type="hidden" value="{{$event->desain_mockup}}" class="form-control" id="desain_mockup_value" placeholder="Masukkan kode event" name="desain_mockup_value">
              @endif
            <div class="form-group">
              <label class="col-sm-12" for="nama_event">Nama Event:</label>
              <div class="col-sm-12">
                <input type="text" value="{{$event->nama_event}}" class="form-control" id="nama_event" placeholder="Masukkan nama event" name="nama_event">
                @if ($errors->has('nama_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('nama_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="tanggal_mulai">Tanggal Mulai:</label>
              <div class="col-sm-12">
                <input type="datetime-local"  value="{{str_replace(' ', 'T', $event->tanggal_mulai)}}" class="form-control" id="tanggal_mulai" placeholder="Masukkan tanggal mulai event" name="tanggal_mulai">
                @if ($errors->has('tanggal_mulai'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tanggal_mulai') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="tanggal_akhir">Tanggal Akhir:</label>
              <div class="col-sm-12">
                <input type="datetime-local"  value="{{str_replace(' ', 'T', $event->tanggal_akhir)}}" class="form-control" id="tanggal_akhir" placeholder="Masukkan tanggal akhir event" name="tanggal_akhir">
                @if ($errors->has('tanggal_akhir'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="tempat_event">Tempat Event:</label>
              <div class="col-sm-12">
                <input type="text"  value="{{$event->tempat_event}}" class="form-control" id="tempat_event" placeholder="Masukkan tempat event" name="tempat_event">
                @if ($errors->has('tempat_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tempat_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="waktu_kumpul">Waktu Kumpul:</label>
              <div class="col-sm-12">
                <input type="datetime-local" value="{{str_replace(' ', 'T', $event->waktu_kumpul)}}"  class="form-control" id="waktu_kumpul" placeholder="Masukkan tempat event" name="waktu_kumpul">
                @if ($errors->has('waktu_kumpul'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('waktu_kumpul') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="tempat_kumpul">Tempat Kumpul:</label>
              <div class="col-sm-12">
                <input type="text" value="{{$event->tempat_kumpul}}" class="form-control" id="tempat_kumpul" placeholder="Masukkan tempat kumpul event" name="tempat_kumpul">
                @if ($errors->has('tempat_kumpul'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tempat_kumpul') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="form-group">
              <label class="col-sm-12" for="tanggal_mulai_pendaftaran">Tanggal Mulai Pendaftaran:</label>
              <div class="col-sm-12">
                <input type="datetime-local" class="form-control" value="{{str_replace(" ", "T", $event->tanggal_awal_pendaftaran)}}" id="tanggal_mulai_pendaftaran" placeholder="Masukkan tanggal mulai event" name="tanggal_mulai_pendaftaran" value="{{old('tanggal_mulai_pendaftaran')}}">
                @if ($errors->has('tanggal_mulai_pendaftaran'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tanggal_mulai') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="tanggal_akhir_pendaftaran">Tanggal Akhir Pendaftaran:</label>
              <div class="col-sm-12">
              <input type="datetime-local" class="form-control" value="{{str_replace(" ", "T", $event->tanggal_akhir_pendaftaran)}}" id="tanggal_akhir_pendaftaran" placeholder="Masukkan tanggal akhir event" name="tanggal_akhir_pendaftaran" value="{{old('tanggal_akhir_pendaftaran')}}">
                @if ($errors->has('tanggal_akhir_pendaftaran'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tanggal_akhir_pendaftaran') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="jenis_event">Jenis Event:</label>
              <div class="col-sm-12">
                <select class="form-control" name="jenis_event" id="jenis_event">
                  <option disabled>-pilih tipe event-</option>
                    @foreach ($eventPortal as $k => $v)
                    <option {{$event->id_jenis_event == $v->id ? 'selected' : ''}} value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('jenis_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('jenis_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="sponsor">Sponsor:</label>
              <div class="col-sm-12">
                <input type="text" value="{{$event->sponsor}}"  class="form-control" id="sponsor" placeholder="Enduro, Djarum" name="sponsor">
                @if ($errors->has('sponsor'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('sponsor') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-5" for="jumlah_peserta">Jumlah Peserta:</label>
              <div class="checkbox" style="padding-top:0px;">
                <label>
                  <input type="checkbox" class="pesertaCheck" {{$event->jumlah_peserta != null ? 'checked' : ''}} name="pesertaCheck" oninput="ShowJumlahPeserta(this)" value="{{$event->jumlah_peserta != null ? '1' : '0'}}">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                  Terbatas
                </label>
              </div>
              <div class="col-sm-12 jumlahPesertaDiv">
                
                @if ($errors->has('jumlah_peserta'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('jumlah_peserta') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-5" for="biaya_pendaftaran">Biaya Pendaftaran:</label>
              <div class="checkbox" style="padding-top:0px;">
                <label>
                  <input type="checkbox" class="biayaCheck" name="biayaCheck" {{count($jenis_pembayaran) > 0 ? 'checked' : ''}}  oninput="adaBiaya(this)" value="0">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                  Ya
                </label>
              </div>
              <div class="col-sm-12">
                <a class="btn btn-warning btn-block biaya" data-backdrop="static" data-keyboard="false" style="display:none;">Masukkan Biaya Pendaftaran</a>
                <input type="text" style="display: none;" class="form-control" id="biaya_pendaftaran" placeholder="Masukkan tempat event" name="biaya_pendaftaran">
                @if ($errors->has('biaya_pendaftaran'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('biaya_pendaftaran') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="deskripsi_event">Deskripsi:</label>
              <div class="col-sm-12">
              <textarea class="form-control" id="deskripsi_event" placeholder="Masukkan deskripsi event" name="deskripsi_event">{{$event->deskripsi_event}}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="e_poster">E-poster:</label>
              <div class="col-sm-12">
                <input type="file" id="imgInp" class="form-control" id="e_poster" placeholder="Masukkan tempat event" name="e_poster">
                @if ($errors->has('e_poster'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('e_poster') }}</strong>
                    </span>
                @endif
              </div>
              <div class="col-sm-12">
              <img id="blah" src="{{ asset('laravel/public/images/event/'.$event->e_poster) }}" alt="{{$event->nama_event}}" style="margin-top: 10px; width: 335px;padding-left: 1px;height: auto;"/>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12" style="background-image:url('https://heartofdixieveincenter.com/wp-content/uploads/2016/07/share-events.jpg');">
              </div>
            </div>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="form-group">
              <label class="col-sm-12" for="id_provinsi">Provinsi:</label>
              <div class="col-sm-12">
                <select class="form-control" id="id_provinsi" data-live-search="true" name="id_provinsi">
                  <option disabled selected>-pilih provinsi-</option>
                  @foreach ($provinsi as $k => $v)
                  <option {{$event->id_provinsi == $v['id'] ? 'selected' : ''}} value="{{$v['id']}}">{{$v['nama']}}</option>
                  @endforeach
                </select>
                @if ($errors->has('id_provinsi'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('id_provinsi') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="id_kota">Kota/kabupaten:</label>
              <div class="col-sm-12">
                <select class="form-control" id="id_kota" name="id_kota">
                  <option disabled selected>-pilih kota-</option>
                  @foreach ($kota as $k => $v)
                  <option {{$event->id_kota == $v['id'] ? 'selected' : ''}} value="{{$v['id']}}">{{$v['nama']}}</option>
                  @endforeach
                </select>
                @if ($errors->has('id_kota'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('id_kota') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="id_kecamatan">Kecamatan:</label>
              <div class="col-sm-12">
                <select class="form-control" id="id_kecamatan" name="id_kecamatan">
                  <option disabled selected>-pilih kecamatan-</option>
                  @foreach ($kecamatan as $k => $v)
                  <option {{$event->id_kecamatan == $v['id'] ? 'selected' : ''}} value="{{$v['id']}}">{{$v['nama']}}</option>
                  @endforeach
                </select>
                @if ($errors->has('id_kecamatan'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('id_kecamatan') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="id_desa">Desa:</label>
              <div class="col-sm-12">
                <select class="form-control" id="id_desa" name="id_desa">
                  <option disabled selected>-pilih desa-</option>
                  @foreach ($desa as $k => $v)
                  <option {{$event->id_desa == $v['id'] ? 'selected' : ''}} value="{{$v['id']}}">{{$v['nama']}}</option>
                  @endforeach
                </select>
                @if ($errors->has('id_desa'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('id_desa') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="kode_pos">Kode Pos:</label>
              <div class="col-sm-12">
                <input type="text" value="{{$event->kode_pos}}" class="form-control" id="kode_pos" placeholder="Masukkan kode event" name="kode_pos">
                @if ($errors->has('kode_pos'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('kode_pos') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="url_event">Url Event:</label>
              <div class="col-sm-12">
                <input type="text" value="{{$event->url_event}}" class="form-control" onclick="nameEvent(this)" id="url_event" placeholder="Masukkan url event" name="url_event">
                @if ($errors->has('url_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('url_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="url_lain">Url Lain:</label>
              <div class="col-sm-12">
                <input type="text"  value="{{$event->url_lain}}" class="form-control" id="url_lain" placeholder="Masukkan url lain" name="url_lain">
              </div>
            </div>
            {{-- <div class="form-group">
              <label class="col-sm-12" for="url_lain">Komunitas:</label>
              <div class="col-sm-12">
                <input type="text" list="komunitas"  value="{{$event->komunitas}}" class="form-control" id="url_lain" placeholder="Masukkan Komunitas anda" name="komunitas">
                <datalist id="komunitas">
                  @foreach($komunitas AS $k => $v)
                    <option value="{{$v->name_community}}">
                  @endforeach
                </datalist>
              </div>
            </div> --}}
            <div class="form-group">
              <label class="col-sm-12" for="jumlah_peserta">Include:</label>
              <div class="checkbox" style="padding-top:0px;">
                <label>
                  <input type="checkbox" class="includeJersey" name="includeJersey" oninput="ShowJersey(this)">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                  Jersey
                </label>
              </div>
              <div class="col-sm-12 JerseyShow">
                
                @if ($errors->has('jumlah_peserta'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('jumlah_peserta') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-12">
              <button class="btn btn-sm btn-primary pull-right" type="submit">
                <i class="fa fa-check"> </i> Simpan
              </button>
            </div>

            <!--modal pembayaran-->
            <div id="tempatModal"></div>
            <!--modal jersey-->
            <div id="jerseyModal"></div>

        </form>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
  @php
   $mockup = 'laravel/public/images/event/mockup/'.$event->desain_mockup;
   $ebHarga = "";   
   $ebTanggal = "";   
   $normalHarga = "";   
   $normalTanggal = "";   
   $otrHarga = "";   
   $otrTanggal = "";   
  @endphp

  <!--untuk menampilkan modal beserta isinya-->
  @if (count($jenis_pembayaran) > 0)
    @foreach ($jenis_pembayaran as $k => $v)
      @php
        if($v->jenis_pembayaran == 'eb'){
          $ebHarga = $v->harga;
          $ebTanggal = str_replace(' ', 'T', $v->tanggal);
        }else if($v->jenis_pembayaran == 'normal'){
          $normalHarga = $v->harga;
          $normalTanggal = str_replace(' ', 'T', $v->tanggal);
          $normalTanggalByr = str_replace(' ', 'T', $v->tanggal_bayar);
        }else{
          $otrHarga = $v->harga;
          $otrTanggal = str_replace(' ', 'T', $v->tanggal);
        }
      @endphp
    @endforeach
  @else
      @php
          $ebHarga = null;
          $ebTanggal = null;
          $normalHarga = null;
          $normalTanggal = null;
          $otrHarga = null;
          $otrTanggal = null;
          $normalTanggalByr = null;
      @endphp
  @endif

  <!--untuk menampilkan jersey dan isinya-->
@if (count($jersey) > 0)
    @foreach($dataJersey AS $k => $v)
        @if(in_array($v->model, $jersey))
          <?php $size[] = $v->size;?>
        @endif
    @endforeach
@else
        <?php $size[] = null;?>
@endif
</section>
<!-- /.content -->
@endsection


<!-- push script ke app.blade.php -->
@push('scripts')
<script>
  //utk tabnael
  function openAttr(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
    checkMenu(evt.currentTarget.className);

    //preview mock up desain
    $("#desain_mockup").change(function() {
      readURLMockup(this);
    });

    function readURLMockup(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function(e) {
            $('#desain_mockup_img').css('background-image', 'url('+e.target.result+')');
            console.log(e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
    }    
  }

  //utk menu jika menu sama dengan tabel
  function checkMenu(a){
    
      console.log(a)
    //jk menu aktive dat table ukuran
    if(a == 'tablinks tabel-button active'){
        //checking jika ada style
        if($('.styleJersey').is(':checked') == true){

            //ajax data
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

              var urls = "{{URL::to('/event/ajaxGetJersey')}}";
              $.ajax({
                url: urls,
                method:"post", 
                data: {
                  "_token": "{{ csrf_token() }}",
                  "id_event": "{{$event->id}}"
                },
                    success: function(result){
                      var model = {};

                        //jika ada style yg dipilih            
                          if($('.styleJerseyModel').length > 0){

                            var data = ""
                            //looping style yg di check
                            $.each($('.styleJerseyModel:checked'), function(k,v){
                                
                                //utk ukuran
                                var value = $(v).val();
                                var ukuran = "<th>Style</th>";
                                var input = "";
                                var nilai = value.replace(' ', '_').toLowerCase()
                                var vax = {}


                                if(result.jmlDatas > 0 ){
                                  if(nilai == 'rb_panjang'){
                                      var vax = result.datas.rb_panjang;
                                      
                                    }
                                  if(nilai == 'rb_pendek'){
                                      var vax = result.datas.rb_pendek;
                                      
                                    }
                                  if(nilai == 'xc_panjang'){
                                      var vax = result.datas.xc_panjang;
                                      
                                    }
                                  if(nilai == 'xc_pendek'){
                                      var vax = result.datas.xc_pendek;
                                      
                                    }
                                  if(nilai == 'dh_panjang'){
                                      var vax = result.datas.dh_panjang;
                                      
                                    }
                                  if(nilai == 'dh_pendek'){
                                      var vax = result.datas.dh_pendek;
                                      
                                    }

                                }
                                  //checking ukuran
                                  $.each($('.ukuranJersey:checked'), function(k,v){
                                    var dataUkuran = $(v).val();
                                    
                                    //jika di db ada
                                    if(result.jmlDatas > 0){

                                      //jika data tidak sama dengan undefined
                                      if(typeof vax !== 'undefined'){

                                          if(dataUkuran == 'XS'){
                                            hasil = (typeof vax == 'undefined') ? '0 X 0 CM' : (typeof vax.XS == 'undefined') ? '0 X 0 CM' : vax.XS;
                                          }
                                          if(dataUkuran == 'S'){
                                            hasil =  (typeof vax == 'undefined') ? '0 X 0 CM' : (typeof vax.S == 'undefined') ? '0 X 0 CM' : vax.S; 
                                          }
                                          if(dataUkuran == 'M'){
                                            hasil =  (typeof vax == 'undefined') ? '0 X 0 CM' : (typeof vax.M == 'undefined') ? '0 X 0 CM' : vax.M; 
                                          }
                                          if(dataUkuran == 'L'){
                                            hasil =  (typeof vax == 'undefined') ? '0 X 0 CM' : (typeof vax.L == 'undefined') ? '0 X 0 CM' : vax.L; 
                                          }
                                          if(dataUkuran == 'XL'){
                                            hasil =  (typeof vax  == 'undefined') ? '0 X 0 CM' : (typeof vax.XL == 'undefined') ? '0 X 0 CM' : vax.XL; 
                                          }
                                          if(dataUkuran == 'XXL'){
                                            hasil =  (typeof vax == 'undefined') ? '0 X 0 CM' : (typeof vax.XXL == 'undefined') ? '0 X 0 CM' : vax.XXL; 
                                          }

                                      //jk ajax hasilnya ga ada
                                      }else{
                                        hasil = '0 X 0 CM';
                                      }
                                    
                                    //jk hasil ajax 0
                                    }else{
                                      hasil = '0 X 0 CM';
                                    }

                                  ukuran += '<th class="'+dataUkuran.replace(' ', '_').toLowerCase()+'">'+dataUkuran+'</th>';
                                  input += '<td class="'+dataUkuran.replace(' ', '_').toLowerCase()+'"><input value="'+hasil+'" class="form-control '+dataUkuran.replace(' ', '_').toLowerCase()+'" data-id="'+dataUkuran.replace(' ', '_').toLowerCase()+'" placeholder="38 X 58 CM" type="text" name="ukuran['+value.replace(' ', '_').toLowerCase()+']['+dataUkuran.replace(' ', '_').toLowerCase()+']"></td>' 
                                });
                              
              
                                data += '<tr class="'+value.replace(' ', '_').toLowerCase()+'"><td><input type="hidden" name="style['+value.replace(' ', '_').toLowerCase()+']" value="'+value+'">'+value+'</td>'+input+'</tr>'
                                $('.ukuran').html(ukuran);
                            });
              
                          }

                        $('.table-ukuran tbody').html(data);
                }
              }); 


        }else{
              var ukuran = "<th>Style</th>";
              
              var input = "";

              //checking ukuran
              $.each($('.ukuranJersey:checked'), function(k,v){
                var dataUkuran = $(v).val();
                ukuran += '<th class="'+dataUkuran.replace(' ', '_').toLowerCase()+'">'+dataUkuran+'</th>';
                input += '<td class="'+dataUkuran.replace(' ', '_').toLowerCase()+'"><input class="form-control '+dataUkuran.replace(' ', '_').toLowerCase()+'" data-id="'+dataUkuran.replace(' ', '_').toLowerCase()+'" placeholder="38 X 58 CM" type="text" name="ukuran[tanpa_style]['+dataUkuran.replace(' ', '_').toLowerCase()+']"></td>' 
              });

              data = '<tr class="tanpa_style"><td><input type="hidden" name="style[tanpa_style]" value="tanpa style">tanpa style</td>'+input+'</tr>'
              $('.ukuran').html(ukuran);
              $('.table-ukuran tbody').html(data);
        }

        

    }
  }
  
    var baseUrl = "";
    var urlEvent = "";

    function ShowStyleJersey(a){
      var cek = $(a).is(':checked') ? 'di cek' : 'ga dicek';
      if(cek == 'di cek'){
          var btn =  '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="RB Panjang" {{in_array("RB Panjang", $jersey) ? "checked" : ""}}>'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'RB Panjang'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="RB Pendek" {{in_array("RB Pendek", $jersey) ? "checked" : ""}}>'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'RB Pendek'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="XC Panjang" {{in_array("XC Panjang", $jersey) ? "checked" : ""}}>'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'XC Panjang'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="XC Pendek" {{in_array("XC Pendek", $jersey) ? "checked" : ""}}>'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'XC Pendek'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="DH Panjang" {{in_array("DH Panjang", $jersey) ? "checked" : ""}}>'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'DH Panjang'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="DH Pendek" {{in_array("DH Pendek", $jersey) ? "checked" : ""}}>'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'DH Pendek'+
                        '</label>'+
                      '</div>';

      }else{
          var btn = "";
      }
      $('.JerseyStyleShow').html(btn);
      
    }

    function ShowJersey(a){
      var modal = '<div id="Jersey" class="modal fade" role="dialog">'+
              '<div class="modal-dialog modal-lg">'+
                '<div class="modal-content">'+
                  '<div class="modal-header">'+
                    '<button type="button" class="close">&times;</button>'+
                    '<h4 class="modal-title">Atribut Jersey</h4>'+
                  '</div>'+
                  '<div class="modal-body">'+
                    '<div class="tab">'+
                      '<button type="button" class="tablinks active" onclick="openAttr(event, \'style\')">Style</button>'+
                      '<button type="button" class="tablinks" onclick="openAttr(event, \'ukuran\')">Ukuran</button>'+
                      '<button type="button" class="tablinks tabel-button" onclick="openAttr(event, \'tabel\')">Tabel Ukuran</button>'+
                      '<button type="button" class="tablinks" onclick="openAttr(event, \'desain\')">Desain Jersey</button>'+
                    '</div>'+

                    '<div id="style" class="tabcontent" style="display: block;">'+
                      '<h3>Style</h3>'+

                        '<div class="form-group">'+
                          '<div class="checkbox" style="padding-top:0px;">'+
                            '<label>'+
                              '<input type="checkbox" class="styleJersey" name="styleJersey" oninput="ShowStyleJersey(this)" value="0">'+
                              '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'Termasuk Style'+
                            '</label>'+
                          '</div>'+
                          '<div class="col-sm-12 JerseyStyleShow">'+
                          '</div>'+
                        '</div>'+
                    '</div>'+

                    '<div id="ukuran" class="tabcontent">'+
                      '<h3>Ukuran</h3>'+

                        '<div class="form-group">'+
                          '<div class="checkbox" style="padding-top:0px;">'+
                            '<label>'+
                              '<input type="checkbox" class="ukuranJersey" name="ukuranJersey" value="XS" {{in_array("XS", $size) ? "checked" : ""}}>'+
                              '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'XS'+
                            '</label>'+
                          '</div>'+
                          '<div class="checkbox" style="padding-top:0px;">'+
                            '<label>'+
                              '<input type="checkbox" class="ukuranJersey" name="ukuranJersey" value="S" {{in_array("S", $size) ? "checked" : ""}}>'+
                              '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'S'+
                            '</label>'+
                          '</div>'+
                          '<div class="checkbox" style="padding-top:0px;">'+
                            '<label>'+
                              '<input type="checkbox" class="ukuranJersey" name="ukuranJersey" value="M" {{in_array("M", $size) ? "checked" : ""}}>'+
                              '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'M'+
                            '</label>'+
                          '</div>'+
                          '<div class="checkbox" style="padding-top:0px;">'+
                            '<label>'+
                              '<input type="checkbox" class="ukuranJersey" name="ukuranJersey" value="L" {{in_array("L", $size) ? "checked" : ""}}>'+
                              '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'L'+
                            '</label>'+
                          '</div>'+
                          '<div class="checkbox" style="padding-top:0px;">'+
                            '<label>'+
                              '<input type="checkbox" class="ukuranJersey" name="ukuranJersey" value="XL" {{in_array("XL", $size) ? "checked" : ""}}>'+
                              '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'XL'+
                            '</label>'+
                          '</div>'+
                          '<div class="checkbox" style="padding-top:0px;">'+
                            '<label>'+
                              '<input type="checkbox" class="ukuranJersey" name="ukuranJersey" value="XXL" {{in_array("XXL", $size) ? "checked" : ""}}>'+
                              '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'XXL'+
                            '</label>'+
                          '</div>'+
                          '<div class="col-sm-12">'+
                          '</div>'+
                        '</div>'+

                    '</div>'+

                    '<div id="tabel" class="tabcontent">'+
                      '<h3>Tabel Ukuran</h3>'+
                      '<table class="table table-bordered table-ukuran">'+
                          '<thead>'+
                            '<tr class="ukuran">'+
                              '<th>Style</th>'+
                              '<th>Ukuran</th>'+
                            '</tr>'+
                          '</thead>'+
                          '<tbody>'+
                          '</tbody>'+
                      '</table>'+
                    '</div>'+

                    '<div id="desain" class="tabcontent">'+
                      '<h3>Desain Jersey</h3>'+
                        '<div class="form-group">'+
                          '<div class="col-sm-12">'+
                            '<input type="file" class="form-control" accept="image/*" required  id="desain_mockup" placeholder="Masukkan url lain" name="desain_mockup">'+
                            '<input type="hidden" class="form-control" required  id="desain_mockup" placeholder="Masukkan url lain" name="desain_mockup">'+
                          '</div>'+
                          '<div id="desain_mockup_img" style="background:url({{asset($mockup)}});height:300px;" class="col-sm-12">'+
                            // '<img alt="your image" style="margin-top: 10px; width: 330px;padding-left: 1px;height: auto;"/>'+
                          '</div>'+
                        '</div>'+
                    '</div>'+

                  '</div>'+
                  '<div class="modal-footer">'+
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
                  '</div>'+
                '</div>'+

              '</div>'+
            '</div>';
      
      
      if($(a).is(':checked') == true){
        var btn ='<button type="button" class="btn btn-warning btn-sm btn-block tampilJersey" data-toggle="modal" data-target="#Jersey" data-backdrop="static" data-keyboard="false" style="margin-top:10px;">Atribut Jersey</button>';

      }else{
        var btn ="";
      }
      $('.JerseyShow').html(btn);
      $('#jerseyModal').html(modal);
    }

    $(document).ready(function(){
      $('#myModal').modal({backdrop: 'static', keyboard: false})  
      var jersey = "{{count($jersey)}}";

      var getUrl = window.location;
      baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0]+'event/';
      var jmlPeserta = $('.pesertaCheck').val();
      var jenisBiaya = "{{count($jenis_pembayaran)}}";
     

      if(jmlPeserta == '1'){
        $('.pesertaCheck').trigger('oninput');
        $('#jumlah_peserta').attr('value', '{{$event->jumlah_peserta}}');
      }

      if(jenisBiaya > 0){
        $('.biayaCheck').trigger('oninput');
        $('.biaya').trigger('click');
      }

      // $('.close').on('click', function(){
      //   $('.close').attr("data-dismiss", "modal");
      //   alert("dihapus");
          if(jersey > 0){
            $('.includeJersey').trigger('click');
            $('.tampilJersey').trigger('click');

            $('.styleJersey').trigger('click');

            openAttr(event, "tabel");
            $('.tabel-button').addClass('active');
            checkMenu($('.tabel-button').attr('class'));

            // $('.close').addClass('closes');
            // $('.close').removeClass('close');

          }
      // });

      $('.close').on('click', function(){
        $('.close').attr("data-dismiss", "modal");
      });

    });


    function nameEvent(a){
      var valuenya = $("#kode_event").val();
      urlEvent = valuenya.replace(/ /g, '-').toLowerCase();
      $(a).val(baseUrl+''+urlEvent);
    }

    function ShowJumlahPeserta(a){
      var input = '<input type="number" value="{{$event->jumlah_peserta != null ? $event->jumlah_peserta : ''}}" name="jumlah_peserta" placeholder="masukkan jumlah maksimal peserta" id="jumlah_peserta" class="form-control">';
      $(a).removeAttr('oninput');
      $(a).attr('oninput', 'HideJumlahPeserta(this)');
      $('.jumlahPesertaDiv').html(input);
      $(a).val("1");
    }

    function HideJumlahPeserta(a){
      $(a).removeAttr('oninput');
      $(a).attr('oninput', 'ShowJumlahPeserta(this)');
      $(a).val("0");
      $('.jumlahPesertaDiv').html("");
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
          }
          
          reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
      readURL(this);
    });

    function adaBiaya(a){
      var nil = $('.biayaCheck').val();
      val = nil == 1 ? 0 : 1;
      $(a).val(val);
      if(val == 1){
        $('.biaya').css('display', 'block');
        var modal = '<div id="myModal" class="modal fade" role="dialog">'+
              '<div class="modal-dialog modal-lg">'+

                '<div class="modal-content">'+
                  '<div class="modal-header">'+
                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                    '<h4 class="modal-title">Jenis Pembayaran</h4>'+
                  '</div>'+
                  '<div class="modal-body">'+
                    '<table class="table table-bordered">'+
                      '<tr>'+
                        '<th>Jenis Pendaftaran</th>'+
                        // '<th>Batas Pendaftaran</th>'+
                        '<th>Biaya Pendaftaran</th>'+
                        '<th>Batas Pembayaran</th>'+
                      '</tr>'+
                      '<tr class="eb">'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Normal<input type="hidden" value="normal" name="jenis_pendaftaran[]"></td>'+
                        // '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" id="normal_tgl_pendaftaran" name="tgl_pendaftaran[normal]"></td>'+
                        '<td><input type="number" class="form-control" value="" id="normal_biaya_pendaftaran" name="biaya_pendaftaran[normal]"></td>'+
                        '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" id="normal_tgl_pembayaran" name="tgl_pembayaran[normal]"></td>'+
                      '</tr>'+
                      '<tr class="otr">'+
                      '</tr>'+
                    '</table>'+
                  '</div>'+
                  // '<table class="table">'+
                  //   '<tr>'+
                  //     '<tr class="aksi">'+
                  //       '<td><button type="button" onclick="addEB(this)" class="addEB btn btn-warning btn-block">Tambah Early Bird</button></td>'+
                  //       '<td><button type="button" onclick="addOTR(this)" class="addOTR btn btn-warning btn-block">Tambah On The Road</button></td>'+
                  //     '</tr>'+
                  //   '</tr>'+
                  // '</table>'+
                  '<div class="modal-footer">'+
                    '<button type="button" class="btn btn-default btn-sm close">Close</button>'+
                  '</div>'+
                '</div>'+

              '</div>'+
            '</div>';
            $('#tempatModal').html(modal);
      }else{
        $('#tempatModal').children().remove();
        $('.biaya').css('display', 'none');
      }
    }

    //modal showing
    $('.biaya').on('click', function(){
      $('#myModal').modal({'show' : 'show', backdrop: 'static', keyboard: false})  
      var ebHarga = '{{$ebHarga}}';
      var ebTanggal = '{{$ebTanggal}}';
      var normalHarga = '{{$normalHarga}}';
      var normalTanggal = '{{$normalTanggal}}';
      var normalTanggalByr = '{{$normalTanggalByr}}';
      var otrHarga = '{{$otrHarga}}';
      var otrTanggal = '{{$otrTanggal}}';
      if(ebHarga != ''){
        if($('.addEB').attr('onclick') == 'addEB(this)'){
          $('.addEB').trigger('click');
        }
        $('#eb_biaya_pendaftaran').removeAttr('value');
        $('#eb_biaya_pendaftaran').attr('value', ebHarga)
        $('#eb_tgl_pendaftaran').removeAttr('value');
        $('#eb_tgl_pendaftaran').attr('value', ebTanggal)
      }
      if(normalHarga != ''){
        $('#normal_biaya_pendaftaran').removeAttr('value');
        $('#normal_biaya_pendaftaran').attr('value', normalHarga)
        $('#normal_tgl_pendaftaran').removeAttr('value');
        $('#normal_tgl_pendaftaran').attr('value', normalTanggal)
        $('#normal_tgl_pembayaran').removeAttr('value');
        $('#normal_tgl_pembayaran').attr('value', normalTanggalByr)
      }
      if(otrHarga != ''){
        if($('.addOTR').attr('onclick') == 'addOTR(this)'){
          $('.addOTR').trigger('click');
        }
        $('#otr_biaya_pendaftaran').removeAttr('value');
        $('#otr_biaya_pendaftaran').attr('value', otrHarga)
        $('#otr_tgl_pendaftaran').removeAttr('value');
        $('#otr_tgl_pendaftaran').attr('value', otrTanggal)
      }    
    }); 

    function addEB(a){
      var td =  '<td>Early Bird<input type="hidden" value="eb" name="jenis_pendaftaran[]"></td>'+
                '<td><input type="date" id="eb_tgl_pendaftaran" class="form-control" value="{{date('Y-m-d')}}" name="tgl_pendaftaran[eb]"></td>'+
                '<td><input type="number" id="eb_biaya_pendaftaran" class="form-control" value="{{date('Y-m-d')}}" name="biaya_pendaftaran[eb]"></td>';
      $('.eb').html(td);
      $(a).text("Hapus Early Bird");
      $(a).removeAttr('onclick');
      $(a).removeClass('btn-warning');
      $(a).addClass('btn-danger');
      $(a).attr('onclick', 'removeEB(this)');
    }

    function removeEB(a){
        $('.eb').children().remove();
        $(a).text("Tambah Early Bird");
        $(a).removeAttr('onclick');
        $(a).addClass('btn-warning');
        $(a).removeClass('btn-danger');
        $(a).attr('onclick', 'addEB(this)');
    }

    function addOTR(a){
      var td =  '<td>On The Road<input type="hidden" value="otr" name="jenis_pendaftaran[]"></td>'+
                '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" id="otr_tgl_pendaftaran" name="tgl_pendaftaran[otr]"></td>'+
                '<td><input type="number" class="form-control" value="{{date('Y-m-d')}}" id="otr_biaya_pendaftaran" name="biaya_pendaftaran[otr]"></td>';
      $('.otr').html(td);
      $(a).text("Hapus On The Road");
      $(a).removeAttr('onclick');
      $(a).removeClass('btn-warning');
      $(a).addClass('btn-danger');
      $(a).attr('onclick', 'removeOTR(this)');
    }

    function removeOTR(a){
        $('.otr').children().remove();
        $(a).text("Tambah On The Road");
        $(a).removeAttr('onclick');
        $(a).addClass('btn-warning');
        $(a).removeClass('btn-danger');
        $(a).attr('onclick', 'addOTR(this)');
    }


    $("#id_provinsi").on('change', function(){
      var id = $("#id_provinsi").find(':selected').val();
      var urls = "{{URL::to('/registrasiEO/ajaxKota')}}";
        $.ajax({
          url: urls,
          method:"post", 
          data: {
            "_token": "{{ csrf_token() }}",
            "id": id
          },
          success: function(result){
              var data = "<option disabled selected>-pilih kota-</option>";
              $.each(result.getKota, function(k,v){
                  data += '<option value="'+v.id+'" data-id="'+v.id+'">'+v.nama+'</option>'
              })
              
              $("#id_kota").html(data);
          }
      }); 
    });
    $("#id_kota").on('change', function(){
      var id = $("#id_kota").find(':selected').val();
      var urls = "{{URL::to('/registrasiEO/ajaxKecamatan')}}";
        $.ajax({
          url: urls,
          method:"post", 
          data: {
            "_token": "{{ csrf_token() }}",
            "id": id
          },
          success: function(result){
              var data = "<option disabled selected>-pilih kecamatan-</option>";
              $.each(result.getKota, function(k,v){
                  data += '<option value="'+v.id+'" data-id="'+v.id+'">'+v.nama+'</option>'
              })
              
              $("#id_kecamatan").html(data);
          }
      }); 
    });
    $("#id_kecamatan").on('change', function(){
      var id = $("#id_kecamatan").find(':selected').val();
      var urls = "{{URL::to('/registrasiEO/ajaxKelurahan')}}";
        $.ajax({
          url: urls,
          method:"post", 
          data: {
            "_token": "{{ csrf_token() }}",
            "id": id
          },
          success: function(result){
              var data = "<option disabled selected>-pilih desa/kelurahan-</option>";
              $.each(result.getKota, function(k,v){
                  data += '<option value="'+v.id+'" data-id="'+v.id+'">'+v.nama+'</option>'
              })
              
              $("#id_desa").html(data);
          }
      }); 
  });
</script>

@endpush