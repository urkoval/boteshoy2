@extends('layouts.app')

@if($contenido && $contenido->head_extra)
@push('head')
{!! $contenido->head_extra !!}
@endpush
@endif

@section('title')
@if($juego->slug === 'euromillones')
    {{ $contenido?->seo_title ?? "Cómo Hacer Apuestas Múltiples en Euromillones | Guía Completa 2024" }}
@elseif($juego->slug === 'bonoloto')
    {{ $contenido?->seo_title ?? "Apuestas Múltiples Bonoloto | Coste, Ejemplos y Cómo Jugar" }}
@elseif($juego->slug === 'la-primitiva')
    {{ $contenido?->seo_title ?? "Apuestas Múltiples Primitiva | Sistemas, Precios y Estrategias" }}
@elseif($juego->slug === 'el-gordo')
    {{ $contenido?->seo_title ?? "Apuestas Múltiples Gordo de la Primitiva | Cómo Funcionan" }}
@else
    {{ $contenido?->seo_title ?? "Apuestas Múltiples en {$juego->nombre} | Cómo Funcionan y Cuánto Cuestan" }}
@endif
@endsection

@section('description')
@if($juego->slug === 'euromillones')
    {{ $contenido?->meta_description ?? "Aprende cómo hacer apuestas múltiples en Euromillones paso a paso: coste real, ejemplos prácticos, ventajas y cómo rellenar tu boleto múltiple." }}
@elseif($juego->slug === 'bonoloto')
    {{ $contenido?->meta_description ?? "Descubre cómo funcionan las apuestas múltiples en Bonoloto: tablas de costes, ejemplos de 7 a 11 números, y estrategias para jugar más combinaciones." }}
@elseif($juego->slug === 'la-primitiva')
    {{ $contenido?->meta_description ?? "Guía completa de apuestas múltiples en La Primitiva: cómo jugar, costes por número, sistemas múltiples y consejos para maximizar tus probabilidades." }}
@elseif($juego->slug === 'el-gordo')
    {{ $contenido?->meta_description ?? "Aprende a hacer apuestas múltiples en el Gordo de la Primitiva: costes, combinaciones posibles y cómo rellenar boletos múltiples." }}
@else
    {{ $contenido?->meta_description ?? "Aprende cómo hacer apuestas múltiples en {$juego->nombre}: qué son, ventajas, coste y cómo rellenar el boleto." }}
@endif
@endsection

@php
$structuredData = [
    "@context" => "https://schema.org",
    "@type" => "HowTo",
    "name" => $juego->slug === 'euromillones' ? "Cómo hacer apuestas múltiples en Euromillones" : 
            ($juego->slug === 'bonoloto' ? "Cómo hacer apuestas múltiples en Bonoloto" : 
            "Cómo hacer apuestas múltiples en " . $juego->nombre),
    "description" => $juego->slug === 'euromillones' ? 
        "Guía paso a paso para hacer apuestas múltiples en Euromillones, incluyendo costes, ejemplos y estrategias" :
        ($juego->slug === 'bonoloto' ? 
        "Aprende a hacer apuestas múltiples en Bonoloto con ejemplos prácticos y tablas de costes" :
        "Guía completa para hacer apuestas múltiples en " . $juego->nombre),
    "image" => url("images/{$juego->slug}-apuestas-multiples.jpg"),
    "totalTime" => "PT10M",
    "supply" => [
        [
            "@type" => "HowToSupply",
            "name" => "Boleto oficial de " . $juego->nombre
        ],
        [
            "@type" => "HowToSupply", 
            "name" => "Bolígrafo o marcador"
        ]
    ],
    "tool" => [
        [
            "@type" => "HowToTool",
            "name" => "Calculadora de apuestas múltiples"
        ]
    ],
    "step" => [
        [
            "@type" => "HowToStep",
            "name" => "Selecciona más números",
            "text" => $juego->slug === 'euromillones' ? 
                "Marca más de 5 números y más de 2 estrellas en el boleto" :
                ($juego->slug === 'el-gordo' ? 
                "Marca más de 5 números en el boleto (6, 7, 8, 9 o 10)" :
                "Marca más de 6 números en el boleto (7, 8, 9, 10 u 11)")
        ],
        [
            "@type" => "HowToStep", 
            "name" => "Marca apuesta múltiple",
            "text" => "Activa la casilla de apuesta múltiple en tu boleto"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Verifica el coste",
            "text" => "El sistema mostrará el coste total según las combinaciones generadas"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Paga y conserva",
            "text" => "Paga el importe y guarda tu boleto para el sorteo"
        ]
    ]
];
@endphp

@php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'border' => 'border-euro-500', 'text' => 'text-euro-500'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'border' => 'border-bono-500', 'text' => 'text-bono-500'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'border' => 'border-primi-500', 'text' => 'text-primi-500'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'border' => 'border-gordo-500', 'text' => 'text-gordo-500'],
    'eurodreams' => ['bg' => 'bg-dream-500', 'border' => 'border-dream-500', 'text' => 'text-dream-500'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'border' => 'border-gray-500', 'text' => 'text-gray-500'];
@endphp

@section('content')
<script type="application/ld+json">
{!! json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
<div class="mb-6">
    <a href="{{ route('juego.guia', $juego->slug) }}" class="{{ $color['text'] }} font-medium hover:underline inline-flex items-center gap-1">
        <span>←</span> Volver a la guía de {{ $juego->nombre }}
    </a>
</div>

<div class="{{ $color['bg'] }} rounded-xl shadow-lg p-6 mb-8">
    <h1 class="text-3xl font-bold text-white">
        @if($juego->slug === 'euromillones')
            {{ $contenido?->h1_principal ?? "Cómo Hacer Apuestas Múltiples en Euromillones" }}
        @elseif($juego->slug === 'bonoloto')
            {{ $contenido?->h1_principal ?? "Apuestas Múltiples Bonoloto: Guía Completa" }}
        @elseif($juego->slug === 'la-primitiva')
            {{ $contenido?->h1_principal ?? "Apuestas Múltiples en La Primitiva" }}
        @elseif($juego->slug === 'el-gordo')
            {{ $contenido?->h1_principal ?? "Apuestas Múltiples en el Gordo" }}
        @else
            {{ $contenido?->h1_principal ?? "Apuestas Múltiples en {$juego->nombre}" }}
        @endif
    </h1>
    <p class="text-white/90 mt-2">
        @if($juego->slug === 'euromillones')
            Juega más números y estrellas para aumentar tus probabilidades en Euromillones
        @elseif($juego->slug === 'bonoloto')
            Sistema económico para jugar más combinaciones en Bonoloto
        @elseif($juego->slug === 'la-primitiva')
            Aumenta tus posibilidades de acertar con múltiples combinaciones
        @elseif($juego->slug === 'el-gordo')
            Juega más números y optimiza tus apuestas en el Gordo
        @else
            Juega más números y aumenta tus probabilidades de ganar
        @endif
    </p>
</div>

@if($contenido && $contenido->contenido_html)
    <section class="bg-white rounded-xl shadow-md p-6 mb-8">
        {!! $contenido->contenido_html !!}
    </section>
@else
    <!-- Contenido fallback -->
    <section class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">¿Qué es una Apuesta Múltiple en {{ $juego->nombre }}?</h2>
        
        <div class="prose max-w-none">
            <p class="text-slate-700 mb-4">
                @if($juego->slug === 'euromillones')
                    Una apuesta múltiple en Euromillones te permite seleccionar más de 5 números principales y más de 2 estrellas, generando automáticamente todas las combinaciones posibles. Esto aumenta significativamente tus probabilidades de ganar cualquier premio.
                @elseif($juego->slug === 'bonoloto')
                    Una apuesta múltiple en Bonoloto te permite jugar más de 6 números en un mismo boleto, generando automáticamente todas las combinaciones posibles de 6 números. Es la forma más económica de jugar múltiples combinaciones.
                @elseif($juego->slug === 'la-primitiva')
                    Una apuesta múltiple en La Primitiva te permite seleccionar más de 6 números, generando todas las combinaciones posibles de 6 números. Con el reintegro, tienes más oportunidades de recuperar tu inversión.
                @elseif($juego->slug === 'el-gordo')
                    Una apuesta múltiple en el Gordo de la Primitiva te permite jugar más de 5 números, generando todas las combinaciones posibles de 5 números. Aumenta tus probabilidades de ganar el bote semanal.
                @else
                    Una apuesta múltiple te permite jugar más de 6 números en un mismo boleto, generando automáticamente todas las combinaciones posibles de 6 números.
                @endif
            </p>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-800">
                    @if($juego->slug === 'euromillones')
                        <strong>Ejemplo Euromillones:</strong> Si juegas 6 números + 3 estrellas, se generan 6 combinaciones diferentes. Si juegas 7 números + 2 estrellas, se generan 14 combinaciones.
                    @elseif($juego->slug === 'bonoloto')
                        <strong>Ejemplo Bonoloto:</strong> Si juegas 7 números en múltiple, se generan 7 combinaciones diferentes de 6 números. Si juegas 8 números, se generan 28 combinaciones.
                    @elseif($juego->slug === 'la-primitiva')
                        <strong>Ejemplo Primitiva:</strong> Si juegas 7 números en múltiple, se generan 7 combinaciones. Con 8 números son 28 combinaciones, y con 9 números son 84 combinaciones.
                    @elseif($juego->slug === 'el-gordo')
                        <strong>Ejemplo Gordo:</strong> Si juegas 6 números, se generan 6 combinaciones. Con 8 números son 56 combinaciones, y con 10 números llegarías a 252 combinaciones.
                    @else
                        <strong>Ejemplo:</strong> Si juegas 7 números en múltiple, se generan 7 combinaciones diferentes de 6 números. Si juegas 8 números, se generan 28 combinaciones.
                    @endif
                </p>
            </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Diferencia con la Apuesta Simple</h3>
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="bg-slate-50 p-4 rounded-lg">
                <h4 class="font-semibold text-slate-800 mb-2">Apuesta Simple</h4>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li>• Seleccionas exactamente {{ $juego->slug === 'el-gordo' ? '5' : '6' }} números</li>
                    <li>• Juegas 1 combinación</li>
                    <li>• Coste: {{ $juego->slug === 'bonoloto' ? '0,50€' : ($juego->slug === 'euromillones' ? '2,50€' : '1,50€') }}</li>
                </ul>
            </div>
            <div class="{{ $color['bg'] }}/10 p-4 rounded-lg {{ $color['border'] }} border-l-4">
                <h4 class="font-semibold text-slate-800 mb-2">Apuesta Múltiple</h4>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li>• Seleccionas {{ $juego->slug === 'el-gordo' ? '6' : '7' }} o más números</li>
                    <li>• Juegas múltiples combinaciones</li>
                    <li>• Coste: según números seleccionados</li>
                </ul>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Tabla de Costes</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border border-slate-200">
                <thead class="{{ $color['bg'] }} text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Números jugados</th>
                        <th class="px-4 py-2 text-center">Combinaciones</th>
                        <th class="px-4 py-2 text-right">Coste total</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @php
                    $costeBase = $juego->slug === 'bonoloto' ? 0.50 : ($juego->slug === 'euromillones' ? 2.50 : 1.50);
                    // El Gordo tiene combinación base de 5 números, los demás de 6
                    if ($juego->slug === 'el-gordo') {
                        // Combinaciones C(n,5) para El Gordo
                        $combinaciones = [
                            6 => 6,      // C(6,5) = 6
                            7 => 21,     // C(7,5) = 21
                            8 => 56,     // C(8,5) = 56
                            9 => 126,    // C(9,5) = 126
                            10 => 252,   // C(10,5) = 252
                            11 => 462,   // C(11,5) = 462
                        ];
                    } else {
                        // Combinaciones C(n,6) para Bonoloto, Primitiva, etc.
                        $combinaciones = [
                            7 => 7,      // C(7,6) = 7
                            8 => 28,     // C(8,6) = 28
                            9 => 84,     // C(9,6) = 84
                            10 => 210,   // C(10,6) = 210
                            11 => 462,   // C(11,6) = 462
                        ];
                    }
                    @endphp
                    @foreach($combinaciones as $nums => $combs)
                    <tr class="border-t border-slate-200">
                        <td class="px-4 py-2 font-medium">{{ $nums }} números</td>
                        <td class="px-4 py-2 text-center">{{ $combs }}</td>
                        <td class="px-4 py-2 text-right font-semibold">{{ number_format($combs * $costeBase, 2) }}€</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Ventajas de Jugar en Múltiple</h3>
        <div class="space-y-3 mb-6">
            <div class="flex items-start gap-3">
                <span class="text-2xl">✅</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Más probabilidades</h4>
                    <p class="text-sm text-slate-600">Al jugar más combinaciones, aumentas tus probabilidades de acertar premios.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">🎯</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Comodidad</h4>
                    <p class="text-sm text-slate-600">Marcas los números una sola vez y el sistema genera todas las combinaciones.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">💰</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Premios múltiples</h4>
                    <p class="text-sm text-slate-600">Puedes ganar varios premios en el mismo sorteo si varias combinaciones resultan premiadas.</p>
                </div>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Cómo Rellenar el Boleto</h3>
        <ol class="list-decimal list-inside space-y-2 text-slate-700 mb-6">
            @if($juego->slug === 'el-gordo')
            <li>Marca más de 5 números en el boleto (6, 7, 8, 9 o 10)</li>
            @else
            <li>Marca más de 6 números en el boleto (7, 8, 9, 10 o 11)</li>
            @endif
            <li>Marca la casilla "Múltiple" o "Apuesta Múltiple"</li>
            <li>El sistema calculará automáticamente el coste total</li>
            <li>Paga y conserva tu boleto</li>
        </ol>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">¿Cuándo Conviene Jugar en Múltiple?</h3>
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6">
            <p class="text-amber-900 text-sm">
                <strong>Recomendación:</strong> Las apuestas múltiples son ideales si tienes varios números "favoritos" y quieres asegurarte de jugarlos todos. 
                Ten en cuenta que el coste aumenta rápidamente, así que juega con responsabilidad.
            </p>
        </div>
    </div>
@endif
</section>

<section class="bg-slate-50 rounded-xl p-6 mb-8">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Enlaces Relacionados</h2>
    <div class="grid md:grid-cols-2 gap-3">
        <a href="{{ route('juego.apuestas-reducidas', $juego->slug) }}" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-1">📊 Apuestas Reducidas</h3>
            <p class="text-sm text-slate-600">Juega más números con menor coste</p>
        </a>
        <a href="{{ route('juego.guia', $juego->slug) }}" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-1">📖 Guía Completa</h3>
            <p class="text-sm text-slate-600">Volver a la guía de {{ $juego->nombre }}</p>
        </a>
        <a href="{{ route('juego', $juego->slug) }}" class="{{ $color['bg'] }} text-white p-4 rounded-lg hover:opacity-90 transition-opacity">
            <h3 class="font-bold mb-1">🏆 Ver Últimos Resultados</h3>
            <p class="text-sm text-white/90">Resultados y premios recientes</p>
        </a>
    </div>
</section>
@endsection
