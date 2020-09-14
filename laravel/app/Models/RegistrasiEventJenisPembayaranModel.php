<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiEventJenisPembayaranModel extends Model //Model
{

    //nama tabelnya
    protected $table = "registrasi_event_jenis_pembayaran"; //nama tabel yang digunakan
    protected $primaryKey = "id"; //nama field primary key yang digunakan 
    public $timestamps = false; //mematikan created_at dan updated_at

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
        'id', 'id_event', 'jenis_pembayaran', 'tanggal', 'tanggal_bayar', 'harga',  'tanggal_ekstra', 'tanggal_bayar_ekstra', 'harga_ekstra', 'updated_by', 'updated_at'
    ];

   
}
