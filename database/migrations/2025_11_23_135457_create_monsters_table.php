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
        Schema::create('monsters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('level');
            $table->integer('hp');
            $table->integer('strength');
            $table->integer('defense');
            $table->integer('exp_reward');
            $table->integer('gold_reward');
            $table->integer('location_id'); // 1: Forest, 2: Cave, 3: Fortress
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monsters');
    }
};
