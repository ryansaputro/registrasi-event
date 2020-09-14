@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Daftar Peserta Event
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
        <div class="panel-heading">
          <h3 class="panel-title">Daftar Peserta Event
              {{-- <a href="{{ URL::to($eo.'/event/registrasi-baru') }}" class="btn btn-success btn-sm pull-right" style="margin-top: -6px;" title="Registrasi Event"><i class="icon-plus"></i> Registrasi Event</a> --}}
            <form style="margin-top:-15px;" class="form-horizontal">
              <div class="form-group">
                <button class="btn btn-primary pull-right" style="margin-right:15px;" value="cari" name="cari" type="submit">Cari</button>
                <select class="form-control pull-right" name="cari_event" style="width:200px;">
                  <option value="xxx">-semua event-</option>
                  @foreach ($event as $k => $v)
                  <option value="{{md5($v->id)}}" {{md5($v->id) == $cari ? 'selected' : '' }}>{{strtoupper($v->kode_event)}}</option>
                  @endforeach
                </select>
              </div>
            </form>
          </h3>
        </div>
        <div class="panel-footer" style="background-color:#f9f9f9;">
          <table id="datatable" class="table table-hover" style="width:100%">
              <thead>
                  <tr>
                      <th id="no">tanggal registrasi</th>
                      <th>nama</th>
                      <th>jenis event</th>
                      <th>status pembayaran</th>
                      <th>tanggal bayar</th>
                      <th>jumlah bayar</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($data AS $k => $v)
                  <tr>
                  <td>{{$v->tanggal}}</td>
                  <td>{{$v->display_name}}</td>
                  <td><span style="background:{{$v->is_free == 'ya' ? 'red' : 'green'}}; color:#fff;padding: 5px;border-radius: 10px;">{{$v->is_free == 'ya' ? 'gratis' : 'berbayar'}}</span></td>
                  <td>
                    @if($v->status_pembayaran == '0')
                      <span style="background:red; color:#fff;padding: 5px;border-radius: 10px;">menunggu</span>
                    @elseif($v->status_pembayaran == '1')
                      <span style="background:green; color:#fff;padding: 5px;border-radius: 10px;">diterima</span>
                    @else
                      <span style="background:red; color:#fff;padding: 5px;border-radius: 10px;">ditolak</span>
                    @endif
                    </td>
                    <td>{{$v->tgl_byr}}</td>
                    <td>Rp. {{number_format($v->jumlah, 0, '.', ',')}},-</td>
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
        var oTable = $('#datatable').DataTable({
            // responsive: true,
            // processing: true,
            // serverSide: true,
            // ajax: "{{ URL::to($eo.'/registrasi_peserta/daftar_peserta/dataTable') }}", //diambil dari routes/web
            // columns: [
            //     {data: 'tanggal', name: 'tanggal'},
            //     {data: 'display_name', name: 'nama'},
            //     {data: 'jenis_event', name: 'jenis_event'},
            //     {data: 'status_pembayaran', name: 'status_pembayaran'},
            // ],
            // "language": {
            //     "url": "{{ asset('assets/js/table-indonesia.json') }}"
            // },
            //  "order": [[ 2, "desc" ]]
        });
        
    </script>
@endpush