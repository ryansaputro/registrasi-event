@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Jenis Pinjaman
    <small>master data</small>
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Silahkan Pilih Menu  
              <a href="{{ route('jenis_pinjaman.create') }}" class="btn btn-success btn-sm pull-right modal-show" style="margin-top: -6px;" title="Tambah Jenis Pinjaman"><i class="icon-plus"></i> Tambah Jenis Pinjaman</a>
          </h3>
        </div>

        <div class="panel-footer" style="background-color:#f9f9f9;">
          <table id="datatable" class="table table-hover" style="width:100%">
              <thead>
                  <tr>
                      <th id="no">ID Jenis Pinjaman</th>
                      <th>Jenis Angsuran</th>
                      <th>Nama Pinjaman</th>
                      <th>Bunga (%)</th>
                      <th>Aksi</th>
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
    <!-- script form daterangepicker -->
    <script type="text/javascript">

      $(function() {   
        $('#daterangepicker').daterangepicker({
                autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('YYYY-MM-DD') + ',' + picker.endDate.format('YYYY-MM-D'));
        });

        $('#daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
      });
    </script>

    <!-- Fungsi Show JSon to Datatable First-->
    <script type="text/javascript">
        var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('table.jenis_pinjaman') }}", //diambil dari routes/web
            columns: [
                {data: 'id_jenis_pinjaman', name: 'id_jenis_pinjaman'},
                {data: 'jenis_angsuran', name: 'jenis_angsuran'},
                {data: 'nama_pinjaman', name: 'nama_pinjaman'},
                {data: 'bunga', name: 'bunga'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
        });
        
        $('#search-form').on('submit', function(e) {
          oTable.draw();
          e.preventDefault();
        });
    </script>

    <script>
      function filtering(){
        var no = document.getElementById("no");//merubah title kolom tabel cara 2
        var tgl_filter = $('.tgl_filter').val();
        var id = $('.s_id').val();

        if ((tgl_filter != '') && (id == ''))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();
          
          {no.style.color="red";$('th#no').text("ID");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/anggota_filter/"+tgl_filter, //diambil dari routes/web
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nik', name: 'nik'},
                {data: 'nama', name: 'nama'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
          });
        } else if ((id != '') && (tgl_filter == ''))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();
          {no.style.color="red";$('th#no').text("ID");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/anggota_filters/"+id, //diambil dari routes/web
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nik', name: 'nik'},
                {data: 'nama', name: 'nama'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
          });
        } else {
          swal({
            type: 'error',
            title: 'Oops...',
            text: 'Silahkan pilih filter yang dibutuhkan!'
          });
        }
      }
    </script>

    <script type="text/javascript">
      function printing(){

        var tgl_filter = $('.tgl_filter').val();
        var id = $('.s_id').val();

        if ((tgl_filter != '') && (id == ''))
        {
          window.open('/anggota-print/'+tgl_filter,'_blank');

        } else if ((id != '') && (tgl_filter == ''))
        {
          window.open('/anggota-prints/'+id,'_blank');

        } else if ((tgl_filter == '') && (id == ''))
        {
          window.open('/anggota-print','_blank');

        } else {
          swal({
            type: 'error',
            title: 'Oops...',
            text: 'Silahkan filter data yang akan di print!'
          });
        }
      }
    </script>

    <script type="text/javascript">
      function refresh(){
        location.reload();
      }
    </script>
    

    <!-- <script src="https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"></script> -->

@endpush