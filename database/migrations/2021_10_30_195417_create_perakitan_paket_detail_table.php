<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerakitanPaketDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perakitan_paket_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perakitan_paket_id')->constrained('perakitan_paket')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang');
            $table->string('bentuk_kepemilikan_stok', 20);
            $table->integer('qty');
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
        Schema::dropIfExists('perakitan_paket_detail');
    }
}
