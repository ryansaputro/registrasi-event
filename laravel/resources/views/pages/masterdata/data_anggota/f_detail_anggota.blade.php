<div class="row">
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user-2 no-padding">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow">
            <div class="widget-user-image">
            <img class="img-circle" src="{{ asset('assets/img/profil') }}/{{$get->foto}}" alt="User Avatar">
            </div>
            <!-- /.widget-user-image -->
            <h3 class="widget-user-username">{{ $get->full_name }}</h3>
            <!-- <h5 class="widget-user-desc">{{ $get->no_ktp }}</h5> -->
            <h5 class="widget-user-desc">{{ $get->alamat }} {{$get->kodepos}}</h5>
        </div>
        <div class="box-footer no-padding">
                <table class="table table-bordered">
                    <tr>
                        <td>NIK</td>
                        <td>{{ $get->nik }}</td>
                    </tr>
                    <tr>
                        <td>No KTP</td>
                        <td>{{ $get->no_ktp }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>{{ $get->nama_jabatan }}</td>
                    </tr>
                    <tr>
                        <td>Divisi</td>
                        <td>{{ $get->nama_divisi }}</td>
                    </tr>
                    <tr>
                        <td>No TLP</td>
                        <td>{{ $get->notelp }}</td>
                    </tr>
                    <tr>
                        <td>Tempat Tgl Lahir</td>
                        <td>{{ $get->tempat_lahir }} {{ $get->tgl_lahir }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>{{ $get->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>Marital</td>
                        <td>{{ $get->status_marital }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $get->email }}</td>
                    </tr>
                    <tr>
                        <td>Status Anggota</td>
                        <td>{{ $get->nama_status_aktif }}</td>
                    </tr>
                </table>
        </div>
        </div>
        <!-- /.widget-user -->
    </div>
</div>