<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sport_id',
        'logo',
        'country',
        'city',
        'stadium',
        'description',
    ];

    /**
     * Get the sport that the team belongs to.
     */
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Get the home matches for the team.
     */
    public function homeMatches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'home_team_id');
    }

    /**
     * Get the away matches for the team.
     */
    public function awayMatches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'away_team_id');
    }

    /**
     * Get all matches for the team.
     */
    public function allMatches()
    {
        return GameMatch::where('home_team_id', $this->id)
                     ->orWhere('away_team_id', $this->id);
    }
}
