<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_sheets', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->text('daily_focus');
            $table->integer('day_rating')->nullable();
            $table->text('learned_today')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_sheets');
    }
}; 