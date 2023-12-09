<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Kandang extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kandang')->insert([
            'id_user' => 2,
            'id_peternak' => 3,
            'nama_kandang' => "Kandang 1",
            'populasi_awal' => 20,
            'alamat_kandang' => "Jln Kandang 1",
        ]);
        DB::table('kandang')->insert([
            'id_user' => 2,
            'id_peternak' => 3,
            'nama_kandang' => "Kandang 2",
            'populasi_awal' => 23,
            'alamat_kandang' => "Jln Kandang 2",
        ]);
    }
}
