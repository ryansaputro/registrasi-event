{!! Form::model($model, [
    'route' => $model->exists ? ['pembayaran_angsuran.update', $model->no_angsuran] : 'pembayaran_angsuran.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
    <div class="row">
        <div>
            <div class="form-group col-md-12">
                <label for="no_pinjaman" class="control-label">No Pinjaman</label>
                {!! Form::text('no_pinjaman', null, ['class' => 'form-control', 'id' => 'no_pinjaman', 'readonly']) !!}
            </div>
        </div>
        
        <div>
            <div class="form-group col-md-4">
                <label for="nik" class="control-label">NIK</label>
                    {!! Form::number('nik', null, ['class' => 'form-control nik', 'id' => 'nik', 'readonly']) !!}
            </div>
            <div class="form-group col-md-4">
                <label for="full_name" class="control-label">Nama</label>
                {!! Form::text('full_name', null, ['class' => 'form-control full_name', 'id' => 'full_name', 'readonly']) !!}
            </div>
            <div class="form-group col-md-4">
                <label for="nama_jabatan" class="control-label">Jabatan</label>
                {!! Form::text('nama_jabatan', null, ['class' => 'form-control nama_jabatan', 'id' => 'nama_jabatan', 'readonly']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-4">
                <label for="angsuran_ke" class="control-label">Angsuran Ke-</label>
                {!! Form::number('angsuran_ke', null, ['class' => 'form-control', 'id' => 'angsuran_ke']) !!}
            </div>
            <div class="form-group col-md-4">
                <label for="pokok" class="control-label">Pokok</label>
                {!! Form::text('pokok', null, ['class' => 'form-control', 'id' => 'pokok']) !!}
            </div>
            <div class="form-group col-md-4">
                <label for="jasa" class="control-label">Jasa</label>
                {!! Form::text('jasa', null, ['class' => 'form-control', 'id' => 'jasa']) !!}
            </div>
        </div>
    </div>
    

{!! Form::close() !!}