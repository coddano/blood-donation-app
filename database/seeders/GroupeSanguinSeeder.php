<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupeSanguinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groupe_sanguins')->insert([
            ['nom'=> 'A+'],
            ['nom' => 'B+'],
            ['nom' => 'AB+'],
            ['nom' =>'O+'],
        ]);
    }
}
