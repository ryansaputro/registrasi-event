{!! Form::model($model, [
    'route' => $model->exists ? ['saldo.update', $model->id_anggota] : 'saldo.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
<div class="row">
    <!-- {{csrf_field()}} -->
    <div>
        <div>
        <div class="form-group col-md-4">
            <label for="simpanan_pokok" class="control-label">Simpanan Pokok</label>
            {!! Form::text('simpanan_pokok', null, ['class' => 'form-control', 'id' => 'simpanan_pokok']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_wajib" class="control-label">Simpanan Wajib</label>
            {!! Form::text('simpanan_wajib', null, ['class' => 'form-control', 'id' => 'simpanan_wajib']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_sukarela" class="control-label">Simpanan Sukarela</label>
            {!! Form::text('simpanan_sukarela', null, ['class' => 'form-control', 'id' => 'simpanan_sukarela']) !!}
        </div>
    </div>
    <div>
        <div class="form-group col-md-4">
            <label for="simpanan_harkop" class="control-label">Simpanan Harkop</label>
            {!! Form::text('simpanan_harkop', null, ['class' => 'form-control', 'id' => 'simpanan_harkop']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_kematian" class="control-label">Simpanan Kematian</label>
            {!! Form::text('simpanan_kematian', null, ['class' => 'form-control', 'id' => 'simpanan_kematian']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="saldo_hutang" class="control-label">Saldo Hutang</label>
            {!! Form::text('saldo_hutang', null, ['class' => 'form-control', 'id' => 'saldo_hutang']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}