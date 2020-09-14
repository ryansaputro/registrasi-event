@extends('layouts_app.app')

@section('content')
<style>
.model, .drmn{
    display:none;
}

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

/*Radio box*/

input[type="radio"] + .label-text:before{
	content: "\f10c";
	font-family: "FontAwesome";
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1;
	-webkit-font-smoothing:antialiased;
	width: 1em;
	display: inline-block;
	margin-right: 5px;
}

input[type="radio"]:checked + .label-text:before{
	content: "\f192";
	color: #da0b45;
	animation: effect 250ms ease-in;
}

input[type="radio"]:disabled + .label-text{
	color: #aaa;
}

input[type="radio"]:disabled + .label-text:before{
	content: "\f111";
	color: #ccc;
}

/*Radio Toggle*/

.toggle input[type="radio"] + .label-text:before{
	content: "\f204";
	font-family: "FontAwesome";
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1;
	-webkit-font-smoothing:antialiased;
	width: 1em;
	display: inline-block;
	margin-right: 10px;
}

.toggle input[type="radio"]:checked + .label-text:before{
	content: "\f205";
	color: #16a085;
	animation: effect 250ms ease-in;
}

.toggle input[type="radio"]:disabled + .label-text{
	color: #aaa;
}

.toggle input[type="radio"]:disabled + .label-text:before{
	content: "\f204";
	color: #ccc;
}


@keyframes effect{
	0%{transform: scale(0);}
	25%{transform: scale(1.3);}
	75%{transform: scale(1.4);}
	100%{transform: scale(1);}
}

.JerseyShow{
    padding-left:20px !important;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css"
	integrity="sha256-kIxwtDqhOVbQysWu0OpR9QfijdXCfqvXgAUJuv7Uxmg=" crossorigin="anonymous" />
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Registrasi Event
  </h1>
</section>
<!-- Main content -->
<section class="content">
@if ($errors->any())
<div class="alert alert-danger">
  @foreach ($errors->all() as $error)
          {{$error}}<br>
  @endforeach
</div>
@endif
<!--<input id="datetimepicker" type="text">-->
  <!-- Default row -->
  <div class="row" style="margin-bottom:100px;">
    <div class="col-md-12">
        <form class="form-horizontal" novalidate action="{{URL::to($id.'/event/registrasi-baru')}}" enctype="multipart/form-data" method="post" novalidate>
          @csrf
          
          <div class="col-md-12 header-event">
            <div class="col-md-1 header-data">
              <i class="fa fa-info-circle fa-3x event-create" aria-hidden="true"></i>
            </div>
            <div class="col-md-11 header-data">
              <h4><strong>Data Event</strong></h4>
              <span>Lengkapi data <b>Event</b> yang akan anda buat</span>
            </div>
          </div>

          <div class="col-md-5 col-md-offset-1">
            <div class="form-group">
              <div class="col-sm-12">
              <input type="file" id="imgInp" style="display:none;" class="form-control" value="{{old('e_poster')}}" id="e_poster" placeholder="Masukkan tempat event" name="e_poster">
                {{-- <span class="label label-danger">Maksimal ukuran gambar 1Mb</span> --}}
                @if ($errors->has('e_poster'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('e_poster') }}</strong>
                    </span>
                @endif
                <a onclick="changeImage(this)">
                  <div style="height: 325px;border-radius:5px;border: 1px solid #f0f0f0;width: 100%;padding-left: 10px;padding-right: 10px;" class="col-md-12">
                    <div id="blah" style="height: 305px;border-radius:5px;background-image:url(https://img.icons8.com/android/96/000000/plus.png);margin-top: 10px;border:2px dashed #f0f0f0;margin-bottom: 10px;" class="col-md-12">
                      <span class="keterangan"><b>Upload Eposter Event Sepeda Anda</b></span>
                      <span class="keterangan-1"><b>Format JPG/JPEG/PNG</b></span>
                    </div>
                  </div>
                </a>
              </div> 
            </div>

          </div>

          <div class="col-md-6" style="float:right; padding-right:10%;">
            <div class="form-group form-event">
              <label class="col-sm-12" for="kode_event">Kode Event <span class="penting">* (Maksimal panjang kode event 3 karakter)</span></label>
              <div class="col-sm-12">
                <input type="text" class="form-control input-event" oninput="nameEvent(this)" id="kode_event" placeholder="Masukkan kode event" maxlength="3" name="kode_event" value="{{old('kode_event')}}">
                @if ($errors->has('kode_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('kode_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group form-event">
              <label class="col-sm-12" for="kode_event">Nama Event <span class="penting">*</span></label>
              <div class="col-sm-12">
                <input type="text" class="form-control input-event" id="nama_event" placeholder="Masukkan nama event" name="nama_event" value="{{old('nama_event')}}">
                @if ($errors->has('nama_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('nama_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group form-event">
              <label class="col-sm-12" for="kode_event">Tanggal Dan Waktu Mulai Event <span class="penting">*</span></label>
              <div class="col-sm-12">
                <input type="text" class="form-control input-event" id="tanggal_mulai" placeholder="Masukkan tanggal mulai event" name="tanggal_mulai" value="{{old('tanggal_mulai')}}">
                @if ($errors->has('tanggal_mulai'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tanggal_mulai') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group form-event">
              <label class="col-sm-12" for="kode_event">Tanggal Dan Waktu Event Berakhir <span class="penting">*</span></label>
              <div class="col-sm-12">
                <input type="text" class="form-control input-event" id="tanggal_akhir" placeholder="Masukkan tanggal akhir event" name="tanggal_akhir" value="{{old('tanggal_akhir')}}">
                @if ($errors->has('tanggal_akhir'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tanggal_akhir') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          
          <div class="col-md-12 col-md-offset-1" style="margin-left: 9.5%;border-bottom: 1px solid #f0f0f0;width: 81.5%;">
            <div class="form-group form-event">
              <label class="col-sm-12" for="deskripsi_event">Deskripsi:</label>
              <div class="col-sm-12">
                <textarea class="form-control input-event" id="deskripsi_event" value="{{old('deskripsi_event')}}" placeholder="Masukkan tempat event" name="deskripsi_event">{{old('deskripsi_event')}}</textarea>
              </div>
            </div>
          </div>
          
          
          <div class="col-md-12 header-event" >
            <div class="col-md-1 header-data">
              <i class="fa fa-calendar-o fa-3x event-create" aria-hidden="true"></i>
              
            </div>
            <div class="col-md-9 header-data">
              <h4><strong>Perlengkapan Wajib Data Event</strong></h4>
              <span>Lengkapi data <b>Perlengkapan Event</b> yang akan dibuat agar peserta mengetahui informasi penting ini</span>
            </div>
            <div class="col-md-2 header-data">
              <i class="fa fa-caret-down fa-3x event-create" aria-hidden="true" style="margin-left: 70px;"></i>
            </div>
          </div>
          
          <div class="col-md-5 col-md-offset-1">
            <div class="form-group form-event">
              <label class="col-sm-12" for="tanggal_mulai_pendaftaran">Tanggal Mulai Pendaftaran:</label>
              <div class="col-sm-12">
                <input type="text" class="form-control input-event" id="tanggal_mulai_pendaftaran" placeholder="Masukkan tanggal mulai event" name="tanggal_mulai_pendaftaran" value="{{old('tanggal_mulai_pendaftaran')}}">
                @if ($errors->has('tanggal_mulai_pendaftaran'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tanggal_mulai') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group form-event">
              <label class="col-sm-12" for="jenis_event">Jenis Event:</label>
              <div class="col-sm-12">
              <select class="form-control input-event" name="jenis_event" value="{{old('jenis_event')}}" id="jenis_event">
                  <option disabled selected>-pilih tipe event-</option>
                    @foreach ($event as $k => $v)
                    <option value="{{$v->id}}" {{old('jenis_event') == $v->id ? 'selected' : ''}}>{{$v->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('jenis_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('jenis_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group form-event">
              <label class="col-sm-12" for="sponsor">Sponsor:</label>
              <div class="col-sm-12">
              <input type="text" class="form-control input-event" id="sponsor" placeholder="Enduro, Djarum" value="{{old('sponsor')}}" name="sponsor">
                @if ($errors->has('sponsor'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('sponsor') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-6" style="float:right; padding-right:10%;">
            <div class="form-group form-event">
              <label class="col-sm-12" for="tanggal_akhir_pendaftaran">Tanggal Akhir Pendaftaran:</label>
              <div class="col-sm-12">
              <input type="text" class="form-control input-event" id="tanggal_akhir_pendaftaran" placeholder="Masukkan tanggal akhir event" name="tanggal_akhir_pendaftaran" value="{{old('tanggal_akhir_pendaftaran')}}">
                @if ($errors->has('tanggal_akhir_pendaftaran'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tanggal_akhir_pendaftaran') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-left: 8.5%;border-bottom: 1px solid #f0f0f0;width: 81.5%;margin-bottom:15px;"></div>
          <div class="col-md-5 col-md-offset-1">
            <div class="form-group form-event">
              <label class="col-sm-12" for="jumlah_peserta">Jumlah Peserta:</label>
              <br>
              <div class="col-md-6" style="border-right:1px solid #f0f0f0;">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="pesertaCheck" name="pesertaCheck" oninput="ShowJumlahPeserta(this)" {{old('jumlah_peserta') ? 'checked' : 'xxx'}} value="{{old('jumlah_peserta') ? '1' : '0'}}">
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
              <div class="col-md-6">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" class="pesertaCheck" name="pesertaCheck" value="0">
                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                    Tidak Terbatas
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12" style="margin-left: 8.5%;border-bottom: 1px solid #f0f0f0;width: 81.5%;margin-bottom:15px;"></div>
          <div class="col-md-11 col-md-offset-1">
            <label>Kategori Pembayaran Event</label>
          </div>
          <div class="col-md-5 col-md-offset-1">
            <label class="event-pilihan-bayar" >
              <input type="radio" onclick="eventBerbayar(this)"  name="type_event" value="PAY">
              <span class="type_event_bayar">
              </span>
              <p class="headbayar">Masukkan Nominal <span class="penting">*</span></p>

            </label>
            <span class="values" style="position:absolute;"></span>
          </div>  
          <div class="col-md-6" style="float:right; padding-right:10%;">
            <label class="event-pilihan-gratis">
              <input type="radio" name="type_event" onclick="eventBerbayar(this)"  value="FREE">
              <span class="type_event_gratis">
              </span>
              <p class="headnya"><strong>Terima Kasih</strong></p>
              <p class="bodynya">Semoga event anda berhasil.</p>

            </label>
          </div>
          <div class="col-md-12" style="margin-left: 8.5%;border-bottom: 1px solid #f0f0f0;width: 81.5%;margin-bottom:10px;margin-top:20px;"></div>
          <div class="col-md-12 header-event">
            <div class="col-md-1 header-data">
              <i class="fa fa-map-marker fa-3x event-create" aria-hidden="true"></i>
              
            </div>
            <div class="col-md-9 header-data">
              <h4><strong>Data Lengkap Lokasi Event</strong></h4>
              <span>Lengkapi data <b>Data Lengkap Lokasi Event</b> yang akan dibuat agar peserta mengetahui tempat pelaksanaan</span>
            </div>
            <div class="col-md-2 header-data">
              <i class="fa fa-caret-down fa-3x event-create" aria-hidden="true" style="margin-left: 70px;"></i>
            </div>
          </div>

          <div class="col-md-5 col-md-offset-1">
            <div class="form-group form-event">
              <label class="col-sm-12" for="tempat_kumpul">Tempat Kumpul:</label>
              <div class="col-sm-12">
                <input type="text" class="form-control input-event" id="tempat_kumpul" placeholder="Masukkan tempat kumpul event" name="tempat_kumpul" value="{{old('tempat_kumpul')}}">
                @if ($errors->has('tempat_kumpul'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('tempat_kumpul') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
          <div class="col-md-6" style="float:right; padding-right:10%;">
            <div class="form-group form-event">
              <label class="col-sm-12" for="waktu_kumpul">Waktu Kumpul:</label>
              <div class="col-sm-12">
                <input type="text" class="form-control input-event" id="waktu_kumpul" placeholder="Masukkan waktu kumpul" name="waktu_kumpul" value="{{old('waktu_kumpul')}}">
                @if ($errors->has('waktu_kumpul'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('waktu_kumpul') }}</strong>
                    </span>
                @endif
              </div>
            </div>

          </div>
          <div class="col-md-12" style="margin-left: 8.5%;border-bottom: 1px solid #f0f0f0;width: 81.5%;margin-bottom:10px;margin-top:20px;"></div>
          <div class="col-md-5 col-md-offset-1">
               <div id="map" style="height: 440px; border: 1px solid #AAA;"></div>
          </div>
          <button type="submit">simpan</button>
          <!--modal pembayaran-->
            <div id="tempatModal">
            </div>

            <div id="jerseyModal">

            </div>
            

            <!-- Modal -->
            
        </form>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
 <link rel="stylesheet" type="text/css" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
      
@endsection

            

<!-- push script ke app.blade.php -->
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
  integrity="sha256-FEqEelWI3WouFOo2VWP/uJfs1y8KJ++FLh2Lbqc8SJk=" crossorigin="anonymous"></script>
  {{-- <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script> --}}
<script type='text/javascript' src='http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js'></script>
<script>

    // Initialize the map and assign it to a variable for later use
var map = L.map('map', {
    // Set latitude and longitude of the map center (required)
    center: [37.7833, -122.4167],
    // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
    zoom: 10
});

L.control.scale().addTo(map);

// Create a Tile Layer and add it to the map
//var tiles = new L.tileLayer('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png').addTo(map);
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  var searchControl = new L.esri.Controls.Geosearch().addTo(map);

  var results = new L.LayerGroup().addTo(map);

  searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
      results.addLayer(L.marker(data.results[i].latlng));
    }
  });

setTimeout(function(){$('.pointer').fadeOut('slow');},3400);

    function eventBerbayar(a){
      console.log($(a));
      if($(a).val() == 'PAY'){
        var data = '<input type="number" class="form-control input-event biaya"  value="" style="margin-left: 10px;margin-top: 15px;" name="biaya_pendaftaran[normal]">';
        $('.values').html(data);
        $('.biaya').focus();
      }else{
        $('.values').html('');
      }
    }
    
    function changeImage(a){
        $('#imgInp').trigger('click');
    }

    $(document).ready(function() {
           $('.summernote').summernote({
            height: 200,
            dialogsInBody: true,
            callbacks:{
                onInit:function(){
                $('body > .note-popover').hide();
                }
            },
        });
        
        var oldValPeserta = "{{old('jumlah_peserta')}}";
        var oldValBiaya = "{{old('biayaCheck')}}";
        var oldValprov = "{{old('id_provinsi')}}";
        var oldValkota = "{{old('id_kota')}}";
        var oldValkec = "{{old('id_kecamatan')}}";
        if(oldValPeserta != ''){
            ShowJumlahPeserta($('.pesertaCheck'))
        }
        if(oldValBiaya != ''){
            adaBiaya($('.biayaCheck'))
        }
        if(oldValprov != ''){
            $('#id_provinsi').trigger('change');
            
            if(oldValkota != ''){
                // $('#id_kota').trigger('change');
                kota($('#id_kota'))
                
                if(oldValkec != ''){
                    // $('#id_kecamatan').trigger('change');
                    kecamatan($('#id_kecamatan'))
                }
            }
        }
        
    });


    $(function() {
      jQuery.datetimepicker.setLocale('id');
      
      jQuery('#tanggal_mulai').datetimepicker({
         i18n:{
          id:{
           months:[
            'Januari','Februari','Maret','April',
            'Mei','Juni','Juli','Agustus',
            'September','Oktober','November','Desember',
           ],
           dayOfWeek:[
            "Ahad", "Senin", "Selasa", "Rabu", 
            "Kamis", "Jum'at", "Sabtu",
           ]
          }
         },
         dayOfWeekStart : 1,
         minDate: 0,
         step: 30,
        });
      
        $('#tanggal_mulai').on('change', function(){
            $('#tanggal_mulai').datetimepicker({
                 minDate: 0,
                 step: 10,
            });
            
            $('#tanggal_akhir').datetimepicker({
                 minDate: $('#tanggal_mulai').val(),
                 step: 10,
            });
            
            $('#waktu_kumpul').datetimepicker({
                 minDate: $('#tanggal_mulai').val(),
                 step: 10,
            });
            
            $('#tanggal_mulai_pendaftaran').datetimepicker({
                 minDate: 0,
                 step: 10,
            });
            
             $('#tanggal_akhir_pendaftaran').datetimepicker({
                 minDate: $('#tanggal_mulai_pendaftaran').val(),
                //  maxDate: new Date($('#tanggal_akhir').val()),
                 step: 30,
            });
        });
    })
    
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


  }

  function checkMenu(a){
    
    //jk menu aktive dat table ukuran
    if(a == 'tablinks tabel-button active'){

        //checking jika ada style
        if($('.styleJersey').is(':checked') == true){

            //jika ada style yg dipilih            
            if($('.styleJerseyModel').length > 0){

              var data ="";
              //looping style yg di check
              $.each($('.styleJerseyModel:checked'), function(k,v){
                  var value = $(v).val();
                  //utk ukuran
                  var ukuran = "<th>Style</th>";
                 
                  var input = "";
                  //checking ukuran
                  $.each($('.ukuranJersey:checked'), function(k,v){
                    var dataUkuran = $(v).val();
                    var hasil = $('input.'+value.replace(' ', '_').toLowerCase()+'-'+dataUkuran.replace(' ', '_').toLowerCase()).val();

                    if((typeof hasil != 'undefined')){
                        hasilnya = $('input.'+value.replace(' ', '_').toLowerCase()+'-'+dataUkuran.replace(' ', '_').toLowerCase()).val();
                    }else{
                        hasilnya =  '0 X 0 CM';
                    } 

                    ukuran += '<th class="'+dataUkuran.replace(' ', '_').toLowerCase()+'">'+dataUkuran+'</th>';
                    input += '<td class="'+dataUkuran.replace(' ', '_').toLowerCase()+'"><input value="'+hasilnya+'" class="ukuranSize form-control '+value.replace(' ', '_').toLowerCase()+'-'+dataUkuran.replace(' ', '_').toLowerCase()+'" data-id="'+dataUkuran.replace(' ', '_').toLowerCase()+'" placeholder="38 X 58 CM" type="text" name="size['+value.replace(' ', '_').toLowerCase()+']['+dataUkuran.replace(' ', '_').toLowerCase()+']"></td>' 
                  });
                
                  data += '<tr class="'+value.replace(' ', '_').toLowerCase()+'"><td><input type="hidden" name="style['+value.replace(' ', '_').toLowerCase()+']" value="'+value+'">'+value+'</td>'+input+'</tr>'
                  $('.ukuran').html(ukuran);
              });

            }
        // }else{
        //       data = '<tr><td>tanpa style</td>'+input+'</tr>'
        }

        $('.table-ukuran tbody').html(data);
    }
  }

    var baseUrl = "";
    var urlEvent = "";

    function ShowStyleJersey(a){
      var cek = $(a).is(':checked') ? 'di cek' : 'ga dicek';
      if(cek == 'di cek'){
          var btn =  '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="RB Panjang">'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'RB Panjang'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="RB Pendek">'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'RB Pendek'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="XC Panjang">'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'XC Panjang'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="XC Pendek">'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'XC Pendek'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="DH Panjang">'+
                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                              'DH Panjang'+
                        '</label>'+
                      '</div>'+
                      '<div class="checkbox" style="padding-top:0px;">'+
                        '<label>'+
                          '<input type="checkbox" class="styleJerseyModel" name="styleJersey[]"  value="DH Pendek">'+
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
        if($(a).is(':checked') == true){
            var mock = '<input type="file" class="form-control" accept="image/*" required  id="desain_mockup" placeholder="Masukkan url lain" name="desain_mockup">';
            var div = '<div id="desain_mockup_img" style="background:url(https://www.intanonline.com/not-found.png);height:300px;" class="col-sm-12">'+
                      '</div>';
            $('.fotoMockup').html(div);
            $('.mockup').html(mock);
            
            
             //preview mock up desain
            $("#desain_mockup").on('change',function() {
              readURLMockup(this);
            });
            
            function readURLMockup(input) {
                if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  
                  reader.onload = function(e) {
                      console.log(e.target.result);
                    $('#desain_mockup_img').css('background-image', 'url('+e.target.result+')');
                  }
                  reader.readAsDataURL(input.files[0]);
                }
            }
            
            
            var urls = "{{URL::to('/event/AjaxJerseyModel')}}";
            $.ajax({
              url: urls,
              method:"post", 
              data: {
                "_token": "{{ csrf_token() }}",
                "data" : "getModel"
              },
                    success: function(result){
                      var data = "";

                      $.each(result.model, function(k,v){
                          var datas = "";
                          
                          //ambil model xc, rb, dh
                          data += '<div class="form-check">'+
                    					'<label>'+
                    						'<input type="radio" name="model[]" oninput="checkJersey(this)" class="model" value="'+v.jersey.id_model+'"> <span class="label-text">'+v.jersey.nama_model+' ('+v.jersey.kd_model+')</span>'+
                    					'</label>'+
                    				'</div>';
                    				
                    				$.each(v.tipe, function(ks,vs){
                    				    
                    				    //ambil data internasional atau local
                    				    data += '<div class="form-check jerseyDrmn drmnKe_'+v.jersey.id_model+'" style="margin-left:10px;">'+
                                					'<label>'+
                                						'<input type="radio" name="drmn['+v.jersey.id_model+']" oninput="checkModelJersey(this)" data-id="'+v.jersey.id_model+'_'+ks.replace(" ", "_")+'"  class="drmn" value="'+ks+'"> <span class="label-text">'+ks+'</span>'+
                                					'</label>'+
                                				'</div>';
                                				
                                				
                                		$.each(vs, function(kx,vx){	
                                		    
                                		    //jenis jersey panjang atau pendek
                                		    $.each(vx, function(kz,vz){	
                                                console.log(kz);
                                		        data += '<div class="checkbox TipejerseyDiv TipejerseyKe_'+v.jersey.id_model+'_'+ks.replace(" ", "_")+'" style="margin-left:20px;">'+
                                                        '<label>'+
                                                          '<input type="checkbox" oninput="tipeClick(this)" data-id="'+v.jersey.id_model+'_'+ks.replace(" ", "_")+'" class="TipeJerseyModel size_'+v.jersey.id_model+'_'+kx+'" name="styleJersey['+v.jersey.id_model+']['+kx+']" >'+
                                                          '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                                                              kz+
                                                        '</label>'+
                                                      '</div>';
                                		        
                                		        $.each(vz, function(ky,vy){	 
                                		            
                                		            $.each(vy, function(ku,vu){	
                                		                
                                            	        data += '<div class="checkbox jerseyDiv jerseyKe_'+v.jersey.id_model+'_'+ks.replace(" ", "_")+'" style="margin-left:30px;">'+
                                                                    '<label>'+
                                                                      '<input type="checkbox" class="styleJerseyModel size_'+v.jersey.id_model+'_'+ks.replace(" ", "_")+'_'+kz.replace(" ", "_")+'_'+kx+'" name="size['+v.jersey.kd_model+']['+ks.replace(" ", "_")+']['+kz.replace(" ", "_")+'][]"  value="'+vu.kd_size+','+vu.ukuran+'">'+
                                                                      '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                                                                          vu.kd_size+' ('+vu.ukuran+')'+
                                                                    '</label>'+
                                                                  '</div>';
                                            		});
                                        		});
                                    		});
                                		});
                                		
                            	    });
                    				
                      })
                      
                      
                      $('.JerseyShow').html(data);
                      $('.jerseyDiv').attr('style', 'display:none;');
                      $('.jerseyDrmn').attr('style', 'display:none;');
                      $('.TipejerseyDiv').attr('style', 'display:none;');
                      
                    }
              }); 
        }else{
            $('.JerseyShow').html("");
            $('.fotoMockup').html("");
            $('.mockup').html("");
            
        }
       
    }
    
    function checkJersey(a){
        $('.drmn').removeAttr('checked');
        $('.styleJerseyModel').removeAttr('checked');
        $('.TipeJerseyModel').removeAttr('checked');
        $('.jerseyDiv').attr('style', 'display:none;');
        $('.jerseyDrmn').attr('style', 'display:none;');
        $('.drmnKe_'+$(a).val()).attr('style', 'display:block;margin-left:10px;');
    }
    
    function checkModelJersey(a){
        var val = $(a).val();
        $('.jerseyDiv').attr('style', 'display:none;');
        $('.TipejerseyDiv').attr('style', 'display:none;');
        $('.styleJerseyModel').removeAttr('checked');
        $('.TipeJerseyModel').removeAttr('checked');
        $('.TipejerseyKe_'+$(a).attr('data-id')).attr('style', 'display:block;;margin-left:20px;');
    }
    
    function tipeClick(a){
        if($(a).is(':checked') == true){
            $('.jerseyKe_'+$(a).attr('data-id')).attr('style', 'display:block;;margin-left:30px;');    
        }else{
            $('.jerseyKe_'+$(a).attr('data-id')).attr('style', 'display:none;');
            $('.jerseyKe_'+$(a).attr('data-id')).removeAttr('checked');;
        }
        
    }
    
    
    $(document).ready(function(){
      var getUrl = window.location;
      baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0]+"event/";
    });

    function nameEvent(a){
      var valuenya = $("#kode_event").val();
      urlEvent = valuenya.replace(/ /g, '-').toLowerCase();
      $("#url_event").val(baseUrl+''+urlEvent);
      $("#url_div").html(baseUrl+''+urlEvent);
    }

    function ShowJumlahPeserta(a){
      var val = "{{old("jumlah_peserta")}}";
      var input = '<input type="number" name="jumlah_peserta" value="'+val+'" placeholder="masukkan jumlah maksimal peserta" id="jumlah_peserta" class="form-control input-event">';
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
            $('#blah').attr('style', 'background-image:url('+e.target.result+');background-size:cover;');
          }
          
          reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
      readURL(this);
    });

    function adaBiaya(a){
        var values = "{{old('biaya_pendaftaran.normal')}}";
        var tgl = "{{old('tgl_pembayaran.normal') ? old('tgl_pembayaran.normal') : date('Y-m-d')}}";
        
        if($(a).is(':checked') == true){
            $(a).attr('value', '1')   
        }else{
            $(a).attr('value', '0')   
        }
      var nil = $('.biayaCheck').val();
    
      val = nil == 1 ? 1 : 0;    
      
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
                        // '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" name="tgl_pendaftaran[normal]"></td>'+
                        '<td><input type="number" class="form-control" value="'+values+'" name="biaya_pendaftaran[normal]"></td>'+
                        '<td><input type="date" class="form-control" value="'+tgl+'" name="tgl_pembayaran[normal]"></td>'+
                      '</tr>'+
                      '<tr class="otr">'+
                      '</tr>'+
                    '</table>'+
                  '</div>'+
                  //'<table class="table">'+
                  //   '<tr>'+
                  //     '<tr class="aksi">'+
                  //       '<td><button type="button" onclick="addEB(this)" class="addEB btn btn-warning btn-block">Tambah Early Bird</button></td>'+
                  //       '<td><button type="button" onclick="addOTR(this)" class="addOTR btn btn-warning btn-block">Tambah On The Road</button></td>'+
                  //     '</tr>'+
                  //   '</tr>'+
                  // '</table>'+
                  '<div class="modal-footer">'+
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
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
      $('#myModal').modal('show');
    }); 

    function addEB(a){
      var td =  '<td>Early Bird<input type="hidden" value="eb" name="jenis_pendaftaran[]"></td>'+
                '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" name="tgl_pendaftaran[eb]"></td>'+
                '<td><input type="number" class="form-control" value="{{date('Y-m-d')}}" name="biaya_pendaftaran[eb]"></td>';
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
                '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" name="tgl_pendaftaran[otr]"></td>'+
                '<td><input type="number" class="form-control" value="{{date('Y-m-d')}}" name="biaya_pendaftaran[otr]"></td>';
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
      var id_kota = "{{old('id_kota')}}"; 
        $.ajax({
          url: urls,
          method:"post", 
          data: {
            "_token": "{{ csrf_token() }}",
            "id": id
          },
          success: function(result){
            //   var data = "<option disabled >-pilih kota-</option>";
              var data = "<option disabled selected >-pilih kota-</option>";
              $.each(result.getKota, function(k,v){
                  if(id_kota == v.id){
                    data += '<option value="'+v.id+'" selected data-id="'+v.id+'">'+v.nama+'</option>'
                  }else{
                    data += '<option value="'+v.id+'"  data-id="'+v.id+'">'+v.nama+'</option>'    
                  }
              })
              
              $("#id_kota").html(data);
          }
      }); 
    });
    
    
    // }
    
    
    function kota(a){
      var id_kecamatan = "{{old('id_kecamatan')}}"; 
      var id_kota = "{{old('id_kota')}}"; 
      var id = typeof $("#id_kota").find(':selected').val() == 'undefined' ? id_kota : $("#id_kota").find(':selected').val() ;
        console.log(id)
      var urls = "{{URL::to('/registrasiEO/ajaxKecamatan')}}";
        $.ajax({
          url: urls,
          method:"post", 
          data: {
            "_token": "{{ csrf_token() }}",
            "id": id
          },
          success: function(result){
              var data = "<option disabled selected >-pilih kecamatan-</option>";
              $.each(result.getKota, function(k,v){
                  
                  if(id_kecamatan == v.id){
                    data += '<option value="'+v.id+'" selected data-id="'+v.id+'">'+v.nama+'</option>'
                  }else{
                    data += '<option value="'+v.id+'"  data-id="'+v.id+'">'+v.nama+'</option>'    
                  }
                  
              })
              
              $("#id_kecamatan").html(data);
          }
      }); 
    }
    
    function kecamatan(a){
        var id_kecamatan = "{{old('id_kecamatan')}}"; 
        var id_desa = "{{old('id_desa')}}"; 
        var id = typeof $("#id_kecamatan").find(':selected').val()  == 'undefined' ? id_kecamatan : $("#id_kecamatan").find(':selected').val();
        var urls = "{{URL::to('/registrasiEO/ajaxKelurahan')}}";
        $.ajax({
          url: urls,
          method:"post", 
          data: {
            "_token": "{{ csrf_token() }}",
            "id": id
          },
          success: function(result){
              var data = "<option disabled selected >-pilih desa-</option>";
              $.each(result.getKota, function(k,v){
                  if(id_desa == v.id){
                    data += '<option value="'+v.id+'" selected data-id="'+v.id+'">'+v.nama+'</option>'
                  }else{
                    data += '<option value="'+v.id+'"  data-id="'+v.id+'">'+v.nama+'</option>'    
                  }
              });
              
              $("#id_desa").html(data);
          }
        })
    }
    // $("#id_kota").on('change', function(){
      
    // });
    
    // $("#id_kecamatan").on('change', function(){
      
    // });
</script>

@endpush