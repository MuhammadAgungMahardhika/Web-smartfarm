<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKandang extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_kandang')->insert([
            'id_kandang' => "1",
            'hari_ke' => "1",
            'pakan' => 50,
            'minum' => 30,
            'riwayat_populasi' => 20,
            'date' => Carbon::now()
        ]);
        DB::table('data_kandang')->insert([
            'id_kandang' => "2",
            'hari_ke' => "1",
            'pakan' => 55,
            'minum' => 35,
            'riwayat_populasi' => 20,
            'date' => Carbon::now()
        ]);
    }
}
