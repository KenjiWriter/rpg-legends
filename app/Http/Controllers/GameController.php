<?php

namespace App\Http\Controllers;

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
        return view('game.locations.adventure', compact('character'));
    }
}
