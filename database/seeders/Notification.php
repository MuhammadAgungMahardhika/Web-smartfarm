<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Notification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notification')->insert([
            'id_kandang' => 1,
            'id_user' => 1,
            'pesan' => "Halo Smartfarm ini pesan pertama",
            'status' => 1,
            'waktu' => Carbon::now(),
        ]);
    }
}
