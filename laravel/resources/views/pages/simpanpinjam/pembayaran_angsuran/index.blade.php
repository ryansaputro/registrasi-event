@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    @if(Session::get('group_name') == 'admin')
      Pembayaran Angsuran
    @elseif(Session::get('group_name') == 'anggota')
      Informasi Angsuran
    @endif
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
            <a href="{{ route('pembayaran_angsuran.create') }}" class="btn btn-success btn-sm pull-right modal-show" style="margin-top: -6px;" title="Pembayaran Angsuran"><i class="icon-plus"></i> Tambah Pembayaran</a>
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
                  <input placeholder="Pilih tanggal" type="text" class="form-control pull-left cari_tgl_pa" id="daterangepicker" value="" name="cari_tgl_pa">
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
                      <th style="width:100px;">No Angsuran</th>
                      <th style="width:100px;">No Pinjaman</th>
                      <th id="nik">NIK Anggota</th>
                      <th id="tgl_pa">Tgl Bayar</th>
                      <th style="width:100px;">Angsuran Ke</th>
                      <th>Pokok</th>
                      <th>Jasa</th>
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
            ajax: "{{ route('table.pembayaran_angsuran') }}", //diambil dari routes/web
            columns: [
                {data: 'no_angsuran', name: 'no_angsuran'},
                {data: 'no_pinjaman', name: 'no_pinjaman'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_bayar', name: 'tgl_bayar'},
                {data: 'angsuran_ke', name: 'angsuran_ke'},
                {data: 'pokok', name: 'pokok'},
                {data: 'jasa', name: 'jasa'},
                {data: 'action', name: 'action'}
            ],
            "language": {
                "url": "{{ asset('assets/js/table-indonesia.json') }}"
            }
        });
    </script>

    <script>
      function filtering(){
        var tgl_pa = document.getElementById("tgl_pa");//merubah title kolom tabel cara 2
        var nik = document.getElementById("nik");
        var cari_tgl = $('.cari_tgl_pa').val();
        var cari_nik = $('.cari_nik').val();

        if ((cari_tgl != '') && (cari_nik == ''))
        {
          $('#datatable').DataTable().clear();
          $('#datatable').DataTable().destroy();
          
          {tgl_pa.style.color="red";$('th#tgl_pa').text("Tgl Bayar");}//rubah warna dan text
          {nik.style.color="black";$('th#nik').text("NIK");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/angsuran_cari_tgl/"+cari_tgl,
            columns: [
                {data: 'no_angsuran', name: 'no_angsuran'},
                {data: 'no_pinjaman', name: 'no_pinjaman'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_bayar', name: 'tgl_bayar'},
                {data: 'angsuran_ke', name: 'angsuran_ke'},
                {data: 'pokok', name: 'pokok'},
                {data: 'jasa', name: 'jasa'},
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
          {tgl_pa.style.color="black";$('th#tgl_ss').text("Tgl Bayar");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/angsuran_cari_nik/"+cari_nik, //diambil dari routes/web
            columns: [
                {data: 'no_angsuran', name: 'no_angsuran'},
                {data: 'no_pinjaman', name: 'no_pinjaman'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_bayar', name: 'tgl_bayar'},
                {data: 'angsuran_ke', name: 'angsuran_ke'},
                {data: 'pokok', name: 'pokok'},
                {data: 'jasa', name: 'jasa'},
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
          {tgl_pa.style.color="red";$('th#tgl_pa').text("Tgl Bayar");}//rubah warna dan text
                      
          var oTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/table/angsuran_cari_tgl_nik/"+cari_tgl+"/"+cari_nik, //diambil dari routes/web
            columns: [
                {data: 'no_angsuran', name: 'no_angsuran'},
                {data: 'no_pinjaman', name: 'no_pinjaman'},
                {data: 'nik', name: 'nik'},
                {data: 'tgl_bayar', name: 'tgl_bayar'},
                {data: 'angsuran_ke', name: 'angsuran_ke'},
                {data: 'pokok', name: 'pokok'},
                {data: 'jasa', name: 'jasa'},
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

        var cari_tgl = $('.cari_tgl_pa').val();
        var cari_nik = $('.cari_nik').val();
        var cari_all = btoa("orzdev");

        if ((cari_tgl != '') && (cari_nik == ''))
        {
          window.open('/print/pembayaran_angsuran/tgl='+btoa(cari_tgl),'_blank');

        } else if ((cari_nik != '') && (cari_tgl == ''))
        {
          window.open('/print/pembayaran_angsuran/nik='+btoa(cari_nik),'_blank');

        } else if ((cari_tgl != '') && (cari_nik != ''))
        {
          window.open('/print/pembayaran_angsuran/tgl='+btoa(cari_tgl)+'/nik='+btoa(cari_nik),'_blank');

        } else if ((cari_tgl == '') && (cari_nik == ''))
        {
          window.open('/print/pembayaran_angsuran/all='+btoa(cari_all),'_blank');

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
      function btnCekData() {
          var no_pinjaman = $('#no_pinjaman').val();
          
          $.ajax({
            type: 'GET',
            url: '/pembayaran_angsuran/get_data/'+no_pinjaman,
            success: function(pinjaman) {
              var angsuran = pinjaman.angsuran_ke;
              var tenor_pinjaman = pinjaman.tenor;

              if (angsuran > tenor_pinjaman) {
                $('#modal').modal('hide');
                $('#datatable').DataTable().ajax.reload(null,false);
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Angsuran telah Lunas! Thank :)'
                }); 
              } else if (angsuran <= tenor_pinjaman) {

                $('#jenis_angsuran').val(pinjaman.jenis_angsuran);
                $('#nik_a').val(pinjaman.nik);
                $('#full_name').val(pinjaman.full_name);
                $('#id_jabatan').val(pinjaman.nama_jabatan);
                $('#angsuran_ke').val(pinjaman.angsuran_ke);
                $('#pokok').val(pinjaman.pokok);
                $('#jasa').val(pinjaman.jasa);
                $('#total_bayar').val(pinjaman.pokok+pinjaman.jasa);
              }
            },
            error: function(xhr, status, error) {
              var err = eval("(" + xhr.responseText + ")");
              swal({
                type: 'error',
                title: 'Oops...',
                text: 'Data No Pinjaman tidak ada !'
              });

              $('#jenis_angsuran').val(" ");
              $('#nik').val(" ");
              $('#full_name').val(" ");
              $('#id_jabatan').val(" ");
              $('#angsuran_ke').val(" ");
              $('#pokok').val(" ");
              $('#jasa').val(" ");
              $('#total_bayar').val(" ");
            }

          });
      }
    </script>

    <script>
    //Button Cari NIK
    function btnCariNikClick(a) {
        var cari_nik = $('#cari_nik').val();

        $.ajax({
            type: 'GET',
            url: '/pembayaran_angsuran/get_datas/nik=' + cari_nik,
            success: function (data) {
                var option = "<option disabled selected>pilih</option>";
                $.each(data, function(k, v){
                    option += "<option value="+v.no_pinjaman+">"+v.no_pinjaman+"</option>"
                })
                $('#no_pinjaman').html(option);
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Data NIK tidak ada !'
                });
            }
        });
    }
    </script>

@endpush