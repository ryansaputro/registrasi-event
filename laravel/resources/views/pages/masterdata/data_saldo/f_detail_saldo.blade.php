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
            <h5 class="widget-user-desc">{{ $get->nik }}</h5>
        </div>
        <div class="box-footer no-padding">
                <table class="table table-bordered">
                    <tr>
                        <td>No KTP</td>
                        <td>{{ $get->no_ktp }}</td>
                    </tr>
                    <tr>
                        <td>Simpanan Pokok</td>
                        <td>Rp.{{ $get->simpanan_pokok }},-</td>
                    </tr>
                    <tr>
                        <td>Simpanan Wajib</td>
                        <td>Rp.{{ $get->simpanan_wajib }},-</td>
                    </tr>
                    <tr>
                        <td>Simpanan Sukarela</td>
                        <td>Rp.{{ $get->simpanan_sukarela }},-</td>
                    </tr>
                    <tr>
                        <td>Simpanan Harkop</td>
                        <td>Rp.{{ $get->simpanan_harkop }},-</td>
                    </tr>
                    <tr>
                        <td>Simpanan Kematian</td>
                        <td>Rp.{{ $get->simpanan_kematian }},-</td>
                    </tr>
                    <tr>
                        <td>Saldo Hutang</td>
                        @if($get->saldo_hutang == NULL)
                            <td>Tidak Ada Hutang</td>
                        @else
                            <td>Rp.{{ $get->saldo_hutang }},-</td>
                        @endif
                    </tr>
                </table>
        </div>
        </div>
        <!-- /.widget-user -->
    </div>
</div>