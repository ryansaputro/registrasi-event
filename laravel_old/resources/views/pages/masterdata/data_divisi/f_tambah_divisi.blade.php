{!! Form::model($model, [
    'route' => $model->exists ? ['divisi.update', $model->id_divisi] : 'divisi.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
<div class="row">
    <!-- {{csrf_field()}} -->
    <div>
        <div class="form-group col-md-12">
            <label for="id_divisi" class="control-label">Id Divisi</label>
            {!! Form::number('id_divisi', null, ['class' => 'form-control', 'id' => 'id_divisi']) !!}
        </div>
        <div class="form-group col-md-12">
            <label for="nama_divisi" class="control-label">Nama Divisi</label>
            {!! Form::text('nama_divisi', null, ['class' => 'form-control', 'id' => 'nama_divisi']) !!}
        </div>
    </div><br/>
</div>

{!! Form::close() !!}