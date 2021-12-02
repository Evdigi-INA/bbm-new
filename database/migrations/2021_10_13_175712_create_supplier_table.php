<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 10);
            $table->string('nama_supplier');
            $table->string('npwp')->nullable();
            $table->string('nppkp')->nullable();
            $table->date('tgl_pkp');
            $table->text('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->char('kode_pos', 10)->nullable();
            $table->string('telp1')->nullable();
            $table->string('telp2')->nullable();
            $table->string('nama_kontak')->nullable();
            $table->string('telp_kontak')->nullable();
            $table->integer('top')->nullable();
            $table->char('status', 5)->nullable();
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
        Schema::dropIfExists('supplier');
    }
}
