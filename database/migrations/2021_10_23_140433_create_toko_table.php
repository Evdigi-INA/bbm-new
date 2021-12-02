<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toko', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telp1')->nullable();
            $table->string('email')->nullable();
            $table->text('deskripsi');
            $table->string('telp2')->nullable();
            $table->string('npwp')->nullable();
            $table->string('fax')->nullable();
            $table->string('nppkp')->nullable();
            $table->string('website')->nullable();
            $table->date('tgl_pkp')->nullable();
            $table->text('alamat');
            $table->string('kota')->nullable();
            $table->char('kode_pos', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toko');
    }
}
