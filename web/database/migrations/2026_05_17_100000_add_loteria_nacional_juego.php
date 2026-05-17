<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('juegos')->insert([
            'slug' => 'loteria-nacional',
            'nombre' => 'Lotería Nacional',
            'dias_sorteo' => 'Jueves,Sábado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('juegos')->where('slug', 'loteria-nacional')->delete();
    }
};
