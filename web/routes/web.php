<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\AdminContenidoController;

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Rutas de administración (ANTES de las rutas con {slug})
Route::prefix('admin')->name('admin.')->middleware('admin.key')->group(function () {
    Route::get('/contenido', [AdminContenidoController::class, 'index'])->name('contenido.index');
    Route::get('/contenido/create', [AdminContenidoController::class, 'create'])->name('contenido.create');
    Route::post('/contenido', [AdminContenidoController::class, 'store'])->name('contenido.store');
    Route::get('/contenido/{contenido}/edit', [AdminContenidoController::class, 'edit'])->name('contenido.edit');
    Route::put('/contenido/{contenido}', [AdminContenidoController::class, 'update'])->name('contenido.update');
    Route::delete('/contenido/{contenido}', [AdminContenidoController::class, 'destroy'])->name('contenido.destroy');
    Route::patch('/contenido/{contenido}/toggle', [AdminContenidoController::class, 'toggleActive'])->name('contenido.toggle');
});

// Rutas de juegos (AL FINAL porque {slug} captura todo)
Route::get('/{slug}/guia', [JuegoController::class, 'guia'])->name('juego.guia');
Route::get('/{slug}/apuestas-multiples', [JuegoController::class, 'apuestasMultiples'])->name('juego.apuestas-multiples');
Route::get('/{slug}/apuestas-reducidas', [JuegoController::class, 'apuestasReducidas'])->name('juego.apuestas-reducidas');
Route::get('/{slug}/combinacion-ganadora', [JuegoController::class, 'combinacionGanadora'])->name('juego.combinacion-ganadora');
Route::get('/{slug}', [JuegoController::class, 'show'])->name('juego');
Route::get('/{slug}/{fecha}', [JuegoController::class, 'sorteo'])->name('sorteo');
