<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameMatch extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sport_id',
        'home_team_id',
        'away_team_id',
        'match_date',
        'venue',
        'home_odds',
        'away_odds',
        'draw_odds',
        'popularity',
        'status',
        'result',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'match_date' => 'datetime',
        'home_odds' => 'decimal:2',
        'away_odds' => 'decimal:2',
        'draw_odds' => 'decimal:2',
        'popularity' => 'integer',
    ];

    /**
     * Get the sport that the match belongs to.
     */
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Get the home team that the match belongs to.
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Get the away team that the match belongs to.
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    /**
     * Get the bets for the match.
     */
    public function bets(): HasMany
    {
        return $this->hasMany(Bet::class, 'match_id');
    }
}
