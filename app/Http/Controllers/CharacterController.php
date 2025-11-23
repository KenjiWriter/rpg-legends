<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Show the form for creating a new character.
     */
    public function create()
    {
        // Check if user can create more characters (max 4)
        if (!auth()->user()->canCreateCharacter()) {
            return redirect()->route('home')->with('error', 'Osiągnięto maksymalną liczbę postaci (4)!');
        }

        return view('characters.create');
    }

    /**
     * Store a newly created character.
     */
    public function store(Request $request)
    {
        // Check character limit
        if (!auth()->user()->canCreateCharacter()) {
            return redirect()->route('home')->with('error', 'Osiągnięto maksymalną liczbę postaci (4)!');
        }

        // Validate request
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:20', 'regex:/^[a-zA-Z0-9_]+$/', 'unique:characters,name'],
            'strength' => ['required', 'integer', 'min:5', 'max:20'],
            'intelligence' => ['required', 'integer', 'min:5', 'max:20'],
            'dexterity' => ['required', 'integer', 'min:5', 'max:20'],
            'vitality' => ['required', 'integer', 'min:5', 'max:20'],
        ]);

        // Verify total stat points (should be 40)
        $totalPoints = $validated['strength'] + $validated['intelligence'] + 
                      $validated['dexterity'] + $validated['vitality'];
        
        if ($totalPoints !== 40) {
            return back()->withErrors(['stats' => 'Suma punktów statystyk musi wynosić 40!'])->withInput();
        }

        // Create character
        $character = auth()->user()->characters()->create([
            'name' => $validated['name'],
            'strength' => $validated['strength'],
            'intelligence' => $validated['intelligence'],
            'dexterity' => $validated['dexterity'],
            'vitality' => $validated['vitality'],
            'level' => 1,
            'experience' => 0,
            'current_hp' => 100,
            'max_hp' => 100,
            'gold' => 100,
            'is_active' => false, // Don't auto-activate
        ]);

        return redirect()->route('home')->with('success', "Postać {$character->name} została utworzona! Klasa: {$character->class}");
    }

    /**
     * Activate a character (make it the active one).
     */
    public function activate(Character $character)
    {
        // Ensure character belongs to current user
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        // Deactivate all user's characters
        auth()->user()->characters()->update(['is_active' => false]);

        // Activate this character
        $character->update(['is_active' => true]);

        return redirect()->route('city')->with('success', "Postać {$character->name} jest teraz aktywna!");
    }

    /**
     * Remove the specified character.
     */
    public function destroy(Character $character)
    {
        // Ensure character belongs to current user
        if ($character->user_id !== auth()->id()) {
            abort(403);
        }

        $characterName = $character->name;
        $character->delete();

        return redirect()->route('home')->with('success', "Postać {$characterName} została usunięta.");
    }

    /**
     * Show character stats page
     */
    public function stats()
    {
        $character = auth()->user()->activeCharacter;
        
        if (!$character) {
            return redirect()->route('home')->with('error', 'Nie masz aktywnej postaci!');
        }

        return view('character.stats', compact('character'));
    }

    /**
     * Allocate a stat point
     */
    public function allocateStat(Request $request)
    {
        $character = auth()->user()->activeCharacter;
        
        if (!$character) {
            return redirect()->route('home')->with('error', 'Nie masz aktywnej postaci!');
        }

        // Check if character has stat points
        if ($character->stat_points <= 0) {
            return back()->with('error', 'Nie masz punktów statystyk do przydzielenia!');
        }

        // Validate stat type
        $validated = $request->validate([
            'stat' => ['required', 'in:strength,intelligence,dexterity,vitality,defense']
        ]);

        // Increment the stat
        $statName = $validated['stat'];
        $character->$statName += 1;
        $character->stat_points -= 1;

        // Update max HP if vitality was increased
        if ($statName === 'vitality') {
            $character->max_hp = 100 + ($character->vitality * 5);
        }

        $character->save();

        $statLabels = [
            'strength' => 'Siła',
            'intelligence' => 'Inteligencja',
            'dexterity' => 'Zręczność',
            'vitality' => 'Witalność',
            'defense' => 'Obrona'
        ];

        return back()->with('success', "Zwiększono {$statLabels[$statName]}! Pozostało punktów: {$character->stat_points}");
    }
}
