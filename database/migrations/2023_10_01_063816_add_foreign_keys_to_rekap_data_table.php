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
        Schema::table('rekap_data', function (Blueprint $table) {
            $table->foreign(['id_kandang'], 'fk_rekap_data_kandang')->references(['id'])->on('kandang')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekap_data', function (Blueprint $table) {
            $table->dropForeign('fk_rekap_data_kandang');
        });
    }
};
