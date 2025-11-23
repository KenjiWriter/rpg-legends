<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => '🎮 Witamy w Świecie RPG!',
                'content' => 'Witajcie, dzielni wojownicy! Wyruszcie w epicką przygodę poprzez mroczne lochy, tajemnicze lasy i niebezpieczne krainy. Zbierajcie doświadczenie, rozwijajcie swoje umiejętności i stańcie się legendą!',
                'published_at' => now()->subDays(7),
                'is_pinned' => true,
            ],
            [
                'title' => '⚔️ Nowa Aktualizacja: System Walki v2.0',
                'content' => 'Wprowadziliśmy nowy, ulepszony system walki! Turowy styl półidle zapewnia dynamiczną rozgrywkę - raz Ty zadajesz obrażenia, raz przeciwnik. Testujcie nowe mechaniki w arenie treningowej!',
                'published_at' => now()->subDays(3),
                'is_pinned' => false,
            ],
            [
                'title' => '🏆 Event Weekendowy: Podwójne XP!',
                'content' => 'W ten weekend wszystkie potwory dają podwójne doświadczenie! To idealny moment, aby awansować na wyższe poziomy i rozwinąć swoje statystyki. Pamiętajcie - Wasza klasa zależy od tego, jak rozwiniecie postać!',
                'published_at' => now()->subDay(),
                'is_pinned' => false,
            ],
            [
                'title' => '📚 System Klas - Jak to działa?',
                'content' => 'W naszej grze nie wybierasz klasy od razu! Twoja klasa jest określana przez statystyki:\n- Wysoka SIŁA → Wojownik\n- Wysoka INTELIGENCJA → Mag\n- Wysoka ZRĘCZNOŚĆ → Łotrzyk\n- Wysoka WITALNOŚĆ → Obrońca\n\nRozwijaj postać według swojego stylu gry!',
                'published_at' => now()->subHours(12),
                'is_pinned' => true,
            ],
            [
                'title' => '💰 Ekonomia: Zbieraj złoto i kupuj ekwipunek!',
                'content' => 'Każda pokonana istota zostawia złoto. Zbieraj je, aby kupować lepszy ekwipunek w miastach. Pamiętaj - niektóre przedmioty wymagają odpowiednich statystyk. Mag nie założy ciężkiej zbroi bez odpowiedniej siły!',
                'published_at' => now()->subHours(6),
                'is_pinned' => false,
            ],
        ];

        foreach ($news as $item) {
            \App\Models\News::create($item);
        }
    }
}
