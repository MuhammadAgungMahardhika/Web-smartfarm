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
        Schema::create('kandang', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('id_user', false, true)->nullable()->index('id_user');
            $table->bigInteger('id_peternak', false, true)->nullable()->index('id_peternak');
            $table->string('nama_kandang', 50)->unique('nama_kandang');
            $table->integer('populasi_awal');
            $table->integer('populasi_saat_ini');
            $table->string('alamat_kandang', 255);
            $table->float('luas_kandang')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif');
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('kandang');
    }
};
