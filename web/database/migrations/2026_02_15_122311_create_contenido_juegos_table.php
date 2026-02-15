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
        Schema::create('contenido_juegos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('juego_id')->constrained()->onDelete('cascade');
            $table->enum('tipo_contenido', ['apuestas_multiples', 'apuestas_reducidas', 'combinacion_ganadora']);
            
            // Campos SEO
            $table->string('seo_title');
            $table->text('meta_description');
            $table->string('h1_principal');
            
            // Contenido principal
            $table->longText('contenido_html')->nullable();
            $table->longText('contenido_markdown')->nullable();
            
            // Datos específicos por juego (JSON)
            $table->json('datos_especificos')->nullable();
            
            // Metadatos adicionales
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            
            // Estado
            $table->boolean('activo')->default(true);
            
            $table->timestamps();
            
            // Índices únicos
            $table->unique(['juego_id', 'tipo_contenido']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenido_juegos');
    }
};
