<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voidk
     */
    public function up()
    {
        Schema::create('pembelian_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelian')->onDelete('cascade');

            $table->unsignedBigInteger('bank_id')->nullable();
            $table->unsignedBigInteger('rekening_bank_id')->nullable();

            $table->enum('jenis_pembayaran', ['Cash', 'Transfer', 'Giro']);
            $table->integer('no_cek_giro')->nullable();
            $table->date('tgl_cek_giro')->nullable();
            $table->double('bayar', 20, 2);
            $table->timestamps();

            $table->foreign('bank_id')->references('id')->on('bank')->nullOnDelete();
            $table->foreign('rekening_bank_id')->references('id')->on('rekening_bank')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_payment');
    }
}
