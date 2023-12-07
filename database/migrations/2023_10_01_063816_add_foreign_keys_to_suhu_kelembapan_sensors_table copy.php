<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suhu_kelembapan_sensors', function (Blueprint $table) {
            $table->foreign(['id_kandang'], 'fk_suhu_kelembapan_sensors_kandang')->references(['id'])->on('kandang')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suhu_kelembapan_sensors', function (Blueprint $table) {
            $table->dropForeign('fk_suhu_kelembapan_sensors_kandang');
        });
    }
};
