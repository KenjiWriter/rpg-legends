<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- ITEMS ---
        
        // Materials
        $ironOre = \App\Models\Item::create([
            'name' => 'Ruda Żelaza', 'type' => 'material', 'rarity' => 'common', 'value' => 5, 'image' => 'iron_ore.png'
        ]);
        $leather = \App\Models\Item::create([
            'name' => 'Skóra', 'type' => 'material', 'rarity' => 'common', 'value' => 4, 'image' => 'leather.png'
        ]);
        $wood = \App\Models\Item::create([
            'name' => 'Drewno', 'type' => 'material', 'rarity' => 'common', 'value' => 2, 'image' => 'wood.png'
        ]);
        $magicDust = \App\Models\Item::create([
            'name' => 'Magiczny Pył', 'type' => 'material', 'rarity' => 'uncommon', 'value' => 15, 'image' => 'magic_dust.png'
        ]);

        // Consumables
        $healthPotion = \App\Models\Item::create([
            'name' => 'Mikstura Zdrowia', 'type' => 'consumable', 'rarity' => 'common', 'value' => 20, 'image' => 'health_potion.png'
        ]);

        // Weapons
        $rustySword = \App\Models\Item::create([
            'name' => 'Zardzewiały Miecz', 'type' => 'weapon', 'rarity' => 'common', 'power' => 5, 'value' => 10, 'image' => 'rusty_sword.png'
        ]);
        $ironSword = \App\Models\Item::create([
            'name' => 'Żelazny Miecz', 'type' => 'weapon', 'rarity' => 'uncommon', 'power' => 12, 'value' => 50, 'image' => 'iron_sword.png'
        ]);
        $steelSword = \App\Models\Item::create([
            'name' => 'Stalowy Miecz', 'type' => 'weapon', 'rarity' => 'rare', 'power' => 25, 'value' => 200, 'image' => 'steel_sword.png'
        ]);

        // Armor
        $leatherArmor = \App\Models\Item::create([
            'name' => 'Skórzana Zbroja', 'type' => 'armor', 'rarity' => 'common', 'power' => 3, 'value' => 15, 'image' => 'leather_armor.png'
        ]);
        $chainmail = \App\Models\Item::create([
            'name' => 'Kolczuga', 'type' => 'armor', 'rarity' => 'uncommon', 'power' => 8, 'value' => 80, 'image' => 'chainmail.png'
        ]);
        $plateArmor = \App\Models\Item::create([
            'name' => 'Płytowa Zbroja', 'type' => 'armor', 'rarity' => 'rare', 'power' => 18, 'value' => 300, 'image' => 'plate_armor.png'
        ]);


        // --- MONSTERS ---

        // Location 1: Forest (Lvl 1-15)
        $goblin = \App\Models\Monster::create([
            'name' => 'Goblin', 'level' => 2, 'hp' => 6, 'strength' => 1, 'defense' => 1, 
            'exp_reward' => 10, 'gold_reward' => 5, 'location_id' => 1, 'image' => 'goblin.png'
        ]);
        $wolf = \App\Models\Monster::create([
            'name' => 'Wilk', 'level' => 5, 'hp' => 11, 'strength' => 1, 'defense' => 1, 
            'exp_reward' => 20, 'gold_reward' => 8, 'location_id' => 1, 'image' => 'wolf.png'
        ]);
        $bear = \App\Models\Monster::create([
            'name' => 'Niedźwiedź', 'level' => 10, 'hp' => 120, 'strength' => 12, 'defense' => 5, 
            'exp_reward' => 50, 'gold_reward' => 20, 'location_id' => 1, 'image' => 'bear.png'
        ]);

        // Location 2: Cave (Lvl 15-30)
        $spider = \App\Models\Monster::create([
            'name' => 'Wielki Pająk', 'level' => 16, 'hp' => 150, 'strength' => 18, 'defense' => 8, 
            'exp_reward' => 80, 'gold_reward' => 30, 'location_id' => 2, 'image' => 'spider.png'
        ]);
        $troll = \App\Models\Monster::create([
            'name' => 'Troll Jaskiniowy', 'level' => 25, 'hp' => 300, 'strength' => 30, 'defense' => 15, 
            'exp_reward' => 150, 'gold_reward' => 60, 'location_id' => 2, 'image' => 'troll.png'
        ]);

        // Location 3: Fortress (Lvl 30-50)
        $orcWarrior = \App\Models\Monster::create([
            'name' => 'Ork Wojownik', 'level' => 32, 'hp' => 400, 'strength' => 45, 'defense' => 25, 
            'exp_reward' => 250, 'gold_reward' => 100, 'location_id' => 3, 'image' => 'orc.png'
        ]);
        $ogre = \App\Models\Monster::create([
            'name' => 'Ogr', 'level' => 45, 'hp' => 800, 'strength' => 70, 'defense' => 40, 
            'exp_reward' => 500, 'gold_reward' => 250, 'location_id' => 3, 'image' => 'ogre.png'
        ]);


        // --- DROPS ---
        
        // Goblin drops
        \DB::table('monster_drops')->insert([
            ['monster_id' => $goblin->id, 'item_id' => $rustySword->id, 'chance' => 0.10],
            ['monster_id' => $goblin->id, 'item_id' => $leather->id, 'chance' => 0.30],
            ['monster_id' => $goblin->id, 'item_id' => $healthPotion->id, 'chance' => 0.15],
        ]);

        // Wolf drops
        \DB::table('monster_drops')->insert([
            ['monster_id' => $wolf->id, 'item_id' => $leather->id, 'chance' => 0.60],
            ['monster_id' => $wolf->id, 'item_id' => $leatherArmor->id, 'chance' => 0.05],
        ]);

        // Bear drops
        \DB::table('monster_drops')->insert([
            ['monster_id' => $bear->id, 'item_id' => $leather->id, 'chance' => 0.80],
            ['monster_id' => $bear->id, 'item_id' => $healthPotion->id, 'chance' => 0.20],
        ]);

        // Spider drops
        \DB::table('monster_drops')->insert([
            ['monster_id' => $spider->id, 'item_id' => $magicDust->id, 'chance' => 0.40],
        ]);

        // Troll drops
        \DB::table('monster_drops')->insert([
            ['monster_id' => $troll->id, 'item_id' => $ironOre->id, 'chance' => 0.50],
            ['monster_id' => $troll->id, 'item_id' => $ironSword->id, 'chance' => 0.10],
        ]);

        // Orc drops
        \DB::table('monster_drops')->insert([
            ['monster_id' => $orcWarrior->id, 'item_id' => $ironOre->id, 'chance' => 0.60],
            ['monster_id' => $orcWarrior->id, 'item_id' => $chainmail->id, 'chance' => 0.15],
            ['monster_id' => $orcWarrior->id, 'item_id' => $steelSword->id, 'chance' => 0.05],
        ]);
    }
}
