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
        Schema::create('sorteos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('juego_id')->constrained('juegos')->onDelete('cascade');
            $table->date('fecha');
            $table->json('numeros');
            $table->json('complementarios')->nullable();
            $table->decimal('bote', 15, 2)->nullable();
            $table->json('premios')->nullable();
            $table->json('localidades')->nullable();
            $table->timestamps();

            $table->unique(['juego_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorteos');
    }
};
