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
        Schema::table('data_kematian_populations', function (Blueprint $table) {
            $table->foreign(['id_population'], 'fk_data_kematian_population')->references(['id'])->on('populations')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_kematian_populations', function (Blueprint $table) {
            $table->dropForeign('fk_data_kematian_population');
        });
    }
};
