<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'match_id',
        'bet_on',
        'amount',
        'odds',
        'potential_win',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'odds' => 'decimal:2',
        'potential_win' => 'decimal:2',
    ];

    /**
     * Get the user that owns the bet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the match that the bet is for.
     */
    public function match(): BelongsTo
    {
        return $this->belongsTo(GameMatch::class, 'match_id');
    }

    /**
     * Calculate potential win based on amount and odds.
     */
    public function calculatePotentialWin()
    {
        return $this->amount * $this->odds;
    }
}
