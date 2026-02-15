<?php

use App\Http\Controllers\AdminContenidoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas del CMS protegidas con autenticación
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('contenido', [AdminContenidoController::class, 'index'])->name('contenido.index');
        Route::get('contenido/create', [AdminContenidoController::class, 'create'])->name('contenido.create');
        Route::post('contenido', [AdminContenidoController::class, 'store'])->name('contenido.store');
        Route::get('contenido/{contenido}/edit', [AdminContenidoController::class, 'edit'])->name('contenido.edit');
        Route::put('contenido/{contenido}', [AdminContenidoController::class, 'update'])->name('contenido.update');
        Route::delete('contenido/{contenido}', [AdminContenidoController::class, 'destroy'])->name('contenido.destroy');
        Route::patch('contenido/{contenido}/toggle', [AdminContenidoController::class, 'toggleActive'])->name('contenido.toggle');
    });
});

require __DIR__.'/auth.php';
