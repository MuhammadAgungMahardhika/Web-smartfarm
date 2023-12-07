<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            'Admin',
            'Pemilik',
            'Peternak'
        ];

        for ($i=0; $i < count($data); $i++) {
            $nama_role = $data[$i];

            DB::table('roles')->insert([
                'nama_role' => $nama_role
            ]);
        }
    }
}
