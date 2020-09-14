<table class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>No Pinjaman</th>
            <th>Jenis Pinjaman</th>
            <th>Jenis Angsuran</th>
            <th>Biaya ADM</th>
            <th>Biaya CPPU</th>
            <th>Sisa Pinjaman</th>
        </tr>
    <thead>
    <tbody>
        <tr>
            <td>{{ $get->no_pinjaman }}</td>
            <td>{{ $get->nama_pinjaman }}</td>
            <td>{{ $get->jenis_angsuran }}</td>
            <td style="text-align:right;">Rp.{{ number_format($get->biaya_adm, 0, ",", ".") }},-</td>
            <td style="text-align:right;">Rp.{{ number_format($get->biaya_cppu, 0, ",", ".") }},-</td>
            <td style="text-align:right;">Rp.{{ number_format($get->saldo_hutang, 0, ",", ".") }},-</td>
        </tr>
    </tbody>

</table>