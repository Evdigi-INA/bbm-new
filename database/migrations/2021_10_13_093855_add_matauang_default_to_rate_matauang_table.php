<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMatauangDefaultToRateMatauangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rate_matauang', function (Blueprint $table) {
            $table->unsignedBigInteger('matauang_default')->after('matauang_id');

            $table->foreign('matauang_default')->references('id')->on('matauang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rate_matauang', function (Blueprint $table) {
            $table->dropForeign(['matauang_default']);
        });
    }
}
