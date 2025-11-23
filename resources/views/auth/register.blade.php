<x-guest-layout>
    <h2 class="section-title" style="margin-bottom: 20px;">📜 Stwórz Konto</h2>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Nazwa użytkownika:</label>
            <input id="name" class="rpgui-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input id="email" class="rpgui-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input id="password" class="rpgui-input" type="password" name="password" required autocomplete="new-password">
            @error('password')
                <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Potwierdź hasło:</label>
            <input id="password_confirmation" class="rpgui-input" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')
                <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
            <button type="submit" class="rpgui-button golden" style="width: 100%;">
                <p>Zarejestruj się</p>
            </button>
        </div>
        
        <hr class="golden" style="margin: 20px 0;">
        
        <div style="text-align: center;">
            <p style="margin-bottom: 10px; font-size: 14px;">Masz już konto?</p>
            <a href="{{ route('login') }}" class="rpgui-button" style="width: 100%;">
                <p>Zaloguj się</p>
            </a>
        </div>
    </form>
</x-guest-layout>
