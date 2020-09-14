{!! Form::model($model, [
    'route' => $model->exists ? ['pinjaman.update', $model->no_pengajuan] : 'pinjaman.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
    <div class="row">
        <div>
            <div class="form-group col-md-10">
                <label for="nik" class="control-label">NIK</label>
                @if(Session::get('group_name')=="admin")
                    {!! Form::number('nik', Session::get('data')['nik'], ['class' => 'form-control nik', 'id' => 'nik']) !!}
                @else
                    {!! Form::number('nik', Session::get('data')['nik'], ['class' => 'form-control nik', 'id' => 'nik', 'readonly']) !!}
                @endif 
            </div>
            <div class="form-group col-md-2">
                <button type="button" style="margin-top:24px;" class="btn btn-success" id="modal-btn-cek" onclick="btnCekNik()">Cek</button>
            </div>
        </div>
        
        <div>
            <div class="form-group col-md-6">
                <label for="full_name" class="control-label">Nama</label>
                {!! Form::text('full_name', null, ['class' => 'form-control full_name', 'id' => 'full_name', 'readonly']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="nama_jabatan" class="control-label">Jabatan</label>
                {!! Form::text('nama_jabatan', null, ['class' => 'form-control nama_jabatan', 'id' => 'nama_jabatan', 'readonly']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="jumlah_pinjaman" class="control-label">Jumlah Pinjaman</label>
                {!! Form::text('jumlah_pinjaman', null, ['class' => 'form-control', 'id' => 'jumlah_pinjaman']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="tenor_pinjaman" class="control-label">Tenor Pinjaman (x)</label>
                {!! Form::number('tenor_pinjaman', null, ['class' => 'form-control', 'id' => 'tenor_pinjaman']) !!}
            </div>
        </div>
        
    </div>
    

{!! Form::close() !!}