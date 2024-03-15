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
        Schema::create('notification', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_kandang')->index('fk_notification_kandang');
            $table->bigInteger('id_user', false, true)->index('fk_notification_user');
            $table->string('pesan');
            $table->boolean('status');
            $table->timestamp('waktu')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
};
