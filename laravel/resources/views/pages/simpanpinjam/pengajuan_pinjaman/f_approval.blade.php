{!! Form::open([
        'route' => 'update.approval',
        'method' => 'POST'
    ]) 
!!}

    <div class="row">
        <div>
            <div class="form-group col-md-6">
                <label for="no_pengajuan" class="control-label">No Pengajuan</label>
                {!! Form::text('no_pengajuan', $model->no_pengajuan, ['class' => 'form-control', 'id' => 'no_pengajuan']) !!}
            </div>
            <div class="form-group col-md-3">
                <label for="status_approve" class="control-label">Status Approval</label>
                {!! Form::select('status_approve', 
                    ['0' => 'Menunggu', '1' => 'Diterima'],1,['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-2">
                <button type="button" style="margin-top:24px;" class="btn btn-success" id="modal-btn-cek" onclick="btnHitung()">Hitung</button>
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="jumlah_pinjaman" class="control-label">Jumlah Pinjaman</label>
                {!! Form::text('jumlah_pinjaman', $model->jumlah_pinjaman, ['class' => 'form-control', 'id' => 'jumlah_pinjaman']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="tenor_pinjaman" class="control-label">Tenor Pinjaman</label>
                {!! Form::number('tenor_pinjaman', $model->tenor_pinjaman, ['class' => 'form-control', 'id' => 'tenor_pinjaman']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="id_jenis_pinjaman" class="control-label">Jenis Pinjaman</label>
                <select id="id_jenis_pinjaman" name="id_jenis_pinjaman" class="form-control">
                    @foreach($jenis_pinjaman as $ref_jenis_pinjaman)
                        <option value='{{$ref_jenis_pinjaman->id_jenis_pinjaman}}' {{$ref_jenis_pinjaman->id_jenis_pinjaman == $model->id_jenis_pinjaman ? 'selected' : ''}}>{{$ref_jenis_pinjaman->nama_pinjaman}}, {{$ref_jenis_pinjaman->jenis_angsuran}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="persentase_bunga" class="control-label">Bunga (%)</label>
                 {!! Form::number('persentase_bunga', null, ['class' => 'form-control', 'id' => 'persentase_bunga', 'readonly']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="biaya_adm" class="control-label">Biaya Administrasi</label>
                {!! Form::text('biaya_adm', null, ['class' => 'form-control', 'id' => 'biaya_adm', 'readonly']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="biaya_cppu" class="control-label">Biaya CPPU</label>
                 {!! Form::text('biaya_cppu', null, ['class' => 'form-control', 'id' => 'biaya_cppu', 'readonly']) !!}
            </div>
        </div>
        <div>
            <div class="form-group col-md-6">
                <label for="pokok" class="control-label">Pokok Pinjaman</label>
                {!! Form::text('pokok', null, ['class' => 'form-control', 'id' => 'pokok', 'readonly']) !!}
            </div>
            <div class="form-group col-md-6">
                <label for="jasa" class="control-label">Jasa Pinjaman</label>
                 {!! Form::text('jasa', null, ['class' => 'form-control', 'id' => 'jasa', 'readonly']) !!}
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="total_angsuran" class="control-label">Total Angsuran</label>
            {!! Form::text('total_angsuran', null, ['class' => 'form-control', 'id' => 'total_angsuran', 'readonly']) !!}
        </div>
    </div>
    

{!! Form::close() !!}