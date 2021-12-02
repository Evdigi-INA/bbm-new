<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('penjualan')->onDelete('cascade');
            $table->foreignId('bank_id')->nullable()->constrained('bank')->nullOnDelete();
            $table->foreignId('rekening_bank_id')->nullable()->constrained('rekening_bank')->nullOnDelete();
            $table->enum('jenis_pembayaran', ['Cash', 'Transfer', 'Giro']);
            $table->integer('no_cek_giro')->nullable();
            $table->date('tgl_cek_giro')->nullable();
            $table->double('bayar', 20, 2);
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
        Schema::dropIfExists('penjualan_pembayaran');
    }
}
