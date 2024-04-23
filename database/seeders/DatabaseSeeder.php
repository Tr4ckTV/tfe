<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Créer 10 utilisateurs fictifs
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => 'Administrateur',
                'email' => 'Elodie.toche@gmail.com',
                'password' => Hash::make('Admin123'),
                'created_at' => now(),
                'updated_at' => now(),
                'type_membre_id' => 1,
            ]);
        }
    }
}

