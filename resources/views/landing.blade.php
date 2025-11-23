@extends('layouts.rpg-layout')

@section('title', 'MMO RPG - Wiadomości i Nowości')

@section('content')
<div class="landing-container">
    <!-- News Feed (Left/Center) -->
    <div class="news-section">
        <div class="rpgui-container framed-golden-2">
            <h2 class="section-title">📜 Aktualności z Królestwa</h2>
            
            @forelse($news as $newsItem)
                <x-news-item :news="$newsItem" />
            @empty
                <div class="rpgui-container framed" style="padding: 20px; text-align: center;">
                    <p>Brak aktualności. Sprawdź ponownie później!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Sidebar (Right) -->
    <div class="sidebar-section">
        @guest
            <!-- Login Form -->
            <div class="rpgui-container framed-golden">
                <h3 class="sidebar-title">🗝️ Wejście do Gry</h3>
                <form action="#" method="POST" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="rpgui-input" placeholder="twoj@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Hasło:</label>
                        <input type="password" id="password" name="password" class="rpgui-input" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="rpgui-button golden">
                        <p>Zaloguj się</p>
                    </button>
                    
                    <div class="form-footer">
                        <a href="#" class="rpgui-link">Zapomniałeś hasła?</a>
                        <hr class="golden">
                        <a href="#" class="rpgui-button">
                            <p>Stwórz Konto</p>
                        </a>
                    </div>
                </form>
            </div>
        @else
            <!-- Character List -->
            <div class="rpgui-container framed-golden">
                <h3 class="sidebar-title">👤 Twoje Postacie</h3>
                
                <div class="character-list">
                    @foreach(auth()->user()->characters as $character)
                        <div class="rpgui-container framed @if($character->is_active) character-active @endif">
                            <h4>{{ $character->name }}</h4>
                            <p class="character-class">{{ $character->class }}</p>
                            <div class="character-stats">
                                <span>Lvl {{ $character->level }}</span>
                                <span>💰 {{ $character->gold }}g</span>
                            </div>
                            @if($character->is_active)
                                <span class="active-badge">✓ Aktywna</span>
                            @else
                                <button class="rpgui-button" style="margin-top: 5px;">
                                    <p>Wybierz</p>
                                </button>
                            @endif
                        </div>
                    @endforeach
                    
                    @if(auth()->user()->canCreateCharacter())
                        <button class="rpgui-button golden" style="width: 100%; margin-top: 10px;">
                            <p>+ Nowa Postać ({{ auth()->user()->characters->count() }}/4)</p>
                        </button>
                    @else
                        <p class="limit-reached">Osiągnięto limit postaci (4/4)</p>
                    @endif
                </div>
                
                <hr class="golden">
                
                <form action="#" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" class="rpgui-button" style="width: 100%;">
                        <p>Wyloguj</p>
                    </button>
                </form>
            </div>
        @endguest
        
        <!-- Info Box -->
        <div class="rpgui-container framed" style="margin-top: 20px;">
            <h4 class="sidebar-title">ℹ️ Jak zacząć?</h4>
            <ul class="rpgui-list">
                <li>1. Stwórz konto</li>
                <li>2. Utwórz postać</li>
                <li>3. Rozwijaj statystyki</li>
                <li>4. Odkryj swoją klasę!</li>
            </ul>
        </div>
    </div>
</div>
@endsection
