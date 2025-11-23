<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['weapon', 'armor', 'material', 'consumable']);
            $table->enum('rarity', ['common', 'uncommon', 'rare', 'epic', 'legendary'])->default('common');
            $table->integer('power')->default(0); // Attack for weapons, Defense for armor
            $table->integer('value')->default(0); // Gold value
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
