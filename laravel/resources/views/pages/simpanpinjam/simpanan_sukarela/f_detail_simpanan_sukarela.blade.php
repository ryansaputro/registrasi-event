<table class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th id="no">No Simpanan</th>
            <th>NIK Anggota</th>
            <th>Jumlah Simpan</th>
            <th>Tgl Simpan</th>
            <th>Status Simpan</th>
        </tr>
    <thead>
    <tbody>
        <tr>
            <td>{{ $get->no_simpanan_sukarela }}</td>
            <td>{{ $get->nik }}</td>
            <td style="text-align:right;">Rp.{{ number_format($get->jumlah_simpan, 0, ",", ".") }},-</td>
            <td>{{ $get->tgl_transaksi }}</td>
            @if($get->is_simpan == 0)
                <td>Gagal</td>
            @else
                <td>Berhasil</td>
            @endif
            
        </tr>
    </tbody>

</table>