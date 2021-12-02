<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelunasanHutangDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelunasan_hutang_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelunasan_hutang_id')->constrained('pelunasan_hutang')->cascadeOnDelete();
            $table->foreignId('pembelian_id')->constrained('pembelian')->cascadeOnDelete();
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
        Schema::dropIfExists('pelunasan_hutang_detail');
    }
}
