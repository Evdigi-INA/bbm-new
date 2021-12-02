<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekGiroTolakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cek_giro_tolak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cek_giro_id')->constrained('cek_giro')->cascadeOnDelete();
            $table->string('kode', 20);
            $table->date('tanggal');
            $table->text('keterangan');
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
        Schema::dropIfExists('cek_giro_tolak');
    }
}
