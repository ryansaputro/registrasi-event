<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiEventModel extends Model //Model
{

    //nama tabelnya
    protected $table = "registrasi_event"; //nama tabel yang digunakan
    protected $primaryKey = "id"; //nama field primary key yang digunakan 
    public $timestamps = true; //mematikan created_at dan updated_at

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
       'id', 'kode_event', 'nama_event', 'tanggal_mulai', 'tanggal_akhir', 'tanggal_awal_pendaftaran', 'tanggal_akhir_pendaftaran','tempat_event', 'id_provinsi', 'id_kota', 'id_kecamatan', 'id_desa', 'kode_pos', 'waktu_kumpul', 'tempat_kumpul', 'deskripsi_event', 'url_event', 'url_lain', 'created_at', 'updated_at', 'id_eo', 'id_jenis_event', 'sponsor', 'jumlah_peserta', 'e_poster', 'desain_mockup', 'syarat_dan_ketentuan'
    ];

   
}
