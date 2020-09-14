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
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Registrasi Event
  </h1>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Silahkan isi
              <a href="{{ URL::to($id.'/event/registrasi') }}" class="btn btn-danger btn-sm pull-right" style="margin-top: -6px;" title="Kembali"><i class="fa fa-times"></i> Kembali</a>
          </h3>
        </div>
      </div>
{{-- 
  
  `id`, `kode_event`, `nama_event`, `tanggal_mulai`, `tanggal_akhir`, `tempat_event`, `id_provinsi`, `id_kota`, `id_kecamatan`, `id_desa`, `kode_pos`, `waktu_kumpul`, `tempat_kumpul`, `deskripsi_event`, `url_event`, `url_lain`, `created_at`, `updatetime-locald_at`, `id_eo`
  
--}}
      
        <form class="form-horizontal" action="{{URL::to($id.'/event/registrasi-baru')}}" enctype="multipart/form-data" method="post">
          @csrf
          <div class="col-md-4 col-lg-4">
            <div class="form-group">
              <label class="col-sm-12" for="kode_event">Kode Event:</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="kode_event" placeholder="Masukkan kode event" name="kode_event">
                @if ($errors->has('kode_event'))
                    <span class="help-block text-red">
                        <strong>{{ $errors->first('kode_event') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12" for="nama_event">Nama Event:</label>
              <div class="col-sm-12">
                <input type="text" class="form-control" id="nama_event" placeholder="Masukkan nama event" name="nama_event">
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
                <input type="datetime-local" class="form-control" id="tanggal_mulai" placeholder="Masukkan tanggal mulai event" name="tanggal_mulai">
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
                <input type="datetime-local" class="form-control" id="tanggal_akhir" placeholder="Masukkan tanggal akhir event" name="tanggal_akhir">
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
                <input type="text" class="form-control" id="tempat_event" placeholder="Masukkan tempat event" name="tempat_event">
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
                <input type="datetime-local" class="form-control" id="waktu_kumpul" placeholder="Masukkan tempat event" name="waktu_kumpul">
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
                <input type="text" class="form-control" id="tempat_kumpul" placeholder="Masukkan tempat kumpul event" name="tempat_kumpul">
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
              <label class="col-sm-12" for="jenis_event">Jenis Event:</label>
              <div class="col-sm-12">
                <select class="form-control" name="jenis_event" id="jenis_event">
                  <option disabled selected>-pilih tipe event-</option>
                    @foreach ($event as $k => $v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
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
                <input type="text" class="form-control" id="sponsor" placeholder="Enduro, Djarum" name="sponsor">
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
                  <input type="checkbox" class="pesertaCheck" name="pesertaCheck" oninput="ShowJumlahPeserta(this)" value="0">
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
                  <input type="checkbox" class="biayaCheck" name="biayaCheck" oninput="adaBiaya(this)" value="0">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                  Ya
                </label>
              </div>
              <div class="col-sm-12">
                <a class="btn btn-warning btn-block biaya" style="display:none;">Masukkan Biaya Pendaftaran</a>
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
                <textarea class="form-control" id="deskripsi_event" placeholder="Masukkan tempat event" name="deskripsi_event"></textarea>
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
                <img id="blah" src="https://www.intanonline.com/not-found.png" alt="your image" style="margin-top: 10px; width: 380px;padding-left: 1px;height: auto;"/>
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
                <option value="{{$v['id']}}">{{$v['nama']}}</option>
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
                <input type="text" class="form-control" id="kode_pos" placeholder="Masukkan kode event" name="kode_pos">
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
                <input type="text" class="form-control" onclick="nameEvent(this)" id="url_event" placeholder="Masukkan url event" name="url_event">
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
                <input type="text" class="form-control" id="url_lain" placeholder="Masukkan url lain" name="url_lain">
              </div>
            </div>
          </div>
          <div class="col-md-12">
              <button class="btn btn-sm btn-primary pull-right" type="submit">
                <i class="fa fa-check"> </i> Simpan
              </button>
            </div>

            <!--modal pembayaran-->
            <div id="tempatModal">
            </div>
        </form>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
@endsection

 

<!-- push script ke app.blade.php -->
@push('scripts')
<script>
    var baseUrl = "";
    var urlEvent = "";
    $(document).ready(function(){
      var getUrl = window.location;
      baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];
    });

    function nameEvent(a){
      var valuenya = $("#nama_event").val();
      urlEvent = valuenya.replace(/ /g, '-').toLowerCase();
      $(a).val(baseUrl+''+urlEvent);
    }

    function ShowJumlahPeserta(a){
      var input = '<input type="number" name="jumlah_peserta" placeholder="masukkan jumlah maksimal peserta" id="jumlah_peserta" class="form-control">';
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
              '<div class="modal-dialog">'+

                '<div class="modal-content">'+
                  '<div class="modal-header">'+
                    '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                    '<h4 class="modal-title">Jenis Pembayaran</h4>'+
                  '</div>'+
                  '<div class="modal-body">'+
                    '<table class="table table-bordered">'+
                      '<tr>'+
                        '<th>Jenis Pendaftaran</th>'+
                        '<th>Batas Pendaftaran</th>'+
                        '<th>Biaya Pendaftaran</th>'+
                      '</tr>'+
                      '<tr class="eb">'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Normal<input type="hidden" value="normal" name="jenis_pendaftaran[]"></td>'+
                        '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" name="tgl_pendaftaran[normal]"></td>'+
                        '<td><input type="number" class="form-control" value="{{date('Y-m-d')}}" name="biaya_pendaftaran[normal]"></td>'+
                      '</tr>'+
                      '<tr class="otr">'+
                      '</tr>'+
                    '</table>'+
                  '</div>'+
                  '<table class="table">'+
                    '<tr>'+
                      '<tr class="aksi">'+
                        '<td><button type="button" onclick="addEB(this)" class="addEB btn btn-warning btn-block">Tambah Early Bird</button></td>'+
                        '<td><button type="button" onclick="addOTR(this)" class="addOTR btn btn-warning btn-block">Tambah On The Road</button></td>'+
                      '</tr>'+
                    '</tr>'+
                  '</table>'+
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