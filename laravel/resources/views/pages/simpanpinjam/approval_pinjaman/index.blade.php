@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Approval Pinjaman
    <small>simpan pinjam</small>
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
            @if(Session::get('group_name')=="admin")
              <!-- <a href="{{ route('simpanan.create') }}" class="btn btn-success btn-sm pull-right modal-show" style="margin-top: -6px;" title="Tambah Simpanan Sukarela"><i class="icon-plus"></i> Tambah Simpanan</a> -->
            @endif
          </h3>
        </div>

        <div class="panel-body">
          <div class="form-inline" >
            <div class="form-group">
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input placeholder="Pilih tanggal" type="text" class="form-control pull-left cari_tgl_ap" id="daterangepicker" value="" name="cari_tgl_ap">
                </div>
            </div>
            <div class="form-group">
              <label>Cari :</label>
              <div class="input-group date">
                <div class="input-group-addon">
                      <span class="glyphicon glyphicon-user"></span>
                </div>
                <input type="text" class="form-control cari_nik" name="cari_nik" placeholder="NIK Anggota">
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
                      <th style="width:100px;">No Pinjaman</th>
                      <th style="width:60px;" id="nik">NIK</th>
                      <th id="tgl_ap">Tgl Pencairan</th>
                      <th >Jml Pinjaman</th>
                      <th >Tenor</th>
                      <th style="width:20px;">Bunga</th>
                      <th >Pokok</th>
                      <th >Jasa</th> 
                      <th style="width:20px;">Status Lunas</th>
                      <th style="width:150px;">Aksi</th>
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
            ajax: "{{ route('table.approval_pinjaman') }}", //diambil dari routes/web
            columns: [ 
                {data: 'no_pinjaman', name: 'no_pinjaman'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_pencairan', name: 'tgl_pencairan'},
                {data: 'jumlah_pinjaman', name: 'jumlah_pinjaman'},
                {data: 'tenor_pinjaman', name: 'tenor_pinjaman'},
                {data: 'persentase_bunga', name: 'persentase_bunga'},
                {data: 'pokok', name: 'pokok'},
                {data: 'jasa', name: 'jasa'},
                {data: 'status_lunas', name: 'status_lunas'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
        });
    </script>

    <script>
      function filtering(){
        var tgl_ap = document.getElementById("tgl_ap");//merubah title kolom tabel cara 2
        var nik = document.getElementById("nik");
        var cari_tgl = $('.cari_tgl_ap').val();
        var cari_nik = $('.cari_nik').val();

        if ((cari_tgl != '') && (cari_nik == ''))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();
          
          {tgl_ap.style.color="red";$('th#tgl_ap').text("Tgl Pencairan");}//rubah warna dan text
          {nik.style.color="black";$('th#nik').text("NIK");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/approval_cari_tgl/"+cari_tgl,
            columns: [
                {data: 'no_pinjaman', name: 'no_pinjaman'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_pencairan', name: 'tgl_pencairan'},
                {data: 'jumlah_pinjaman', name: 'jumlah_pinjaman'},
                {data: 'tenor_pinjaman', name: 'tenor_pinjaman'},
                {data: 'persentase_bunga', name: 'persentase_bunga'},
                {data: 'pokok', name: 'pokok'},
                {data: 'jasa', name: 'jasa'},
                {data: 'status_lunas', name: 'status_lunas'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
          });
        } else if ((cari_nik != '') && (cari_tgl == ''))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();

          {nik.style.color="red";$('th#nik').text("NIK");}//rubah warna dan text
          {tgl_ap.style.color="black";$('th#tgl_ap').text("Tgl Pencairan");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/approval_cari_nik/"+cari_nik, //diambil dari routes/web
            columns: [
                {data: 'no_pinjaman', name: 'no_pinjaman'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_pencairan', name: 'tgl_pencairan'},
                {data: 'jumlah_pinjaman', name: 'jumlah_pinjaman'},
                {data: 'tenor_pinjaman', name: 'tenor_pinjaman'},
                {data: 'persentase_bunga', name: 'persentase_bunga'},
                {data: 'pokok', name: 'pokok'},
                {data: 'jasa', name: 'jasa'},
                {data: 'status_lunas', name: 'status_lunas'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
          });
        } else if ((cari_nik != '') && (cari_tgl != ''))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();
          
          {nik.style.color="red";$('th#nik').text("NIK");}//rubah warna dan text
          {tgl_ap.style.color="red";$('th#tgl_ap').text("Tgl Pencairan");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/approval_cari_tgl_nik/"+cari_tgl+"/"+cari_nik, //diambil dari routes/web
            columns: [
                {data: 'no_pinjaman', name: 'no_pinjaman'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_pencairan', name: 'tgl_pencairan'},
                {data: 'jumlah_pinjaman', name: 'jumlah_pinjaman'},
                {data: 'tenor_pinjaman', name: 'tenor_pinjaman'},
                {data: 'persentase_bunga', name: 'persentase_bunga'},
                {data: 'pokok', name: 'pokok'},
                {data: 'jasa', name: 'jasa'},
                {data: 'status_lunas', name: 'status_lunas'},
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
            text: 'Silahkan pilih salah satu filter yang dibutuhkan!'
          });
        }
      }
    </script>

    <script type="text/javascript">
      function printing(){
        var cari_tgl = $('.cari_tgl_ap').val();
        var cari_nik = $('.cari_nik').val();
        var cari_all = btoa("orzdev");

        if ((cari_tgl != '') && (cari_nik == ''))
        {
          window.open('/print/approval_pinjaman/tgl='+btoa(cari_tgl),'_blank');

        } else if ((cari_nik != '') && (cari_tgl == ''))
        {
          window.open('/print/approval_pinjaman/nik='+btoa(cari_nik),'_blank');

        } else if ((cari_tgl != '') && (cari_nik != ''))
        {
          window.open('/print/approval_pinjaman/tgl='+btoa(cari_tgl)+'/nik='+btoa(cari_nik),'_blank');

        } else if ((cari_tgl == '') && (cari_nik == ''))
        {
          window.open('/print/approval_pinjaman/all='+btoa(cari_all),'_blank');

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
                $('#cek_nama').val(data.full_name);
                $('#cek_jabatan').val(data.nama_jabatan);
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