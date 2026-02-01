<?php

namespace App\Http\Controllers;

use App\Models\Juego;

class HomeController extends Controller
{
    public function index()
    {
        $juegos = Juego::with('ultimoSorteo')->get();
        
        return view('home', compact('juegos'));
    }
}
