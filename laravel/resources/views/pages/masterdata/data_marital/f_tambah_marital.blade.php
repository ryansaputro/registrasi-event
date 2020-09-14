{!! Form::model($model, [
    'route' => $model->exists ? ['marital.update', $model->id_marital] : 'marital.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
<div class="row">
    <!-- {{csrf_field()}} -->
    <div>
        <div class="form-group col-md-12">
            <label for="id_marital" class="control-label">Id Marital</label>
            {!! Form::number('id_marital', null, ['class' => 'form-control', 'id' => 'id_marital']) !!}
        </div>
        <div class="form-group col-md-12">
            <label for="status_marital" class="control-label">Status Marital</label>
            {!! Form::text('status_marital', null, ['class' => 'form-control', 'id' => 'status_marital']) !!}
        </div>
    </div><br/>
</div>

{!! Form::close() !!}