{!! Form::open([
        'route' => 'update.saldo',
        'method' => 'POST'
    ]) 
!!}
<div class="row">
    <div>
        <div>
        <div class="form-group col-md-4">
            <label for="simpanan_pokok" class="control-label">Simpanan Pokok</label>
            {!! Form::text('simpanan_pokok', $model->simpanan_pokok, ['class' => 'form-control', 'id' => 'simpanan_pokok']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_wajib" class="control-label">Simpanan Wajib</label>
            {!! Form::text('simpanan_wajib', $model->simpanan_wajib, ['class' => 'form-control', 'id' => 'simpanan_wajib']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_sukarela" class="control-label">Simpanan Sukarela</label>
            {!! Form::text('simpanan_sukarela', $model->simpanan_sukarela, ['class' => 'form-control', 'id' => 'simpanan_sukarela']) !!}
        </div>
    </div>
    <div>
        <div class="form-group col-md-4">
            <label for="simpanan_harkop" class="control-label">Simpanan Harkop</label>
            {!! Form::text('simpanan_harkop', $model->simpanan_harkop, ['class' => 'form-control', 'id' => 'simpanan_harkop']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_kematian" class="control-label">Simpanan Kematian</label>
            {!! Form::text('simpanan_kematian', $model->simpanan_kematian, ['class' => 'form-control', 'id' => 'simpanan_kematian']) !!}
        </div>
        <div class="form-group col-md-4">
            {!! Form::hidden('id_anggota', $model->id_anggota, ['class' => 'form-control', 'id' => 'id_anggota']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}