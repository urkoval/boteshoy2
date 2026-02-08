<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Sorteo;

class JuegoController extends Controller
{
    public function show(string $slug)
    {
        $juego = Juego::where('slug', $slug)->firstOrFail();
        $sorteos = $juego->sorteos()->orderBy('fecha', 'desc')->paginate(20);
        
        return view('juego', compact('juego', 'sorteos'));
    }

    public function sorteo(string $slug, string $fecha)
    {
        $juego = Juego::where('slug', $slug)->firstOrFail();
        $sorteo = Sorteo::where('juego_id', $juego->id)
            ->where('fecha', $fecha)
            ->firstOrFail();
        
        // Obtener fechas disponibles para el calendario
        $fechasDisponibles = $juego->sorteos()
            ->where('fecha', '>=', now()->copy()->subYears(2))
            ->where('fecha', '<=', now())
            ->pluck('fecha')
            ->map(function($fecha) {
                return $fecha->format('Y-m-d');
            })
            ->toArray();
        
        return view('sorteo', compact('juego', 'sorteo', 'fechasDisponibles'));
    }
}
