<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserMeta extends Authenticatable //Model
{
    use Notifiable;

    // protected $guard = "anggota";

    //nama tabelnya
    protected $table = "wp_usermeta"; //nama tabel yang digunakan
    protected $primaryKey = "umeta_id"; //nama field primary key yang digunakan 
    public $timestamps = false; //mematikan created_at dan updated_at
    protected $connection = 'secondary';

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
       'umeta_id', 'user_id', 'meta_key', 'meta_value'
    ];

}
