@extends('layouts.app')

@section('title')
Resultado Lotería Nacional {{ $sorteo->fecha->format('d M Y') }} | Números y Premios
@endsection

@section('description')
Resultado del sorteo de Lotería Nacional del {{ $sorteo->fecha->format('d/m/Y') }}. Primer premio, segundo premio, terminaciones y reintegros.
@endsection

@php
$caduca = $sorteo->fecha->copy()->addMonthsNoOverflow(3);
$diasCad = now()->startOfDay()->diffInDays($caduca->copy()->startOfDay(), false);

$comp = $sorteo->complementarios ?? [];
$primerPremio = $comp['primer_premio'] ?? null;
$primerPremioEuros = $comp['primer_premio_euros'] ?? null;
$segundoPremio = $comp['segundo_premio'] ?? null;
$segundoPremioEuros = $comp['segundo_premio_euros'] ?? null;
$reintegros = $comp['reintegros'] ?? [];
$reintegroEuros = $comp['reintegro_euros'] ?? null;
$terminaciones = $comp['terminaciones'] ?? [];

// Agrupar terminaciones por última cifra
$terminacionesPorCifra = [];
foreach ($terminaciones as $t) {
    $ultimaCifra = substr($t['cifras'], -1);
    if (!isset($terminacionesPorCifra[$ultimaCifra])) {
        $terminacionesPorCifra[$ultimaCifra] = [];
    }
    $terminacionesPorCifra[$ultimaCifra][] = $t;
}
// Ordenar por última cifra
ksort($terminacionesPorCifra);

$faqSorteo = [
    [
        '@type' => 'Question',
        'name' => "¿Cuál fue el primer premio de Lotería Nacional el {$sorteo->fecha->format('d/m/Y')}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $primerPremio ? "El primer premio fue el número {$primerPremio}." : 'Consulta el primer premio en esta página.',
        ],
    ],
    [
        '@type' => 'Question',
        'name' => "¿Cuáles son los reintegros de Lotería Nacional de este sorteo?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => !empty($reintegros) ? "Los reintegros son: " . implode(', ', $reintegros) . "." : 'Consulta los reintegros en esta página.',
        ],
    ],
    [
        '@type' => 'Question',
        'name' => '¿Cuándo caducan los premios de este sorteo?',
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => "Los premios caducan a los 3 meses desde la fecha del sorteo. Para este sorteo, la fecha de caducidad es {$caduca->format('d/m/Y')}.",
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

@section('content')
<div class="bg-loteria-500 -mx-4 -mt-8 px-4 py-8 mb-8 text-white">
    <div class="container mx-auto">
        <nav class="text-sm text-white/60 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Inicio</a>
            <span class="mx-2">›</span>
            <a href="{{ route('juego', $juego->slug) }}" class="hover:text-white">{{ $juego->nombre }}</a>
            <span class="mx-2">›</span>
            <span class="text-white">{{ $sorteo->fecha->format('d/m/Y') }}</span>
        </nav>
        <div class="text-3xl font-bold mb-1">{{ $juego->nombre }}</div>
        <h1 class="text-white/80 text-lg capitalize">Resultados del {{ $sorteo->fecha->translatedFormat('l, d \d\e F \d\e Y') }}</h1>
        <p class="text-white/70 mt-2">
            Primer premio, segundo premio, terminaciones premiadas y reintegros del sorteo de Lotería Nacional.
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

<!-- Selector de calendario -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <label for="fecha-selector" class="text-sm font-medium text-slate-700">Ver resultados de otra fecha:</label>
            <div class="flex items-center gap-2">
                <input 
                    type="date" 
                    id="fecha-selector" 
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm"
                    value="{{ $sorteo->fecha->format('Y-m-d') }}"
                    min="{{ $sorteo->fecha->copy()->subYears(2)->format('Y-m-d') }}"
                    max="{{ now()->format('Y-m-d') }}"
                >
                <button 
                    onclick="verResultadosFecha()" 
                    class="px-4 py-2 bg-loteria-500 text-white rounded-lg hover:bg-loteria-600 transition-colors text-sm font-medium whitespace-nowrap"
                >
                    Ver resultados
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const fechasDisponibles = @json($fechasDisponibles);

function verResultadosFecha() {
    const fechaSeleccionada = document.getElementById('fecha-selector').value;
    if (!fechaSeleccionada) {
        alert('Por favor, selecciona una fecha');
        return;
    }
    
    if (!fechasDisponibles.includes(fechaSeleccionada)) {
        alert('No hay resultados disponibles para la fecha seleccionada. Por favor, elige otra fecha.');
        return;
    }
    
    window.location.href = `{{ route('juego', $juego->slug) }}/${fechaSeleccionada}`;
}

document.getElementById('fecha-selector').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        verResultadosFecha();
    }
});
</script>

<!-- Premios Principales -->
<div class="bg-white rounded-xl shadow-lg p-8 mb-6">
    <h2 class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-6">Premios Principales</h2>
    
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Primer Premio -->
        @if($primerPremio)
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border-2 border-amber-400">
            <div class="text-center">
                <span class="text-sm font-medium text-amber-700 uppercase tracking-wide">Primer Premio</span>
                <div class="mt-3">
                    <span class="text-5xl font-bold text-amber-800 tracking-widest">{{ $primerPremio }}</span>
                </div>
                @if($primerPremioEuros)
                <div class="mt-3 text-lg font-semibold text-amber-700">
                    {{ number_format($primerPremioEuros, 2, ',', '.') }} € / billete
                </div>
                @endif
            </div>
        </div>
        @endif
        
        <!-- Segundo Premio -->
        @if($segundoPremio)
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-6 border-2 border-slate-300">
            <div class="text-center">
                <span class="text-sm font-medium text-slate-600 uppercase tracking-wide">Segundo Premio</span>
                <div class="mt-3">
                    <span class="text-5xl font-bold text-slate-700 tracking-widest">{{ $segundoPremio }}</span>
                </div>
                @if($segundoPremioEuros)
                <div class="mt-3 text-lg font-semibold text-slate-600">
                    {{ number_format($segundoPremioEuros, 2, ',', '.') }} € / billete
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    
    <!-- Reintegros -->
    @if(!empty($reintegros))
    <div class="mt-6 pt-6 border-t border-slate-200">
        <div class="text-center">
            <span class="text-sm font-medium text-slate-500 uppercase tracking-wide">Reintegros</span>
            <div class="mt-3 flex justify-center gap-3">
                @foreach($reintegros as $r)
                <span class="w-12 h-12 bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold text-xl">
                    {{ $r }}
                </span>
                @endforeach
            </div>
            @if($reintegroEuros)
            <div class="mt-2 text-sm text-slate-600">
                {{ number_format($reintegroEuros, 2, ',', '.') }} € / décimo
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Terminaciones Premiadas -->
@if(!empty($terminacionesPorCifra))
<div class="bg-white rounded-xl shadow-lg p-8 mb-6">
    <h2 class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-6">Terminaciones Premiadas</h2>
    
    <div class="grid grid-cols-2 sm:grid-cols-5 md:grid-cols-10 gap-4">
        @foreach(range(0, 9) as $cifra)
        <div class="bg-slate-50 rounded-lg p-3">
            <div class="text-center font-bold text-lg text-slate-700 border-b border-slate-200 pb-2 mb-2">
                {{ $cifra }}
            </div>
            @if(isset($terminacionesPorCifra[$cifra]))
                <div class="space-y-1 text-sm">
                    @foreach($terminacionesPorCifra[$cifra] as $t)
                    <div class="flex justify-between items-center">
                        <span class="font-mono font-medium text-slate-800">{{ $t['cifras'] }}</span>
                        <span class="text-emerald-600 font-semibold">{{ number_format($t['premio'], 0, ',', '.') }}€</span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-xs text-slate-400 text-center">-</div>
            @endif
        </div>
        @endforeach
    </div>
    
    <p class="mt-4 text-xs text-slate-500 text-center">
        Los premios mostrados son por billete completo. Un décimo recibe 1/10 del premio.
    </p>
</div>
@endif

<!-- Cómo comprobar tu décimo -->
<div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 mb-6 border border-amber-200">
    <h3 class="text-lg font-bold text-slate-800 mb-3">¿Cómo comprobar si tu décimo tiene premio?</h3>
    <div class="text-slate-600 space-y-2">
        <p><strong>1. Primer y Segundo Premio:</strong> Tu número debe coincidir exactamente con el número premiado.</p>
        <p><strong>2. Terminaciones:</strong> Si las últimas cifras de tu número coinciden con alguna terminación premiada, tienes premio.</p>
        <p><strong>3. Reintegros:</strong> Si la última cifra de tu número coincide con algún reintegro, recuperas el importe del décimo.</p>
    </div>
</div>

<!-- FAQs -->
<section class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes</h2>

    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué es un décimo de Lotería Nacional?</summary>
            <div class="mt-2 text-slate-600">
                Un décimo es una fracción de un billete completo. Cada billete se divide en 10 décimos, por lo que si tu décimo resulta premiado, recibes 1/10 del premio total del billete.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué son las terminaciones?</summary>
            <div class="mt-2 text-slate-600">
                Las terminaciones son las últimas cifras del número premiado. Si tu décimo termina en las mismas cifras que una terminación premiada, tienes derecho a ese premio. Por ejemplo, si la terminación "03" está premiada y tu número es 45203, tienes premio.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cómo funcionan los reintegros?</summary>
            <div class="mt-2 text-slate-600">
                Si la última cifra de tu número coincide con alguno de los reintegros, recuperas el importe que pagaste por el décimo. Es la forma más común de obtener premio en Lotería Nacional.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuándo caducan los premios?</summary>
            <div class="mt-2 text-slate-600">
                Los premios de Lotería Nacional caducan a los 3 meses desde la fecha del sorteo. Para este sorteo, la fecha límite para cobrar es el {{ $caduca->format('d/m/Y') }}.
            </div>
        </details>
    </div>
</section>

@endsection
