<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MMO RPG') }} - Autentykacja</title>
    
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
    <div class="min-h-screen flex flex-col items-center justify-center" style="padding: 20px;">
        <!-- Logo/Title -->
        <div class="rpgui-container framed-golden" style="margin-bottom: 30px; padding: 20px; text-align: center;">
            <a href="/" style="text-decoration: none;">
                <h1 class="game-title" style="font-size: 20px; margin: 0;">⚔️ LEGENDS OF RPG ⚔️</h1>
            </a>
        </div>

        <!-- Auth Content -->
        <div class="rpgui-container framed-golden-2" style="width: 100%; max-width: 500px; padding: 30px;">
            {{ $slot }}
        </div>
        
        <!-- Back to Home Link -->
        <div style="margin-top: 20px; text-align: center;">
            <a href="/" class="rpgui-link">← Powrót do strony głównej</a>
        </div>
    </div>

    <!-- RPGUI Framework JS -->
    <script src="https://cdn.jsdelivr.net/npm/rpgui@1.3.2/dist/rpgui.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof RPGUI !== 'undefined') {
                RPGUI.set_fps(60);
                RPGUI.create_all();
            }
        });
    </script>
</body>
</html>
