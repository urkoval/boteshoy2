<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\SitemapController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/{slug}', [JuegoController::class, 'show'])->name('juego');
Route::get('/{slug}/{fecha}', [JuegoController::class, 'sorteo'])->name('sorteo');
