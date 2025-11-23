@php 
    $wrapperClass = 'game-wrapper'; 
    $fullScreen = true;
@endphp
@extends('layouts.rpg-layout')

@section('title', 'Karczma "Pod Pijanym Goblinem"')

@section('content')
    <!-- Full Screen Container -->
    <div style="position: relative; width: 100%; height: 100vh; background-color: #1a1410; overflow: hidden; display: flex; flex-direction: column;">
        
        <!-- Background -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                    background: url('{{ asset('images/tavern_bg.png') }}') no-repeat center center; 
                    background-size: cover; filter: brightness(0.6);">
        </div>

        <!-- Tavern UI Container -->
        <div style="position: relative; z-index: 10; flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px;">
            
            <!-- Header -->
            <div class="rpgui-container framed-golden" style="padding: 20px 40px; margin-bottom: 30px; background: rgba(0,0,0,0.8);">
                <h1 style="margin:0; font-size: 32px; color: #ffd700; text-align: center;">🍺 Karczma "Pod Pijanym Goblinem"</h1>
                <p style="text-align: center; color: #ccc; margin-top: 10px;">Witaj, wędrowcze! Usiądź, odpocznij i napij się czegoś zimnego.</p>
            </div>

            <!-- Menu & Character Info -->
            <div style="display: flex; gap: 40px; align-items: flex-start;">
                
                <!-- Character Status -->
                <div class="rpgui-container framed" style="width: 250px; padding: 20px; background: rgba(0,0,0,0.8);">
                    <h3 style="margin-top: 0; color: #fff;">Twój Stan</h3>
                    <hr>
                    <p style="margin: 10px 0;">❤️ HP: <span style="color: #e74c3c;">{{ $character->current_hp }} / {{ $character->max_hp }}</span></p>
                    <p style="margin: 10px 0;">💰 Złoto: <span style="color: #f1c40f;">{{ $character->gold }}</span></p>
                    
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="{{ route('city') }}" class="rpgui-button" style="width: 100%; text-decoration: none; display: block;">
                            <p>🚪 Wyjdź</p>
                        </a>
                    </div>
                </div>

                <!-- Menu -->
                <div class="rpgui-container framed-golden" style="width: 400px; padding: 20px; background: rgba(0,0,0,0.8);">
                    <h3 style="margin-top: 0; color: #ffd700;">Menu</h3>
                    <hr>

                    <!-- Beer -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #444;">
                        <div>
                            <h4 style="margin: 0; color: #fff;">🍺 Kufel Piwa</h4>
                            <p style="margin: 5px 0; font-size: 12px; color: #aaa;">Przywraca 20 HP</p>
                        </div>
                        <form action="{{ route('city.tavern.heal') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="beer">
                            <button type="submit" class="rpgui-button golden" style="padding: 5px 15px;">
                                <p style="margin:0;">10 💰</p>
                            </button>
                        </form>
                    </div>

                    <!-- Meal -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #444;">
                        <div>
                            <h4 style="margin: 0; color: #fff;">🍖 Pieczone Żeberka</h4>
                            <p style="margin: 5px 0; font-size: 12px; color: #aaa;">Przywraca 100 HP</p>
                        </div>
                        <form action="{{ route('city.tavern.heal') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="meal">
                            <button type="submit" class="rpgui-button golden" style="padding: 5px 15px;">
                                <p style="margin:0;">50 💰</p>
                            </button>
                        </form>
                    </div>

                    <!-- Feast -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                        <div>
                            <h4 style="margin: 0; color: #fff;">🍲 Królewska Uczta</h4>
                            <p style="margin: 5px 0; font-size: 12px; color: #aaa;">Pełne uzdrowienie</p>
                        </div>
                        <form action="{{ route('city.tavern.heal') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="feast">
                            <button type="submit" class="rpgui-button golden" style="padding: 5px 15px;">
                                <p style="margin:0;">100 💰</p>
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
