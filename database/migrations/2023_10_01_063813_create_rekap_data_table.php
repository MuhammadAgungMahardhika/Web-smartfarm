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
        Schema::create('rekap_data', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_kandang')->index('fk_rekap_data_kandang');
            $table->integer('hari_ke');
            $table->date('date');
            $table->integer('rata_rata_amoniak');
            $table->integer('rata_rata_suhu');
            $table->integer('kelembapan');
            $table->integer('pakan');
            $table->integer('minum');
            $table->integer('bobot');
            $table->integer('jumlah_kematian')->nullable();
            $table->integer('jumlah_kematian_harian');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
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
        Schema::dropIfExists('rekap_data');
    }
};
