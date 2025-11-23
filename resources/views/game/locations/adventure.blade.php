@php 
    $wrapperClass = 'game-wrapper'; 
    $fullScreen = true;
@endphp
@extends('layouts.rpg-layout')

@section('title', 'Wyrusz na Przygodę')

@section('content')
    <!-- Full Screen Container -->
    <div style="position: relative; width: 100%; height: 100vh; background-color: #1a1410; overflow: hidden; display: flex; flex-direction: column;">
        
        <!-- Background (Darker/Different than city) -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('images/city_bg.png') }}'); 
                    background-size: cover; background-position: center; filter: blur(2px);">
        </div>

        <!-- TOP UI BAR -->
        <div class="ui-bar top-bar">
            <div class="ui-group left">
                <a href="{{ route('city') }}" class="ui-button" title="Powrót do miasta">⬅️</a>
            </div>
            
            <div class="ui-group center">
                <div class="location-title">🌲 Wybierz Cel Podróży</div>
            </div>

            <div class="ui-group right">
                <div class="ui-button" title="Mapa Świata">🗺️</div>
            </div>
        </div>

        <!-- Adventure Selection Content -->
        <div style="position: relative; z-index: 10; flex: 1; display: flex; align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
            
            <div class="locations-grid">
                @foreach($locations as $location)
                    @php
                        $canEnter = $character->level >= $location['min_level'] && $character->level <= $location['max_level'];
                        // Or maybe just min level requirement? Usually max level is just a suggestion or cap.
                        // User asked for "1-15", "15-30", so let's stick to ranges or at least min level.
                        // Let's allow entry if level >= min_level.
                        $isLocked = $character->level < $location['min_level'];
                    @endphp

                    <div class="rpgui-container framed-golden location-card {{ $isLocked ? 'locked' : '' }}">
                        <div class="location-image">
                            <!-- Placeholder for location image -->
                            <div style="width: 100%; height: 120px; background: #2c3e50; display: flex; align-items: center; justify-content: center; color: #555;">
                                <span>[Obrazek]</span>
                            </div>
                        </div>
                        
                        <div class="location-info">
                            <h3 class="location-name">{{ $location['name'] }}</h3>
                            <p class="location-level">Lvl {{ $location['min_level'] }} - {{ $location['max_level'] }}</p>
                            <p class="location-desc">{{ $location['description'] }}</p>
                            <p class="location-difficulty">Trudność: <span class="{{ $location['difficulty'] == 'Łatwy' ? 'diff-easy' : ($location['difficulty'] == 'Średni' ? 'diff-med' : 'diff-hard') }}">{{ $location['difficulty'] }}</span></p>
                        </div>

                        <div class="location-action">
                            @if($isLocked)
                                <button class="rpgui-button" disabled style="width: 100%; opacity: 0.5; cursor: not-allowed;">
                                    <p>🔒 Zablokowane (Lvl {{ $location['min_level'] }})</p>
                                </button>
                            @else
                                <a href="{{ route('game.combat.start', ['location' => $location['id']]) }}" class="rpgui-button golden" style="width: 100%; text-decoration: none; display: block; text-align: center;">
                                    <p style="margin: 10px 0;">⚔️ Wyrusz</p>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    <style>
        .ui-bar {
            position: relative;
            width: 100%;
            background: #2c2415;
            border-bottom: 2px solid #4a3f28;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            height: 60px;
            box-sizing: border-box;
            z-index: 100;
            box-shadow: 0 0 10px rgba(0,0,0,0.8);
        }

        .ui-group { display: flex; gap: 10px; }
        
        .ui-button {
            width: 40px; height: 40px;
            background: #4a3f28; border: 2px solid #c9b388; border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; cursor: pointer; color: #fff; text-decoration: none;
        }
        .ui-button:hover { background: #6b5d42; border-color: #ffd700; }

        .location-title {
            font-family: 'Press Start 2P', cursive; color: #ffd700; font-size: 14px;
            text-shadow: 2px 2px 0 #000; background: rgba(0,0,0,0.5);
            padding: 10px 20px; border-radius: 4px; border: 1px solid #4a3f28;
        }

        .locations-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            max-width: 1200px;
        }

        .location-card {
            width: 300px;
            background: rgba(0,0,0,0.8);
            padding: 15px;
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .location-card:hover:not(.locked) {
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.2);
        }

        .location-card.locked {
            filter: grayscale(0.8);
            opacity: 0.8;
        }

        .location-name {
            font-size: 16px; color: #ffd700; margin: 0 0 5px 0; text-align: center;
        }

        .location-level {
            font-size: 12px; color: #e74c3c; text-align: center; margin: 0 0 10px 0; font-weight: bold;
        }

        .location-desc {
            font-size: 14px; color: #ccc; margin: 0 0 10px 0; line-height: 1.4; flex: 1;
        }

        .location-difficulty {
            font-size: 12px; color: #aaa; margin: 0;
        }

        .diff-easy { color: #2ecc71; }
        .diff-med { color: #f1c40f; }
        .diff-hard { color: #e74c3c; }

    </style>
@endsection
