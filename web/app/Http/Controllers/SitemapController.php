<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Sorteo;

class SitemapController extends Controller
{
    public function index()
    {
        $juegos = Juego::all();
        $sorteos = Sorteo::with('juego')->orderBy('fecha', 'desc')->get();
        
        return response()
            ->view('sitemap', compact('juegos', 'sorteos'))
            ->header('Content-Type', 'application/xml');
    }
}
