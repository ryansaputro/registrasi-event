@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Saldo Anggota
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
              <!-- <a href="{{ route('saldo.create') }}" class="btn btn-success btn-sm pull-right modal-show" style="margin-top: -6px;" title="Tambah Divisi"><i class="icon-plus"></i> Tambah Saldo</a> -->
          </h3>
        </div>

        <div class="panel-footer" style="background-color:#f9f9f9;">
          <table id="datatable" class="table table-hover" style="width:100%">
              <thead>
                  <tr>
                      <th id="no">No</th>
                      <th id="nik">NIK</th>
                      <th>Simpanan Pokok</th>
                      <th>Simpanan Wajib</th>
                      <th>Simpanan Sukarela</th>
                      <th>Saldo Hutang</th>
                      <th>Saldo Kematian</th>
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
            ajax: "{{ route('table.saldo') }}", //diambil dari routes/web
            columns: [
                {data: 'DT_RowIndex', name: 'id_anggota'}, //data = nama field db
                {data: 'nik', name: 'nik'},
                {data: 'simpanan_pokok', name: 'simpanan_pokok'},
                {data: 'simpanan_wajib', name: 'simpanan_wajib'},
                {data: 'simpanan_sukarela', name: 'simpanan_sukarela'},
                {data: 'saldo_hutang', name: 'saldo_hutang'},
                {data: 'simpanan_kematian', name: 'simpanan_kematian'},
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