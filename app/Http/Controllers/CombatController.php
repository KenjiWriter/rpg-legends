<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Character;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CombatController extends Controller
{
    public function start($locationId)
    {
        $character = auth()->user()->activeCharacter;
        
        // Find random monster in location
        $monster = Monster::where('location_id', $locationId)
            ->inRandomOrder()
            ->first();

        if (!$monster) {
            return redirect()->route('city.adventure')->with('error', 'Nie znaleziono potworów w tej lokacji!');
        }

        // --- BATTLE SIMULATION ---
        
        $combatData = [
            'monster' => $monster,
            'player_start_hp' => $character->current_hp,
            'player_max_hp' => $character->max_hp,
            'monster_start_hp' => $monster->hp,
            'monster_max_hp' => $monster->hp,
            'turns' => [],
            'result' => null,
            'rewards' => []
        ];

        $playerHp = $character->current_hp;
        $monsterHp = $monster->hp;
        $turnCount = 1;

        while ($playerHp > 0 && $monsterHp > 0) {
            $turnData = ['turn' => $turnCount, 'logs' => []];

            // --- PLAYER TURN ---
            // Dmg: Str + Random(1-5) - (Monster Def / 2)
            $playerDmg = max(1, $character->strength + rand(1, 5) - floor($monster->defense / 2));
            $monsterHp -= $playerDmg;
            $turnData['logs'][] = [
                'type' => 'player_attack',
                'message' => "Zadałeś {$playerDmg} obrażeń!",
                'damage' => $playerDmg,
                'target' => 'monster'
            ];

            if ($monsterHp <= 0) {
                $monsterHp = 0;
                $combatData['result'] = 'victory';
                $turnData['monster_hp'] = 0;
                $turnData['player_hp'] = $playerHp;
                $combatData['turns'][] = $turnData;
                break;
            }

            // --- MONSTER TURN ---
            // Dmg: Str + Random(1-3) - (Player Def / 2)
            $monsterDmg = max(1, $monster->strength + rand(1, 3) - floor($character->defense / 2));
            $playerHp -= $monsterDmg;
            $turnData['logs'][] = [
                'type' => 'monster_attack',
                'message' => "{$monster->name} zadaje Ci {$monsterDmg} obrażeń!",
                'damage' => $monsterDmg,
                'target' => 'player'
            ];

            if ($playerHp <= 0) {
                $playerHp = 0;
                $combatData['result'] = 'defeat';
            }

            $turnData['monster_hp'] = $monsterHp;
            $turnData['player_hp'] = $playerHp;
            $combatData['turns'][] = $turnData;
            $turnCount++;
        }

        // --- APPLY RESULTS ---

        $character->current_hp = $playerHp;

        if ($combatData['result'] === 'victory') {
            // EXP
            $character->experience += $monster->exp_reward;
            $combatData['rewards']['exp'] = $monster->exp_reward;

            // Level Up
            $nextLevelExp = $character->level * 100;
            if ($character->experience >= $nextLevelExp) {
                $character->level++;
                $character->experience -= $nextLevelExp;
                
                // Random stat increases (1-3 per stat)
                $randomStats = [
                    'strength' => rand(1, 3),
                    'intelligence' => rand(1, 3),
                    'dexterity' => rand(1, 3),
                    'vitality' => rand(1, 3),
                    'defense' => rand(1, 2)
                ];
                
                $character->strength += $randomStats['strength'];
                $character->intelligence += $randomStats['intelligence'];
                $character->dexterity += $randomStats['dexterity'];
                $character->vitality += $randomStats['vitality'];
                $character->defense += $randomStats['defense'];
                
                // Update max HP based on new vitality
                $character->max_hp = 100 + ($character->vitality * 5);
                $character->current_hp = $character->max_hp; // Full heal on level up
                
                // Grant 3 allocatable stat points
                $character->stat_points += 3;
                
                $combatData['rewards']['level_up'] = [
                    'new_level' => $character->level,
                    'stat_points_granted' => 3,
                    'random_stats' => $randomStats
                ];
            }

            // Gold
            $character->gold += $monster->gold_reward;
            $combatData['rewards']['gold'] = $monster->gold_reward;

            // Drops
            $drops = \DB::table('monster_drops')->where('monster_id', $monster->id)->get();
            $combatData['rewards']['items'] = [];

            foreach ($drops as $drop) {
                if ((rand(1, 10000) / 10000) <= $drop->chance) {
                    $item = \App\Models\Item::find($drop->item_id);
                    
                    $inventory = Inventory::where('character_id', $character->id)
                        ->where('item_id', $item->id)
                        ->first();

                    if ($inventory) {
                        $inventory->quantity++;
                        $inventory->save();
                    } else {
                        Inventory::create([
                            'character_id' => $character->id,
                            'item_id' => $item->id,
                            'quantity' => 1
                        ]);
                    }
                    $combatData['rewards']['items'][] = $item;
                }
            }
        }

        $character->save();

        return view('game.combat', compact('character', 'monster', 'combatData', 'locationId'));
    }
}
