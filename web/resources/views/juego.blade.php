@extends('layouts.app')

@section('title')
Resultados {{ $juego->nombre }} Hoy | Último Sorteo y Premios
@endsection

@section('description')
Consulta los últimos resultados de {{ $juego->nombre }}. Números ganadores, premios y histórico de sorteos.
@endsection

@php
$latestSorteo = $sorteos->first();
$latestFechaHuman = $latestSorteo ? $latestSorteo->fecha->format('d/m/Y') : null;

$faqJuego = [
    [
        '@type' => 'Question',
        'name' => "¿Cuál es el último sorteo de {$juego->nombre}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $latestSorteo
                ? "El último sorteo disponible de {$juego->nombre} es el {$latestFechaHuman}."
                : "Aún no hay sorteos disponibles para {$juego->nombre}.",
        ],
    ],
    [
        '@type' => 'Question',
        'name' => "¿Qué días se sortea {$juego->nombre}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Días de sorteo: ' . str_replace(',', ', ', $juego->dias_sorteo) . '.',
        ],
    ],
    [
        '@type' => 'Question',
        'name' => "¿Cuándo caducan los premios de {$juego->nombre}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => "Por norma general, los premios caducan a los 3 meses desde la fecha del sorteo. En cada sorteo mostramos la fecha de caducidad y cuánto falta.",
        ],
    ],
];

$faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqJuego,
];
@endphp

@push('head')
<script type="application/ld+json">@json($faqSchema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)</script>
@endpush

@php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'ball' => 'bg-blue-600'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'ball' => 'bg-red-600'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'ball' => 'bg-emerald-600'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'ball' => 'bg-purple-600'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'ball' => 'bg-gray-600'];
@endphp

@section('content')
<div class="{{ $color['bg'] }} -mx-4 -mt-8 px-4 py-8 mb-8 text-white">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-2">Últimos resultados de {{ $juego->nombre }}</h1>
        <p class="text-white/70">Sorteos: {{ str_replace(',', ', ', $juego->dias_sorteo) }}</p>
        <p class="text-white/70 mt-2">
            @if($latestSorteo)
                Último sorteo disponible {{ $latestFechaHuman }}. Consulta números ganadores, premios y el histórico por fechas.
            @else
                Consulta el histórico por fechas cuando estén disponibles los sorteos.
            @endif
        </p>
    </div>
</div>

@if($sorteos->count() > 0)
    <div class="container mx-auto mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Historial de sorteos</h2>
    </div>
    <div class="space-y-3">
        @foreach($sorteos as $sorteo)
        <a href="{{ route('sorteo', [$juego->slug, $sorteo->fecha->format('Y-m-d')]) }}" 
           class="block bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition border-l-4 {{ str_replace('bg-', 'border-', $color['ball']) }}">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="min-w-[120px]">
                    <p class="font-bold text-slate-800">{{ $sorteo->fecha->format('d/m/Y') }}</p>
                    <p class="text-sm text-slate-500 capitalize">{{ $sorteo->fecha->translatedFormat('l') }}</p>
                    @php
                        $caduca = $sorteo->fecha->copy()->addMonthsNoOverflow(3);
                        $diasCad = now()->startOfDay()->diffInDays($caduca->copy()->startOfDay(), false);
                    @endphp
                    <p class="text-xs text-slate-500 mt-1">
                        @if($diasCad > 1)
                            Caduca en {{ $diasCad }} días ({{ $caduca->format('d/m/Y') }})
                        @elseif($diasCad === 1)
                            Caduca en 1 día ({{ $caduca->format('d/m/Y') }})
                        @elseif($diasCad === 0)
                            Caduca hoy ({{ $caduca->format('d/m/Y') }})
                        @else
                            Caducado ({{ $caduca->format('d/m/Y') }})
                        @endif
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-1.5 flex-1 justify-center">
                    @foreach($sorteo->numeros as $numero)
                        <span class="ball w-9 h-9 {{ $color['ball'] }} text-white rounded-full flex items-center justify-center font-bold text-sm">
                            {{ $numero }}
                        </span>
                    @endforeach
                    
                    @if($sorteo->complementarios)
                        <span class="text-gray-300 mx-1">+</span>
                        @foreach($sorteo->complementarios as $key => $valor)
                            @if(is_array($valor))
                                @foreach($valor as $v)
                                    <span class="ball w-9 h-9 bg-amber-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                        {{ $v }}
                                    </span>
                                @endforeach
                            @else
                                <span class="ball w-9 h-9 bg-slate-400 text-white rounded-full flex items-center justify-center font-bold text-xs">
                                    {{ $valor }}
                                </span>
                            @endif
                        @endforeach
                    @endif
                </div>
                
                @if($sorteo->bote)
                    <p class="text-emerald-600 font-bold text-right min-w-[100px]">
                        {{ number_format($sorteo->bote, 0, ',', '.') }} €
                    </p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    
    <div class="mt-8">
        {{ $sorteos->links() }}
    </div>
@else
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <p class="text-gray-400 italic">No hay sorteos disponibles todavía.</p>
    </div>
@endif

<section class="mt-10 bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes sobre {{ $juego->nombre }}</h2>

    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuál es el último sorteo de {{ $juego->nombre }}?</summary>
            <div class="mt-2 text-slate-600">
                @if($latestSorteo)
                    El último sorteo disponible de {{ $juego->nombre }} es el {{ $latestFechaHuman }}.
                @else
                    Aún no hay sorteos disponibles para {{ $juego->nombre }}.
                @endif
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué días se sortea {{ $juego->nombre }}?</summary>
            <div class="mt-2 text-slate-600">
                Días de sorteo: {{ str_replace(',', ', ', $juego->dias_sorteo) }}.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuándo caducan los premios de {{ $juego->nombre }}?</summary>
            <div class="mt-2 text-slate-600">
                Por norma general, los premios caducan a los 3 meses desde la fecha del sorteo. En cada sorteo mostramos la fecha de caducidad y cuánto falta.
            </div>
        </details>
    </div>
</section>
@endsection
