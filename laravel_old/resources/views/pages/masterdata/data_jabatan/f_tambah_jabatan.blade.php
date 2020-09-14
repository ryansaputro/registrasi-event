{!! Form::model($model, [
    'route' => $model->exists ? ['jabatan.update', $model->id_jabatan] : 'jabatan.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
<div class="row">
    <!-- {{csrf_field()}} -->
    <div>
        <div class="form-group col-md-12">
            <label for="id_jabatan" class="control-label">Id Jabatan</label>
            {!! Form::number('id_jabatan', null, ['class' => 'form-control', 'id' => 'id_jabatan']) !!}
        </div>
        <div class="form-group col-md-12">
            <label for="nama_jabatan" class="control-label">Nama Jabatan</label>
            {!! Form::text('nama_jabatan', null, ['class' => 'form-control', 'id' => 'nama_jabatan']) !!}
        </div>
    </div><br/>
</div>

{!! Form::close() !!}