<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('gamemode', 20)->index();
            $table->json('vibe');
            $table->json('filters');
            $table->string('answer_logic', 40)->nullable();
            $table->json('result_logic')->nullable();
            $table->json('actors')->nullable();
            $table->json('targets')->nullable();
            $table->boolean('enabled')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('question_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('language', 5);
            $table->text('question');
            $table->text('condition')->nullable();
            $table->json('options')->nullable();
            $table->json('answer')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
            $table->unique(['question_id', 'language']);
            $table->index(['language', 'enabled']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_translations');
        Schema::dropIfExists('questions');
    }
};
