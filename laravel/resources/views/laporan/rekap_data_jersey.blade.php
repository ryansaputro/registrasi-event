@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Laporan Daftar Peserta By Jersey
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
              {{-- <a href="{{ URL::to($id.'/event/registrasi-baru') }}" class="btn btn-success btn-sm pull-right" style="margin-top: -6px;" title="Registrasi Event"><i class="icon-plus"></i> Registrasi Event</a> --}}
          </h3>
        </div>
        <div class="panel-footer" style="background-color:#f9f9f9;">
          <table id="data_peserta_by_gender" class="table table-hover" style="width:100%">
              <thead>
                  <tr>
                      <th id="no">kode event</th>
                      <th>Nama Event</th>
                      <th>S</th>
                      <th>M</th>
                      <th>L</th>
                      <th>XL</th>
                      <th>XS</th>
                      <th>XXL</th>
                      <th>Total Peserta</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($data as $k => $v)
                      <tr>
                        <td>{{$v->kode_event}}</td>
                        <td>{{$v->nama_event}}</td>
                        
                        
                        @if(!empty($ukuranS[$v->id]))
                            <td>{{array_key_exists($v->id, $ukuranS) ? $ukuranS[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
                        
                        @if(!empty($ukuranM[$v->id]))
                            <td>{{array_key_exists($v->id, $ukuranM) ? $ukuranM[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
                        
                        @if(!empty($ukuranL[$v->id]))
                            <td>{{array_key_exists($v->id, $ukuranL) ? $ukuranL[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
                        
                        @if(!empty($ukuranXL[$v->id]))
                            <td>{{array_key_exists($v->id, $ukuranXL) ? $ukuranXL[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
                        
                        @if(!empty($ukuranXS[$v->id]))
                            <td>{{array_key_exists($v->id, $ukuranXS) ? $ukuranXS[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
                        
                        @if(!empty($ukuranXXL[$v->id]))
                            <td>{{array_key_exists($v->id, $ukuranXXL) ? $ukuranXXL[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
                        
                        @if(!empty($peserta[$v->id]))
                            <td>{{array_key_exists($v->id, $peserta) ? $peserta[$v->id] : 0}} orang</td>
                        @else
                            <td>-</td>
                        @endif
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
</section>
<!-- /.content -->
@endsection

<!-- push script ke app.blade.php -->
@push('scripts')
    <!-- Fungsi Show JSon to Datatable First-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data_peserta_by_gender').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            } );
        } );
      
    </script>
    
@endpush