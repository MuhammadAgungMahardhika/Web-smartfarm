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
        Schema::create('data_kandang', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_kandang')->index('fk_data_kandang_kandang');
            $table->integer('hari_ke');
            $table->integer('pakan');
            $table->integer('minum');
            $table->integer('riwayat_populasi')->nullable();;
            $table->date('date');
            $table->enum('classification', ['normal', 'abnormal'])->default('normal');
            $table->timestamp('created_at')->useCurrent();
            $table->integer('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            // Menambahkan constraint unique pada kombinasi kolom id_kandang dan date
            $table->unique(['id_kandang', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_kandang');
    }
};
