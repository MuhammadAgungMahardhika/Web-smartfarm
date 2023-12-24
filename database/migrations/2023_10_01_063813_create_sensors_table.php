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
        Schema::create('sensors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_kandang')->index('fk_sensors_kandang');
            $table->double('suhu', 15, 3);
            $table->double('kelembapan', 15, 3);
            $table->double('amonia', 15, 3);
            $table->boolean('is_outlier')->default(false);
            $table->timestamp('datetime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensors');
    }
};
