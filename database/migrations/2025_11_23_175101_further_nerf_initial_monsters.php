<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('monsters')->where('name', 'Goblin')->update([
            'hp' => 6,
            'strength' => 1
        ]);

        DB::table('monsters')->where('name', 'Wilk')->update([
            'hp' => 11,
            'strength' => 1,
            'defense' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('monsters')->where('name', 'Goblin')->update([
            'hp' => 20,
            'strength' => 2
        ]);

        DB::table('monsters')->where('name', 'Wilk')->update([
            'hp' => 35,
            'strength' => 4,
            'defense' => 2
        ]);
    }
};
