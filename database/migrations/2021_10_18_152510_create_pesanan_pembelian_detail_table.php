<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananPembelianDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan_pembelian_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_pembelian_id')->constrained('pesanan_pembelian')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang');
            $table->integer('qty');
            $table->double('harga', 20, 2);
            $table->double('diskon_persen', 20, 2)->nullable();
            $table->double('diskon', 20, 2)->nullable();
            $table->double('ppn', 20, 2)->nullable();
            $table->double('pph', 20, 2)->nullable();
            $table->double('biaya_masuk', 20, 2)->nullable();
            $table->double('clr_fee', 20, 2)->nullable();
            $table->double('gross', 20, 2);
            $table->double('netto', 20, 2);
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
        Schema::dropIfExists('pesanan_pembelian_detail');
    }
}
