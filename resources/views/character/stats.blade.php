@extends('layouts.rpg-layout')

@section('title', 'Statystyki Postaci')

@section('content')
<div style="padding: 40px; max-width: 900px; margin: 0 auto;">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="rpgui-container framed-golden" style="margin-bottom: 20px; padding: 15px; background: rgba(46, 204, 113, 0.2);">
            <p style="margin: 0; color: #2ecc71; text-align: center;">✅ {{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="rpgui-container framed" style="margin-bottom: 20px; padding: 15px; background: rgba(231, 76, 60, 0.2);">
            <p style="margin: 0; color: #e74c3c; text-align: center;">❌ {{ session('error') }}</p>
        </div>
    @endif

    <div class="rpgui-container framed-golden-2">
        <h2 style="text-align: center; color: #ffd700; margin-top: 0;">📊 Statystyki - {{ $character->name }}</h2>
        <hr class="golden">

        {{-- Character Info --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div class="rpgui-container framed">
                <h3 style="margin-top: 0; color: #ffd700;">⚔️ Informacje</h3>
                <p><strong>Klasa:</strong> {{ $character->class }}</p>
                <p><strong>Poziom:</strong> {{ $character->level }}</p>
                <p><strong>Doświadczenie:</strong> {{ $character->experience }} / {{ $character->level * 100 }}</p>
                <p><strong>Złoto:</strong> 💰 {{ $character->gold }}g</p>
            </div>

            <div class="rpgui-container framed">
                <h3 style="margin-top: 0; color: #ffd700;">❤️ Punkty Życia</h3>
                <p><strong>HP:</strong> {{ $character->current_hp }} / {{ $character->max_hp }}</p>
                <div style="background: #2c2415; height: 30px; border: 2px solid #8b7355; position: relative;">
                    <div style="background: linear-gradient(to bottom, #e74c3c, #c0392b); height: 100%; width: {{ ($character->current_hp / $character->max_hp) * 100 }}%; transition: width 0.3s;"></div>
                    <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-weight: bold;">{{ $character->current_hp }} / {{ $character->max_hp }}</span>
                </div>
            </div>
        </div>

        {{-- Stat Points Available --}}
        @if($character->stat_points > 0)
            <div class="rpgui-container framed-golden" style="margin-bottom: 20px; padding: 20px; text-align: center;">
                <h3 style="margin: 0 0 10px 0; color: #ffd700;">⭐ Dostępne Punkty Statystyk: {{ $character->stat_points }}</h3>
                <p style="margin: 0; color: #d4c4a8;">Kliknij przycisk "+" obok statystyki, aby ją zwiększyć</p>
            </div>
        @else
            <div class="rpgui-container framed" style="margin-bottom: 20px; padding: 15px; text-align: center; background: rgba(0,0,0,0.3);">
                <p style="margin: 0; color: #9b8c6f; font-size: 14px;">Brak dostępnych punktów statystyk. Zdobądź poziom, aby otrzymać nowe!</p>
            </div>
        @endif

        {{-- Stats Grid --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            {{-- Strength --}}
            <div class="rpgui-container framed">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #ffd700;">💪 Siła (STR)</h4>
                        <p style="margin: 0; font-size: 28px; color: #e74c3c;">{{ $character->strength }}</p>
                    </div>
                    @if($character->stat_points > 0)
                        <form action="{{ route('character.allocateStat') }}" method="POST">
                            @csrf
                            <input type="hidden" name="stat" value="strength">
                            <button type="submit" class="rpgui-button golden" style="font-size: 24px; padding: 10px 20px;">
                                <p style="margin: 0;">+</p>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Intelligence --}}
            <div class="rpgui-container framed">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #ffd700;">🧠 Inteligencja (INT)</h4>
                        <p style="margin: 0; font-size: 28px; color: #3498db;">{{ $character->intelligence }}</p>
                    </div>
                    @if($character->stat_points > 0)
                        <form action="{{ route('character.allocateStat') }}" method="POST">
                            @csrf
                            <input type="hidden" name="stat" value="intelligence">
                            <button type="submit" class="rpgui-button golden" style="font-size: 24px; padding: 10px 20px;">
                                <p style="margin: 0;">+</p>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Dexterity --}}
            <div class="rpgui-container framed">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #ffd700;">🎯 Zręczność (DEX)</h4>
                        <p style="margin: 0; font-size: 28px; color: #2ecc71;">{{ $character->dexterity }}</p>
                    </div>
                    @if($character->stat_points > 0)
                        <form action="{{ route('character.allocateStat') }}" method="POST">
                            @csrf
                            <input type="hidden" name="stat" value="dexterity">
                            <button type="submit" class="rpgui-button golden" style="font-size: 24px; padding: 10px 20px;">
                                <p style="margin: 0;">+</p>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Vitality --}}
            <div class="rpgui-container framed">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #ffd700;">❤️ Witalność (VIT)</h4>
                        <p style="margin: 0; font-size: 28px; color: #e67e22;">{{ $character->vitality }}</p>
                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #9b8c6f;">(Max HP: {{ 100 + ($character->vitality * 5) }})</p>
                    </div>
                    @if($character->stat_points > 0)
                        <form action="{{ route('character.allocateStat') }}" method="POST">
                            @csrf
                            <input type="hidden" name="stat" value="vitality">
                            <button type="submit" class="rpgui-button golden" style="font-size: 24px; padding: 10px 20px;">
                                <p style="margin: 0;">+</p>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Defense --}}
            <div class="rpgui-container framed" style="grid-column: 1 / -1;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0 0 5px 0; color: #ffd700;">🛡️ Obrona (DEF)</h4>
                        <p style="margin: 0; font-size: 28px; color: #95a5a6;">{{ $character->defense }}</p>
                    </div>
                    @if($character->stat_points > 0)
                        <form action="{{ route('character.allocateStat') }}" method="POST">
                            @csrf
                            <input type="hidden" name="stat" value="defense">
                            <button type="submit" class="rpgui-button golden" style="font-size: 24px; padding: 10px 20px;">
                                <p style="margin: 0;">+</p>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <hr class="golden" style="margin: 30px 0;">

        {{-- Navigation --}}
        <div style="display: flex; gap: 10px; justify-content: center;">
            <a href="{{ route('city') }}" class="rpgui-button" style="text-decoration: none;">
                <p>🏰 Powrót do Miasta</p>
            </a>
        </div>
    </div>
</div>
@endsection
