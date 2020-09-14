{!! Form::model($model, [
    'route' => $model->exists ? ['jenis_angsuran.update', $model->id_jenis_angsuran] : 'jenis_angsuran.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
<div class="row">
    <!-- {{csrf_field()}} -->
    <div>
        <div class="form-group col-md-12">
            <label for="id_jenis_angsuran" class="control-label">Id Jenis Angsuran</label>
            {!! Form::number('id_jenis_angsuran', null, ['class' => 'form-control', 'id' => 'id_jenis_angsuran']) !!}
        </div>
        <div class="form-group col-md-12">
            <label for="jenis_angsuran" class="control-label">Jenis Angsuran</label>
            {!! Form::text('jenis_angsuran', null, ['class' => 'form-control', 'id' => 'jenis_angsuran']) !!}
        </div>
    </div><br/>
</div>

{!! Form::close() !!}