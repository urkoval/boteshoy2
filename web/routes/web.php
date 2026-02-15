<?php

use App\Http\Controllers\AdminContenidoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\SorteoController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Rutas de juegos (solo lectura)
Route::get('/{juego}', [JuegoController::class, 'show'])->name('juego.show');
Route::get('/{juego}/apuestas-multiples', [JuegoController::class, 'apuestasMultiples'])->name('juego.apuestas-multiples');
Route::get('/{juego}/apuestas-reducidas', [JuegoController::class, 'apuestasReducidas'])->name('juego.apuestas-reducidas');
Route::get('/{juego}/combinacion-ganadora', [JuegoController::class, 'combinacionGanadora'])->name('juego.combinacion-ganadora');
Route::get('/{juego}/guia', [JuegoController::class, 'guia'])->name('juego.guia');

// Rutas de sorteos (solo lectura)
Route::get('/{juego}/sorteos', [SorteoController::class, 'index'])->name('sorteo.index');
Route::get('/{juego}/sorteo/{sorteo}', [SorteoController::class, 'show'])->name('sorteo.show');

// CMS - Solo lectura por ahora
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('contenido', [AdminContenidoController::class, 'index'])->name('contenido.index');
    // Rutas de creación deshabilitadas temporalmente
    // Route::get('contenido/create', [AdminContenidoController::class, 'create'])->name('contenido.create');
    // Route::post('contenido', [AdminContenidoController::class, 'store'])->name('contenido.store');
    // Route::get('contenido/{contenido}/edit', [AdminContenidoController::class, 'edit'])->name('contenido.edit');
    // Route::put('contenido/{contenido}', [AdminContenidoController::class, 'update'])->name('contenido.update');
    // Route::delete('contenido/{contenido}', [AdminContenidoController::class, 'destroy'])->name('contenido.destroy');
    // Route::patch('contenido/{contenido}/toggle', [AdminContenidoController::class, 'toggleActive'])->name('contenido.toggle');
});
