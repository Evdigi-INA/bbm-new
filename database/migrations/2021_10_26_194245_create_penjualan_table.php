<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20);
            $table->date('tanggal');
            $table->foreignId('pesanan_penjualan_id')->nullable()->constrained('pesanan_penjualan');
            $table->foreignId('gudang_id')->nullable()->constrained('gudang');
            $table->foreignId('matauang_id')->nullable()->constrained('matauang');
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggan');
            $table->foreignId('salesman_id')->nullable()->constrained('salesman');
            $table->double('rate', 20, 2);
            $table->string('bentuk_kepemilikan_stok', 20);
            $table->text('keterangan')->nullable();
            $table->text('alamat')->nullable();
            $table->double('subtotal', 20, 2);
            $table->double('total_diskon', 20, 2);
            $table->double('total_gross', 20, 2);
            $table->double('total_ppn', 20, 2);
            $table->double('total_biaya_kirim', 20, 2);
            $table->double('total_netto', 20, 2);
            // total netto + biaya kirim
            $table->double('total_penjualan', 20, 2);
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
        Schema::dropIfExists('penjualan');
    }
}
