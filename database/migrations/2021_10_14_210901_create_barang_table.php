<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 15);
            $table->string('nama');
            $table->tinyInteger('jenis');
            $table->foreignId('kategori_id')->constrained('kategori');
            $table->foreignId('satuan_id')->constrained('satuan_barang');
            $table->foreignId('harga_beli_matauang')->constrained('matauang');
            $table->foreignId('harga_jual_matauang')->constrained('matauang');
            $table->double('harga_beli', 20, 2);
            $table->double('harga_jual', 20, 2);
            $table->double('harga_jual_min', 20, 2);
            $table->integer('stok');
            $table->integer('min_stok');
            $table->string('gambar')->nullable();
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
        Schema::dropIfExists('barang');
    }
}
