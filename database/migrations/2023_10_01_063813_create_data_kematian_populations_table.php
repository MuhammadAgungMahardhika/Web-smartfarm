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
        Schema::create('data_kematian_populations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_population')->index('fk_data_kematian_population');
            $table->integer('total_kematian');
            $table->integer('jam');
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
        Schema::dropIfExists('data_kematian_populations');
    }
};
