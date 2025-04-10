<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\GameMatch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BetController extends Controller
{
    /**
     * Display a listing of the bets for the current user.
     */
    public function index()
    {
        $user = Auth::user();
        $bets = Bet::with(['match', 'match.homeTeam', 'match.awayTeam', 'match.sport'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Transform data for the frontend
        $formattedBets = $bets->map(function ($bet) {
            $match = $bet->match;
            return [
                'id' => $bet->id,
                'match' => [
                    'id' => $match->id,
                    'homeTeam' => $match->homeTeam->name,
                    'awayTeam' => $match->awayTeam->name,
                    'date' => $match->match_date->toIso8601String(),
                    'venue' => $match->venue,
                    'sport' => $match->sport->slug,
                ],
                'betOn' => $bet->bet_on,
                'team' => $bet->bet_on === 'home' ? $match->homeTeam->name : 
                          ($bet->bet_on === 'away' ? $match->awayTeam->name : 'Draw'),
                'amount' => (float) $bet->amount,
                'odds' => (float) $bet->odds,
                'potentialWin' => (float) $bet->potential_win,
                'status' => $bet->status,
                'date' => $bet->created_at->toIso8601String(),
            ];
        });

        return response()->json($formattedBets);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created bet.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'match_id' => 'required|exists:matches,id',
            'bet_on' => 'required|in:home,away,draw',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = Auth::user();
        $match = GameMatch::find($request->match_id);

        if (!$match) {
            return response()->json(['message' => 'Match not found'], Response::HTTP_NOT_FOUND);
        }

        // Get the odds based on the bet selection
        $odds = null;
        if ($request->bet_on === 'home') {
            $odds = $match->home_odds;
        } elseif ($request->bet_on === 'away') {
            $odds = $match->away_odds;
        } elseif ($request->bet_on === 'draw' && $match->draw_odds) {
            $odds = $match->draw_odds;
        }

        if (!$odds) {
            return response()->json(['message' => 'Invalid bet type for this match'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Calculate potential win
        $potentialWin = $request->amount * $odds;

        // Create the bet
        $bet = Bet::create([
            'user_id' => $user->id,
            'match_id' => $request->match_id,
            'bet_on' => $request->bet_on,
            'amount' => $request->amount,
            'odds' => $odds,
            'potential_win' => $potentialWin,
            'status' => 'pending',
        ]);

        return response()->json([
            'id' => $bet->id,
            'match_id' => $bet->match_id,
            'bet_on' => $bet->bet_on,
            'amount' => (float) $bet->amount,
            'odds' => (float) $bet->odds,
            'potential_win' => (float) $bet->potential_win,
            'status' => $bet->status,
            'date' => $bet->created_at->toIso8601String(),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified bet.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $bet = Bet::with(['match', 'match.homeTeam', 'match.awayTeam', 'match.sport'])
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$bet) {
            return response()->json(['message' => 'Bet not found'], Response::HTTP_NOT_FOUND);
        }

        $match = $bet->match;
        $formattedBet = [
            'id' => $bet->id,
            'match' => [
                'id' => $match->id,
                'homeTeam' => $match->homeTeam->name,
                'awayTeam' => $match->awayTeam->name,
                'date' => $match->match_date->toIso8601String(),
                'venue' => $match->venue,
                'sport' => $match->sport->slug,
                'status' => $match->status,
                'result' => $match->result,
            ],
            'betOn' => $bet->bet_on,
            'team' => $bet->bet_on === 'home' ? $match->homeTeam->name : 
                      ($bet->bet_on === 'away' ? $match->awayTeam->name : 'Draw'),
            'amount' => (float) $bet->amount,
            'odds' => (float) $bet->odds,
            'potentialWin' => (float) $bet->potential_win,
            'status' => $bet->status,
            'date' => $bet->created_at->toIso8601String(),
        ];

        return response()->json($formattedBet);
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
