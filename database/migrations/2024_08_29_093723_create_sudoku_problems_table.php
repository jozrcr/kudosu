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
        Schema::create('sudoku_problems', function (Blueprint $table) {
            $table->id();
            $table->string('unique_hash')->unique();
            $table->text('problem');
            $table->integer('max_value');
            $table->boolean('is_daily')->default(false);
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sudoku_problems');
    }
};
