<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelian')->cascadeOnDelete();
            $table->foreignId('gudang_id')->constrained('gudang')->cascadeOnDelete();
            $table->string('kode', 20);
            $table->date('tanggal');
            $table->double('rate', 20, 2);
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retur_pembelian');
    }
}
