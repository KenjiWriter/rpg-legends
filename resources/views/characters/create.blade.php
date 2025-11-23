@extends('layouts.rpg-layout')

@section('title', 'Stwórz Nową Postać')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div class="rpgui-container framed-golden-2" style="padding: 30px; background: #1a1410;">
        <h2 class="section-title">⚔️ Stwórz Nową Postać</h2>

        @if($errors->any())
            <div class="rpgui-container framed" style="background: rgba(231, 76, 60, 0.2); margin-bottom: 20px; padding: 15px;">
                <ul style="margin: 0; padding-left: 20px; color: #e74c3c;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('characters.store') }}" method="POST" id="characterForm">
            @csrf

            <!-- Character Name -->
            <div class="form-group">
                <label for="name">Nazwa Postaci:</label>
                <input type="text" id="name" name="name" class="rpgui-input" value="{{ old('name') }}" required 
                       minlength="3" maxlength="20" pattern="[a-zA-Z0-9_]+" 
                       placeholder="np. Wojownik123">
                <span style="font-size: 12px; color: #c9b388; display: block; margin-top: 5px;">
                    3-20 znaków (tylko litery, cyfry i _)
                </span>
            </div>

            <hr class="golden" style="margin: 25px 0;">

            <!-- Stat Points Info -->
            <div style="text-align: center; margin-bottom: 20px;">
                <h3 class="sidebar-title">📊 Rozdziel Punkty Statystyk</h3>
                <p style="margin: 10px 0; font-size: 16px;">
                    Pozostało punktów: <span id="remainingPoints" style="color: #ffd700; font-size: 20px; font-family: 'Press Start 2P', cursive;">40</span>
                </p>
                <p style="margin: 5px 0; font-size: 14px; color: #c9b388;">
                    Każda statystyka: min 5, max 20 | Suma: 40 punktów
                </p>
            </div>

            <!-- Stats Allocation -->
            <div class="stats-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <!-- Strength -->
                <div class="stat-block">
                    <label for="strength">💪 Siła (Strength):</label>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                        <button type="button" onclick="changeStat('strength', -1)" class="rpgui-button" style="padding: 5px 10px;">
                            <p style="margin: 0;">-</p>
                        </button>
                        <input type="number" id="strength" name="strength" class="rpgui-input" value="10" 
                               min="5" max="20" required readonly style="text-align: center; width: 80px;">
                        <button type="button" onclick="changeStat('strength', 1)" class="rpgui-button" style="padding: 5px 10px;">
                            <p style="margin: 0;">+</p>
                        </button>
                    </div>
                    <div style="margin-top: 8px; height: 10px; background: #2c2415; border: 1px solid #4a3f28;">
                        <div id="strength-bar" style="height: 100%; width: 33%; background: linear-gradient(to right, #e74c3c, #c0392b); transition: width 0.3s;"></div>
                    </div>
                </div>

                <!-- Intelligence -->
                <div class="stat-block">
                    <label for="intelligence">🧙 Inteligencja (Intelligence):</label>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                        <button type="button" onclick="changeStat('intelligence', -1)" class="rpgui-button" style="padding: 5px 10px;">
                            <p style="margin: 0;">-</p>
                        </button>
                        <input type="number" id="intelligence" name="intelligence" class="rpgui-input" value="10" 
                               min="5" max="20" required readonly style="text-align: center; width: 80px;">
                        <button type="button" onclick="changeStat('intelligence', 1)" class="rpgui-button" style="padding: 5px 10px;">
                            <p style="margin: 0;">+</p>
                        </button>
                    </div>
                    <div style="margin-top: 8px; height: 10px; background: #2c2415; border: 1px solid #4a3f28;">
                        <div id="intelligence-bar" style="height: 100%; width: 33%; background: linear-gradient(to right, #3498db, #2980b9); transition: width 0.3s;"></div>
                    </div>
                </div>

                <!-- Dexterity -->
                <div class="stat-block">
                    <label for="dexterity">🗡️ Zręczność (Dexterity):</label>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                        <button type="button" onclick="changeStat('dexterity', -1)" class="rpgui-button" style="padding: 5px 10px;">
                            <p style="margin: 0;">-</p>
                        </button>
                        <input type="number" id="dexterity" name="dexterity" class="rpgui-input" value="10" 
                               min="5" max="20" required readonly style="text-align: center; width: 80px;">
                        <button type="button" onclick="changeStat('dexterity', 1)" class="rpgui-button" style="padding: 5px 10px;">
                            <p style="margin: 0;">+</p>
                        </button>
                    </div>
                    <div style="margin-top: 8px; height: 10px; background: #2c2415; border: 1px solid #4a3f28;">
                        <div id="dexterity-bar" style="height: 100%; width: 33%; background: linear-gradient(to right, #2ecc71, #27ae60); transition: width 0.3s;"></div>
                    </div>
                </div>

                <!-- Vitality -->
                <div class="stat-block">
                    <label for="vitality">🛡️ Witalność (Vitality):</label>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                        <button type="button" onclick="changeStat('vitality', -1)" class="rpgui-button" style="padding: 5px 10px;">
                            <p style="margin: 0;">-</p>
                        </button>
                        <input type="number" id="vitality" name="vitality" class="rpgui-input" value="10" 
                               min="5" max="20" required readonly style="text-align: center; width: 80px;">
                        <button type="button" onclick="changeStat('vitality', 1)" class="rpgui-button" style="padding: 5px 10px;">
                            <p style="margin: 0;">+</p>
                        </button>
                    </div>
                    <div style="margin-top: 8px; height: 10px; background: #2c2415; border: 1px solid #4a3f28;">
                        <div id="vitality-bar" style="height: 100%; width: 33%; background: linear-gradient(to right, #f39c12, #e67e22); transition: width 0.3s;"></div>
                    </div>
                </div>
            </div>

            <hr class="golden" style="margin: 25px 0;">

            <!-- Class Preview -->
            <div class="rpgui-container framed-golden" style="text-align: center; padding: 20px; background: rgba(255, 215, 0, 0.05);">
                <h3 class="sidebar-title">🎭 Twoja Klasa</h3>
                <p id="classPreview" style="font-size: 24px; color: #ffd700; margin: 10px 0; font-family: 'Press Start 2P', cursive;">
                    Wojownik
                </p>
                <p id="classDescription" style="font-size: 14px; color: #c9b388; margin: 0;">
                    Klasa określana przez najwyższą statystykę
                </p>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 15px; margin-top: 25px;">
                <button type="submit" class="rpgui-button golden" style="flex: 1;" id="submitBtn">
                    <p>✨ Stwórz Postać</p>
                </button>
                <a href="{{ route('home') }}" class="rpgui-button" style="flex: 1; text-align: center;">
                    <p>Anuluj</p>
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const stats = {
    strength: 10,
    intelligence: 10,
    dexterity: 10,
    vitality: 10
};

const classNames = {
    strength: 'Wojownik',
    intelligence: 'Mag',
    dexterity: 'Łotrzyk',
    vitality: 'Obrońca'
};

const classDescriptions = {
    strength: 'Potężny bojownik walczący w zwarciu',
    intelligence: 'Mistrz magii i zaklęć',
    dexterity: 'Zwinny łowca i skrytobójca',
    vitality: 'Niezniszczalny obrońca drużyny'
};

function updateUI() {
    // Update stat values and bars
    for (let stat in stats) {
        document.getElementById(stat).value = stats[stat];
        const percentage = ((stats[stat] - 5) / 15) * 100;
        document.getElementById(stat + '-bar').style.width = percentage + '%';
    }

    // Calculate remaining points
    const total = Object.values(stats).reduce((a, b) => a + b, 0);
    const remaining = 40 - total;
    document.getElementById('remainingPoints').textContent = remaining;
    document.getElementById('remainingPoints').style.color = remaining === 0 ? '#2ecc71' : remaining < 0 ? '#e74c3c' : '#ffd700';

    // Update class preview
    const dominantStat = Object.keys(stats).reduce((a, b) => stats[a] > stats[b] ? a : b);
    document.getElementById('classPreview').textContent = classNames[dominantStat];
    document.getElementById('classDescription').textContent = classDescriptions[dominantStat];

    // Enable/disable submit button
    document.getElementById('submitBtn').disabled = remaining !== 0;
}

function changeStat(stat, delta) {
    const newValue = stats[stat] + delta;
    
    // Check bounds
    if (newValue < 5 || newValue > 20) {
        return;
    }
    
    // If increasing (+1), check if we have points available
    if (delta > 0) {
        const currentTotal = Object.values(stats).reduce((a, b) => a + b, 0);
        const remaining = 40 - currentTotal;
        if (remaining <= 0) {
            return; // No points left to spend
        }
    }
    
    stats[stat] = newValue;
    updateUI();
}

// Initialize
updateUI();
</script>
@endsection
