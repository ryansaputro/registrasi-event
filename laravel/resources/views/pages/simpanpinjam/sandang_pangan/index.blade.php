@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Sandang Pangan
    <small>simpan pinjam</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li>
    <li class="active">Blank page</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Silahkan Pilih Menu
              
              <a href="{{ route('sandangpangan.create') }}" class="btn btn-success btn-sm pull-right modal-show" style="margin-top: -6px;" title="Tambah Sandang Pangan"><i class="icon-plus"></i> Tambah Sandang Pangan</a>
              <!-- <a target="_blank" href="/anggota-print" class="btn btn-success btn-sm pull-right" style="margin-top: -6px;margin-right:3px;"><i class="icon-print"></i> Print</a> -->
          </h3>
        </div>

        <div class="panel-body">
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
                <input type="text" class="form-control s_id" name="s_id" placeholder="NIK Anggota">
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
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Tgl Simpanan</th>
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
            ajax: "{{ route('table.anggota') }}", //diambil dari routes/web
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
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

    <script>
      //Button CEK NIK
      function btnCek() {
          var nik = $('.nik').val();
          
          if(nik == ""){
            swal({
              type: 'error',
              title: 'Oops...',
              text: 'Data nik harus di Isi !'
            });
          } else {
            $.ajax({
              type: 'GET',
              url: '/anggota/get/'+nik,
              success: function(data) {
                swal({
                  type: 'success',
                  title: 'Success',
                  text: 'NIK Tersedia!'
                });
                $('#cek_nama').val(data.nama);
                $('#cek_jabatan').val(data.jabatan);
              },
              error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal({
                  type: 'error',
                  title: 'Oops...',
                  text: 'Data NIK tidak ada !'
                });
                $('#cek_nama').val('');
                $('#cek_jabatan').val('');
              }

            });
          }
      }
    </script>

@endpush