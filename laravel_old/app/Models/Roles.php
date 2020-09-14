<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //
    protected $table = 'roles';

    //tabel roles punya relasi dengan tabel users
    // public function user()
    // {
    //     return $this->hasMany(User::class);
    // }
}
