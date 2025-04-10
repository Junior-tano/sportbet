<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bet;
use App\Models\GameMatch;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord de l'utilisateur avec ses paris et les matchs à venir
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les paris récents de l'utilisateur
        $recentBets = Bet::with(['match', 'match.homeTeam', 'match.awayTeam', 'match.sport'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Récupérer les matchs à venir
        $upcomingMatches = GameMatch::with(['sport', 'homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->orderBy('match_date', 'asc')
            ->take(5)
            ->get();
            
        return view('sportsbet2.pages.dashboard', [
            'recentBets' => $recentBets,
            'upcomingMatches' => $upcomingMatches
        ]);
    }
} 