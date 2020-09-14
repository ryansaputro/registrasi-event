{!! Form::model($model, [
    'route' => $model->exists ? ['anggota.update', $model->id_anggota] : 'anggota.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}
<div class="row">
    <!-- {{csrf_field()}} -->
    <div class="flex flex-col">
        <div class="form-group col-md-4">
            <label for="nik" class="control-label">NIK Anggota</label>
            {!! Form::number('nik', null, ['class' => 'form-control', 'id' => 'nik']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="no_ktp" class="control-label">No KTP</label>
            {!! Form::number('no_ktp', null, ['class' => 'form-control', 'id' => 'no_ktp']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="email" class="control-label">Email</label>
            {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
        </div>
    </div><br/>
    <div class="flex flex-col">
        <div class="form-group col-md-4">
            <label for="id_jabatan" class="control-label">Jabatan</label>
            <select id="id_jabatan" name="id_jabatan" class="form-control">
                @foreach($jabatan as $ref_jabatan)
                    <option value='{{$ref_jabatan->id_jabatan}}'>{{$ref_jabatan->nama_jabatan}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="id_divisi" class="control-label">Divisi</label>
            <select id="id_divisi" name="id_divisi"  class="form-control">
                @foreach($divisi as $ref_divisi)
                    <option value='{{$ref_divisi->id_divisi}}'>{{$ref_divisi->nama_divisi}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="notelp" class="control-label">No Handphone</label>
            {!! Form::number('notelp', null, ['class' => 'form-control', 'id' => 'notelp']) !!}
        </div>
    </div>
    <div class="flex flex-col">
        <div class="form-group col-md-8">
            <label for="full_name" class="control-label">Nama Lengkap</label>
            {!! Form::text('full_name', null, ['class' => 'form-control', 'id' => 'full_name']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="tgl_lahir" class="control-label">Tanggal Lahir</label>
            {!! Form::date('tgl_lahir', null, ['class' => 'form-control', 'id' => 'tgl_lahir']) !!}
        </div>
    </div>
    <div class="flex flex-col">
        <div class="form-group col-md-4">
            <label for="tempat_lahir" class="control-label">Tempat Lahir</label>
            {!! Form::text('tempat_lahir', null, ['class' => 'form-control', 'id' => 'tempat_lahir']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="id_kelamin" class="control-label">Jenis Kelamin</label>
            <div class="form-control">
                <div class="radio-inline">
                    {!! Form::radio('id_kelamin','1', true) !!}<p>L</p>
                </div>
                <div class="radio-inline">
                    {!! Form::radio('id_kelamin', '2') !!}<p>P</p>
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="id_marital" class="control-label">Status Marital</label>
            <select id="id_marital" name="id_marital" class="form-control">
                @foreach($marital as $ref_marital)
                    <option value='{{$ref_marital->id_marital}}'>{{$ref_marital->status_marital}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="form-group col-md-8">
            <label for="alamat" class="control-label">Alamat Lengkap</label>
            {!! Form::text('alamat', null, ['class' => 'form-control', 'id' => 'alamat']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="kodepos" class="control-label">Kode Pos</label>
            {!! Form::number('kodepos', null, ['class' => 'form-control', 'id' => 'kodepos']) !!}
        </div>
    </div>
    <div class="flex flex-col">
        <div class="form-group col-md-4">
            <label for="simpanan_pokok" class="control-label">Simpanan Pokok</label>
            {!! Form::number('simpanan_pokok', '100000', ['class' => 'form-control', 'id' => 'simpanan_pokok']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_wajib" class="control-label">Simpanan Wajib</label>
            {!! Form::number('simpanan_wajib', '100000', ['class' => 'form-control', 'id' => 'simpanan_wajib']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_sukarela" class="control-label">Simpanan Sukarela</label>
            {!! Form::number('simpanan_sukarela', '10000', ['class' => 'form-control', 'id' => 'simpanan_sukarela']) !!}
        </div>
    </div>
    <div class="flex flex-col">
        <div class="form-group col-md-8">
            <label for="simpanan_harkop" class="control-label">Simpanan Harkop</label>
            {!! Form::number('simpanan_harkop', '100000', ['class' => 'form-control', 'id' => 'simpanan_harkop']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="simpanan_kematian" class="control-label">Simpanan Kematian</label>
            {!! Form::number('simpanan_kematian', '10000', ['class' => 'form-control', 'id' => 'simpanan_kematian']) !!}
        </div>
    </div>
    <div class="flex flex-col">
        <div class="form-group col-md-8">
            <label for="foto" class="control-label">Foto</label><br>
            <div class="col-md-1">
                <img id="get_foto" value="{{$model->foto}}" src="{{ asset('assets/img/profil') }}/{{$model->foto}}" style="height:33px;margin-left:-15px;"/>
            </div>
            <div class="col-md-11" style="margin-top:0px;margin-left:0px">
            {!! Form::file('foto', ['class' => 'form-control', 'id' => 'foto']) !!}
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="id_status_aktif" class="control-label">Status Anggota</label>
            <select id="id_status_aktif" name="id_status_aktif" class="form-control">
                @foreach($aktif as $ref_aktif)
                    <option value='{{$ref_aktif->id_status_aktif}}'>{{$ref_aktif->nama_status_aktif}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{!! Form::close() !!}