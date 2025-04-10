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
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('match_id')->constrained('matches')->onDelete('cascade');
            $table->enum('bet_on', ['home', 'away', 'draw']);
            $table->decimal('amount', 10, 2);
            $table->decimal('odds', 5, 2);
            $table->decimal('potential_win', 10, 2);
            $table->enum('status', ['pending', 'won', 'lost', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};
