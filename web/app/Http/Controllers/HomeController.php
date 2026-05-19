<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Sorteo;

class HomeController extends Controller
{
    public function index()
    {
        $juegos = Juego::with('ultimoSorteo')->get();
        
        // Últimos sorteos de Lotería Nacional por día
        $loteriaNacional = Juego::where('slug', 'loteria-nacional')->first();
        $loteriaJueves = null;
        $loteriaSabado = null;
        
        if ($loteriaNacional) {
            $loteriaJueves = $loteriaNacional->sorteos()
                ->whereRaw('strftime("%w", fecha) = "4"')
                ->orderBy('fecha', 'desc')
                ->first();
            
            $loteriaSabado = $loteriaNacional->sorteos()
                ->whereRaw('strftime("%w", fecha) = "6"')
                ->orderBy('fecha', 'desc')
                ->first();
        }
        
        return view('home', compact('juegos', 'loteriaJueves', 'loteriaSabado'));
    }
}
