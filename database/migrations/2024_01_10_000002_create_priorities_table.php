<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_sheet_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->integer('order_number');
            $table->timestamps();
            
            $table->unique(['daily_sheet_id', 'order_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
}; 