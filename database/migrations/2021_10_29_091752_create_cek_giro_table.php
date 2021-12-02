<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekGiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cek_giro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->nullable()->constrained('pembelian')->cascadeOnDelete();
            $table->foreignId('penjualan_id')->nullable()->constrained('penjualan')->cascadeOnDelete();
            // Out = Pembelian, In = Penjualan
            $table->enum('jenis_cek', ['Out', 'In']);
            $table->enum('status', ['Belum Lunas', 'Cair', 'Tolak']);
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
        Schema::dropIfExists('cek_giro');
    }
}
