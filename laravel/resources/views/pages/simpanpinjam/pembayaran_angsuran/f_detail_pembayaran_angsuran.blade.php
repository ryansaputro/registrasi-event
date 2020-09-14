<table class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th id="no">No Angsuran</th>
            <th>No Pinjaman</th>
            <th>Tgl Bayar</th>
            <th>Angsuran Ke</th>
            <th>Pokok</th>
            <th>Jasa</th>
        </tr>
    <thead>
    <tbody>
        <tr>
            <td>{{ $get->no_angsuran }}</td>
            <td>{{ $get->no_pinjaman }}</td>
            <td>{{ $get->tgl_bayar }}</td>
            <td>{{ $get->angsuran_ke }} X</td>
            <td style="text-align:right;">Rp.{{ number_format($get->pokok, 0, ",", ".") }},-</td>
            <td style="text-align:right;">Rp.{{ number_format($get->jasa, 0, ",", ".") }},-</td>
        </tr>
    </tbody>

</table>