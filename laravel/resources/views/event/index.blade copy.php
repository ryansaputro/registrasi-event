@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Event
  </h1>
</section>

<!-- Main content -->
<section class="content">
<!--sukses notifikasi-->
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
<!--gagal notifikasi-->
@elseif(session()->has('failed'))
    <div class="alert alert-danger">
        {{ session()->get('failed') }}
    </div>
@endif
<!--error notifikasi-->
@if ($errors->any())
  <div class="alert alert-danger">
     @foreach ($errors->all() as $error)
           {{$error}}<br>
      @endforeach
  </div>
@endif
 <!-- Default row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Menu Event  
              <a href="{{ URL::to($id.'/event/registrasi-baru') }}" class="btn btn-success btn-sm pull-right" style="margin-top: -6px;" title="Registrasi Event"><i class="icon-plus"></i> Registrasi Event</a>
          </h3>
        </div>
        <div class="panel-footer" style="background-color:#f9f9f9;">
          <table id="datatable" class="table table-hover" style="width:100%">
              <thead>
                  <tr>
                      <th id="no">kode event</th>
                      <th>nama event</th>
                      <th>tanggal mulai</th>
                      {{-- <th>tanggal akhir</th> --}}
                      {{-- <th>tempat kumpul</th> --}}
                      <th>kuota</th>
                      <th>peserta registrasi</th>
                      <th>peserta bayar</th>
                      <th>aksi</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($data as $k => $v)
                      <tr>
                        <td>{{$v->kode_event}}</td>
                        <td>{{$v->nama_event}}</td>
                        <td>{{$v->tanggal_mulai}}</td>
                        {{-- <td>{{$v->tanggal_akhir}}</td> --}}
                        {{-- <td>{{$v->tempat_kumpul}}</td> --}}
                        <td>{{$v->jumlah_peserta != null ? $v->jumlah_peserta. ' orang' : 'tidak terbatas'}}</td>
                        @if(!empty($peserta[$v->id]))
                            <td>{{array_key_exists($v->id, $peserta) ? $peserta[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
                        @if(!empty($pesertaByr[$v->id]))
                            <td>{{array_key_exists($v->id, $pesertaByr) ? $pesertaByr[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
                        <td>
                          <a href="{{ route('event.show', [$id, strtolower(str_replace(" ","-",$v->kode_event))]) }}" class="btn btn-success btn-xs" title="Detail Data"><i class="fa fa-eye" ></i> Lihat</a>
                          @if(date('Y-m-d H:i:s') < $v->tanggal_mulai)
                          <a href="{{ route('event.edit', [$id, strtolower(str_replace(" ","-",$v->kode_event))]) }}" class="btn btn-primary btn-xs" title="Edit Data"><i class="fa fa-pencil"></i> Edit</a> 
                          @endif
                          <a href="{{ route('daftar_peserta.index', [$id, 'cari=cari', 'cari_event='. md5($v->id)]) }}" class="btn btn-warning btn-xs" title="List Peserta Event {{$v->nama_event}}"><i class="fa fa-list" ></i> Peserta</a>
                          @if(!empty($peserta[$v->id]))
                            @if($peserta[$v->id] == $v->jumlah_peserta)
                              <a onclick="tambahWaktu(this)" data-name="{{$v->nama_event}}" data-kode="{{$v->kode_event}}" class="btn btn-danger btn-xs update" title="Kuota penuh untuk {{$v->nama_event}} update tanggal untuk membukanya"><i class="fa fa-battery-full" aria-hidden="true"></i> Kuota Penuh</a>
                            @endif
                          @endif
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table> 
        </div>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <form class="form-horizontal" action="{{URL::to($id.'/event/registrasi')}}" enctype="multipart/form-data" method="post">
    @csrf
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kuota Penuh</h4>
      </div>
      <div class="modal-body row">
        <div class="col-md-12">
          <div class="form-group">
            <label style="padding-left:15px;" for="kode_event">Kode Event:</label>
            <div class="col-md-12">
              <input type="text" readonly class="form-control kode_event" name="kode_event" value="{{old('kode_event')}}">
            </div>
          </div>
          <div class="form-group">
            <label style="padding-left:15px;" for="nama_event">Nama Event:</label>
            <div class="col-md-12">
              <input type="text" readonly class="form-control nama_event" name="nama_event" value="{{old('nama_event')}}">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label style="padding-left:15px;" for="jumlah_peserta">Kuota Event:</label>
            <div class="col-md-12">
              <input type="text" readonly class="form-control jumlah_peserta" name="jumlah_pesertas" value="{{old('jumlah_pesertas')}}">
              <input type="hidden" readonly class="form-control jumlah_peserta" name="jumlah_peserta" value="{{old('jumlah_peserta')}}">
            </div>
          </div>
          <div class="form-group">
            <label style="padding-left:15px;" for="tanggal_mulai">Batas Tanggal Daftar:</label>
            <div class="col-md-12">
              <input type="text" readonly class="form-control tanggal_mulais" name="tanggal_mulais" value="{{old('tanggal')}}">
              <input type="hidden" readonly class="form-control tanggal_mulai" name="tanggal_mulai" value="{{old('tanggal')}}">
            </div>
          </div>
          <div class="form-group">
            <label style="padding-left:15px;" for="tanggal">Batas Tanggal Bayar:</label>
            <div class="col-md-12">
              <input type="text" readonly class="form-control tanggal" name="tanggal" value="{{old('tanggal')}}">
            </div>
          </div>
          <div class="form-group">
            <label style="padding-left:15px;" for="harga">Harga:</label>
            <div class="col-md-12">
              <input type="text" readonly class="form-control hargas" name="hargas" value="{{old('hargas')}}">
              <input type="hidden" readonly class="form-control harga" name="harga" value="{{old('harga')}}">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label style="padding-left:15px;" for="kuota_baru">Tambah Kuota:</label>
            <div class="col-md-12">
              <input type="number"  class="form-control kuota_baru" name="kuota_baru" value="{{old('kuota_baru')}}">
            </div>
            <!--/.col-md-12-->
          </div>
          <!--/.form-group-->
          <div class="form-group">
            <label style="padding-left:15px;" for="tanggal_daftar_baru">Undur Tanggal Daftar:</label>
            <div class="col-md-12">
              <input type="date"  class="form-control tanggal_daftar_barus" name="tanggal_daftar_barus" value="{{old('tanggal_daftar_barus')}}">
              <input type="hidden"  class="form-control tanggal_daftar_baru" name="tanggal_daftar_baru" value="{{old('tanggal_daftar_baru')}}">
            </div>
            <!--/.col-md-12-->
          </div>
          <!--/.form-group-->
          <div class="form-group">
            <label style="padding-left:15px;" for="tanggal_bayar_baru">Undur Tanggal Bayar:</label>
            <div class="col-md-12">
              <input type="date"  class="form-control tanggal_bayar_baru" name="tanggal_bayar_baru" value="{{old('tanggal_bayar_baru')}}">
            </div>
            <!--/.col-md-12-->
          </div>
          <!--/.form-group-->
          <div class="form-group">
            <label style="padding-left:15px;" for="harga_baru">Harga:</label>
            <div class="col-md-12">
              <input type="number"  class="form-control harga_baru" name="harga_baru" value="{{old('harga_baru')}}">
            </div>
            <!--/.col-md-12-->
          </div>
          <!--/.form-group-->
        </div>
        <!--/.col-md-6-->
      </div>
      <div class="modal-footer">
        <button class="btn btn-block btn-primary" type="submit">Simpan</button>
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Batalkan</button>
      </div>
    </div>
    <!--/.modal-content-->
  </div>
  <!--/.modal-dialog-->
  </form>
</div>
<!-- /#myModal -->
</section>
<!-- /.content -->
@endsection

<!-- push script ke app.blade.php -->
@push('scripts')
    <!-- Fungsi Show JSon to Datatable First-->
    <script type="text/javascript">
        var oTable = $('#datatable').DataTable({});
      
        function tambahWaktu(a){
          //setting header ajax with token
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          
          //get data event detail from ajax
          $.ajax({
            type:'POST',
            url:'{{URL::to($id."/event/registrasi/ajaxKuota")}}',
            data:{kode:$(a).attr('data-kode')},
              success:function(data){
                
                //isi field
                $('.kode_event').attr('value', data.event.kode_event);
                $('.nama_event').attr('value', data.event.nama_event);
                $('.jumlah_pesertas').attr('value', data.event.jumlah_peserta == null ? 'tidak terbatas' : data.event.jumlah_peserta+' orang');
                $('.jumlah_peserta').attr('value', data.event.jumlah_peserta);
                $('.kuota_baru').attr('value', data.event.jumlah_peserta == null ? 'tidak terbatas' : data.event.jumlah_peserta);
                $('.tanggal_mulais').attr('value', data.detail == null ? data.event.tanggal_mulai : data.detail.tanggal );
                $('.tanggal_mulai').attr('value', data.detail == null ? data.event.tanggal_mulai : data.detail.tanggal );
                $('.tanggal_daftar_barus').attr('value', data.detail == null ? data.event.tanggal_mulai : data.detail.tanggal );
                // $('.tanggal_daftar_baru').attr('value', data.event.tanggal_mulai);
                $('.tanggal').attr('value', data.detail == null ? data.event.tanggal_mulai : data.detail.tanggal );
                $('.tanggal_bayar_baru').attr('value', data.detail == null ? data.event.tanggal_mulai : data.detail.tanggal);
                $('.hargas').attr('value', 'Rp. '+addCommas(data.detail == null ? 0 : data.detail.harga ));
                $('.harga').attr('value', data.detail == null ? 0 : data.detail.harga );
                $('.harga_baru').attr('value', data.detail == null ? 0 : data.detail.harga );

                if(data.detail == null){
                  $('.tanggal_daftar_barus').attr('readonly', 'readonly');
                  $('.tanggal_daftar_barus').removeAttr('type', 'readonly');
                  $('.tanggal_bayar_baru').attr('readonly', 'readonly');
                  $('.tanggal_bayar_baru').removeAttr('type', 'readonly');
                  $('.harga_baru').attr('readonly', 'readonly');
                }else{
                  $('.tanggal_daftar_barus').attr('type','date');
                  $('.tanggal_bayar_baru').attr('type','date');
                }

                //buka modal
                $(a).attr('data-toggle', 'modal');
                $(a).attr('data-target', '#myModal');

              }
          });
          // $('.modal-title').text($(a).attr('data-kode'));
        }


        //fungsi untuk format angka
        function addCommas(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
    </script>
@endpush