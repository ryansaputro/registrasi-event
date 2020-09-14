{!! Form::model($model, [
    'route' => $model->exists ? ['jenis_pinjaman.update', $model->id_jenis_pinjaman] : 'jenis_pinjaman.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
<div class="row">
    <!-- {{csrf_field()}} -->
    <div>
        <div class="form-group col-md-6">
            <label for="id_jenis_pinjaman" class="control-label">Id Jenis Pinjaman</label>
            {!! Form::number('id_jenis_pinjaman', null, ['class' => 'form-control', 'id' => 'id_jenis_pinjaman']) !!}
        </div>
        <div class="form-group col-md-6">
            <label for="id_jenis_angsuran" class="control-label">Id Jenis Angsuran</label>
            <select id="id_jenis_angsuran" name="id_jenis_angsuran" class="form-control">
                @foreach($angsuran as $ref_angsuran)
                    <option value='{{$ref_angsuran->id_jenis_angsuran}}' {{$ref_angsuran->id_jenis_angsuran == $model->id_jenis_angsuran ? 'selected' : ''}}>{{$ref_angsuran->jenis_angsuran}}</option>
                @endforeach
            </select>
        </div>
    </div><br>
    <div><br/>
        <div class="form-group col-md-6">
            <label for="nama_pinjaman" class="control-label">Nama Pinjaman</label>
            {!! Form::text('nama_pinjaman', null, ['class' => 'form-control', 'id' => 'nama_pinjaman']) !!}
        </div>
        <div class="form-group col-md-6">
            <label for="bunga" class="control-label">Bunga</label>
            {!! Form::number('bunga', null, ['class' => 'form-control', 'id' => 'bunga']) !!}
        </div>
    </div><br/>
</div>

{!! Form::close() !!}