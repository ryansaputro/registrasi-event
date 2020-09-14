@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Pengajuan Pinjaman
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
              <a href="{{ route('pinjaman.create') }}" class="btn btn-success btn-sm pull-right modal-show" style="margin-top: -6px;" title="Ajukan Pinjaman"><i class="icon-plus"></i> Ajukan Pinjaman</a>
          </h3>
        </div>

        <div class="panel-body">
          <div class="form-inline" >
            <div class="form-group">
              <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input placeholder="Pilih tanggal" type="text" class="form-control pull-left cari_tgl_pe" id="daterangepicker" value="" name="cari_tgl_pe">
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
                      <th style="width:90px;">No Pengajuan</th>
                      <th id="nik">NIK Anggota</th>
                      <th id="tgl_pe">Tgl Pengajuan</th>
                      <th>Jml Pengajuan</th>
                      <th>Tenor</th>
                      <th>Status</th>
                      <th style="width:220px;">Aksi</th>
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
            ajax: "{{ route('table.pinjaman') }}", 
            columns: [
                {data: 'no_pengajuan', name: 'no_pengajuan'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
                {data: 'jumlah_pinjaman', name: 'jumlah_pinjaman'},
                {data: 'tenor_pinjaman', name: 'tenor_pinjaman'},
                {data: 'status_approve', name: 'status_approve'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
        });
    </script>

    <script>
      function filtering(){
        var tgl_pe = document.getElementById("tgl_pe");//merubah title kolom tabel cara 2
        var nik = document.getElementById("nik");
        var cari_tgl = $('.cari_tgl_pe').val();
        var cari_nik = $('.cari_nik').val();

        if ((cari_tgl != '') && (cari_nik == ''))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();
          
          {tgl_pe.style.color="red";$('th#tgl_pe').text("Tgl Pengajuan");}//rubah warna dan text
          {nik.style.color="black";$('th#nik').text("NIK");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/pinjaman_cari_tgl/"+cari_tgl,
            columns: [
                {data: 'no_pengajuan', name: 'no_pengajuan'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
                {data: 'jumlah_pinjaman', name: 'jumlah_pinjaman'},
                {data: 'tenor_pinjaman', name: 'tenor_pinjaman'},
                {data: 'status_approve', name: 'status_approve'},
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
          {tgl_pe.style.color="black";$('th#tgl_pe').text("Tgl Pengajuan");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/pinjaman_cari_nik/"+cari_nik, //diambil dari routes/web
            columns: [
                {data: 'no_pengajuan', name: 'no_pengajuan'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
                {data: 'jumlah_pinjaman', name: 'jumlah_pinjaman'},
                {data: 'tenor_pinjaman', name: 'tenor_pinjaman'},
                {data: 'status_approve', name: 'status_approve'},
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
          
          {nik.style.color="red";$('th#nik').text("NIK");}
          {tgl_pe.style.color="red";$('th#tgl_pe').text("Tgl Pengajuan");}
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/pinjaman_cari_tgl_nik/"+cari_tgl+"/"+cari_nik, //diambil dari routes/web
            columns: [
                {data: 'no_pengajuan', name: 'no_pengajuan'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
                {data: 'jumlah_pinjaman', name: 'jumlah_pinjaman'},
                {data: 'tenor_pinjaman', name: 'tenor_pinjaman'},
                {data: 'status_approve', name: 'status_approve'},
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

        var cari_tgl = $('.cari_tgl_pe').val();
        var cari_nik = $('.cari_nik').val();
        var cari_all = btoa("orzdev");

        if ((cari_tgl != '') && (cari_nik == ''))
        {
          window.open('/print/pengajuan_pinjaman/tgl='+btoa(cari_tgl),'_blank');

        } else if ((cari_nik != '') && (cari_tgl == ''))
        {
          window.open('/print/pengajuan_pinjaman/nik='+btoa(cari_nik),'_blank');

        } else if ((cari_tgl != '') && (cari_nik != ''))
        {
          window.open('/print/pengajuan_pinjaman/tgl='+btoa(cari_tgl)+'/nik='+btoa(cari_nik),'_blank');

        } else if ((cari_tgl == '') && (cari_nik == ''))
        {
          window.open('/print/pengajuan_pinjaman/all='+btoa(cari_all),'_blank');

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
      function btnCekNik() {
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
                $('#full_name').val(data.full_name);
                $('#nama_jabatan').val(data.nama_jabatan);
              },
              error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal({
                  type: 'error',
                  title: 'Oops...',
                  text: 'Data NIK tidak ada !'
                });
                $('#full_name').val('');
                $('#nama_jabatan').val('');
              }

            });
          }
      }
      
      //Button Hitung
      function btnHitung() {  
        var jumlah_pinjaman = $('#jumlah_pinjaman').val();
        var tenor_pinjaman = $('#tenor_pinjaman').val();
        var id_jenis_pinjaman = $('#id_jenis_pinjaman').val();

        $.ajax({
          type: 'GET',
          url: '/pinjaman/get_jns_pinjaman/'+id_jenis_pinjaman,
          success: function(data) {
              var bunga = $('#persentase_bunga').val(data.bunga);
              var persentase_bunga = bunga.val();

              $('#biaya_adm').val(Math.round((jumlah_pinjaman*1)/100));
              $('#biaya_cppu').val(Math.round((jumlah_pinjaman*1)/100));
              var pokok = $('#pokok').val(Math.round(jumlah_pinjaman/tenor_pinjaman));
              var jml_pokok = parseInt(pokok.val());
              var jasa = $('#jasa').val(Math.round(((jumlah_pinjaman*persentase_bunga)/100)));
              var jml_jasa = parseInt(jasa.val());
              var total = jml_pokok+jml_jasa;

              $('#total_angsuran').val(total);   
          },
          error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            swal({
              type: 'error',
              title: 'Oops...',
              text: 'Data tidak ada !'
            });
            $('#bunga').val('');
          }
        });
      }
    </script>
    

@endpush