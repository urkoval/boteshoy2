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

    public function guia(string $slug)
    {
        $juego = Juego::where('slug', $slug)->firstOrFail();
        
        // Vista específica para Lotería Nacional
        if ($slug === 'loteria-nacional') {
            return view('guia-loteria-nacional', compact('juego'));
        }
        
        return view('juego-guia', compact('juego'));
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
        
        // Vista específica para Lotería Nacional
        if ($slug === 'loteria-nacional') {
            return view('sorteo-loteria', compact('juego', 'sorteo', 'fechasDisponibles'));
        }
        
        return view('sorteo', compact('juego', 'sorteo', 'fechasDisponibles'));
    }

    public function apuestasMultiples(string $slug)
    {
        // Lotería Nacional no tiene apuestas múltiples
        if ($slug === 'loteria-nacional') {
            abort(404);
        }
        
        $juego = Juego::where('slug', $slug)->firstOrFail();
        
        // Buscar contenido en CMS
        $contenido = $juego->contenidos()
            ->porTipo('apuestas_multiples')
            ->activos()
            ->first();
        
        return view('juego-apuestas-multiples', compact('juego', 'contenido'));
    }

    public function apuestasReducidas(string $slug)
    {
        // Lotería Nacional no tiene apuestas reducidas
        if ($slug === 'loteria-nacional') {
            abort(404);
        }
        
        $juego = Juego::where('slug', $slug)->firstOrFail();
        
        // Buscar contenido en CMS
        $contenido = $juego->contenidos()
            ->porTipo('apuestas_reducidas')
            ->activos()
            ->first();
        
        return view('juego-apuestas-reducidas', compact('juego', 'contenido'));
    }

    public function combinacionGanadora(string $slug)
    {
        // Lotería Nacional no tiene combinación ganadora (son décimos, no combinaciones)
        if ($slug === 'loteria-nacional') {
            abort(404);
        }
        
        $juego = Juego::where('slug', $slug)->firstOrFail();
        
        // Buscar contenido en CMS
        $contenido = $juego->contenidos()
            ->porTipo('combinacion_ganadora')
            ->activos()
            ->first();
        
        $ultimoSorteo = $juego->sorteos()
            ->orderBy('fecha', 'desc')
            ->first();
            
        return view('juego-combinacion-ganadora', compact('juego', 'contenido', 'ultimoSorteo'));
    }

    public function decimoPremiado()
    {
        $juego = Juego::where('slug', 'loteria-nacional')->firstOrFail();
        
        // Últimos sorteos de jueves y sábado
        $ultimoJueves = $juego->sorteos()
            ->whereRaw('strftime("%w", fecha) = "4"')
            ->orderBy('fecha', 'desc')
            ->first();
        
        $ultimoSabado = $juego->sorteos()
            ->whereRaw('strftime("%w", fecha) = "6"')
            ->orderBy('fecha', 'desc')
            ->first();
        
        return view('loteria-decimo-premiado', compact('juego', 'ultimoJueves', 'ultimoSabado'));
    }

    public function loteriaNacionalJueves()
    {
        $juego = Juego::where('slug', 'loteria-nacional')->firstOrFail();
        
        // Filtrar solo sorteos de jueves (día 4)
        $sorteos = $juego->sorteos()
            ->whereRaw('strftime("%w", fecha) = "4"')
            ->orderBy('fecha', 'desc')
            ->paginate(20);
        
        $diaSemana = 'jueves';
        
        return view('juego-loteria-dia', compact('juego', 'sorteos', 'diaSemana'));
    }

    public function loteriaNacionalSabado()
    {
        $juego = Juego::where('slug', 'loteria-nacional')->firstOrFail();
        
        // Filtrar solo sorteos de sábado (día 6)
        $sorteos = $juego->sorteos()
            ->whereRaw('strftime("%w", fecha) = "6"')
            ->orderBy('fecha', 'desc')
            ->paginate(20);
        
        $diaSemana = 'sabado';
        
        return view('juego-loteria-dia', compact('juego', 'sorteos', 'diaSemana'));
    }
}
