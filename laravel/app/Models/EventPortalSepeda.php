<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPortalSepeda extends Model
{
    //nama tabelnya
    protected $table = "wp_nci_event_type"; //nama tabel yang digunakan
    protected $primaryKey = "id"; //nama field primary key yang digunakan 
    public $timestamps = false; //mematikan created_at dan updated_at
    protected $connection = 'secondary';

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
        'id', 'name', 'description', 'status', 'created_at', 'id_users'
    ];

}
