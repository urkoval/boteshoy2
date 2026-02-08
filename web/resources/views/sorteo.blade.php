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
        <div class="text-3xl font-bold mb-1">{{ $juego->nombre }}</div>
        <h1 class="text-white/80 text-lg capitalize">Resultados de {{ $juego->nombre }} del {{ $sorteo->fecha->translatedFormat('l, d \d\e F \d\e Y') }}</h1>
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

<!-- Selector de calendario -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <label for="fecha-selector" class="text-sm font-medium text-slate-700">Ver resultados de otra fecha:</label>
            <input 
                type="date" 
                id="fecha-selector" 
                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                value="{{ $sorteo->fecha->format('Y-m-d') }}"
                min="{{ $sorteo->fecha->copy()->subYears(2)->format('Y-m-d') }}"
                max="{{ now()->format('Y-m-d') }}"
            >
            <button 
                onclick="verResultadosFecha()" 
                class="px-4 py-2 {{ $color['bg'] }} text-white rounded-lg hover:opacity-90 transition-opacity text-sm font-medium"
            >
                Ver resultados
            </button>
        </div>
        <div class="text-xs text-slate-500">
            Fechas disponibles hasta {{ now()->format('d/m/Y') }}
        </div>
    </div>
</div>

<script>
// Fechas disponibles para validación
const fechasDisponibles = @json($fechasDisponibles);

function verResultadosFecha() {
    const fechaSeleccionada = document.getElementById('fecha-selector').value;
    if (!fechaSeleccionada) {
        alert('Por favor, selecciona una fecha');
        return;
    }
    
    // Validar si la fecha tiene resultados disponibles
    if (!fechasDisponibles.includes(fechaSeleccionada)) {
        alert('No hay resultados disponibles para la fecha seleccionada. Por favor, elige una fecha marcada en negrita.');
        return;
    }
    
    // Construir URL para la fecha seleccionada
    const url = `{{ route('juego', $juego->slug) }}/${fechaSeleccionada}`;
    
    // Redirigir a la página de resultados de esa fecha
    window.location.href = url;
}

// Manejar tecla Enter en el input de fecha
document.getElementById('fecha-selector').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        verResultadosFecha();
    }
});

// Marcar fechas disponibles en negrita cuando se abre el calendario
document.getElementById('fecha-selector').addEventListener('focus', function() {
    marcarFechasDisponibles();
});

document.getElementById('fecha-selector').addEventListener('click', function() {
    marcarFechasDisponibles();
});

function marcarFechasDisponibles() {
    // Pequeño retraso para asegurar que el calendario se ha abierto
    setTimeout(() => {
        const calendar = document.querySelector('input[type="date"]');
        
        // Método 1: Intentar con shadow DOM (Chrome/Safari)
        if (calendar && calendar.shadowRoot) {
            const days = calendar.shadowRoot.querySelectorAll('td');
            days.forEach(day => {
                const dayText = day.textContent.trim();
                if (dayText && !isNaN(dayText)) {
                    const currentMonth = calendar.value ? new Date(calendar.value).getMonth() : new Date().getMonth();
                    const currentYear = calendar.value ? new Date(calendar.value).getFullYear() : new Date().getFullYear();
                    
                    // Construir fecha en formato YYYY-MM-DD
                    const fecha = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(dayText).padStart(2, '0')}`;
                    
                    if (fechasDisponibles.includes(fecha)) {
                        // Destacar con recuadro de color verde
                        day.style.backgroundColor = '#10b981';
                        day.style.color = 'white';
                        day.style.borderRadius = '4px';
                        day.style.fontWeight = 'bold';
                        day.style.border = '2px solid #059669';
                    } else {
                        // Días sin resultados
                        day.style.opacity = '0.3';
                        day.style.cursor = 'not-allowed';
                    }
                }
            });
        }
        
        // Método 2: Intentar con WebKit (Chrome antiguo)
        if (calendar && calendar.webkitShadowRoot) {
            const days = calendar.webkitShadowRoot.querySelectorAll('td');
            days.forEach(day => {
                const dayText = day.textContent.trim();
                if (dayText && !isNaN(dayText)) {
                    const currentMonth = calendar.value ? new Date(calendar.value).getMonth() : new Date().getMonth();
                    const currentYear = calendar.value ? new Date(calendar.value).getFullYear() : new Date().getFullYear();
                    
                    const fecha = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(dayText).padStart(2, '0')}`;
                    
                    if (fechasDisponibles.includes(fecha)) {
                        day.style.backgroundColor = '#10b981';
                        day.style.color = 'white';
                        day.style.borderRadius = '4px';
                        day.style.fontWeight = 'bold';
                        day.style.border = '2px solid #059669';
                    } else {
                        day.style.opacity = '0.3';
                        day.style.cursor = 'not-allowed';
                    }
                }
            });
        }
        
        // Método 3: Intentar con pseudo-elementos (Firefox)
        // Esto es más limitado, pero al menos podemos mostrar información
        const style = document.createElement('style');
        style.textContent = `
            input[type="date"]::-webkit-calendar-picker-indicator {
                background: #10b981;
                border-radius: 4px;
                padding: 2px;
                cursor: pointer;
            }
        `;
        
        if (!document.querySelector('style[data-calendar-style]')) {
            style.setAttribute('data-calendar-style', 'true');
            document.head.appendChild(style);
        }
        
        // Método 4: Mostrar ayuda visual adicional
        const helpText = document.createElement('div');
        helpText.className = 'text-xs text-slate-500 mt-2';
        helpText.innerHTML = '💡 <strong>Días disponibles:</strong> ' + 
            fechasDisponibles.slice(-5).map(fecha => {
                const date = new Date(fecha);
                return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
            }).join(', ') + '...';
        
        // Reemplazar ayuda existente si hay
        const existingHelp = document.querySelector('.calendar-help');
        if (existingHelp) {
            existingHelp.replaceWith(helpText);
        } else {
            helpText.className = 'calendar-help text-xs text-slate-500 mt-2';
            document.querySelector('.bg-white.rounded-xl.shadow-lg.p-6.mb-6').appendChild(helpText);
        }
        
    }, 100);
}
</script>

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
    
    @if($juego->slug === 'euromillones')
    <!-- Tabla especial para Euromillones -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[500px]">
            <thead class="{{ $color['bg'] }} text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-center">Aciertos</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes Europa</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes España</th>
                    <th class="px-6 py-3 font-medium text-right">Premio (€)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sorteo->premios as $premio)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700">{{ $premio['categoria'] ?? '-' }}</td>
                    <td class="px-6 py-3 text-center text-slate-600 font-medium">{{ $premio['aciertos'] ?? '-' }}</td>
                    <td class="px-6 py-3 text-right text-slate-600">{{ number_format($premio['acertantes_europa'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right text-slate-600">{{ number_format($premio['acertantes_espana'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        @if(array_key_exists('premio', $premio) && $premio['premio'] === null)
                            <span class="text-slate-500">Pendiente</span>
                        @else
                            {{ number_format($premio['premio'] ?? 0, 2, ',', '.') }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif($juego->slug === 'bonoloto')
    <!-- Tabla especial para Bonoloto con Aciertos como dato fijo -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[450px]">
            <thead class="{{ $color['bg'] }} text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-center">Aciertos</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes</th>
                    <th class="px-6 py-3 font-medium text-right">Premio (€)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    // Aciertos fijos para Bonoloto según categoría (compatible con ambos formatos)
                    $aciertosFijos = [
                        '1ª' => '6', '1a' => '6',
                        '2ª' => '5+C', '2a' => '5+C',
                        '3ª' => '5', '3a' => '5',
                        '4ª' => '4', '4a' => '4',
                        '5ª' => '3', '5a' => '3',
                    ];
                @endphp
                @foreach($sorteo->premios as $premio)
                @php
                    // Normalizar categoría a formato estándar para visualización
                    $categoriaMostrar = $premio['categoria'] ?? '-';
                    if ($categoriaMostrar === '1a') $categoriaMostrar = '1ª';
                    elseif ($categoriaMostrar === '2a') $categoriaMostrar = '2ª';
                    elseif ($categoriaMostrar === '3a') $categoriaMostrar = '3ª';
                    elseif ($categoriaMostrar === '4a') $categoriaMostrar = '4ª';
                    elseif ($categoriaMostrar === '5a') $categoriaMostrar = '5ª';
                    elseif ($categoriaMostrar === '6a') $categoriaMostrar = '6ª';
                    elseif ($categoriaMostrar === '7a') $categoriaMostrar = '7ª';
                    elseif ($categoriaMostrar === '8a') $categoriaMostrar = '8ª';
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700">{{ $categoriaMostrar }}</td>
                    <td class="px-6 py-3 text-center text-slate-600 font-medium">
                        {{ $aciertosFijos[$premio['categoria']] ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-right text-slate-600">{{ number_format($premio['acertantes'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        @if(array_key_exists('premio', $premio) && $premio['premio'] === null)
                            <span class="text-slate-500">Pendiente</span>
                        @else
                            {{ number_format($premio['premio'] ?? 0, 2, ',', '.') }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif($juego->slug === 'la-primitiva')
    <!-- Tabla especial para La Primitiva con Aciertos como dato fijo -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[450px]">
            <thead class="{{ $color['bg'] }} text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-center">Aciertos</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes</th>
                    <th class="px-6 py-3 font-medium text-right">Premio (€)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    // Aciertos fijos para La Primitiva según categoría (compatible con ambos formatos)
                    $aciertosFijos = [
                        'Especial' => '6+R',
                        '1ª' => '6', '1a' => '6',
                        '2ª' => '5+C', '2a' => '5+C',
                        '3ª' => '5', '3a' => '5',
                        '4ª' => '4', '4a' => '4',
                        '5ª' => '3', '5a' => '3',
                        '6ª' => 'Reintegro', '6a' => 'Reintegro',
                    ];
                @endphp
                @foreach($sorteo->premios as $premio)
                @php
                    // Normalizar categoría a formato estándar para visualización
                    $categoriaMostrar = $premio['categoria'] ?? '-';
                    if ($categoriaMostrar === '1a') $categoriaMostrar = '1ª';
                    elseif ($categoriaMostrar === '2a') $categoriaMostrar = '2ª';
                    elseif ($categoriaMostrar === '3a') $categoriaMostrar = '3ª';
                    elseif ($categoriaMostrar === '4a') $categoriaMostrar = '4ª';
                    elseif ($categoriaMostrar === '5a') $categoriaMostrar = '5ª';
                    elseif ($categoriaMostrar === '6a') $categoriaMostrar = '6ª';
                    elseif ($categoriaMostrar === '7a') $categoriaMostrar = '7ª';
                    elseif ($categoriaMostrar === '8a') $categoriaMostrar = '8ª';
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700">{{ $categoriaMostrar }}</td>
                    <td class="px-6 py-3 text-center text-slate-600 font-medium">
                        {{ $aciertosFijos[$premio['categoria']] ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-right text-slate-600">{{ number_format($premio['acertantes'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        @if(array_key_exists('premio', $premio) && $premio['premio'] === null)
                            <span class="text-slate-500">Pendiente</span>
                        @else
                            {{ number_format($premio['premio'] ?? 0, 2, ',', '.') }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif($juego->slug === 'el-gordo')
    <!-- Tabla especial para El Gordo con Aciertos como dato fijo -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[450px]">
            <thead class="{{ $color['bg'] }} text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-center">Aciertos</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes</th>
                    <th class="px-6 py-3 font-medium text-right">Premio (€)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    // Aciertos fijos para El Gordo según categoría (compatible con ambos formatos)
                    $aciertosFijos = [
                        '1ª' => '5+1', '1a' => '5+1',
                        '2ª' => '5+0', '2a' => '5+0',
                        '3ª' => '4+1', '3a' => '4+1',
                        '4ª' => '4+0', '4a' => '4+0',
                        '5ª' => '3+1', '5a' => '3+1',
                        '6ª' => '3+0', '6a' => '3+0',
                        '7ª' => '2+1', '7a' => '2+1',
                        '8ª' => '2+0', '8a' => '2+0',
                        'Reintegro' => '0+1',
                    ];
                @endphp
                @foreach($sorteo->premios as $premio)
                @php
                    // Normalizar categoría a formato estándar para visualización
                    $categoriaMostrar = $premio['categoria'] ?? '-';
                    if ($categoriaMostrar === '1a') $categoriaMostrar = '1ª';
                    elseif ($categoriaMostrar === '2a') $categoriaMostrar = '2ª';
                    elseif ($categoriaMostrar === '3a') $categoriaMostrar = '3ª';
                    elseif ($categoriaMostrar === '4a') $categoriaMostrar = '4ª';
                    elseif ($categoriaMostrar === '5a') $categoriaMostrar = '5ª';
                    elseif ($categoriaMostrar === '6a') $categoriaMostrar = '6ª';
                    elseif ($categoriaMostrar === '7a') $categoriaMostrar = '7ª';
                    elseif ($categoriaMostrar === '8a') $categoriaMostrar = '8ª';
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700">{{ $categoriaMostrar }}</td>
                    <td class="px-6 py-3 text-center text-slate-600 font-medium">
                        {{ $aciertosFijos[$premio['categoria']] ?? '-' }}
                    </td>
                    <td class="px-6 py-3 text-right text-slate-600">{{ number_format($premio['acertantes'] ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        @if(array_key_exists('premio', $premio) && $premio['premio'] === null)
                            <span class="text-slate-500">Pendiente</span>
                        @else
                            {{ number_format($premio['premio'] ?? 0, 2, ',', '.') }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <!-- Tabla normal para otros juegos -->
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
    @endif
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
