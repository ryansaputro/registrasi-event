<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiPesertaEventModel extends Model //Model
{

    //nama tabelnya
    protected $table = "registrasi_peserta_event"; //nama tabel yang digunakan
    protected $primaryKey = "id"; //nama field primary key yang digunakan 
    public $timestamps = true; //mematikan created_at dan updated_at

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
       'id', 'id_event', 'id_member', 'tanggal', 'nama_kontak', 'hubungan_kontak', 'no_telp', 'is_free', 'status_pembayaran', 'jumlah_bayar', 'created_at', 'updated_at'
    ];

   
}
