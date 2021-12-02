<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentMinusDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment_minus_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adjustment_minus_id')->constrained('adjustment_minus')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang');
            $table->foreignId('supplier_id')->constrained('supplier');
            $table->string('bentuk_kepemilikan_stok', 20);
            $table->integer('qty');
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
        Schema::dropIfExists('adjustment_minus_detail');
    }
}
