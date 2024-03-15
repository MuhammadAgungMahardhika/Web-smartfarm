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
        Schema::table('notification', function (Blueprint $table) {
            $table->foreign(['id_kandang'], 'fk_notification_kandang')->references(['id'])->on('kandang');
            $table->foreign(['id_user'], 'fk_notification_user')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropForeign('fk_notification_kandang');
            $table->dropForeign('fk_notification_user');
        });
    }
};
