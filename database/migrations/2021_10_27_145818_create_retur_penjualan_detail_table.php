<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturPenjualanDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retur_penjualan_id')->constrained('retur_penjualan')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang');
            $table->integer('qty_beli');
            $table->integer('qty_retur');
            $table->double('harga', 20, 2);
            $table->double('diskon_persen', 20, 2)->nullable();
            $table->double('diskon', 20, 2)->nullable();
            $table->double('ppn', 20, 2)->nullable();
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
        Schema::dropIfExists('retur_penjualan_detail');
    }
}
