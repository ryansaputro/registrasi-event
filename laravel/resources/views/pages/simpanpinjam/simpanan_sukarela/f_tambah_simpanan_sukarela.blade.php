{!! Form::open([
        'route' => 'simpanan.store',
        'method' => 'POST'
    ]) 
!!}
<div class="row">
    <div class="form-group col-md-12">
        <label for="date" class="control-label">Pilih Tanggal</label>
            {!! Form::date('date', null, ['class' => 'form-control', 'id' => 'date']) !!}
    </div>
</div>
    

{!! Form::close() !!}