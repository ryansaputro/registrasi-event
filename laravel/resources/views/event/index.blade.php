@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header event">
  <div class="col-md-12 menus-top">
    <div class="col-md-2 menus aktif">
      <a class="a-header" href="{{URL::to(strtolower(str_replace(" ","_",Session::get('data')['full_name']).'/event/registrasi'))}}">
        <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>
        Event Berlangsung
      </a>
    </div>
    <div class="col-md-2 menus">
      <a class="a-header" href="{{URL::to(strtolower(str_replace(" ","_",Session::get('data')['full_name']).'/event/registrasi'))}}">
        <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>
        Event Berakhir
      </a>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-1 menus grid">
      <a class="a-header active tampilan" href="#grid">
          <i class="fa fa-th-large fa-2x" aria-hidden="true"></i>
      </a>
        
    </div>
    <div class="col-md-1 menus list">
      <a class="a-header not-active tampilan" href="#list">
        <i class="fa fa-list-ul fa-2x" aria-hidden="true"></i>
      </a>
    </div>
    <div class="col-md-3 menus">
        <a style="margin-top: 25px;" class="btn btn-primary btn-block" href="{{ URL::to($id.'/event/registrasi-baru') }}"><i class="fa fa-plus" aria-hidden="true"></i> Buat Event</a>
    </div>
  </div>
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
  <div class="row isi-event">
    @foreach ($data as $k => $v)
    <div class="col-md-9">
      <div class="col-md-3 div-no">
          <div class="vl"></div>
          <h3 class="text-center nomor">{{$k+1}}</h3>
      </div>
    <div class="col-md-9" style="height:100%;margin-top:{{$k > 0 ? '10px' : '0px'}};margin-bottom:20px;">
        <div class="box panel-default">
          <div class="panel-heading gambar" style="background:url({{asset('laravel/public/images/event/'.$v->e_poster)}});background-position: center;height:250px;background-repeat: no-repeat;background-size: cover;">
          </div>
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-2">
                <p class="title-list-event">Kode event</p>
                <h4>{{$v->kode_event}}</h4>
              </div>
              <div class="col-md-4">
                <p class="title-list-event">Nama event</p>
                <h4>{{$v->nama_event}}</h4>
              </div>
              <div class="col-md-3">
                <p class="title-list-event">Status</p>
              <h4 style="color:{{$v->status == '1' ? 'blue' : 'red'}};">{{$v->status == '1' ? 'Berlangsung' : 'Berakhir'}}</h4>
              </div>
              <div class="col-md-3">
                <p class="title-list-event">Pembayaran</p>
                <h4>Rp. {{number_format($v->harga, 0,".",".")}}</h4>
              </div>
            </div>
          </div>
          <div class="panel-footer" style="background-color:#fff;">
            <div class="row">
              <div class="col-md-2" style="border-right:1px solid whitesmoke;">
                <p class="title-list-event">Tanggal Mulai</p>
                <p class="body-list-event">{{$v->tanggal_mulai}}</p>
              </div>
              <div class="col-md-2" style="border-right:1px solid whitesmoke;">
                <p class="title-list-event">Kuota</p>
                <p class="body-list-event">{{$v->jumlah_peserta != null ? $v->jumlah_peserta. ' orang' : 'tidak terbatas'}}</p>
              </div>
              <div class="col-md-3" style="border-right:1px solid whitesmoke;">
                <p class="title-list-event">Peserta Registrasi</p>
                <p class="body-list-event">
                    @if(!empty($peserta[$v->id]))
                            {{array_key_exists($v->id, $peserta) ? $peserta[$v->id] : 0}} orang
                    @else
                      -
                    @endif
                </p>
              </div>
              <div class="col-md-2" style="border-right:1px solid whitesmoke;">
                <p class="title-list-event">Peserta Bayar</p>
                <p class="body-list-event">
                    @if(!empty($pesertaByr[$v->id]))
                        {{array_key_exists($v->id, $pesertaByr) ? $pesertaByr[$v->id] : 0}} orang
                    @else
                        -
                    @endif
                </p>
              </div>
              <div class="col-md-3">
                  <a href="{{ route('event.show', [$id, strtolower(str_replace(" ","-",$v->kode_event))]) }}" class="btn btn-success btn-xs btn-block" title="Detail Data"><i class="fa fa-eye" ></i> Lihat</a>
                  @if(date('Y-m-d H:i:s') < $v->tanggal_mulai)
                  <a href="{{ route('event.edit', [$id, strtolower(str_replace(" ","-",$v->kode_event))]) }}" class="btn btn-primary btn-xs btn-block" title="Edit Data"><i class="fa fa-pencil"></i> Edit</a> 
                  @endif
                  <a href="{{ route('daftar_peserta.index', [$id, 'cari=cari', 'cari_event='. md5($v->id)]) }}" class="btn btn-warning btn-xs btn-block" title="List Peserta Event {{$v->nama_event}}"><i class="fa fa-list" ></i> Peserta</a>
                  @if(!empty($peserta[$v->id]))
                    @if($peserta[$v->id] == $v->jumlah_peserta)
                      <a onclick="tambahWaktu(this)" data-name="{{$v->nama_event}}" data-kode="{{$v->kode_event}}" class="btn btn-danger btn-xs update btn-block" title="Kuota penuh untuk {{$v->nama_event}} update tanggal untuk membukanya"><i class="fa fa-battery-full" aria-hidden="true"></i> Kuota Penuh</a>
                    @endif
                  @endif
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    @endforeach
    <div class="col-md-3 right-sidebar" style="">
      <div class="panel-default sidebars" style="margin-right: -13px;">
        <div class="panel-heading">
            <h3 class="panel-title" style="font-weight: 600;">
              BERDASARKAN EVENT
            </h3>
        </div>
        <div class="panel-body">
          <ul id="myUL">
            <li><span class="caret">EVENT BERLANGSUNG</span>
              <ul class="nested">
                @foreach ($rightSidebarYearActive as $k => $v)
                  <li><span class="caret">{{$v->tahun}}</span>
                    <ul class="nested">
                      @foreach ($rightSidebarMonthActive as $x => $y)
                        @if($v->tahun == $y->tahun)
                          <li><span class="caret">{{$y->bulan}}</span>
                            <ul class="nested">
                              @foreach ($rightSidebarActive as $a => $b)
                                @if($b->tahun == $v->tahun && $y->bulan == $b->bulan)
                                  <li>{{$b->nama_event}} ({{$b->kode_event}})</li>
                                @endif
                              @endforeach
                            </ul>
                          </li>
                        @endif
                      @endforeach
                    </ul>
                  </li>  
                @endforeach
              </ul>
            </li>
          </ul>
          <ul id="myUL">
            <li><span class="caret">EVENT BERAKHIR</span>
              <ul class="nested">
                @foreach ($rightSidebarYearNonActive as $k => $v)
                  <li><span class="caret">{{$v->tahun}}</span>
                    <ul class="nested">
                      @foreach ($rightSidebarMonthNonActive as $x => $y)
                        @if($v->tahun == $y->tahun)
                          <li><span class="caret">{{$y->bulan}}</span>
                            <ul class="nested">
                              @foreach ($rightSidebarNonActive as $a => $b)
                                @if($b->tahun == $v->tahun && $y->bulan == $b->bulan)
                                  <li>{{$b->nama_event}} ({{$b->kode_event}})</li>
                                @endif
                              @endforeach
                            </ul>
                          </li>
                        @endif
                      @endforeach
                    </ul>
                  </li>  
                @endforeach
              </ul>
            </li>
          </ul>
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
        $('.tampilan').on('click', function(){
          if($(this).attr('href') == '#list'){
              $('.gambar').css('display', 'none');
              $('.list').addClass('active');
              $('.list').removeClass('not-active');
              $('.grid').addClass('not-active');
              $('.grid').removeClass('active');
              $('.list').children().addClass('active');
              $('.list').children().removeClass('not-active');
              $('.grid').children().removeClass('active');
              $('.grid').children().addClass('not-active');
          }else{
              $('.gambar').css('display', 'inherit');
              $('.list').addClass('not-active');
              $('.list').removeClass('active');
              $('.grid').addClass('active');
              $('.grid').removeClass('not-active');
              $('.grid').children().addClass('active');
              $('.grid').children().removeClass('not-active');
              $('.list').children().removeClass('active');
              $('.list').children().addClass('not-active');
          }
        });

        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
          toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
          });
        }

        $(document).ready(function(){
          $('.sidebars').attr('style', 'height:'+$('.isi-event').outerHeight()+'px')
          $('.vl').attr('style', 'height:'+$('.isi-event').outerHeight()+'px')
        });
        $(window).scroll(function (event) {
            var scroll = $(window).scrollTop();
            if(scroll >= 40 ){
              $('.right-sidebar').css('top', '95px');
            }else{
              $('.right-sidebar').css('top', 'unset');
            }
        });
        
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