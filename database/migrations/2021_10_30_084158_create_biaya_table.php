<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiayaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biaya', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matauang_id')->constrained('matauang');
            $table->foreignId('bank_id')->nullable()->constrained('bank');
            $table->foreignId('rekening_bank_id')->nullable()->constrained('rekening_bank');
            $table->string('kode', 20);
            $table->date('tanggal');
            $table->enum('jenis_transaksi', ['Pemasukan', 'Pengeluaran']);
            $table->enum('kas_bank', ['Kas', 'Bank']);
            $table->text('keterangan')->nullable();
            $table->double('rate', 20, 2);
            $table->double('total', 20, 2);
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
        Schema::dropIfExists('biaya');
    }
}
