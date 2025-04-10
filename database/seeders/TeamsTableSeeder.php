<?php

namespace Database\Seeders;

use App\Models\Sport;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Football teams
        $footballSport = Sport::where('slug', 'football')->first();
        
        if ($footballSport) {
            $footballTeams = [
                [
                    'name' => 'Real Madrid',
                    'country' => 'Espagne',
                    'city' => 'Madrid',
                    'stadium' => 'Santiago Bernabéu',
                ],
                [
                    'name' => 'Barcelona',
                    'country' => 'Espagne',
                    'city' => 'Barcelone',
                    'stadium' => 'Camp Nou',
                ],
                [
                    'name' => 'Manchester City',
                    'country' => 'Angleterre',
                    'city' => 'Manchester',
                    'stadium' => 'Etihad Stadium',
                ],
                [
                    'name' => 'Liverpool',
                    'country' => 'Angleterre',
                    'city' => 'Liverpool',
                    'stadium' => 'Anfield',
                ],
                [
                    'name' => 'Bayern Munich',
                    'country' => 'Allemagne',
                    'city' => 'Munich',
                    'stadium' => 'Allianz Arena',
                ],
                [
                    'name' => 'Borussia Dortmund',
                    'country' => 'Allemagne',
                    'city' => 'Dortmund',
                    'stadium' => 'Signal Iduna Park',
                ],
                [
                    'name' => 'Paris Saint-Germain',
                    'country' => 'France',
                    'city' => 'Paris',
                    'stadium' => 'Parc des Princes',
                ],
                [
                    'name' => 'Olympique de Marseille',
                    'country' => 'France',
                    'city' => 'Marseille',
                    'stadium' => 'Vélodrome',
                ],
            ];

            foreach ($footballTeams as $team) {
                Team::updateOrCreate(
                    ['name' => $team['name'], 'sport_id' => $footballSport->id],
                    array_merge($team, ['sport_id' => $footballSport->id])
                );
            }
        }

        // Basketball teams
        $basketballSport = Sport::where('slug', 'basketball')->first();
        
        if ($basketballSport) {
            $basketballTeams = [
                [
                    'name' => 'Los Angeles Lakers',
                    'country' => 'États-Unis',
                    'city' => 'Los Angeles',
                    'stadium' => 'Staples Center',
                ],
                [
                    'name' => 'Boston Celtics',
                    'country' => 'États-Unis',
                    'city' => 'Boston',
                    'stadium' => 'TD Garden',
                ],
                [
                    'name' => 'Brooklyn Nets',
                    'country' => 'États-Unis',
                    'city' => 'Brooklyn',
                    'stadium' => 'Barclays Center',
                ],
                [
                    'name' => 'Chicago Bulls',
                    'country' => 'États-Unis',
                    'city' => 'Chicago',
                    'stadium' => 'United Center',
                ],
                [
                    'name' => 'Golden State Warriors',
                    'country' => 'États-Unis',
                    'city' => 'San Francisco',
                    'stadium' => 'Chase Center',
                ],
                [
                    'name' => 'Phoenix Suns',
                    'country' => 'États-Unis',
                    'city' => 'Phoenix',
                    'stadium' => 'Footprint Center',
                ],
                [
                    'name' => 'Milwaukee Bucks',
                    'country' => 'États-Unis',
                    'city' => 'Milwaukee',
                    'stadium' => 'Fiserv Forum',
                ],
                [
                    'name' => 'Miami Heat',
                    'country' => 'États-Unis',
                    'city' => 'Miami',
                    'stadium' => 'FTX Arena',
                ],
            ];

            foreach ($basketballTeams as $team) {
                Team::updateOrCreate(
                    ['name' => $team['name'], 'sport_id' => $basketballSport->id],
                    array_merge($team, ['sport_id' => $basketballSport->id])
                );
            }
        }

        // Tennis "teams" (players)
        $tennisSport = Sport::where('slug', 'tennis')->first();
        
        if ($tennisSport) {
            $tennisPlayers = [
                [
                    'name' => 'Roger Federer',
                    'country' => 'Suisse',
                ],
                [
                    'name' => 'Rafael Nadal',
                    'country' => 'Espagne',
                ],
                [
                    'name' => 'Novak Djokovic',
                    'country' => 'Serbie',
                ],
                [
                    'name' => 'Carlos Alcaraz',
                    'country' => 'Espagne',
                ],
                [
                    'name' => 'Serena Williams',
                    'country' => 'États-Unis',
                ],
                [
                    'name' => 'Naomi Osaka',
                    'country' => 'Japon',
                ],
                [
                    'name' => 'Daniil Medvedev',
                    'country' => 'Russie',
                ],
                [
                    'name' => 'Alexander Zverev',
                    'country' => 'Allemagne',
                ],
            ];

            foreach ($tennisPlayers as $player) {
                Team::updateOrCreate(
                    ['name' => $player['name'], 'sport_id' => $tennisSport->id],
                    array_merge($player, ['sport_id' => $tennisSport->id])
                );
            }
        }
    }
}
