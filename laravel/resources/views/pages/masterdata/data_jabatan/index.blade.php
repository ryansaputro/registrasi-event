@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Jabatan
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
              <a href="{{ route('jabatan.create') }}" class="btn btn-success btn-sm pull-right modal-show" style="margin-top: -6px;" title="Tambah Jabatan"><i class="icon-plus"></i> Tambah Jabatan</a>
          </h3>
        </div>

        <!-- <div class="panel-body">
          <div class="form-inline" >
            <div class="form-group">
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input placeholder="Pilih tanggal" type="text" class="form-control pull-left tgl_filter" id="daterangepicker" value="" name="tgl_filter">
                </div>
            </div>
            <div class="form-group">
              <label>Cari :</label>
              <div class="input-group date">
                <div class="input-group-addon">
                      <span class="glyphicon glyphicon-user"></span>
                </div>
                <input type="text" class="form-control s_id" name="s_id" placeholder="Id Anggota">
              </div>
            </div>
            <button type="submit" class="btn btn-default" onclick="filtering()"><i class="fa fa-search"></i> CARI</button>
            <button style="margin-left:5px;" class="btn btn-default" onclick="printing()"><i class="fa fa-print"></i></button>
            <button style="margin-left:5px;" class="btn btn-default" onclick="refresh()"><i class="fa fa-refresh"></i></button>
          </div>
          <div class="form-inline">
            
          </div>
        </div> -->

        <div class="panel-footer" style="background-color:#f9f9f9;">
          <table id="datatable" class="table table-hover" style="width:100%">
              <thead>
                  <tr>
                      <th id="no">ID Jabatan</th>
                      <th>Nama Jabatan</th>
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
            ajax: "{{ route('table.jabatan') }}", //diambil dari routes/web
            columns: [
                {data: 'id_jabatan', name: 'id_jabatan'}, //data = nama field db
                {data: 'nama_jabatan', name: 'nama_jabatan'},
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