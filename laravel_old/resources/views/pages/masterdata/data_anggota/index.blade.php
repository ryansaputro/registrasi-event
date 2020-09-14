@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Anggota
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
              <a href="{{ route('anggota.create') }}" class="btn btn-success btn-sm pull-right modal-show" style="margin-top: -6px;" title="Tambah Anggota"><i class="icon-plus"></i> Tambah Anggota</a>
          </h3>
        </div>

        <div class="panel-body">
          <div class="form-inline" >
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                      <span class="glyphicon glyphicon-user"></span>
                </div>
                <input type="text" class="form-control" id="s_nik" name="s_nik" placeholder="NIK Anggota">
              </div>
              <div class="input-group">
                <div class="input-group-addon">
                      <span class="glyphicon glyphicon-user"></span>
                </div>
                <input type="text" class="form-control" id="s_ktp" name="s_ktp" placeholder="NO KTP">
              </div>
            </div>
            <button type="submit" class="btn btn-default" onclick="filtering()"><i class="fa fa-search"></i> CARI</button>
            <button style="margin-left:5px;" class="btn btn-default" onclick="printing()"><i class="fa fa-print"></i></button>
            <button style="margin-left:5px;" class="btn btn-default" onclick="refresh()"><i class="fa fa-refresh"></i></button>
          </div>
          <div class="form-inline">
            
          </div>
        </div>

        <div class="panel-footer" style="background-color:#f9f9f9;">
          <table id="datatable" class="table table-hover" style="width:100%">
              <thead>
                  <tr>
                      <th id="no">No</th>
                      <th id="nik">NIK</th>
                      <th>Nama Lengkap</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th style="width:250px">Aksi</th>
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
            ajax: "{{ route('table.anggota') }}", //diambil dari routes/web
            columns: [
                {data: 'DT_RowIndex', name: 'id_anggota'}, //data = nama field db
                {data: 'nik', name: 'nik'},
                {data: 'full_name', name: 'nama'},
                {data: 'email', name: 'email'},
                {data: 'nama_status_aktif', name: 'nama_status_aktif'},
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
        
        var th_no = document.getElementById("no");//merubah title kolom tabel cara 2
        var th_nik = document.getElementById("nik");
        var nik = $('#s_nik').val();
        var ktp = $('#s_ktp').val();

        if ((nik != '') && ((ktp == '')))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();

          {th_nik.style.color="red";
            $('th#no').text("ID");
            $('th#nik').text("NIK Anggota");
          }//rubah warna dan text

          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/anggota_filter/"+nik, //diambil dari routes/web
            columns: [
                {data: 'id_anggota', name: 'id_anggota'}, //data = nama field db
                {data: 'nik', name: 'nik'},
                {data: 'full_name', name: 'nama'},
                {data: 'email', name: 'email'},
                {data: 'nama_status_aktif', name: 'nama_status_aktif'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
          });

        }else if ((nik == '') && ((ktp != '')))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();

          {th_nik.style.color="red";
            $('th#no').text("ID");
            $('th#nik').text("No KTP");
          }//rubah warna dan text

          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/anggota_filters/"+ktp, //diambil dari routes/web
            columns: [
                {data: 'id_anggota', name: 'id_anggota'}, //data = nama field db
                {data: 'no_ktp', name: 'no_ktp'},
                {data: 'full_name', name: 'nama'},
                {data: 'email', name: 'email'},
                {data: 'nama_status_aktif', name: 'nama_status_aktif'},
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

        var nik = $('#s_nik').val();
        var ktp = $('#s_ktp').val();
        var key_all = btoa("orzdev");

        if ((nik != '') && ((ktp == '')))
        {
          window.open('/anggota-print/'+btoa(nik),'_blank');

        } else if ((nik == '') && ((ktp != '')))
        {
          window.open('/anggota-prints/'+btoa(ktp),'_blank');

        } else if ((nik == '') && ((ktp == '')))
        {
          window.open('/anggota-print-all/'+key_all,'_blank');

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

@endpush