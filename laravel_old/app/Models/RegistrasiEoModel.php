<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiEoModel extends Model //Model
{

    //nama tabelnya
    protected $table = "registrasi_eo"; //nama tabel yang digunakan
    protected $primaryKey = "id"; //nama field primary key yang digunakan 
    public $timestamps = true; //mematikan created_at dan updated_at

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
       'id', 'id_member', 'kode', 'nama', 'kontak', 'no_hp_kontak', 'no_wa_kontak', 'id_provinsi', 'id_kota', 'alamat', 'kode_pos', 'alamat_web', 'logo', 'status', 'created_at', 'updated_at'
    ];

   
}
