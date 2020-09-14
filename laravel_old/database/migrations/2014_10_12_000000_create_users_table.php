<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('roles_id')->unsigned()->nullable();
            $table->integer('nik')->unique();
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('bagian')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); //->nullable()
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namaRoles');
        });

        Schema::table('anggota', function (Blueprint $table) {
            $table->foreign('roles_id')->references('id')->on('anggota')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota');
        Schema::dropIfExists('roles');
    }
}
