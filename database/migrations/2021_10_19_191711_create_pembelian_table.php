<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 25);
            $table->date('tanggal');

            $table->unsignedBigInteger('pesanan_pembelian_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();

            $table->foreignId('matauang_id')->constrained('matauang');
            $table->foreignId('gudang_id')->constrained('gudang');
            $table->double('rate', 20, 2);
            $table->string('bentuk_kepemilikan_stok', 20);
            $table->text('keterangan')->nullable();
            $table->double('subtotal', 20, 2);
            $table->double('total_ppn', 20, 2);
            $table->double('total_pph', 20, 2);
            $table->double('total_gross', 20, 2);
            $table->double('total_biaya_masuk', 20, 2);
            $table->double('total_clr_fee', 20, 2);
            $table->double('total_diskon', 20, 2);
            $table->double('total_netto', 20, 2);
            $table->timestamps();

            $table->foreign('pesanan_pembelian_id')->references('id')->on('pesanan_pembelian')->nullOnDelete();
            $table->foreign('supplier_id')->references('id')->on('supplier')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}
