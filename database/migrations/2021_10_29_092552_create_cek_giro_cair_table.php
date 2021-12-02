<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekGiroCairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cek_giro_cair', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cek_giro_id')->constrained('cek_giro')->cascadeOnDelete();
            $table->foreignId('bank_id')->nullable()->constrained('bank')->nullOnDelete();
            $table->foreignId('rekening_bank_id')->nullable()->constrained('rekening_bank')->nullOnDelete();
            $table->string('kode', 20);
            $table->date('tanggal');
            $table->enum('dicairkan_ke', ['Kas', 'Bank']);
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
        Schema::dropIfExists('cek_giro_cair');
    }
}
