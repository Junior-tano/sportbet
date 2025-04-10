<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ordre important pour respecter les relations entre tables
        $this->call([
            SportsTableSeeder::class,
            TeamsTableSeeder::class,
            MatchesTableSeeder::class,
        ]);
    }
}
