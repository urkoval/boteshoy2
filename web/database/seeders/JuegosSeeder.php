<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Juego;

class JuegosSeeder extends Seeder
{
    public function run(): void
    {
        $juegos = [
            [
                'slug' => 'euromillones',
                'nombre' => 'Euromillones',
                'dias_sorteo' => 'martes,viernes',
            ],
            [
                'slug' => 'bonoloto',
                'nombre' => 'Bonoloto',
                'dias_sorteo' => 'lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            ],
            [
                'slug' => 'la-primitiva',
                'nombre' => 'La Primitiva',
                'dias_sorteo' => 'lunes,jueves,sabado',
            ],
            [
                'slug' => 'el-gordo',
                'nombre' => 'El Gordo de la Primitiva',
                'dias_sorteo' => 'domingo',
            ],
        ];

        foreach ($juegos as $juego) {
            Juego::updateOrCreate(['slug' => $juego['slug']], $juego);
        }
    }
}
