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
            'slug' => 'eurodreams',
            'nombre' => 'Eurodreams',
            'dias_sorteo' => 'Lunes,Jueves',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('juegos')->where('slug', 'eurodreams')->delete();
    }
};
