<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('villes')->insert([
            ['nom' => 'Cotonou'],
            ['nom' => 'Porto-Novo'],
            ['nom' => 'Parakou'],
            ['nom' => 'Abomey-Calavi'],
        ]);
    }
}
