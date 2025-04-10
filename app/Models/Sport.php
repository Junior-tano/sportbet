<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon',
        'slug',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the teams for the sport.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Get the matches for the sport.
     */
    public function matches(): HasMany
    {
        return $this->hasMany(GameMatch::class);
    }
}
