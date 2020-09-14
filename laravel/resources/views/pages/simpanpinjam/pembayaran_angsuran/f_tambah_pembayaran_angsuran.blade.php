{!! Form::model($model, [
    'route' => $model->exists ? ['pembayaran_angsuran.update', $model->no_angsuran] : 'pembayaran_angsuran.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
    <div class="row">
        <div>
            <div class="form-group col-md-10">
                <label for="cari_nik" class="control-label">Cari NIK</label>
                {!! Form::number('cari_nik', null, ['class' => 'form-control', 'id' => 'cari_nik']) !!}
            </div>
            <div class="form-group col-md-2">
                <button type="button" style="margin-top:24px;" class="btn btn-success" id="btnCariNik" onclick="btnCariNikClick(this)">Cari</button>
            </div>
        </div>
        <div>
            <div class="form-group col-md-10">
                <label for="no_pinjaman" class="control-label">No Pinjaman</label>
                <select id="no_pinjaman" name="no_pinjaman" class="form-control">
                    
                </select>
            </div>
            <div class="form-group col-md-2">
                <button type="button" style="margin-top:24px;" class="btn btn-success" id="modal-btn-cek" onclick="btnCekData()">Cek</button>
            </div>
        </div>
        <div class="form-group col-md-12">
                <label for="jenis_angsuran" class="control-label">Jenis Angsuran</label>
                {!! Form::text('jenis_angsuran', null, ['class' => 'form-control', 'id' => 'jenis_angsuran', 'readonly']) !!}
            </div>
        <div>
            <div class="form-group col-md-4">
                <label for="nik_a" class="control-label">NIK</label>
                {!! Form::text('nik_a', null, ['class' => 'form-control', 'id' => 'nik_a', 'readonly']) !!}
            </div>
            <div class="form-group col-md-4">
                <label for="full_name" class="control-label">Nama</label>
                {!! Form::text('full_name', null, ['class' => 'form-control full_name', 'id' => 'full_name', 'readonly']) !!}
            </div>
            <div class="form-group col-md-4">
                <label for="id_jabatan" class="control-label">Jabatan</label>
                {!! Form::text('id_jabatan', null, ['class' => 'form-control id_jabatan', 'id' => 'id_jabatan', 'readonly']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-4">
                <label for="angsuran_ke" class="control-label">Angsuran Ke-</label>
                {!! Form::number('angsuran_ke', null, ['class' => 'form-control', 'id' => 'angsuran_ke', 'readonly']) !!}
            </div>
            <div class="form-group col-md-4">
                <label for="pokok" class="control-label">Pokok</label>
                {!! Form::text('pokok', null, ['class' => 'form-control', 'id' => 'pokok', 'readonly']) !!}
            </div>
            <div class="form-group col-md-4">
                <label for="jasa" class="control-label">Jasa</label>
                {!! Form::text('jasa', null, ['class' => 'form-control', 'id' => 'jasa', 'readonly']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-12">
                <label for="total_bayar" class="control-label">Total Bayar</label>
                {!! Form::text('total_bayar', null, ['class' => 'form-control', 'id' => 'total_bayar']) !!}
            </div>
        </div>
    </div>
    

{!! Form::close() !!}