{!! Form::model($model, [
    'route' => $model->exists ? ['pinjaman.update', $model->no_pengajuan] : 'pinjaman.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
    <div class="row">
        <div>
            <div class="form-group col-md-12">
                <label for="nik" class="control-label">NIK</label>
                @if(Session::get('group_name')=="admin")
                    {!! Form::number('nik', $model->nik, ['class' => 'form-control nik', 'id' => 'nik']) !!}
                @else
                    {!! Form::number('nik', $model->nik, ['class' => 'form-control nik', 'id' => 'nik', 'readonly']) !!}
                @endif 
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
