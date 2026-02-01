@extends('layouts.app')

@section('title')
Resultado {{ $juego->nombre }} {{ $sorteo->fecha->format('d M Y') }} | Números y Premios
@endsection

@section('description')
Resultado del sorteo de {{ $juego->nombre }} del {{ $sorteo->fecha->format('d/m/Y') }}. Números ganadores, acertantes y premios.
@endsection

@php
$caduca = $sorteo->fecha->copy()->addMonthsNoOverflow(3);
$diasCad = now()->startOfDay()->diffInDays($caduca->copy()->startOfDay(), false);

$numsText = implode(', ', $sorteo->numeros ?? []);
$compText = '';
if (!empty($sorteo->complementarios)) {
    $parts = [];
    foreach (($sorteo->complementarios ?? []) as $k => $v) {
        if (is_array($v)) {
            $parts[] = ucfirst((string)$k) . ': ' . implode(', ', $v);
        } else {
            $parts[] = ucfirst((string)$k) . ': ' . $v;
        }
    }
    if (!empty($parts)) {
        $compText = ' (' . implode(' | ', $parts) . ')';
    }
}

$faqSorteo = [
    [
        '@type' => 'Question',
        'name' => "¿Cuál fue la combinación ganadora de {$juego->nombre} el {$sorteo->fecha->format('d/m/Y')}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $numsText ? ("La combinación ganadora fue: {$numsText}{$compText}.") : 'Consulta la combinación ganadora en esta página.',
        ],
    ],
    [
        '@type' => 'Question',
        'name' => "¿Cuándo caducan los premios de {$juego->nombre} de este sorteo?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => "Por norma general, los premios caducan a los 3 meses desde la fecha del sorteo. Para este sorteo, la fecha de caducidad es {$caduca->format('d/m/Y')}.",
        ],
    ],
    [
        '@type' => 'Question',
        'name' => '¿Por qué algunos premios aparecen como pendientes?',
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Si el reparto de premios aún no está publicado, el importe puede aparecer como pendiente hasta que la fuente lo actualice.',
        ],
    ],
];

$faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqSorteo,
];
@endphp

@push('head')
<script type="application/ld+json">@json($faqSchema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)</script>
@endpush

@php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'ball' => 'bg-blue-600', 'text' => 'text-euro-500'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'ball' => 'bg-red-600', 'text' => 'text-bono-500'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'ball' => 'bg-emerald-600', 'text' => 'text-primi-500'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'ball' => 'bg-purple-600', 'text' => 'text-gordo-500'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'ball' => 'bg-gray-600', 'text' => 'text-gray-500'];
@endphp

@section('content')
<div class="{{ $color['bg'] }} -mx-4 -mt-8 px-4 py-8 mb-8 text-white">
    <div class="container mx-auto">
        <nav class="text-sm text-white/60 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Inicio</a>
            <span class="mx-2">›</span>
            <a href="{{ route('juego', $juego->slug) }}" class="hover:text-white">{{ $juego->nombre }}</a>
            <span class="mx-2">›</span>
            <span class="text-white">{{ $sorteo->fecha->format('d/m/Y') }}</span>
        </nav>
        <h1 class="text-3xl font-bold mb-1">{{ $juego->nombre }}</h1>
        <p class="text-white/80 text-lg capitalize">{{ $sorteo->fecha->translatedFormat('l, d \d\e F \d\e Y') }}</p>
        <p class="text-white/70 mt-2">
            Resultado de {{ $juego->nombre }} hoy: último sorteo disponible del {{ $sorteo->fecha->format('d/m/Y') }}. Consulta combinación ganadora, premios y acertantes.
        </p>
        <p class="text-white/70 mt-1 text-sm">
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
</div>

<div class="bg-white rounded-xl shadow-lg p-8 mb-6">
    <h2 class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-4">Combinación Ganadora</h2>
    
    <div class="flex flex-wrap gap-3 mb-6 justify-center">
        @foreach($sorteo->numeros as $numero)
            <span class="ball w-14 h-14 {{ $color['ball'] }} text-white rounded-full flex items-center justify-center font-bold text-xl">
                {{ $numero }}
            </span>
        @endforeach
        
        @if($sorteo->complementarios)
            <span class="flex items-center text-gray-300 mx-2 text-2xl">+</span>
            @foreach($sorteo->complementarios as $key => $valor)
                @if(is_array($valor))
                    @foreach($valor as $v)
                        <span class="ball w-14 h-14 bg-amber-500 text-white rounded-full flex items-center justify-center font-bold text-xl" title="{{ ucfirst($key) }}">
                            {{ $v }}
                        </span>
                    @endforeach
                @else
                    <span class="ball w-14 h-14 bg-slate-400 text-white rounded-full flex items-center justify-center font-bold text-lg" title="{{ ucfirst($key) }}">
                        {{ $valor }}
                    </span>
                @endif
            @endforeach
        @endif
    </div>
    
    @if($sorteo->complementarios)
        <div class="flex flex-wrap gap-4 justify-center text-sm text-slate-500">
            @foreach($sorteo->complementarios as $key => $valor)
                <span>
                    <strong class="capitalize">{{ $key }}:</strong>
                    @if(is_array($valor))
                        {{ implode(', ', $valor) }}
                    @else
                        {{ $valor }}
                    @endif
                </span>
            @endforeach
        </div>
    @endif
</div>

@if($sorteo->bote)
<div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 mb-6 text-white text-center">
    <p class="text-sm uppercase tracking-wide opacity-80 mb-1">Bote</p>
    <p class="text-4xl font-bold">{{ number_format($sorteo->bote, 0, ',', '.') }} €</p>
</div>
@endif

@if($sorteo->premios && count($sorteo->premios) > 0)
<div class="bg-white rounded-xl shadow-lg p-6 mb-6 overflow-hidden">
    <h2 class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-4">Tabla de Premios</h2>
    
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[400px]">
            <thead class="{{ $color['bg'] }} text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes</th>
                    <th class="px-6 py-3 font-medium text-right">Premio</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sorteo->premios as $premio)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700">{{ $premio['categoria'] ?? '-' }}</td>
                    <td class="px-6 py-3 text-right text-slate-600">{{ number_format($premio['acertantes'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        @if(array_key_exists('premio', $premio) && $premio['premio'] === null)
                            <span class="text-slate-500">Pendiente</span>
                        @else
                            {{ number_format($premio['premio'] ?? 0, 2, ',', '.') }} €
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if($sorteo->localidades && count($sorteo->localidades) > 0)
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h2 class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-4">Localidades Premiadas</h2>
    <ul class="space-y-2 text-slate-600">
        @foreach($sorteo->localidades as $localidad)
            <li class="flex items-center gap-2">
                <span class="w-2 h-2 {{ $color['ball'] }} rounded-full"></span>
                {{ $localidad }}
            </li>
        @endforeach
    </ul>
</div>
@endif

<div class="mt-8">
    <a href="{{ route('juego', $juego->slug) }}" class="{{ $color['text'] }} font-medium hover:underline inline-flex items-center gap-1">
        <span>←</span> Volver a {{ $juego->nombre }}
    </a>
</div>

<section class="mt-10 bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes sobre el sorteo</h2>

    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuál fue la combinación ganadora de {{ $juego->nombre }} el {{ $sorteo->fecha->format('d/m/Y') }}?</summary>
            <div class="mt-2 text-slate-600">
                @if(!empty($numsText))
                    La combinación ganadora fue: {{ $numsText }}{{ $compText }}.
                @else
                    Consulta la combinación ganadora en esta página.
                @endif
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuándo caducan los premios de {{ $juego->nombre }} de este sorteo?</summary>
            <div class="mt-2 text-slate-600">
                Por norma general, los premios caducan a los 3 meses desde la fecha del sorteo. Para este sorteo, la fecha de caducidad es {{ $caduca->format('d/m/Y') }}.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Por qué algunos premios aparecen como pendientes?</summary>
            <div class="mt-2 text-slate-600">
                Si el reparto de premios aún no está publicado, el importe puede aparecer como pendiente hasta que la fuente lo actualice.
            </div>
        </details>
    </div>
</section>
@endsection
