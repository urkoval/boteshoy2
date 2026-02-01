@extends('layouts.app')

@section('title', 'Resultados Loterías España Hoy')
@section('description', 'Consulta los últimos resultados de Euromillones, Bonoloto, La Primitiva y El Gordo de la Primitiva. Números ganadores y premios actualizados.')

@php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'border' => 'border-euro-500', 'text' => 'text-euro-500', 'ball' => 'bg-blue-600'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'border' => 'border-bono-500', 'text' => 'text-bono-500', 'ball' => 'bg-red-600'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'border' => 'border-primi-500', 'text' => 'text-primi-500', 'ball' => 'bg-emerald-600'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'border' => 'border-gordo-500', 'text' => 'text-gordo-500', 'ball' => 'bg-purple-600'],
];
@endphp

@section('content')
@if(!empty($boteDestacado))
<section class="mb-8">
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-6 py-5 text-white">
            <div class="text-xs text-white/70">Bote destacado</div>
            <div class="mt-1 flex items-end justify-between gap-4">
                <div>
                    <div class="text-2xl font-extrabold">{{ $boteDestacado['nombre'] }}</div>
                    <div class="text-sm text-white/80">Próximo sorteo: {{ $boteDestacado['fecha_sorteo'] }}</div>
                </div>
                <div class="text-right">
                    <div class="text-3xl md:text-4xl font-extrabold">{{ number_format($boteDestacado['bote_eur'], 0, ',', '.') }} €</div>
                </div>
            </div>
        </div>

        @if(!empty($botesHeader))
        <div class="p-6">
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($botesHeader as $b)
                    <article class="rounded-xl border border-slate-200 p-5">
                        <div class="flex items-center justify-between">
                            <div class="font-bold text-slate-800">{{ $b['nombre'] }}</div>
                            <div class="text-sm md:text-base font-extrabold {{ $b['classes']['text'] }}">{{ number_format($b['bote_eur'], 0, ',', '.') }} €</div>
                        </div>
                        <div class="text-xs text-slate-500 mt-1">Próximo sorteo: {{ $b['fecha_sorteo'] }}</div>
                    </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endif

<h1 class="text-3xl font-bold text-slate-800 mb-8">Últimos Resultados</h1>

<div class="grid gap-6 md:grid-cols-2">
    @foreach($juegos as $juego)
    @php $color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'border' => 'border-gray-500', 'text' => 'text-gray-500', 'ball' => 'bg-gray-600']; @endphp
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
        <div class="{{ $color['bg'] }} px-6 py-4">
            <h2 class="text-xl font-bold text-white">
                <a href="{{ route('juego', $juego->slug) }}" class="hover:opacity-90">
                    {{ $juego->nombre }}
                </a>
            </h2>
            @if($juego->ultimoSorteo)
                <p class="text-white/70 text-sm">{{ $juego->ultimoSorteo->fecha->translatedFormat('l, d M Y') }}</p>
            @endif
        </div>
        
        <div class="p-6">
            @if($juego->ultimoSorteo)
                <div class="flex flex-wrap gap-2 mb-4 justify-center">
                    @foreach($juego->ultimoSorteo->numeros as $numero)
                        <span class="ball w-11 h-11 {{ $color['ball'] }} text-white rounded-full flex items-center justify-center font-bold text-lg">
                            {{ $numero }}
                        </span>
                    @endforeach
                    
                    @if($juego->ultimoSorteo->complementarios)
                        <span class="flex items-center text-gray-400 mx-1">+</span>
                        @foreach($juego->ultimoSorteo->complementarios as $key => $valor)
                            @if(is_array($valor))
                                @foreach($valor as $v)
                                    <span class="ball w-11 h-11 bg-amber-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                        {{ $v }}
                                    </span>
                                @endforeach
                            @else
                                <span class="ball w-11 h-11 bg-slate-400 text-white rounded-full flex items-center justify-center font-bold text-sm" title="{{ ucfirst($key) }}">
                                    {{ $valor }}
                                </span>
                            @endif
                        @endforeach
                    @endif
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
@endsection
