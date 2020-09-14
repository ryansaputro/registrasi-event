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
                      <span style="background:red; color:#fff;padding: 5px;border-radius: 10px;">belum lunas</span>
                    @elseif($v->status_pembayaran == '1')
                      <span style="background:green; color:#fff;padding: 5px;border-radius: 10px;">lunas</span>
                    @else
                      <span style="background:yellow; color:#fff;padding: 5px;border-radius: 10px;">kadaluarsa</span>
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