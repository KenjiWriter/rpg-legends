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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('level')->default(1);
            $table->integer('experience')->default(0);
            
            // Stats system - class will be determined by stat allocation
            $table->integer('strength')->default(10);
            $table->integer('intelligence')->default(10);
            $table->integer('dexterity')->default(10);
            $table->integer('vitality')->default(10);
            
            // Combat stats
            $table->integer('current_hp')->default(100);
            $table->integer('max_hp')->default(100);
            
            // Economy
            $table->integer('gold')->default(100);
            
            // Character selection
            $table->boolean('is_active')->default(false);
            
            $table->timestamps();
            
            // Ensure unique character names per user
            $table->unique(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
