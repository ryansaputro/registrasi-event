<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiPesertaEventPembayaranModel extends Model //Model
{

    //nama tabelnya
    protected $table = "registrasi_peserta_event_pembayaran"; //nama tabel yang digunakan
    protected $primaryKey = "id"; //nama field primary key yang digunakan 
    public $timestamps = true; //mematikan created_at dan updated_at

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
       'id', 'id_event', 'id_member', 'bank', 'atas_nama', 'bukti', 'jumlah', 'status_approve', 'approval_oleh', 'jumlah_approval', 'tanggal_approval', 'no_unik','created_at', 'updated_at'
    ];

   
}
