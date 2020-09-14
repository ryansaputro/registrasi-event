<?php

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Faker\Provider\es_PE\Person;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'nik' => $faker->unique()->randomNumber($nbDigits = 8),
        'roles' => $faker->unique()->randomNumber($nbDigits = 8),
        'nama' => $faker->name,
        'jabatan' => 'staff',
        'bagian' => 'sekretariat',
        'status_pegawai' => 'PDAM',
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('oriza'), // password
        'remember_token' => Str::random(10),
    ];
});
