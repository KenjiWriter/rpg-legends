@php 
    $wrapperClass = 'game-wrapper'; 
    $fullScreen = true;
@endphp
@extends('layouts.rpg-layout')

@section('title', 'Walka!')

@section('content')
    <!-- Full Screen Container -->
    <div style="position: relative; width: 100%; height: 100vh; background-color: #1a1410; overflow: hidden; display: flex; flex-direction: column;">
        
        <!-- Background -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                    background: url('{{ asset('images/combat_bg.png') }}') no-repeat center center; 
                    background-size: cover; filter: brightness(0.7);">
        </div>

        <!-- Combat UI Container -->
        <div style="position: relative; z-index: 10; flex: 1; display: flex; flex-direction: column; padding: 20px;">
            
            <!-- Top Bar: Turn Info -->
            <div class="rpgui-container framed-golden" style="align-self: center; padding: 10px 30px; margin-bottom: 20px;">
                <h1 id="turn-indicator" style="margin:0; font-size: 20px; color: #ffd700;">Tura 1</h1>
            </div>

            <!-- Battle Area -->
            <div style="flex: 1; display: flex; justify-content: space-between; align-items: center; padding: 0 50px;">
                
                <!-- Player Side -->
                <div class="combatant player">
                    <div class="combatant-visual">
                        <div style="width: 150px; height: 150px; background: #3498db; border: 2px solid #fff; display:flex; align-items:center; justify-content:center; font-size: 64px;">
                            👤
                        </div>
                    </div>
                    <div class="rpgui-container framed" style="margin-top: 10px; padding: 10px; width: 220px;">
                        <h3 style="margin:0; color: #fff;">{{ $character->name }}</h3>
                        <p style="margin:5px 0; font-size:12px;">Lvl {{ $character->level }} {{ $character->class }}</p>
                        
                        <!-- Stats -->
                        <div style="display: flex; justify-content: space-between; font-size: 10px; color: #aaa; margin-bottom: 5px;">
                            <span>STR: {{ $character->strength }}</span>
                            <span>DEF: {{ $character->defense }}</span>
                        </div>

                        <!-- HP Bar -->
                        <div class="hp-bar-container">
                            <div id="player-hp-bar" class="hp-bar-fill" style="width: 100%;"></div>
                            <span id="player-hp-text" class="hp-text">{{ $combatData['player_start_hp'] }} / {{ $combatData['player_max_hp'] }} HP</span>
                        </div>

                        <!-- EXP Bar -->
                        @php
                            $nextLevelExp = $character->level * 100;
                            $expPercent = ($character->experience / $nextLevelExp) * 100;
                        @endphp
                        <div class="exp-bar-container" style="margin-top: 5px; height: 5px; background: #333; border: 1px solid #000;">
                            <div class="exp-bar-fill" style="width: {{ $expPercent }}%; height: 100%; background: #f1c40f;"></div>
                        </div>
                    </div>
                </div>

                <!-- VS -->
                <div style="font-size: 48px; color: #e74c3c; font-weight: bold; text-shadow: 2px 2px 0 #000;">VS</div>

                <!-- Monster Side -->
                <div class="combatant monster">
                    <div class="combatant-visual">
                        @if($monster->image)
                            <img src="{{ asset('images/' . $monster->image) }}" alt="{{ $monster->name }}" style="width: 150px; height: 150px; image-rendering: pixelated;">
                        @else
                            <div style="width: 150px; height: 150px; background: #e74c3c; border: 2px solid #fff; display:flex; align-items:center; justify-content:center; font-size: 64px;">
                                👹
                            </div>
                        @endif
                    </div>
                    <div class="rpgui-container framed" style="margin-top: 10px; padding: 10px; width: 220px;">
                        <h3 style="margin:0; color: #e74c3c;">{{ $monster->name }}</h3>
                        <p style="margin:5px 0; font-size:12px;">Lvl {{ $monster->level }}</p>
                        
                        <!-- HP Bar -->
                        <div class="hp-bar-container">
                            <div id="monster-hp-bar" class="hp-bar-fill enemy" style="width: 100%;"></div>
                            <span id="monster-hp-text" class="hp-text">{{ $combatData['monster_start_hp'] }} / {{ $combatData['monster_max_hp'] }} HP</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Area: Log & Actions -->
            <div style="height: 200px; display: flex; gap: 20px; margin-top: 20px;">
                
                <!-- Combat Log -->
                <div class="rpgui-container framed-golden" style="flex: 2; overflow-y: auto; padding: 10px; background: rgba(0,0,0,0.8);">
                    <ul id="combat-log" style="list-style: none; padding: 0; margin: 0;">
                        <!-- JS will populate this -->
                    </ul>
                </div>

                <!-- Actions / Status -->
                <div class="rpgui-container framed-golden" style="flex: 1; display: flex; flex-direction: column; gap: 10px; padding: 15px; justify-content: center; align-items: center;">
                    
                    <div id="combat-status" style="text-align: center;">
                        <p style="color: #ffd700; font-size: 18px;">Walka trwa...</p>
                    </div>

                    <div id="auto-repeat-timer" style="display: none; text-align: center;">
                        <p style="color: #ccc;">Kolejna walka za: <span id="timer-count" style="color: #fff; font-weight: bold;">3</span>s</p>
                    </div>

                    <a href="{{ route('city.adventure') }}" id="btn-escape" class="rpgui-button" style="width: 100%; text-align: center; text-decoration: none;">
                        <p>🏃 Ucieczka / Powrót</p>
                    </a>

                </div>

            </div>

        </div>

    </div>

    <style>
        .hp-bar-container {
            width: 100%; height: 20px; background: #333; border: 2px solid #000; position: relative; margin-top: 5px;
        }
        .hp-bar-fill {
            height: 100%; background: #2ecc71; transition: width 0.2s;
        }
        .hp-bar-fill.enemy { background: #e74c3c; }
        .hp-text {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; color: #fff; text-shadow: 1px 1px 0 #000;
        }
        .combatant-visual { transition: transform 0.1s; }
        .combatant-visual.hit { transform: translateX(5px); filter: brightness(2) sepia(1) hue-rotate(-50deg) saturate(5); }
        .combatant-visual.attack { transform: scale(1.2); }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const combatData = @json($combatData);
            const logEl = document.getElementById('combat-log');
            const playerHpBar = document.getElementById('player-hp-bar');
            const playerHpText = document.getElementById('player-hp-text');
            const monsterHpBar = document.getElementById('monster-hp-bar');
            const monsterHpText = document.getElementById('monster-hp-text');
            const turnIndicator = document.getElementById('turn-indicator');
            const statusEl = document.getElementById('combat-status');
            const timerEl = document.getElementById('auto-repeat-timer');
            const timerCount = document.getElementById('timer-count');
            const escapeBtn = document.getElementById('btn-escape');

            let currentTurnIndex = 0;
            const turnDelay = 800; // ms per turn

            function addLog(message, type) {
                const li = document.createElement('li');
                li.style.marginBottom = '5px';
                li.style.color = type === 'player' ? '#2ecc71' : (type === 'monster' ? '#e74c3c' : '#ccc');
                li.style.borderBottom = '1px solid #333';
                li.innerText = '> ' + message;
                logEl.prepend(li); // Newest on top
            }

            function updateHp(target, current, max) {
                const percent = (current / max) * 100;
                if (target === 'player') {
                    playerHpBar.style.width = percent + '%';
                    playerHpText.innerText = current + ' / ' + max + ' HP';
                } else {
                    monsterHpBar.style.width = percent + '%';
                    monsterHpText.innerText = current + ' / ' + max + ' HP';
                }
            }

            function playTurn() {
                if (currentTurnIndex >= combatData.turns.length) {
                    endCombat();
                    return;
                }

                const turn = combatData.turns[currentTurnIndex];
                turnIndicator.innerText = 'Tura ' + turn.turn;

                // Process logs for this turn
                turn.logs.forEach(log => {
                    setTimeout(() => {
                        addLog(log.message, log.type === 'player_attack' ? 'player' : 'monster');
                        
                        // Visual feedback
                        if (log.type === 'player_attack') {
                            document.querySelector('.combatant.player .combatant-visual').classList.add('attack');
                            setTimeout(() => document.querySelector('.combatant.player .combatant-visual').classList.remove('attack'), 200);
                            
                            document.querySelector('.combatant.monster .combatant-visual').classList.add('hit');
                            setTimeout(() => document.querySelector('.combatant.monster .combatant-visual').classList.remove('hit'), 200);
                        } else {
                            document.querySelector('.combatant.monster .combatant-visual').classList.add('attack');
                            setTimeout(() => document.querySelector('.combatant.monster .combatant-visual').classList.remove('attack'), 200);

                            document.querySelector('.combatant.player .combatant-visual').classList.add('hit');
                            setTimeout(() => document.querySelector('.combatant.player .combatant-visual').classList.remove('hit'), 200);
                        }

                    }, 100);
                });

                // Update HP at end of turn
                setTimeout(() => {
                    updateHp('player', turn.player_hp, combatData.player_max_hp);
                    updateHp('monster', turn.monster_hp, combatData.monster_max_hp);
                }, 400);

                currentTurnIndex++;
                setTimeout(playTurn, turnDelay);
            }

            function endCombat() {
                if (combatData.result === 'victory') {
                    statusEl.innerHTML = '<h2 style="color: #2ecc71; margin:0;">ZWYCIĘSTWO!</h2>';
                    addLog('--- KONIEC WALKI ---', 'system');
                    
                    if (combatData.rewards.exp) addLog('Zdobyto ' + combatData.rewards.exp + ' EXP', 'system');
                    if (combatData.rewards.gold) addLog('Zdobyto ' + combatData.rewards.gold + ' Złota', 'system');
                    if (combatData.rewards.items && combatData.rewards.items.length > 0) {
                        combatData.rewards.items.forEach(item => {
                            addLog('Znaleziono: ' + item.name, 'system');
                        });
                    }
                    if (combatData.rewards.level_up) {
                        addLog('🎉 AWANS NA NOWY POZIOM!', 'player');
                    }

                    // Start Auto-Repeat
                    startAutoRepeat();

                } else {
                    statusEl.innerHTML = '<h2 style="color: #e74c3c; margin:0;">PORAŻKA...</h2>';
                    addLog('Zostałeś pokonany...', 'monster');
                    escapeBtn.innerHTML = '<p>Wróć do miasta</p>';
                }
            }

            function startAutoRepeat() {
                timerEl.style.display = 'block';
                let timeLeft = 3;
                
                const interval = setInterval(() => {
                    timeLeft--;
                    timerCount.innerText = timeLeft;
                    if (timeLeft <= 0) {
                        clearInterval(interval);
                        // Reload page to start new battle
                        window.location.reload();
                    }
                }, 1000);
            }

            // Start simulation
            addLog('Rozpoczynasz walkę z: ' + combatData.monster.name, 'system');
            setTimeout(playTurn, 500);
        });
    </script>
@endsection
