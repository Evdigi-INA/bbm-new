<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiayaDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biaya_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biaya_id')->constrained('biaya')->cascadeOnDelete();
            $table->text('deskripsi');
            $table->double('jumlah', 20, 2);
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
        Schema::dropIfExists('biaya_detail');
    }
}
