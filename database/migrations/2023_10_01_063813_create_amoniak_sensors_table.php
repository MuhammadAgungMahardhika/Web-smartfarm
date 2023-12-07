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
        Schema::create('amoniak_sensors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_kandang')->index('fk_amoniak_sensors_kandang');
            $table->timestamp('date')->useCurrentOnUpdate()->useCurrent();
            $table->integer('amoniak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amoniak_sensors');
    }
};
