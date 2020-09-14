<a href="{{ $url_show }}" class="btn btn-success btn-sm" title="Detail Data"><i class="fa fa-eye" ></i> Lihat</a>
@if(date('Y-m-d H:i:s') < $xxx->tanggal_mulai)
<a href="{{ $url_edit }}" class="btn btn-primary btn-sm" title="Edit Data"><i class="fa fa-pencil"> Edit</i></a> 
@endif
<a href="{{ $url_list_peserta }}" class="btn btn-warning btn-sm" title="List Peserta Event {{$xxx->nama_event}}"><i class="fa fa-list" ></i> Lihat</a>