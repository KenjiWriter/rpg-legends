@php 
    $wrapperClass = 'game-wrapper'; 
    $fullScreen = true;
@endphp
@extends('layouts.rpg-layout')

@section('title', 'Miasto - Centrum')

@section('content')
    {{-- Flash messages --}}
    @if(session('success'))
        <div class="rpgui-container framed-golden" style="position: fixed; top: 100px; left: 50%; transform: translateX(-50%); z-index: 1000; background: rgba(46, 204, 113, 0.9); max-width: 600px;">
            <p style="margin:0; color:#fff; text-align:center; text-shadow: 1px 1px 0 #000;">✅ {{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="rpgui-container framed" style="position: fixed; top: 100px; left: 50%; transform: translateX(-50%); z-index: 1000; background: rgba(231, 76, 60, 0.9); max-width: 600px;">
            <p style="margin:0; color:#fff; text-align:center; text-shadow: 1px 1px 0 #000;">❌ {{ session('error') }}</p>
        </div>
    @endif

    <!-- Full Screen Game Container -->
    <div style="position: relative; width: 100%; height: 100vh; background-color: #1a1410; overflow: hidden;">
        
        <!-- Background Image -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                    background-image: url('{{ asset('images/city_bg.png') }}'); 
                    background-size: cover; background-position: center;">
        </div>

        <!-- Dark Overlay (Subtle) -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2);"></div>

        <!-- TOP UI BAR -->
        <div class="ui-bar top-bar">
            <div class="ui-group left">
                <div class="ui-button" title="Postać">👤</div>
                <div class="ui-button" title="Ekwipunek">🎒</div>
                <div class="ui-button" title="Umiejętności">📖</div>
            </div>
            
            <div class="ui-group center">
                <div class="location-title">🏙️ Rynek Miejski</div>
            </div>

            <div class="ui-group right">
                <div class="ui-button" title="Mapa">🗺️</div>
                <div class="ui-button" title="Ustawienia">⚙️</div>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="ui-button logout" title="Wyloguj">🚪</button>
                </form>
            </div>
        </div>

        <!-- Character HUD (Floating) -->
        <div class="character-hud">
            <div class="hud-row">
                <span class="char-name">{{ $character->name }}</span>
                <span class="char-lvl">Lvl {{ $character->level ?? 1 }}</span>
            </div>
            <div class="hud-bars">
                <div class="hud-bar hp-bar">
                    <div class="bar-fill" style="width: {{ ($character->current_hp / $character->max_hp) * 100 }}%;"></div>
                    <span class="bar-text">{{ $character->current_hp }}/{{ $character->max_hp }} HP</span>
                </div>
                <div class="hud-gold">
                    💰 {{ $character->gold ?? 0 }}g
                </div>
            </div>
        </div>

        <!-- Building Hotspots -->
        
        <!-- Zbrojmistrz -->
        <a href="{{ route('city.armorer') }}" class="building-hotspot" style="top: 35%; left: 15%;">
            <div class="hotspot-icon">
                <img src="{{ asset('images/blacksmith_icon.png') }}" alt="Zbrojmistrz">
            </div>
            <div class="hotspot-label">
                <span class="label-text">Zbrojmistrz</span>
            </div>
        </a>

        <!-- Brońmistrz -->
        <a href="{{ route('city.weaponsmith') }}" class="building-hotspot" style="top: 30%; left: 35%;">
            <div class="hotspot-icon">
                <!-- Removed hue-rotate to keep original colors if desired, or keep for distinction -->
                <img src="{{ asset('images/blacksmith_icon.png') }}" style="filter: hue-rotate(45deg);" alt="Brońmistrz">
            </div>
            <div class="hotspot-label">
                <span class="label-text">Brońmistrz</span>
            </div>
        </a>

        <!-- Kowal -->
        <a href="{{ route('city.blacksmith') }}" class="building-hotspot" style="top: 40%; left: 55%;">
            <div class="hotspot-icon">
                <!-- Removed grayscale filter as requested -->
                <img src="{{ asset('images/blacksmith_icon.png') }}" alt="Kowal">
            </div>
            <div class="hotspot-label">
                <span class="label-text">Kowal</span>
            </div>
        </a>

        <!-- Handlarka -->
        <a href="{{ route('city.merchant') }}" class="building-hotspot" style="top: 45%; left: 80%;">
            <div class="hotspot-icon">
                <img src="{{ asset('images/merchant_icon.png') }}" alt="Handlarka">
            </div>
            <div class="hotspot-label">
                <span class="label-text">Handlarka</span>
            </div>
        </a>

        <!-- Adventure Gate -->
        <a href="{{ route('city.adventure') }}" class="building-hotspot adventure-gate" style="bottom: 120px; left: 50%; transform: translateX(-50%);">
            <div class="hotspot-icon large">
                <img src="{{ asset('images/adventure_icon.png') }}" alt="Przygoda">
            </div>
            <div class="hotspot-label large">
                <span class="label-text">🌲 Wyruszy na Przygodę</span>
            </div>
        </a>

        <!-- BOTTOM UI BAR -->
        <div class="ui-bar bottom-bar">
            <div class="chat-container">
                <div class="chat-messages">
                    <p><span class="chat-system">[System]:</span> Witaj w świecie Legends of RPG!</p>
                    <p><span class="chat-system">[System]:</span> Jesteś w mieście. Odwiedź handlarzy lub wyrusz na wyprawę.</p>
                </div>
                <div class="chat-input-area">
                    <input type="text" class="chat-input" placeholder="Wpisz wiadomość...">
                    <button class="ui-button small">➤</button>
                </div>
            </div>
            <div class="bottom-menu">
                <div class="ui-button" title="Zadania">📜</div>
                <div class="ui-button" title="Gildia">🛡️</div>
                <div class="ui-button" title="Ranking">🏆</div>
            </div>
        </div>

    </div>

    <style>
        /* UI Bars */
        .ui-bar {
            position: absolute;
            left: 0;
            width: 100%;
            background: #2c2415;
            border-top: 2px solid #4a3f28;
            border-bottom: 2px solid #4a3f28;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-sizing: border-box;
            z-index: 100;
            box-shadow: 0 0 10px rgba(0,0,0,0.8);
        }

        .top-bar {
            top: 0;
            height: 60px;
            justify-content: space-between;
            background: rgba(26, 20, 16, 0.95);
        }

        .bottom-bar {
            bottom: 0;
            height: 100px; /* Taller for chat */
            background: rgba(26, 20, 16, 0.95);
            justify-content: space-between;
            align-items: flex-end; /* Align items to bottom */
            padding-bottom: 10px;
        }

        /* UI Buttons */
        .ui-group {
            display: flex;
            gap: 10px;
        }

        .ui-button {
            width: 40px;
            height: 40px;
            background: #4a3f28;
            border: 2px solid #c9b388;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.1s;
            color: #fff;
        }

        .ui-button:hover {
            background: #6b5d42;
            transform: translateY(-2px);
            border-color: #ffd700;
        }

        .ui-button.logout {
            background: #c0392b;
            border-color: #e74c3c;
        }

        .ui-button.small {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }

        .location-title {
            font-family: 'Press Start 2P', cursive;
            color: #ffd700;
            font-size: 14px;
            text-shadow: 2px 2px 0 #000;
            background: rgba(0,0,0,0.5);
            padding: 10px 20px;
            border-radius: 4px;
            border: 1px solid #4a3f28;
        }

        /* HUD */
        .character-hud {
            position: absolute;
            top: 70px; /* Below top bar */
            left: 20px;
            width: 250px;
            background: rgba(0,0,0,0.7);
            border: 2px solid #4a3f28;
            border-radius: 4px;
            padding: 10px;
            z-index: 90;
        }

        .hud-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .char-name {
            color: #ffd700;
            font-family: 'Press Start 2P', cursive;
            font-size: 10px;
        }

        .char-lvl {
            color: #ccc;
            font-size: 12px;
        }

        .hud-bar {
            height: 15px;
            background: #333;
            border: 1px solid #000;
            position: relative;
            margin-bottom: 5px;
        }

        .hp-bar .bar-fill {
            height: 100%;
            background: #e74c3c;
            transition: width 0.3s;
        }

        .bar-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            line-height: 15px;
            color: #fff;
            text-shadow: 1px 1px 0 #000;
        }

        .hud-gold {
            text-align: right;
            color: #f1c40f;
            font-size: 12px;
        }

        /* Chat */
        .chat-container {
            width: 400px;
            height: 80px;
            background: rgba(0,0,0,0.5);
            border: 1px solid #4a3f28;
            display: flex;
            flex-direction: column;
            padding: 5px;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            font-size: 12px;
            color: #ccc;
        }

        .chat-messages p {
            margin: 2px 0;
        }

        .chat-system {
            color: #f1c40f;
        }

        .chat-input-area {
            display: flex;
            gap: 5px;
            margin-top: 5px;
        }

        .chat-input {
            flex: 1;
            background: rgba(0,0,0,0.3);
            border: 1px solid #4a3f28;
            color: #fff;
            padding: 2px 5px;
            font-family: 'VT323', monospace;
        }

        .bottom-menu {
            display: flex;
            gap: 10px;
            margin-bottom: 10px; /* Align with chat input */
        }

        /* Hotspots */
        .building-hotspot {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            transition: transform 0.2s;
            z-index: 50;
            cursor: pointer;
        }

        .building-hotspot:hover {
            transform: scale(1.1);
            z-index: 60;
        }

        .hotspot-icon {
            width: 96px; /* Increased size */
            height: 96px; /* Increased size */
        }

        .hotspot-icon img {
            width: 100%;
            height: 100%;
            image-rendering: pixelated;
        }

        .hotspot-icon.large {
            width: 128px; /* Even larger for adventure */
            height: 128px;
        }

        .hotspot-label {
            margin-top: -10px; /* Overlap slightly */
            background: rgba(0,0,0,0.8);
            padding: 4px 8px;
            border: 1px solid #ffd700;
            border-radius: 4px;
        }

        .label-text {
            color: #ffd700;
            font-family: 'Press Start 2P', cursive;
            font-size: 10px;
            text-shadow: 1px 1px 0 #000;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .ui-bar {
                padding: 0 10px;
            }
            .chat-container {
                width: 200px;
            }
            .location-title {
                display: none;
            }
        }
    </style>
@endsection
