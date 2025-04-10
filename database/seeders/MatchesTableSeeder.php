<?php

namespace Database\Seeders;

use App\Models\GameMatch;
use App\Models\Sport;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Football Matches
        $footballSport = Sport::where('slug', 'football')->first();
        
        if ($footballSport) {
            $footballTeams = Team::where('sport_id', $footballSport->id)->get();
            
            if ($footballTeams->count() >= 8) {
                $footballMatches = [
                    [
                        'home_team_id' => $footballTeams[0]->id, // Real Madrid
                        'away_team_id' => $footballTeams[1]->id, // Barcelona
                        'match_date' => Carbon::now()->addDays(5)->setHour(20)->setMinute(0),
                        'venue' => 'Santiago Bernabéu',
                        'home_odds' => 1.5,
                        'away_odds' => 2.5,
                        'draw_odds' => 3.2,
                        'popularity' => 95,
                    ],
                    [
                        'home_team_id' => $footballTeams[2]->id, // Manchester City
                        'away_team_id' => $footballTeams[3]->id, // Liverpool
                        'match_date' => Carbon::now()->addDays(6)->setHour(18)->setMinute(30),
                        'venue' => 'Etihad Stadium',
                        'home_odds' => 1.9,
                        'away_odds' => 3.5,
                        'draw_odds' => 3.2,
                        'popularity' => 88,
                    ],
                    [
                        'home_team_id' => $footballTeams[4]->id, // Bayern Munich
                        'away_team_id' => $footballTeams[5]->id, // Borussia Dortmund
                        'match_date' => Carbon::now()->addDays(7)->setHour(15)->setMinute(30),
                        'venue' => 'Allianz Arena',
                        'home_odds' => 1.6,
                        'away_odds' => 4.2,
                        'draw_odds' => 3.5,
                        'popularity' => 92,
                    ],
                    [
                        'home_team_id' => $footballTeams[6]->id, // PSG
                        'away_team_id' => $footballTeams[7]->id, // Marseille
                        'match_date' => Carbon::now()->addDays(10)->setHour(20)->setMinute(0),
                        'venue' => 'Parc des Princes',
                        'home_odds' => 1.45,
                        'away_odds' => 6.5,
                        'draw_odds' => 4.2,
                        'popularity' => 87,
                    ],
                ];

                foreach ($footballMatches as $match) {
                    GameMatch::updateOrCreate(
                        [
                            'home_team_id' => $match['home_team_id'],
                            'away_team_id' => $match['away_team_id'],
                            'match_date' => $match['match_date'],
                        ],
                        array_merge($match, ['sport_id' => $footballSport->id])
                    );
                }
            }
        }

        // Basketball Matches
        $basketballSport = Sport::where('slug', 'basketball')->first();
        
        if ($basketballSport) {
            $basketballTeams = Team::where('sport_id', $basketballSport->id)->get();
            
            if ($basketballTeams->count() >= 8) {
                $basketballMatches = [
                    [
                        'home_team_id' => $basketballTeams[0]->id, // LA Lakers
                        'away_team_id' => $basketballTeams[1]->id, // Boston Celtics
                        'match_date' => Carbon::now()->addDays(2)->setHour(20)->setMinute(0),
                        'venue' => 'Staples Center',
                        'home_odds' => 1.8,
                        'away_odds' => 2.0,
                        'draw_odds' => null, // No draw in basketball
                        'popularity' => 90,
                    ],
                    [
                        'home_team_id' => $basketballTeams[2]->id, // Brooklyn Nets
                        'away_team_id' => $basketballTeams[3]->id, // Chicago Bulls
                        'match_date' => Carbon::now()->addDays(4)->setHour(18)->setMinute(0),
                        'venue' => 'Barclays Center',
                        'home_odds' => 1.65,
                        'away_odds' => 2.3,
                        'draw_odds' => null,
                        'popularity' => 75,
                    ],
                    [
                        'home_team_id' => $basketballTeams[4]->id, // Golden State Warriors
                        'away_team_id' => $basketballTeams[5]->id, // Phoenix Suns
                        'match_date' => Carbon::now()->addDays(8)->setHour(19)->setMinute(0),
                        'venue' => 'Chase Center',
                        'home_odds' => 1.75,
                        'away_odds' => 2.1,
                        'draw_odds' => null,
                        'popularity' => 82,
                    ],
                    [
                        'home_team_id' => $basketballTeams[6]->id, // Milwaukee Bucks
                        'away_team_id' => $basketballTeams[7]->id, // Miami Heat
                        'match_date' => Carbon::now()->addDays(9)->setHour(18)->setMinute(30),
                        'venue' => 'Fiserv Forum',
                        'home_odds' => 1.7,
                        'away_odds' => 2.2,
                        'draw_odds' => null,
                        'popularity' => 76,
                    ],
                ];

                foreach ($basketballMatches as $match) {
                    GameMatch::updateOrCreate(
                        [
                            'home_team_id' => $match['home_team_id'],
                            'away_team_id' => $match['away_team_id'],
                            'match_date' => $match['match_date'],
                        ],
                        array_merge($match, ['sport_id' => $basketballSport->id])
                    );
                }
            }
        }

        // Tennis Matches
        $tennisSport = Sport::where('slug', 'tennis')->first();
        
        if ($tennisSport) {
            $tennisPlayers = Team::where('sport_id', $tennisSport->id)->get();
            
            if ($tennisPlayers->count() >= 8) {
                $tennisMatches = [
                    [
                        'home_team_id' => $tennisPlayers[0]->id, // Roger Federer
                        'away_team_id' => $tennisPlayers[1]->id, // Rafael Nadal
                        'match_date' => Carbon::now()->addDays(3)->setHour(16)->setMinute(0),
                        'venue' => 'Wimbledon',
                        'home_odds' => 2.2,
                        'away_odds' => 1.7,
                        'draw_odds' => null, // No draw in tennis
                        'popularity' => 85,
                    ],
                    [
                        'home_team_id' => $tennisPlayers[2]->id, // Novak Djokovic
                        'away_team_id' => $tennisPlayers[3]->id, // Carlos Alcaraz
                        'match_date' => Carbon::now()->addDays(7)->setHour(14)->setMinute(0),
                        'venue' => 'Roland Garros',
                        'home_odds' => 1.85,
                        'away_odds' => 1.95,
                        'draw_odds' => null,
                        'popularity' => 80,
                    ],
                    [
                        'home_team_id' => $tennisPlayers[4]->id, // Serena Williams
                        'away_team_id' => $tennisPlayers[5]->id, // Naomi Osaka
                        'match_date' => Carbon::now()->addDays(10)->setHour(13)->setMinute(0),
                        'venue' => 'US Open',
                        'home_odds' => 2.0,
                        'away_odds' => 1.8,
                        'draw_odds' => null,
                        'popularity' => 78,
                    ],
                    [
                        'home_team_id' => $tennisPlayers[6]->id, // Daniil Medvedev
                        'away_team_id' => $tennisPlayers[7]->id, // Alexander Zverev
                        'match_date' => Carbon::now()->addDays(12)->setHour(15)->setMinute(0),
                        'venue' => 'Australian Open',
                        'home_odds' => 1.9,
                        'away_odds' => 1.9,
                        'draw_odds' => null,
                        'popularity' => 70,
                    ],
                ];

                foreach ($tennisMatches as $match) {
                    GameMatch::updateOrCreate(
                        [
                            'home_team_id' => $match['home_team_id'],
                            'away_team_id' => $match['away_team_id'],
                            'match_date' => $match['match_date'],
                        ],
                        array_merge($match, ['sport_id' => $tennisSport->id])
                    );
                }
            }
        }
    }
}
