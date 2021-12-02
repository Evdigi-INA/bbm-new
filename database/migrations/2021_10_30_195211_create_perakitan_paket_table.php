<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerakitanPaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perakitan_paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gudang_id')->constrained('gudang');
            $table->foreignId('paket_id')->constrained('barang');
            $table->string('kode', 20);
            $table->date('tanggal');
            $table->integer('kuantitas');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('perakitan_paket');
    }
}
