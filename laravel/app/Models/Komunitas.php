<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Komunitas extends Authenticatable //Model
{
    //nama tabelnya
    protected $table = "wp_nci_community"; //nama tabel yang digunakan
    protected $primaryKey = "id_community"; //nama field primary key yang digunakan 
    public $timestamps = false; //mematikan created_at dan updated_at
    protected $connection = 'secondary';

    //field apa saja yang ada pada tabel tersebut
    protected $fillable = [
       'id_community', 'name_community', 'city', 'community_category', 'id_users', 'community_total_member', 'community_motto', 'community_logo', 'community_background', 'description', 'created_at', 'updated_at', 'status', 'contact_person', 'base_camp'
    ];

}
