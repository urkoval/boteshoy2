<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('es');

        View::composer('*', function ($view) {
            $botesHeader = [];
            $boteDestacado = null;
            $boteProximo = null;
            $boteSemana = null;

            try {
                if (!Schema::hasTable('botes')) {
                    $view->with('botesHeader', $botesHeader)->with('boteDestacado', $boteDestacado);
                    return;
                }

                $rows = DB::table('botes')
                    ->select('juego_slug', 'fecha_sorteo', 'bote_eur', 'updated_at')
                    ->where('fecha_sorteo', '>=', now()->format('Y-m-d'))
                    ->orderBy('fecha_sorteo')
                    ->orderByDesc('updated_at')
                    ->get();

                $latestByJuego = [];
                foreach ($rows as $row) {
                    if (!isset($latestByJuego[$row->juego_slug])) {
                        $latestByJuego[$row->juego_slug] = $row;
                    }
                }

                $orderedSlugs = ['euromillones', 'bonoloto', 'la-primitiva', 'el-gordo'];
                $slugToNombre = [
                    'euromillones' => 'Euromillones',
                    'bonoloto' => 'Bonoloto',
                    'la-primitiva' => 'La Primitiva',
                    'el-gordo' => 'El Gordo',
                ];
                $slugToClasses = [
                    'euromillones' => ['bg' => 'bg-euro-500/20', 'border' => 'border-euro-500/30', 'text' => 'text-euro-600'],
                    'bonoloto' => ['bg' => 'bg-bono-500/20', 'border' => 'border-bono-500/30', 'text' => 'text-bono-600'],
                    'la-primitiva' => ['bg' => 'bg-primi-500/20', 'border' => 'border-primi-500/30', 'text' => 'text-primi-600'],
                    'el-gordo' => ['bg' => 'bg-gordo-500/20', 'border' => 'border-gordo-500/30', 'text' => 'text-gordo-600'],
                ];

                foreach ($orderedSlugs as $slug) {
                    if (!isset($latestByJuego[$slug])) {
                        continue;
                    }
                    $row = $latestByJuego[$slug];
                    $botesHeader[] = [
                        'slug' => $slug,
                        'nombre' => $slugToNombre[$slug] ?? $slug,
                        'fecha_sorteo' => $row->fecha_sorteo,
                        'bote_eur' => (int) $row->bote_eur,
                        'classes' => $slugToClasses[$slug] ?? ['bg' => 'bg-white/10', 'border' => 'border-white/20', 'text' => 'text-white'],
                    ];
                }

                // Bote próximo: el más cercano en fecha
                $hoy = now()->format('Y-m-d');
                foreach ($botesHeader as $item) {
                    if (!$boteProximo || $item['fecha_sorteo'] <= $boteProximo['fecha_sorteo']) {
                        if ($item['fecha_sorteo'] === $hoy || !$boteProximo) {
                            $boteProximo = $item;
                        } elseif ($item['fecha_sorteo'] < $boteProximo['fecha_sorteo']) {
                            $boteProximo = $item;
                        }
                    }
                }

                // Bote semana: el mayor de todos
                foreach ($botesHeader as $item) {
                    if (!$boteSemana || $item['bote_eur'] > $boteSemana['bote_eur']) {
                        $boteSemana = $item;
                    }
                }

                // Si son el mismo, buscar el segundo mayor para boteSemana
                if ($boteProximo && $boteSemana && $boteProximo['slug'] === $boteSemana['slug']) {
                    $segundoMayor = null;
                    foreach ($botesHeader as $item) {
                        if ($item['slug'] !== $boteProximo['slug']) {
                            if (!$segundoMayor || $item['bote_eur'] > $segundoMayor['bote_eur']) {
                                $segundoMayor = $item;
                            }
                        }
                    }
                    if ($segundoMayor) {
                        $boteSemana = $segundoMayor;
                    }
                }

                $boteDestacado = $boteSemana; // mantener compatibilidad
            } catch (\Throwable $e) {
                $botesHeader = [];
                $boteDestacado = null;
                $boteProximo = null;
                $boteSemana = null;
            }

            $view->with('botesHeader', $botesHeader)
                 ->with('boteDestacado', $boteDestacado)
                 ->with('boteProximo', $boteProximo)
                 ->with('boteSemana', $boteSemana);
        });
    }
}
