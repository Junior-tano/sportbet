<?php

namespace Database\Seeders;

use App\Models\Sport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sports = [
            [
                'name' => 'Football',
                'icon' => 'fa-futbol',
                'slug' => 'football',
                'active' => true,
            ],
            [
                'name' => 'Basketball',
                'icon' => 'fa-basketball-ball',
                'slug' => 'basketball',
                'active' => true,
            ],
            [
                'name' => 'Tennis',
                'icon' => 'fa-table-tennis',
                'slug' => 'tennis',
                'active' => true,
            ],
            [
                'name' => 'Baseball',
                'icon' => 'fa-baseball-ball',
                'slug' => 'baseball',
                'active' => false,
            ],
            [
                'name' => 'Hockey',
                'icon' => 'fa-hockey-puck',
                'slug' => 'hockey',
                'active' => false,
            ],
        ];

        foreach ($sports as $sport) {
            Sport::updateOrCreate(
                ['slug' => $sport['slug']],
                $sport
            );
        }
    }
}
