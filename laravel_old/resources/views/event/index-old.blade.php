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
                      <th>tanggal akhir</th>
                      <th>tempat kumpul</th>
                      <th>aksi</th>
                  </tr>
              </thead>
              <tbody>
                  
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
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ URL::to($id.'/event/dataTable') }}", //diambil dari routes/web
            columns: [
                {data: 'kode_event', name: 'kode_event'},
                {data: 'nama_event', name: 'nama_event'},
                {data: 'tanggal_mulai', name: 'tanggal_mulai'},
                {data: 'tanggal_akhir', name: 'tanggal_akhir'},
                {data: 'tempat_kumpul', name: 'tempat_kumpul'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            },
             "order": [[ 2, "desc" ]]
        });
        
    </script>
@endpush