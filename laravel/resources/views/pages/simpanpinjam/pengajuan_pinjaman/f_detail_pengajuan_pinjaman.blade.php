<table class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th id="no">No Pengajuan</th>
            @if($get->no_pinjaman != NULL)
                <th>No Pinjaman</th>
            @endif
            <th>NIK Anggota</th>
            <th>Jml Pencairan</th>
            <th>Tenor</th>
            <th>Tgl Pencairan</th>
            <th>Status Pinjaman</th>
        </tr>
    <thead>
    <tbody>
        <tr>
            <td>{{ $get->no_pengajuan }}</td>
            @if($get->no_pinjaman != NULL)
                <td>{{ $get->no_pinjaman }}</td>
            @endif
            <td>{{ $get->nik }}</td>
            <td>Rp.{{ number_format($get->jumlah_pinjaman, 0, ",", ".") }},-</td>
            <td>{{ $get->tenor_pinjaman }} X</td>
            <td>{{ $get->tgl_pencairan }}</td>
            @if($get->status_lunas == 0)
                <td>Belum Lunas</td>
            @else
                <td>Lunas</td>
            @endif
            
        </tr>
    </tbody>

</table>