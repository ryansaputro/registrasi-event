<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable //Model
{
    use Notifiable;

    // protected $guard = "anggota";

    //nama tabelnya
    protected $table = "wp_users"; //nama tabel yang digunakan
    protected $primaryKey = "ID"; //nama field primary key yang digunakan 
    public $timestamps = false; //mematikan created_at dan updated_at
    protected $connection = 'secondary';

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
       'ID', 'user_login', 'user_pass', 'user_nicename', 'user_email', 'user_url', 'user_registered', 'user_activation_key', 'user_status', 'display_name', 'is_expert', 'md5_pass', 'remember_token'
    ];

    //field apa saja yang dianggap privasi dan tidak akan ditampilkan pada view
    protected $hidden = [
        'password', 'remember_token'
    ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
   
}
