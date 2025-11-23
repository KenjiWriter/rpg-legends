<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="section-title" style="margin-bottom: 20px;">🗝️ Zaloguj się</h2>

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input id="email" class="rpgui-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input id="password" class="rpgui-input" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <label for="remember_me" style="display: flex; align-items: center; cursor: pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="margin-right: 10px;">
                <span style="font-size: 14px;">Zapamiętaj mnie</span>
            </label>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
            <button type="submit" class="rpgui-button golden" style="width: 100%;">
                <p>Zaloguj się</p>
            </button>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="rpgui-link" style="text-align: center; display: block;">
                    Zapomniałeś hasła?
                </a>
            @endif
        </div>
        
        <hr class="golden" style="margin: 20px 0;">
        
        <div style="text-align: center;">
            <p style="margin-bottom: 10px; font-size: 14px;">Nie masz konta?</p>
            <a href="{{ route('register') }}" class="rpgui-button" style="width: 100%;">
                <p>Stwórz Konto</p>
            </a>
        </div>
    </form>
</x-guest-layout>
