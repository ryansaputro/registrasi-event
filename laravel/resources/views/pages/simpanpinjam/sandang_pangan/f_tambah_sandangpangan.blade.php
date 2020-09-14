{!! Form::model($model, [
    'route' => $model->exists ? ['simpanan.update', $model->id] : 'simpanan.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
    <div class="row">
        <div>
            <div class="form-group col-md-10">
                <label for="nik" class="control-label">NIK</label>
                {!! Form::number('nik', null, ['class' => 'form-control nik', 'id' => 'nik']) !!}
            </div>
            <div class="form-group col-md-2">
                 <button type="button" style="margin-top:24px;" class="btn btn-success" id="modal-btn-cek" onclick="btnCek()">Cek</button>
            </div>
        </div>
        
        <div>
            <div class="form-group col-md-6">
                <label for="cek_nama" class="control-label">Nama</label>
                {!! Form::text('cek_nama', null, ['class' => 'form-control cek_nama', 'id' => 'cek_nama', 'readonly']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="cek_jabatan" class="control-label">Jabatan</label>
                {!! Form::text('cek_jabatan', null, ['class' => 'form-control cek_jabatan', 'id' => 'cek_jabatan', 'readonly']) !!}
            </div>
        </div>        
        <div>
            <div class="form-group col-md-6">
                <label for="sandang" class="control-label">Sandang</label>
                {!! Form::number('sandang', null, ['class' => 'form-control', 'id' => 'sandang']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="pangan" class="control-label">Pangan</label>
                {!! Form::number('pangan', null, ['class' => 'form-control', 'id' => 'pangan']) !!}
            </div>
        </div>
    </div>
    

{!! Form::close() !!}