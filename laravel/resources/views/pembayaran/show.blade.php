@extends('layouts_app.app')

@section('content')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap" rel="stylesheet">
<style>
@media (max-width : 768px) {
  .biaya {
    position: absolute;
    margin-top: 20%;
    margin-left: 180px;
  }
}
@media (min-width : 1224px) {
  .biaya {
    position: absolute;
    margin-top: 37%;
  }
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
  <div class="row" style="background: #fff;">
    <div class="col-md-12" style="margin-bottom:50px;">
      <div class="box panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">{{strtoupper($evt->nama_event)}}
              <a href="{{ URL::to($eo.'/event/registrasi') }}" class="btn btn-danger btn-sm pull-right" style="margin-top: -6px;" title="Kembali"><i class="fa fa-times"></i> Kembali</a>
          </h3>
        </div>
      </div>
      <div class="col-md-6" style="background:url({{asset('images/event/'.$evt->e_poster)}});height:500px;background-repeat: no-repeat;background-size: cover;">
      </div>      
      <div class="col-md-6">
        <section class="tanggal">
          <h4 style="font-weight:500;">{{$evt->tanggal_mulai}}</h4>
        </section>
        <section class="nama_event">
          <h3 style="font-weight:700;">{{strtoupper($evt->nama_event)}}</h3>
          <p>{{strtoupper($evt->deskripsi_event)}}</p>
          <br>
          <br>
          <span>Oleh :</span>
          <br>
          <span style="font-weight:700;">{{strtoupper(str_replace('_', ' ', $eo))}}</span>
         
        </section>
        <section class="biaya">
          <p>Biaya Pendaftaran</p>
          <h5 style="font-weight:700;">Rp. {{number_format($jenisPembayaran, 0,',', '.')}}</h5>
        </section>
      </div>  
      <hr>    
      <hr>    
      <div class="col-md-12" style="border-top:1px solid #d2d6de;margin-bottom:10px;padding-top:20px;">
        <button class="btn" style="background: #011e3d;color:#fff;"><i class="fa fa-share-alt" aria-hidden="true"></i></button>
      </div>
      <div class="col-md-12" style="border-top:1px solid #d2d6de;margin-top:10px;padding-top:20px;">
      </div>
      <div class="col-md-6">
        <label style="margin-top:15px;">Deskripsi :</label>
        <p>{{$evt->deskripsi_event}}</p>

        <label style="margin-top:15px;">Jenis Event :</label>
        <p>{{array_key_exists($evt->id_jenis_event, $eventPortal) ? $eventPortal[$evt->id_jenis_event] : '-'}}</p>
        
        <label style="margin-top:15px;">Jumlah Peserta :</label>
        <p>{{$evt->jumlah_peserta != null ? 'Terbatas' : '-'}}</p>
        
        <label style="margin-top:15px;">Catatan Tambahan :</label>
        
        <p>Waktu Kumpul : {{$evt->waktu_kumpul}}</p>
        <p>Tempat Kumpul : {{$evt->tempat_kumpul}}</p>

         <label style="margin-top:25px;">Sponsor :</label>
         <br>
        <button class="btn btn-danger" style="border-radius:10px;background: #fff0;color:#da0b45;">{{$evt->sponsor}}</button>
      </div>
      <div class="col-md-6">
        <label style="margin-top:15px;">Waktu Pelaksanaan :</label>
        <p>{{$evt->deskripsi_event}}</p>

        <label style="margin-top:15px;">Akhir Pelaksanaan :</label>
        <p>{{$evt->id_jenis_event}}</p>
        
        <label style="margin-top:15px;">Tempat Pelaksanaan :</label>
        <p>{{$evt->jumlah_peserta != null ? 'Terbatas' : '-'}}</p>
        
        <label style="margin-top:15px;">Kontak :</label>
        <br>
        <span>{{strtoupper(str_replace('_', ' ', $eo))}}</span>
        <br>
        <span>{{$hp_eo}}</span>
        <br>
        <span style="color:#da0b45;">{{$user}}</span>
        <br>
        <label style="margin-top:15px;">URL :</label>
        <p><a style="color:#da0b45;" href="{{$evt->url_event}}">{{$evt->url_event}}</a></p>
      </div>
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
      baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0]+"/event/";
    });

    function nameEvent(a){
      var valuenya = $("#kode_event").val();
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
                        '<th>Batas Pendaftaran</th>'+
                        '<th>Biaya Pendaftaran</th>'+
                        '<th>Batas Pembayaran</th>'+
                      '</tr>'+
                      '<tr class="eb">'+
                      '</tr>'+
                      '<tr>'+
                        '<td>Normal<input type="hidden" value="normal" name="jenis_pendaftaran[]"></td>'+
                        '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" name="tgl_pendaftaran[normal]"></td>'+
                        '<td><input type="number" class="form-control" value="" name="biaya_pendaftaran[normal]"></td>'+
                        '<td><input type="date" class="form-control" value="{{date('Y-m-d')}}" name="tgl_pembayaran[normal]"></td>'+
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