@extends('layouts.app')

@section('title')
{{ $contenido?->seo_title ?? "Apuestas Múltiples en {$juego->nombre} | Cómo Funcionan y Cuánto Cuestan" }}
@endsection

@section('description')
{{ $contenido?->meta_description ?? "Aprende cómo hacer apuestas múltiples en {$juego->nombre}: qué son, ventajas, coste y cómo rellenar el boleto." }}
@endsection

@php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'border' => 'border-euro-500', 'text' => 'text-euro-500'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'border' => 'border-bono-500', 'text' => 'text-bono-500'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'border' => 'border-primi-500', 'text' => 'text-primi-500'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'border' => 'border-gordo-500', 'text' => 'text-gordo-500'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'border' => 'border-gray-500', 'text' => 'text-gray-500'];
@endphp

@section('content')
<div class="mb-6">
    <a href="{{ route('juego.guia', $juego->slug) }}" class="{{ $color['text'] }} font-medium hover:underline inline-flex items-center gap-1">
        <span>←</span> Volver a la guía de {{ $juego->nombre }}
    </a>
</div>

<div class="{{ $color['bg'] }} rounded-xl shadow-lg p-6 mb-8">
    <h1 class="text-3xl font-bold text-white">{{ $contenido?->h1_principal ?? "Apuestas Múltiples en {$juego->nombre}" }}</h1>
    <p class="text-white/90 mt-2">Juega más números y aumenta tus probabilidades de ganar</p>
</div>

@if($contenido && $contenido->contenido_html)
    <section class="bg-white rounded-xl shadow-md p-6 mb-8">
        {!! $contenido->contenido_html !!}
    </section>
@else
    <!-- Contenido fallback -->
    <section class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">¿Qué es una Apuesta Múltiple?</h2>
        
        <div class="prose max-w-none">
            <p class="text-slate-700 mb-4">
                Una apuesta múltiple te permite jugar más de 6 números en un mismo boleto, generando automáticamente todas las combinaciones posibles de 6 números.
            </p>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-800"><strong>Ejemplo:</strong> Si juegas 7 números en múltiple, se generan 7 combinaciones diferentes de 6 números. Si juegas 8 números, se generan 28 combinaciones.</p>
            </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Diferencia con la Apuesta Simple</h3>
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="bg-slate-50 p-4 rounded-lg">
                <h4 class="font-semibold text-slate-800 mb-2">Apuesta Simple</h4>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li>• Seleccionas exactamente 6 números</li>
                    <li>• Juegas 1 combinación</li>
                    <li>• Coste: {{ $juego->slug === 'bonoloto' ? '0,50€' : ($juego->slug === 'euromillones' ? '2,50€' : '1€') }}</li>
                </ul>
            </div>
            <div class="{{ $color['bg'] }}/10 p-4 rounded-lg {{ $color['border'] }} border-l-4">
                <h4 class="font-semibold text-slate-800 mb-2">Apuesta Múltiple</h4>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li>• Seleccionas 7 o más números</li>
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
                    $costeBase = $juego->slug === 'bonoloto' ? 0.50 : ($juego->slug === 'euromillones' ? 2.50 : 1.00);
                    $combinaciones = [
                        7 => 7,
                        8 => 28,
                        9 => 84,
                        10 => 210,
                        11 => 462,
                    ];
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
            <li>Marca más de 6 números en el boleto (7, 8, 9, 10 o 11)</li>
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
