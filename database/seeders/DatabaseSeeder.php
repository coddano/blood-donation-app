<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Création de l'admin
        User::factory()->create([
            'name' => 'Admin Dano',
            'email' => 'admin@dano.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]); 

        //Creation d'utilisateurs normaux

        User::factory(5)->create();

        $this->call([
            VilleSeeder::class,
            GroupeSanguinSeeder::class,
        ]);
    }
}
