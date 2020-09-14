<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiEventJerseyModel extends Model //Model
{

    //nama tabelnya
    protected $table = "registrasi_event_jersey"; //nama tabel yang digunakan
    protected $primaryKey = "id"; //nama field primary key yang digunakan 
    public $timestamps = false; //mematikan created_at dan updated_at

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
       'id', 'model', 'id_event', 'size', 'ukuran', 'id_jersey_darimana'
    ];

   
}
