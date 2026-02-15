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

<!-- CTA a Guía -->
<div class="mt-8 bg-gradient-to-r from-slate-50 to-blue-50 rounded-xl p-6 border border-slate-200">
    <h3 class="text-lg font-bold text-slate-800 mb-2">¿No sabes cómo jugar a {{ $juego->nombre }}?</h3>
    <p class="text-slate-600 mb-4">Aprende las reglas, premios, probabilidades y todo lo que necesitas saber.</p>
    <a href="{{ route('juego.guia', $juego->slug) }}" class="{{ $color['bg'] }} text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 inline-block">
        Ver guía completa de {{ $juego->nombre }} →
    </a>
</div>

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

        @switch($juego->slug)
            @case('euromillones')
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué son las estrellas en Euromillones?</summary>
                    <div class="mt-2 text-slate-600">
                        Las estrellas son 2 números adicionales (del 1 al 12) que debes acertar además de los 5 números principales para ganar el premio mayor. También dan acceso a categorías de premios intermedias.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto cuesta jugar a Euromillones?</summary>
                    <div class="mt-2 text-slate-600">
                        Cada apuesta simple de Euromillones cuesta 2,50€. Puedes hacer múltiples apuestas y combinaciones aumentando el coste proporcionalmente.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué impuestos se aplican a los premios de Euromillones?</summary>
                    <div class="mt-2 text-slate-600">
                        En España, los premios hasta 20.000€ están exentos de impuestos. A partir de esa cantidad, se aplica un 20% de retención en la fuente.
                    </div>
                </details>
                @break

            @case('bonoloto')
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué es el reintegro en Bonoloto?</summary>
                    <div class="mt-2 text-slate-600">
                        El reintegro es un número del 0 al 9 que, si aciertas, te devuelve el importe de tu apuesta. Es una forma de recuperar tu inversión aunque no ganes otros premios.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto cuesta jugar a Bonoloto?</summary>
                    <div class="mt-2 text-slate-600">
                        La apuesta mínima de Bonoloto cuesta 0,50€. El reintegro añade 0,50€ adicionales, haciendo un total de 1€ por apuesta completa.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Desde qué cantidad hay premios en Bonoloto?</summary>
                    <div class="mt-2 text-slate-600">
                        Con 3 aciertos ya tienes premio (aproximadamente 6€). Los premios aumentan con más aciertos hasta el bote con 6 números acertados.
                    </div>
                </details>
                @break

            @case('la-primitiva')
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué es "El Millón" en La Primitiva?</summary>
                    <div class="mt-2 text-slate-600">
                        "El Millón" es un sorteo adicional que se realiza los jueves con un premio garantizado de 1 millón de euros para un único número de 8 cifras.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cómo funciona el Número Clave en La Primitiva?</summary>
                    <div class="mt-2 text-slate-600">
                        El Número Clave es un número del 0 al 9 que te da acceso a un bote adicional si aciertas los 6 números principales. Solo aplica para la categoría máxima.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuál es la diferencia entre La Primitiva y El Gordo?</summary>
                    <div class="mt-2 text-slate-600">
                        Aunque ambos usan 6 números del 1-49, El Gordo tiene un coste mayor (1,50€ vs 1€), botes más altos (5M€ vs 3M€ mínimo) y se sortea solo los domingos.
                    </div>
                </details>
                @break

            @case('el-gordo')
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Por qué se llama "El Gordo" si es de La Primitiva?</summary>
                    <div class="mt-2 text-slate-600">
                        Aunque es parte de la familia La Primitiva, se llama "El Gordo" porque tradicionalmente ofrece los botes más grandes y atractivos de los sorteos semanales.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿El Número Clave de El Gordo funciona igual que en La Primitiva?</summary>
                    <div class="mt-2 text-slate-600">
                        Sí, funciona igual: es un número del 0 al 9 que da acceso a un bote adicional si aciertas los 6 números principales. La diferencia es que en El Gordo el bote base es mayor.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto cuesta jugar a El Gordo?</summary>
                    <div class="mt-2 text-slate-600">
                        Cada apuesta de El Gordo cuesta 1,50€. Incluye el reintegro que te devuelve el importe completo si aciertas el número del 0 al 9.
                    </div>
                </details>
                @break
        @endswitch

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cómo se reclaman los premios?</summary>
            <div class="mt-2 text-slate-600">
                Premios hasta 2.000€: en administraciones de loterías. Entre 2.000€ y 40.000€: en entidades bancarias colaboradoras. Más de 40.000€: en las oficinas de Loterías y Apuestas del Estado.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Dónde puedo consultar los resultados oficiales?</summary>
            <div class="mt-2 text-slate-600">
                Los resultados oficiales los publica Loterías y Apuestas del Estado en su web y en las administraciones. En esta web mostramos la misma información de forma actualizada.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Puedo jugar online?</summary>
            <div class="mt-2 text-slate-600">
                Sí, puedes jugar online a través de la web oficial de Loterías y Apuestas del Estado o aplicaciones autorizadas. Recuerda jugar siempre en canales oficiales.
            </div>
        </details>
    </div>
</section>
@endsection
