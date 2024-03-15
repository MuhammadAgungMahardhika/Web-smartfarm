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
        Schema::create('data_kematian', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_data_kandang')->index('fk_data_kematian_data_kandang');
            $table->integer('kematian_terbaru')->nullable();
            $table->integer('jumlah_kematian');
            $table->time('jam');
            $table->date('hari')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_kematian');
    }
};
