<?php

namespace App\Http\Controllers;

use App\Models\ContenidoJuego;
use App\Models\Juego;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminContenidoController extends Controller
{
    public function index(): View
    {
        $contenidos = ContenidoJuego::with('juego')
            ->orderBy('juego_id')
            ->orderBy('tipo_contenido')
            ->get();

        return view('admin.contenido.index', compact('contenidos'));
    }

    public function create(): View
    {
        $juegos = Juego::all();
        $tiposContenido = [
            'apuestas_multiples' => 'Apuestas Múltiples',
            'apuestas_reducidas' => 'Apuestas Reducidas',
            'combinacion_ganadora' => 'Combinación Ganadora',
        ];

        return view('admin.contenido.create', compact('juegos', 'tiposContenido'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'juego_id' => 'required|exists:juegos,id',
            'tipo_contenido' => 'required|in:apuestas_multiples,apuestas_reducidas,combinacion_ganadora',
            'seo_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'h1_principal' => 'required|string|max:100',
            'contenido_html' => 'nullable|string',
            'contenido_markdown' => 'nullable|string',
            'datos_especificos' => 'nullable|array',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ]);

        // Verificar unicidad
        $exists = ContenidoJuego::where('juego_id', $validated['juego_id'])
            ->where('tipo_contenido', $validated['tipo_contenido'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['tipo_contenido' => 'Ya existe contenido para este juego y tipo.']);
        }

        ContenidoJuego::create($validated);

        return redirect()
            ->route('admin.contenido.index')
            ->with('success', 'Contenido creado correctamente.');
    }

    public function edit(ContenidoJuego $contenido): View
    {
        $juegos = Juego::all();
        $tiposContenido = [
            'apuestas_multiples' => 'Apuestas Múltiples',
            'apuestas_reducidas' => 'Apuestas Reducidas',
            'combinacion_ganadora' => 'Combinación Ganadora',
        ];

        return view('admin.contenido.edit', compact('contenido', 'juegos', 'tiposContenido'));
    }

    public function update(Request $request, ContenidoJuego $contenido): RedirectResponse
    {
        $validated = $request->validate([
            'seo_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'h1_principal' => 'required|string|max:100',
            'contenido_html' => 'nullable|string',
            'contenido_markdown' => 'nullable|string',
            'datos_especificos' => 'nullable|array',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ]);

        $contenido->update($validated);

        return redirect()
            ->route('admin.contenido.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroy(ContenidoJuego $contenido): RedirectResponse
    {
        $contenido->delete();

        return redirect()
            ->route('admin.contenido.index')
            ->with('success', 'Contenido eliminado correctamente.');
    }

    public function toggleActive(ContenidoJuego $contenido): RedirectResponse
    {
        $contenido->activo = !$contenido->activo;
        $contenido->save();

        $status = $contenido->activo ? 'activado' : 'desactivado';

        return redirect()
            ->route('admin.contenido.index')
            ->with('success', "Contenido {$status} correctamente.");
    }
}
