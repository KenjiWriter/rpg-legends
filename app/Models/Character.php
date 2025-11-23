<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'level',
        'experience',
        'strength',
        'intelligence',
        'dexterity',
        'vitality',
        'current_hp',
        'max_hp',
        'gold',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the character.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine character class based on highest stat.
     * Class is dynamically calculated, not stored.
     */
    public function getClassAttribute(): string
    {
        $stats = [
            'Warrior' => $this->strength,
            'Mage' => $this->intelligence,
            'Rogue' => $this->dexterity,
            'Tank' => $this->vitality,
        ];

        arsort($stats);
        return array_key_first($stats);
    }

    /**
     * Get the dominant stat value
     */
    public function getDominantStatAttribute(): int
    {
        return max($this->strength, $this->intelligence, $this->dexterity, $this->vitality);
    }

    /**
     * Scope to get active character for user.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Boot method to enforce character limit.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($character) {
            $characterCount = static::where('user_id', $character->user_id)->count();
            if ($characterCount >= 4) {
                throw new \Exception('Maximum character limit (4) reached for this user.');
            }
        });
    }
}
