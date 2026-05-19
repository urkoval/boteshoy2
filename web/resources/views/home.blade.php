@extends('layouts.app')

@section('title', 'Resultados Loterías España Hoy')
@section('description', 'Consulta los últimos resultados de Euromillones, Bonoloto, La Primitiva y El Gordo de la Primitiva. Números ganadores y premios actualizados.')

@php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'border' => 'border-euro-500', 'text' => 'text-euro-500', 'ball' => 'bg-blue-600'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'border' => 'border-bono-500', 'text' => 'text-bono-500', 'ball' => 'bg-red-600'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'border' => 'border-primi-500', 'text' => 'text-primi-500', 'ball' => 'bg-emerald-600'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'border' => 'border-gordo-500', 'text' => 'text-gordo-500', 'ball' => 'bg-purple-600'],
    'eurodreams' => ['bg' => 'bg-dream-500', 'border' => 'border-dream-500', 'text' => 'text-dream-500', 'ball' => 'bg-cyan-600'],
    'loteria-nacional' => ['bg' => 'bg-loteria-500', 'border' => 'border-loteria-500', 'text' => 'text-loteria-500', 'ball' => 'bg-amber-700'],
];
@endphp

@section('content')
<h1 class="text-3xl font-bold text-slate-800 mb-6">Resultados de Loterías en España Hoy</h1>

@if(!empty($boteProximo) || !empty($boteSemana))
<section class="mb-8">
    <div class="grid gap-4 md:grid-cols-2">
        @if(!empty($boteProximo))
        <a href="{{ route('juego', $boteProximo['slug']) }}" class="block rounded-2xl bg-white shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-amber-600 to-amber-500 px-6 py-5 text-white">
                <div class="text-xs text-white/80 font-medium uppercase tracking-wide">🎯 Próximo sorteo</div>
                <div class="mt-2">
                    <div class="text-xl font-bold">{{ $boteProximo['nombre'] }}</div>
                    <div class="text-sm text-white/80">{{ \Carbon\Carbon::parse($boteProximo['fecha_sorteo'])->translatedFormat('l, j M') }}</div>
                    <div class="text-3xl sm:text-4xl font-extrabold mt-2">{{ number_format($boteProximo['bote_eur'], 0, ',', '.') }} €</div>
                </div>
            </div>
        </a>
        @endif

        @if(!empty($boteSemana) && (!$boteProximo || $boteSemana['slug'] !== $boteProximo['slug']))
        <a href="{{ route('juego', $boteSemana['slug']) }}" class="block rounded-2xl bg-white shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-r from-slate-800 to-slate-700 px-6 py-5 text-white">
                <div class="text-xs text-white/80 font-medium uppercase tracking-wide">🏆 Mayor bote</div>
                <div class="mt-2">
                    <div class="text-xl font-bold">{{ $boteSemana['nombre'] }}</div>
                    <div class="text-sm text-white/80">{{ \Carbon\Carbon::parse($boteSemana['fecha_sorteo'])->translatedFormat('l, j M') }}</div>
                    <div class="text-3xl sm:text-4xl font-extrabold mt-2">{{ number_format($boteSemana['bote_eur'], 0, ',', '.') }} €</div>
                </div>
            </div>
        </a>
        @endif
    </div>
</section>
@endif

<!-- Juegos Principales -->
<div class="grid gap-6 md:grid-cols-2 mb-8">
    @foreach($juegos as $juego)
    @if($juego->slug === 'loteria-nacional')
        @continue
    @endif
    @php
    $color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'border' => 'border-gray-500', 'text' => 'text-gray-500', 'ball' => 'bg-gray-600'];
    @endphp
    <div class="rounded-xl bg-white shadow-lg overflow-hidden border-t-4 {{ $color['border'] }}">
        <div class="{{ $color['bg'] }} px-6 py-4">
            <h2 class="text-xl font-bold text-white">{{ $juego->nombre }}</h2>
            @if($juego->ultimoSorteo)
                <div class="text-sm text-white/80 mt-1">
                    Último sorteo: {{ $juego->ultimoSorteo->fecha->format('d/m/Y') }}
                </div>
            @endif
        </div>
        
        <div class="p-6">
            @if($juego->ultimoSorteo)
                <div class="flex flex-wrap justify-center gap-2 mb-4">
                    @foreach($juego->ultimoSorteo->numeros as $key => $valor)
                        @if($valor !== null && $valor !== '')
                            @if($juego->slug === 'euromillones' && $key >= 5)
                                <span class="ball w-11 h-11 {{ $color['ball'] }} text-white rounded-full flex items-center justify-center font-bold text-sm" title="Estrella">
                                    {{ $valor }}
                                </span>
                            @else
                                <span class="ball w-11 h-11 bg-slate-400 text-white rounded-full flex items-center justify-center font-bold text-sm" title="{{ ucfirst($key) }}">
                                    {{ $valor }}
                                </span>
                            @endif
                        @endif
                    @endforeach
                </div>

                @if($juego->ultimoSorteo->bote)
                    <div class="text-center mb-4">
                        <span class="text-sm text-gray-500">Bote</span>
                        <p class="text-2xl font-bold text-emerald-600">
                            {{ number_format($juego->ultimoSorteo->bote, 0, ',', '.') }} €
                        </p>
                    </div>
                @endif

                <a href="{{ route('sorteo', [$juego->slug, $juego->ultimoSorteo->fecha->format('Y-m-d')]) }}" 
                   class="block text-center {{ $color['text'] }} font-medium hover:underline">
                    Ver detalles →
                </a>
            @else
                <p class="text-gray-400 italic text-center py-8">Sin sorteos disponibles</p>
            @endif
        </div>
    </div>
    @endforeach
</div>

<!-- Lotería Nacional: Jueves y Sábado -->
@if($loteriaJueves || $loteriaSabado)
<section class="mb-8">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Lotería Nacional</h2>
    <div class="grid gap-4 md:grid-cols-2">
        @if($loteriaJueves)
        @php
            $compJ = $loteriaJueves->complementarios ?? [];
            $primerJ = $compJ['primer_premio'] ?? null;
            $reintegrosJ = $compJ['reintegros'] ?? [];
        @endphp
        <a href="{{ route('loteria.jueves') }}" class="block rounded-xl bg-white shadow-lg overflow-hidden border-t-4 border-amber-600 hover:shadow-xl transition">
            <div class="bg-amber-600 px-6 py-3">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Sorteo del Jueves</h3>
                    <span class="text-sm text-white/80">{{ $loteriaJueves->fecha->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-500">1º Premio</span>
                        @if($primerJ)
                        <div class="text-2xl font-bold text-amber-700 tracking-wider">{{ $primerJ }}</div>
                        @endif
                    </div>
                    @if(!empty($reintegrosJ))
                    <div class="text-right">
                        <span class="text-xs text-slate-500">Reintegros</span>
                        <div class="flex gap-1 mt-1">
                            @foreach($reintegrosJ as $r)
                            <span class="w-7 h-7 bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold text-xs">{{ $r }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mt-3 text-amber-600 text-sm font-medium">Ver todos los jueves →</div>
            </div>
        </a>
        @endif

        @if($loteriaSabado)
        @php
            $compS = $loteriaSabado->complementarios ?? [];
            $primerS = $compS['primer_premio'] ?? null;
            $reintegrosS = $compS['reintegros'] ?? [];
        @endphp
        <a href="{{ route('loteria.sabado') }}" class="block rounded-xl bg-white shadow-lg overflow-hidden border-t-4 border-amber-700 hover:shadow-xl transition">
            <div class="bg-amber-700 px-6 py-3">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Sorteo del Sábado</h3>
                    <span class="text-sm text-white/80">{{ $loteriaSabado->fecha->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-500">1º Premio</span>
                        @if($primerS)
                        <div class="text-2xl font-bold text-amber-800 tracking-wider">{{ $primerS }}</div>
                        @endif
                    </div>
                    @if(!empty($reintegrosS))
                    <div class="text-right">
                        <span class="text-xs text-slate-500">Reintegros</span>
                        <div class="flex gap-1 mt-1">
                            @foreach($reintegrosS as $r)
                            <span class="w-7 h-7 bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold text-xs">{{ $r }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mt-3 text-amber-700 text-sm font-medium">Ver todos los sábados →</div>
            </div>
        </a>
        @endif
    </div>
</section>
@endif

<!-- Sección Educativa -->
<section class="mt-12">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Guías por Juego</h2>

    <div class="grid gap-6 md:grid-cols-2">
        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-euro-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Euromillones</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="{{ route('juego.guia', 'euromillones') }}" class="text-blue-600 hover:underline">Como se juega a Euromillones</a></li>
                <li><a href="{{ route('juego.guia', 'euromillones') }}" class="text-blue-600 hover:underline">Premios y probabilidades de Euromillones</a></li>
                <li><a href="{{ route('juego.guia', 'euromillones') }}" class="text-blue-600 hover:underline">Que son las estrellas en Euromillones</a></li>
                <li><a href="{{ route('juego', 'euromillones') }}" class="text-blue-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>

        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-bono-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Bonoloto</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="{{ route('juego.guia', 'bonoloto') }}" class="text-red-600 hover:underline">Como se juega a Bonoloto</a></li>
                <li><a href="{{ route('juego.guia', 'bonoloto') }}" class="text-red-600 hover:underline">Premios y probabilidades de Bonoloto</a></li>
                <li><a href="{{ route('juego.guia', 'bonoloto') }}" class="text-red-600 hover:underline">Reintegro y complementario en Bonoloto</a></li>
                <li><a href="{{ route('juego', 'bonoloto') }}" class="text-red-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>

        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-primi-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">La Primitiva</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="{{ route('juego.guia', 'la-primitiva') }}" class="text-emerald-600 hover:underline">Como se juega a La Primitiva</a></li>
                <li><a href="{{ route('juego.guia', 'la-primitiva') }}" class="text-emerald-600 hover:underline">Premios y probabilidades de La Primitiva</a></li>
                <li><a href="{{ route('juego.guia', 'la-primitiva') }}" class="text-emerald-600 hover:underline">Reintegro y complementario en La Primitiva</a></li>
                <li><a href="{{ route('juego', 'la-primitiva') }}" class="text-emerald-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>

        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-gordo-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">El Gordo de la Primitiva</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="{{ route('juego.guia', 'el-gordo') }}" class="text-purple-600 hover:underline">Como se juega a El Gordo de la Primitiva</a></li>
                <li><a href="{{ route('juego.guia', 'el-gordo') }}" class="text-purple-600 hover:underline">Premios y probabilidades de El Gordo</a></li>
                <li><a href="{{ route('juego.guia', 'el-gordo') }}" class="text-purple-600 hover:underline">Como funciona el Numero Clave</a></li>
                <li><a href="{{ route('juego', 'el-gordo') }}" class="text-purple-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>

        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-dream-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Eurodreams</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="{{ route('juego.guia', 'eurodreams') }}" class="text-cyan-600 hover:underline">Como se juega a Eurodreams</a></li>
                <li><a href="{{ route('juego.guia', 'eurodreams') }}" class="text-cyan-600 hover:underline">Premios y probabilidades de Eurodreams</a></li>
                <li><a href="{{ route('juego.guia', 'eurodreams') }}" class="text-cyan-600 hover:underline">Que es el Numero Dream</a></li>
                <li><a href="{{ route('juego', 'eurodreams') }}" class="text-cyan-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>

        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-loteria-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Loteria Nacional</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="{{ route('juego.guia', 'loteria-nacional') }}" class="text-amber-700 hover:underline">Como se juega a Loteria Nacional</a></li>
                <li><a href="{{ route('juego.guia', 'loteria-nacional') }}" class="text-amber-700 hover:underline">Premios y probabilidades de Loteria Nacional</a></li>
                <li><a href="{{ route('juego.guia', 'loteria-nacional') }}" class="text-amber-700 hover:underline">Sorteos de Loteria Nacional Jueves y Sabado</a></li>
                <li><a href="{{ route('juego', 'loteria-nacional') }}" class="text-amber-700 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>
    </div>
</section>

<!-- Enlaces internos estratégicos -->
<div class="bg-gradient-to-r from-slate-50 to-blue-50 rounded-xl p-6 border border-slate-200">
    <h3 class="text-lg font-bold text-slate-800 mb-3">Explora por Juego</h3>
    <div class="grid gap-3 md:grid-cols-2">
        <a href="{{ route('juego', 'euromillones') }}" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-blue-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">Euromillones</div>
                <div class="text-sm text-slate-600">Resultados y guía completa</div>
            </div>
        </a>
        <a href="{{ route('juego', 'bonoloto') }}" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-red-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">Bonoloto</div>
                <div class="text-sm text-slate-600">Sorteos diarios y premios</div>
            </div>
        </a>
        <a href="{{ route('juego', 'la-primitiva') }}" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-emerald-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">La Primitiva</div>
                <div class="text-sm text-slate-600">Historial y jackpots</div>
            </div>
        </a>
        <a href="{{ route('juego', 'el-gordo') }}" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-purple-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">El Gordo</div>
                <div class="text-sm text-slate-600">Números clave y premios</div>
            </div>
        </a>
        <a href="{{ route('juego', 'eurodreams') }}" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-cyan-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">Eurodreams</div>
                <div class="text-sm text-slate-600">Premios mensuales de por vida</div>
            </div>
        </a>
        <a href="{{ route('juego', 'loteria-nacional') }}" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-amber-700 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">Loteria Nacional</div>
                <div class="text-sm text-slate-600">Sorteos Jueves y Sabado</div>
            </div>
        </a>
    </div>
</div>
@endsection
