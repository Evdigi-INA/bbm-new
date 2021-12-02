<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->date('tanggal');
            // $table->foreignId('supplier_id')->constrained('supplier');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreignId('matauang_id')->constrained('matauang');
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
        Schema::dropIfExists('pesanan_pembelian');
    }
}
