<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display the city hub (main game screen).
     */
    public function city()
    {
        $character = auth()->user()->activeCharacter;
        
        if (!$character) {
            return redirect()->route('home')->with('error', 'Musisz mieć aktywną postać!');
        }

        return view('game.city', compact('character'));
    }

    /**
     * Display the armorer (zbrojmistrz).
     */
    public function armorer()
    {
        $character = auth()->user()->activeCharacter;
        return view('game.locations.armorer', compact('character'));
    }

    /**
     * Display the weaponsmith (brońmistrz).
     */
    public function weaponsmith()
    {
        $character = auth()->user()->activeCharacter;
        return view('game.locations.weaponsmith', compact('character'));
    }

    /**
     * Display the blacksmith (kowal).
     */
    public function blacksmith()
    {
        $character = auth()->user()->activeCharacter;
        return view('game.locations.blacksmith', compact('character'));
    }

    /**
     * Display the merchant (handlarka).
     */
    public function merchant()
    {
        $character = auth()->user()->activeCharacter;
        return view('game.locations.merchant', compact('character'));
    }

    /**
     * Display adventure selection.
     */
    public function adventure()
    {
        $character = auth()->user()->activeCharacter;

        $locations = [
            [
                'id' => 1,
                'name' => 'Las Goblinów',
                'min_level' => 1,
                'max_level' => 15,
                'description' => 'Ciemny las pełen złośliwych goblinów. Idealne miejsce na początek.',
                'image' => 'forest_bg.png', // Placeholder
                'difficulty' => 'Łatwy'
            ],
            [
                'id' => 2,
                'name' => 'Mroczna Jaskinia',
                'min_level' => 15,
                'max_level' => 30,
                'description' => 'Wilgotna jaskinia zamieszkana przez pająki i nietoperze.',
                'image' => 'cave_bg.png', // Placeholder
                'difficulty' => 'Średni'
            ],
            [
                'id' => 3,
                'name' => 'Twierdza Orków',
                'min_level' => 30,
                'max_level' => 50,
                'description' => 'Potężna fortyfikacja orków. Tylko dla odważnych.',
                'image' => 'fortress_bg.png', // Placeholder
                'difficulty' => 'Trudny'
            ]
        ];

        return view('game.locations.adventure', compact('character', 'locations'));
    }
    public function tavern()
    {
        $character = auth()->user()->activeCharacter;
        return view('game.tavern', compact('character'));
    }

    public function heal(Request $request)
    {
        $character = auth()->user()->activeCharacter;
        $type = $request->input('type');
        
        $cost = 0;
        $healAmount = 0;

        switch ($type) {
            case 'beer':
                $cost = 10;
                $healAmount = 20;
                break;
            case 'meal':
                $cost = 50;
                $healAmount = 100;
                break;
            case 'feast':
                $cost = 100;
                $healAmount = 9999; // Full heal
                break;
            default:
                return redirect()->back()->with('error', 'Nieznany wybór.');
        }

        if ($character->gold < $cost) {
            return redirect()->back()->with('error', 'Nie masz wystarczająco złota!');
        }

        if ($character->current_hp >= $character->max_hp) {
            return redirect()->back()->with('error', 'Jesteś już w pełni sił!');
        }

        $character->gold -= $cost;
        $character->current_hp = min($character->max_hp, $character->current_hp + $healAmount);
        $character->save();

        return redirect()->back()->with('success', 'Odzyskałeś siły!');
    }
}
