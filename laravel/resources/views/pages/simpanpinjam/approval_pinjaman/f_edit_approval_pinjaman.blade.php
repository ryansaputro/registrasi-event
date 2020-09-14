{!! Form::model($model, [
    'route' => $model->exists ? ['approval_pinjaman.update', $model->no_pinjaman] : 'approval_pinjaman.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}

    <div class="row">
        <div>
            <div class="form-group col-md-6">
                <label for="no_pinjaman" class="control-label">No Pinjaman</label>
                {!! Form::text('no_pinjaman', $model->no_pinjaman, ['class' => 'form-control', 'id' => 'no_pinjaman', 'readonly']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="status_approve" class="control-label">Status Lunas</label>
                {!! Form::select('status_lunas', 
                    ['0' => 'Belum Lunas', '1' => 'Lunas'],$model->status_lunas,['class' => 'form-control']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="jumlah_pinjaman" class="control-label">Jumlah Pinjaman</label>
                {!! Form::text('jumlah_pinjaman', $model->jumlah_pinjaman, ['class' => 'form-control', 'id' => 'jumlah_pinjaman']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="tenor_pinjaman" class="control-label">Tenor Pinjaman</label>
                {!! Form::number('tenor_pinjaman', $model->tenor_pinjaman, ['class' => 'form-control', 'id' => 'tenor_pinjaman']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="id_jenis_pinjaman" class="control-label">Jenis Pinjaman</label>
                <select id="id_jenis_pinjaman" name="id_jenis_pinjaman" class="form-control">
                    @foreach($jenis_pinjaman as $ref_jenis_pinjaman)
                        <option value='{{$ref_jenis_pinjaman->id_jenis_pinjaman}}' {{$ref_jenis_pinjaman->id_jenis_pinjaman == $model->id_jenis_pinjaman ? 'selected' : ''}}>{{$ref_jenis_pinjaman->nama_pinjaman}}, {{$ref_jenis_pinjaman->jenis_angsuran}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="persentase_bunga" class="control-label">Bunga (%)</label>
                 {!! Form::number('persentase_bunga', null, ['class' => 'form-control', 'id' => 'persentase_bunga', 'readonly']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="biaya_adm" class="control-label">Biaya Administrasi</label>
                {!! Form::text('biaya_adm', null, ['class' => 'form-control', 'id' => 'biaya_adm']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="biaya_cppu" class="control-label">Biaya CPPU</label>
                 {!! Form::text('biaya_cppu', null, ['class' => 'form-control', 'id' => 'biaya_cppu']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="pokok" class="control-label">Pokok Pinjaman</label>
                {!! Form::text('pokok', null, ['class' => 'form-control', 'id' => 'pokok']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="jasa" class="control-label">Jasa Pinjaman</label>
                 {!! Form::text('jasa', null, ['class' => 'form-control', 'id' => 'jasa']) !!}
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="saldo_hutang" class="control-label">Sisa Pinjaman</label>
            {!! Form::text('saldo_hutang', null, ['class' => 'form-control', 'id' => 'saldo_hutang']) !!}
        </div>
    </div>
    

{!! Form::close() !!}