@extends('layouts.rpg-layout')

@section('title', 'MMO RPG - Wiadomości i Nowości')

@section('content')
<!-- Flash Messages -->
@if(session('success'))
    <div class="rpgui-container framed-golden" style="max-width: 1200px; margin: 0 auto 20px; padding: 15px; background: rgba(46, 204, 113, 0.2);">
        <p style="margin: 0; color: #2ecc71; text-align: center; font-size: 16px;">✅ {{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="rpgui-container framed" style="max-width: 1200px; margin: 0 auto 20px; padding: 15px; background: rgba(231, 76, 60, 0.2);">
        <p style="margin: 0; color: #e74c3c; text-align: center; font-size: 16px;">❌ {{ session('error') }}</p>
    </div>
@endif

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
                <form action="{{ route('login') }}" method="POST" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="rpgui-input" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Hasło:</label>
                        <input type="password" id="password" name="password" class="rpgui-input" required>
                        @error('password')
                            <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="remember_me" style="display: flex; align-items: center; cursor: pointer;">
                            <input id="remember_me" type="checkbox" name="remember" style="margin-right: 10px;">
                            <span style="font-size: 14px;">Zapamiętaj mnie</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="rpgui-button golden" style="width: 100%;">
                        <p>Zaloguj się</p>
                    </button>
                    
                    <div class="form-footer">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="rpgui-link">Zapomniałeś hasła?</a>
                        @endif
                        <hr class="golden">
                        <button type="button" class="rpgui-button" style="width: 100%;" onclick="openRegisterModal()">
                            <p>Stwórz Konto</p>
                        </button>
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
                                <form action="{{ route('characters.activate', $character) }}" method="POST" style="margin-top: 5px;">
                                    @csrf
                                    <button type="submit" class="rpgui-button" style="width: 100%;">
                                        <p>Wybierz</p>
                                    </button>
                                </form>
                            @endif
                            
                            @if(!$character->is_active)
                                <form action="{{ route('characters.destroy', $character) }}" method="POST" style="margin-top: 5px;" onsubmit="return confirm('Czy na pewno chcesz usunąć postać {{ $character->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rpgui-button" style="width: 100%; background: rgba(231, 76, 60, 0.3);">
                                        <p>Usuń</p>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                    
                    @if(auth()->user()->canCreateCharacter())
                        <a href="{{ route('characters.create') }}" class="rpgui-button golden" style="width: 100%; margin-top: 10px; display: block; text-align: center;">
                            <p>+ Nowa Postać ({{ auth()->user()->characters->count() }}/4)</p>
                        </a>
                    @else
                        <p class="limit-reached">Osiągnięto limit postaci (4/4)</p>
                    @endif
                </div>
                
                <hr class="golden">
                
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
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

<!-- Registration Modal -->
<div id="registerModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.85); z-index: 1000; align-items: center; justify-content: center;">
    <div class="rpgui-container framed-golden-2" style="width: 90%; max-width: 500px; padding: 30px; max-height: 90vh; overflow-y: auto; background: #1a1410;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 class="section-title" style="margin: 0;">📜 Stwórz Konto</h2>
            <button type="button" onclick="closeRegisterModal()" style="background: none; border: none; color: #ffd700; font-size: 24px; cursor: pointer; padding: 0; line-height: 1;">×</button>
        </div>

        <form action="{{ route('register') }}" method="POST" class="auth-form">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="modal-name">Nazwa użytkownika:</label>
                <input id="modal-name" class="rpgui-input" type="text" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="modal-email">Email:</label>
                <input id="modal-email" class="rpgui-input" type="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="modal-password">Hasło:</label>
                <input id="modal-password" class="rpgui-input" type="password" name="password" required>
                @error('password')
                    <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="modal-password_confirmation">Potwierdź hasło:</label>
                <input id="modal-password_confirmation" class="rpgui-input" type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="rpgui-button golden" style="width: 100%; margin-top: 10px;">
                <p>Zarejestruj się</p>
            </button>
            
            <button type="button" onclick="closeRegisterModal()" class="rpgui-button" style="width: 100%; margin-top: 10px;">
                <p>Anuluj</p>
            </button>
        </form>
    </div>
</div>

<script>
function openRegisterModal() {
    const modal = document.getElementById('registerModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeRegisterModal() {
    const modal = document.getElementById('registerModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking backdrop
document.getElementById('registerModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRegisterModal();
    }
});

// Open modal if there are registration errors
@if($errors->any() && old('name'))
    document.addEventListener('DOMContentLoaded', function() {
        openRegisterModal();
    });
@endif
</script>
@endsection
