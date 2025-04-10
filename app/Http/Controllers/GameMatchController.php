<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Sport;
use App\Models\Team;
use Illuminate\Http\Request;

class GameMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les matchs depuis la base de données
        $matches = GameMatch::with(['sport', 'homeTeam', 'awayTeam'])->get();
        
        // Si aucun match n'est trouvé, vérifier si nous devons les seeder
        if ($matches->isEmpty()) {
            return $this->createMockMatches();
        }
        
        // Transformer les données pour correspondre au format attendu par le frontend
        $formattedMatches = $matches->map(function ($match) {
            return [
                'id' => (string) $match->id,
                'homeTeam' => $match->homeTeam->name,
                'awayTeam' => $match->awayTeam->name,
                'homeOdds' => (float) $match->home_odds,
                'awayOdds' => (float) $match->away_odds,
                'drawOdds' => $match->draw_odds ? (float) $match->draw_odds : null,
                'date' => $match->match_date->toIso8601String(),
                'venue' => $match->venue,
                'sport' => $match->sport->slug,
                'popularity' => $match->popularity,
            ];
        });
        
        return $formattedMatches;
    }
    
    /**
     * Create mock matches in the database if none exist
     */
    private function createMockMatches()
    {
        // Vérifier si les sports existent, sinon les créer
        if (Sport::count() === 0) {
            $football = Sport::create(['name' => 'Football', 'slug' => 'football', 'icon' => 'fa-futbol', 'active' => true]);
            $basketball = Sport::create(['name' => 'Basketball', 'slug' => 'basketball', 'icon' => 'fa-basketball-ball', 'active' => true]);
            $tennis = Sport::create(['name' => 'Tennis', 'slug' => 'tennis', 'icon' => 'fa-table-tennis', 'active' => true]);
        } else {
            $football = Sport::where('slug', 'football')->first();
            $basketball = Sport::where('slug', 'basketball')->first();
            $tennis = Sport::where('slug', 'tennis')->first();
        }
        
        // Vérifier si les équipes existent, sinon les créer
        $teams = [
            // Football
            ['name' => 'Real Madrid', 'sport_id' => $football->id, 'country' => 'Espagne', 'city' => 'Madrid'],
            ['name' => 'Barcelona', 'sport_id' => $football->id, 'country' => 'Espagne', 'city' => 'Barcelone'],
            ['name' => 'Manchester City', 'sport_id' => $football->id, 'country' => 'Angleterre', 'city' => 'Manchester'],
            ['name' => 'Liverpool', 'sport_id' => $football->id, 'country' => 'Angleterre', 'city' => 'Liverpool'],
            ['name' => 'Bayern Munich', 'sport_id' => $football->id, 'country' => 'Allemagne', 'city' => 'Munich'],
            ['name' => 'Borussia Dortmund', 'sport_id' => $football->id, 'country' => 'Allemagne', 'city' => 'Dortmund'],
            ['name' => 'Paris Saint-Germain', 'sport_id' => $football->id, 'country' => 'France', 'city' => 'Paris'],
            ['name' => 'Olympique de Marseille', 'sport_id' => $football->id, 'country' => 'France', 'city' => 'Marseille'],
            
            // Basketball
            ['name' => 'Los Angeles Lakers', 'sport_id' => $basketball->id, 'country' => 'USA', 'city' => 'Los Angeles'],
            ['name' => 'Boston Celtics', 'sport_id' => $basketball->id, 'country' => 'USA', 'city' => 'Boston'],
            ['name' => 'Brooklyn Nets', 'sport_id' => $basketball->id, 'country' => 'USA', 'city' => 'Brooklyn'],
            ['name' => 'Chicago Bulls', 'sport_id' => $basketball->id, 'country' => 'USA', 'city' => 'Chicago'],
            ['name' => 'Golden State Warriors', 'sport_id' => $basketball->id, 'country' => 'USA', 'city' => 'San Francisco'],
            ['name' => 'Phoenix Suns', 'sport_id' => $basketball->id, 'country' => 'USA', 'city' => 'Phoenix'],
            ['name' => 'Milwaukee Bucks', 'sport_id' => $basketball->id, 'country' => 'USA', 'city' => 'Milwaukee'],
            ['name' => 'Miami Heat', 'sport_id' => $basketball->id, 'country' => 'USA', 'city' => 'Miami'],
            
            // Tennis (traités comme des équipes pour simplifier)
            ['name' => 'Roger Federer', 'sport_id' => $tennis->id, 'country' => 'Suisse', 'city' => 'Bâle'],
            ['name' => 'Rafael Nadal', 'sport_id' => $tennis->id, 'country' => 'Espagne', 'city' => 'Manacor'],
            ['name' => 'Novak Djokovic', 'sport_id' => $tennis->id, 'country' => 'Serbie', 'city' => 'Belgrade'],
            ['name' => 'Carlos Alcaraz', 'sport_id' => $tennis->id, 'country' => 'Espagne', 'city' => 'El Palmar'],
            ['name' => 'Serena Williams', 'sport_id' => $tennis->id, 'country' => 'USA', 'city' => 'Compton'],
            ['name' => 'Naomi Osaka', 'sport_id' => $tennis->id, 'country' => 'Japon', 'city' => 'Osaka'],
            ['name' => 'Daniil Medvedev', 'sport_id' => $tennis->id, 'country' => 'Russie', 'city' => 'Moscou'],
            ['name' => 'Alexander Zverev', 'sport_id' => $tennis->id, 'country' => 'Allemagne', 'city' => 'Hambourg'],
        ];
        
        foreach ($teams as $teamData) {
            if (!Team::where('name', $teamData['name'])->exists()) {
                Team::create($teamData);
            }
        }
        
        // Créer des matchs de démonstration
        $mockMatches = [
            [
                'sport_id' => $football->id,
                'home_team_id' => Team::where('name', 'Real Madrid')->first()->id,
                'away_team_id' => Team::where('name', 'Barcelona')->first()->id,
                'match_date' => now()->addDays(2),
                'venue' => 'Santiago Bernabéu',
                'home_odds' => 10.5,
                'away_odds' => 2.5,
                'draw_odds' => 3.2,
                'popularity' => 95,
            ],
            [
                'sport_id' => $basketball->id,
                'home_team_id' => Team::where('name', 'Los Angeles Lakers')->first()->id,
                'away_team_id' => Team::where('name', 'Boston Celtics')->first()->id,
                'match_date' => now()->addDays(3),
                'venue' => 'Staples Center',
                'home_odds' => 1.8,
                'away_odds' => 2.0,
                'draw_odds' => null,
                'popularity' => 90,
            ],
            [
                'sport_id' => $tennis->id,
                'home_team_id' => Team::where('name', 'Roger Federer')->first()->id,
                'away_team_id' => Team::where('name', 'Rafael Nadal')->first()->id,
                'match_date' => now()->addDays(4),
                'venue' => 'Wimbledon',
                'home_odds' => 2.2,
                'away_odds' => 1.7,
                'draw_odds' => null,
                'popularity' => 85,
            ],
            [
                'sport_id' => $football->id,
                'home_team_id' => Team::where('name', 'Manchester City')->first()->id,
                'away_team_id' => Team::where('name', 'Liverpool')->first()->id,
                'match_date' => now()->addDays(5),
                'venue' => 'Etihad Stadium',
                'home_odds' => 1.9,
                'away_odds' => 3.5,
                'draw_odds' => 3.2,
                'popularity' => 88,
            ],
            [
                'sport_id' => $basketball->id,
                'home_team_id' => Team::where('name', 'Brooklyn Nets')->first()->id,
                'away_team_id' => Team::where('name', 'Chicago Bulls')->first()->id,
                'match_date' => now()->addDays(6),
                'venue' => 'Barclays Center',
                'home_odds' => 1.65,
                'away_odds' => 2.3,
                'draw_odds' => null,
                'popularity' => 75,
            ],
            [
                'sport_id' => $tennis->id,
                'home_team_id' => Team::where('name', 'Novak Djokovic')->first()->id,
                'away_team_id' => Team::where('name', 'Carlos Alcaraz')->first()->id,
                'match_date' => now()->addDays(7),
                'venue' => 'Roland Garros',
                'home_odds' => 1.85,
                'away_odds' => 1.95,
                'draw_odds' => null,
                'popularity' => 80,
            ],
        ];
        
        // Insérer les matchs
        foreach ($mockMatches as $matchData) {
            GameMatch::create($matchData);
        }
        
        // Récupérer et transformer les matchs maintenant créés
        return $this->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
