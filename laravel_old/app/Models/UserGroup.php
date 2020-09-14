<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model //Model
{

    //nama tabelnya
    protected $table = "zmember"; //nama tabel yang digunakan
    // protected $primaryKey = "id"; //nama field primary key yang digunakan 
    public $timestamps = false; //mematikan created_at dan updated_at

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
        'group_id', 'id_anggota'
    ];

   
}
