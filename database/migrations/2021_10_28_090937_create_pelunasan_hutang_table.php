<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelunasanHutangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelunasan_hutang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->nullable()->constrained('bank')->nullOnDelete();
            $table->foreignId('rekening_bank_id')->nullable()->constrained('rekening_bank')->nullOnDelete();
            $table->string('kode', 20);
            $table->date('tanggal');
            $table->double('rate', 20, 2);
            $table->enum('jenis_pembayaran', ['Cash', 'Transfer', 'Giro']);
            $table->integer('no_cek_giro')->nullable();
            $table->date('tgl_cek_giro')->nullable();
            $table->double('bayar', 20, 2);
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
        Schema::dropIfExists('pelunasan_hutang');
    }
}
