<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable //Model
{
    use Notifiable;

    protected $guard = "anggota";

    //nama tabelnya
    protected $table = "anggota"; //nama tabel yang digunakan
    protected $primaryKey = "id_anggota"; //nama field primary key yang digunakan 
    public $timestamps = false; //mematikan created_at dan updated_at

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
        'id_anggota', 'nik', 'no_ktp', 'alamat', 'kode_pos', 'notelp', 'tempat_lahir', 'tgl_lahir',
        'jenis_kelamin', 'email', 'full_name', 'password', 'foto', 'status_aktif', 'tgl_aktif',
        'tgl_non_aktif'
    ];

    //field apa saja yang dianggap privasi dan tidak akan ditampilkan pada view
    protected $hidden = [
        'password', 'remember_token'
    ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
   
}
