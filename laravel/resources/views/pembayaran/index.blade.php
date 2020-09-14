@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Pembayaran
  </h1>
</section>

<!-- Main content -->
<section class="content">
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@elseif(session()->has('failed'))
    <div class="alert alert-danger">
        {{ session()->get('failed') }}
    </div>
@endif
<!-- Default row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box panel-primary">
        <div class="panel-heading" style="height: 55px;">
          <h3 class="panel-title">Menu Pembayaran 
            <form style="margin-top:-15px;" class="form-horizontal">
              <div class="form-group">
                <button class="btn btn-primary pull-right" style="margin-right:15px;" value="cari" name="cari" type="submit">Cari</button>
                <select class="form-control pull-right" name="cari_event" style="width:200px;">
                  <option disabled selected>-pilih event-</option>
                  @foreach ($event as $k => $v)
                  <option value="{{md5($v->id)}}" {{md5($v->id) == $cari ? 'selected' : '' }}>{{strtoupper($v->nama_event)}}</option>
                  @endforeach
                </select>
              </div>
            </form>
              {{-- <a href="{{ URL::to($eo.'/event/registrasi-baru') }}" class="btn btn-success btn-sm pull-right" style="margin-top: -6px;" title="Registrasi Event"><i class="icon-plus"></i> Registrasi Event</a> --}}
          </h3>
        </div>
        <div class="panel-footer" style="background-color:#f9f9f9;">
            <table class="table table-striped" id="tableBayar">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Nama Bank</th>
                        <th>Atas Nama</th>
                        <th>Jumlah</th>
                        <th>Bukti</th>
                        <th>Status Approval</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data AS $k => $v)
                      @if($v->status_approval == '0')
                        @php
                          $status_approval = 'menunggu';   
                        @endphp
                      
                      @elseif($v->status_approval == '1')
                        @php
                          $status_approval = 'disetujui';   
                        @endphp
                      
                      @elseif($v->status_approval == '2')
                        @php
                          $status_approval = 'ditolak';   
                        @endphp
                      @endif
                      <tr>
                          <td>1</td>
                          <td>{{$v->created_at}}</td>
                          <td>{{$v->bank}}</td>
                          <td>{{$v->atas_nama}}</td>
                          <td>Rp.{{number_format($v->jumlah, 0, ',', '.')}},-</td>
                          <td>
                            <?php $from = explode("_", $v->bukti);?>
                            @if($from[1] == 'android')
                            <a target="_blank" href="https://api-all.portalsepeda.com/gambar/member/bukti/{{$v->bukti}}">{{substr($v->bukti, 0, 10)}}...</a>
                            @else
                            <a target="_blank" href="{{asset('laravel/public/images/member/bukti/'.$v->bukti)}}">{{substr($v->bukti, 0, 10)}}...</a>
                            @endif
                          </td>
                          <td>
                              <span style="background: {{$v->status_approval == '1' ? 'green' : 'red'}}; padding:3px; border-radius:5px;color:#fff;">{{$status_approval}}</span>
                          </td>
                          <td>
                              
                              @if($v->status_approval == '0')
                              <button type="button" class="btn btn-info btn-xs modal-bayar" data-bayar="{{URL::to($eo.'/'.$v->kode_event.'/cek_pembayaran')}}" data-member="{{md5($v->ID)}}" data-id="{{$v->kode_event}}">Terima</button>
                              @else
                                -
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pembayaran</h4>
        </div>
        <form class="form-horizontal form-bayar" enctype="multipart/form-data" method="post">
        @csrf
            <div class="modal-body">
              <div class="form-group">
                  <label class="col-sm-12" for="jumlah_approval">Jumlah Pembayaran:</label>
                  <div class="col-sm-12">
                    <div class="id">
                        <input type="hidden" name="id_member" class="idMember">
                    </div>
                    <input type="number" class="form-control" id="jumlah_approval" placeholder="Masukkan jumlah bayar" name="jumlah_approval">
                    @if ($errors->has('jumlah_approval'))
                        <span class="help-block text-red">
                            <strong>{{ $errors->first('jumlah_approval') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit"><i class="fa fa-check"> </i> Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</section>
<!-- /.content -->
@endsection

<!-- push script ke app.blade.php -->
@push('scripts')
    <!-- Fungsi Show JSon to Datatable First-->
    <script type="text/javascript">
        $('.modal-bayar').on('click', function(){
           $(this).attr('data-toggle', 'modal'); 
           $(this).attr('data-target', '#myModal');
           action=$(this).attr('data-bayar') ;
           var id = $(this).attr('data-id');
           var id_member = $(this).attr('data-member');
           var url = "http://localhost/eo/{{$eo}}/"+id+"/cek_pembayaran";
           $('.form-bayar').attr('action', url);
           $('.idMember').attr('value', id_member);
           
           
        });
    
    
        var oTable = $('#tableBayar').DataTable({});

        function myFunction(a) {
          var aksi = $(a).val();
          
            if (window.confirm(aksi+" pembayaran ini?"))
            {
                $('.'+aksi).attr('type', 'submit');
            }else{
                return false;
            }
          
        }
    </script>
@endpush