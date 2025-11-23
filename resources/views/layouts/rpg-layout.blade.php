<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MMO RPG - Twoja Przygoda Zaczyna Się Tutaj')</title>
    
    <!-- RPGUI Framework CSS -->
    <link href="https://cdn.jsdelivr.net/npm/rpgui@1.3.2/dist/rpgui.min.css" rel="stylesheet" type="text/css">
    
    <!-- Google Fonts - Pixel/Retro Style -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/rpg-custom.css') }}" rel="stylesheet">
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header/Navbar -->
    <div class="rpgui-content rpgui-container framed-golden" style="margin: 20px auto; max-width: 1200px; padding: 15px;">
        <div class="navbar-content">
            <h1 class="game-title">⚔️ LEGENDS OF RPG ⚔️</h1>
            @guest
                <p class="nav-info">Zaloguj się, aby rozpocząć swoją przygodę!</p>
            @else
                <p class="nav-info">Witaj, {{ auth()->user()->name }}! 
                    @if(auth()->user()->activeCharacter)
                        Grasz jako: <strong>{{ auth()->user()->activeCharacter->name }}</strong> ({{ auth()->user()->activeCharacter->class }})
                    @endif
                </p>
            @endguest
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="rpgui-container framed" style="margin: 20px auto; max-width: 1200px; text-align: center; padding: 10px;">
        <p style="margin: 0; font-size: 12px;">&copy; {{ date('Y') }} MMO RPG. Wszelkie prawa zastrzeżone.</p>
    </div>

    <!-- RPGUI Framework JS -->
    <script src="https://cdn.jsdelivr.net/npm/rpgui@1.3.2/dist/rpgui.min.js"></script>
    <script>
        // Initialize RPGUI when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof RPGUI !== 'undefined') {
                RPGUI.set_fps(60);
                RPGUI.create_all();
            }
        });
    </script>
</body>
</html>
