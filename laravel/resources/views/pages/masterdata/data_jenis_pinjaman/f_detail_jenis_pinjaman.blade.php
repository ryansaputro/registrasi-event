<table class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th id="no">ID Jenis Pinjaman</th>
            <th>Jenis Angsuran</th>
            <th>Nama Pinjaman</th>
            <th>Bunga</th>
        </tr>
    <thead>
    <tbody>
        <tr>
            <td>{{ $get->id_jenis_pinjaman }}</td>
            <td>{{ $get->id_jenis_angsuran }}</td>
            <td>{{ $get->nama_pinjaman }}</td>
            <td>{{ $get->bunga }} %</td>
        </tr>
    </tbody>

</table>