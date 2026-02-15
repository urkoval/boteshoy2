@extends('layouts.app')

@section('title')
{{ $contenido?->seo_title ?? "Apuestas Reducidas en {$juego->nombre} | Sistemas Optimizados para Ahorrar" }}
@endsection

@section('description')
{{ $contenido?->meta_description ?? "Aprende cómo funcionan las apuestas reducidas en {$juego->nombre}: qué son, garantías, costes y dónde hacerlas." }}
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
    <h1 class="text-3xl font-bold text-white">Apuestas Reducidas en {{ $juego->nombre }}</h1>
    <p class="text-white/90 mt-2">Sistemas optimizados para jugar más números con menor coste</p>
</div>

<section class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-slate-800 mb-6">¿Qué es un Sistema Reducido?</h2>
    
    <div class="prose max-w-none">
        <p class="text-slate-700 mb-4">
            Un sistema reducido es un método matemático que te permite jugar más números (por ejemplo, 10 o 12) pero generando menos combinaciones que una apuesta múltiple completa, reduciendo así el coste.
        </p>
        
        <div class="bg-purple-50 border-l-4 border-purple-500 p-4 mb-6">
            <p class="text-purple-800"><strong>Ejemplo:</strong> Si juegas 10 números en múltiple completo, generas 210 combinaciones. Con un sistema reducido, puedes jugar esos 10 números con solo 30-40 combinaciones, con garantía de premio si aciertas ciertos números.</p>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Diferencia: Múltiple vs Reducido</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border border-slate-200">
                <thead class="{{ $color['bg'] }} text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Característica</th>
                        <th class="px-4 py-2 text-center">Apuesta Múltiple</th>
                        <th class="px-4 py-2 text-center">Sistema Reducido</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="border-t border-slate-200">
                        <td class="px-4 py-2 font-medium">10 números</td>
                        <td class="px-4 py-2 text-center">210 combinaciones</td>
                        <td class="px-4 py-2 text-center">30-60 combinaciones</td>
                    </tr>
                    <tr class="border-t border-slate-200 bg-slate-50">
                        <td class="px-4 py-2 font-medium">Cobertura</td>
                        <td class="px-4 py-2 text-center">100% de combinaciones</td>
                        <td class="px-4 py-2 text-center">Optimizada (garantías)</td>
                    </tr>
                    <tr class="border-t border-slate-200">
                        <td class="px-4 py-2 font-medium">Coste (Bonoloto)</td>
                        <td class="px-4 py-2 text-center">105€</td>
                        <td class="px-4 py-2 text-center">15-30€</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Cómo Funcionan los Sistemas Reducidos</h3>
        <p class="text-slate-700 mb-4">
            Los sistemas reducidos utilizan algoritmos matemáticos para seleccionar las combinaciones más eficientes. Cada sistema tiene una <strong>garantía</strong>:
        </p>

        <div class="space-y-3 mb-6">
            <div class="bg-green-50 border-l-4 border-green-500 p-4">
                <h4 class="font-semibold text-green-900 mb-2">Garantía 4 si 4</h4>
                <p class="text-sm text-green-800">Si 4 de tus números salen premiados, garantizas al menos un premio de 4 aciertos.</p>
            </div>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <h4 class="font-semibold text-blue-900 mb-2">Garantía 3 si 5</h4>
                <p class="text-sm text-blue-800">Si 5 de tus números salen premiados, garantizas al menos un premio de 3 aciertos (puede haber más).</p>
            </div>
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4">
                <h4 class="font-semibold text-amber-900 mb-2">Garantía 3 si 6</h4>
                <p class="text-sm text-amber-800">Si aciertas los 6 números, garantizas al menos un premio de 3 aciertos (pero puede que no el bote).</p>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Ventajas y Desventajas</h3>
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="bg-green-50 p-4 rounded-lg">
                <h4 class="font-semibold text-green-900 mb-3">✅ Ventajas</h4>
                <ul class="text-sm text-green-800 space-y-2">
                    <li>• <strong>Menor coste:</strong> Pagas menos que una múltiple completa</li>
                    <li>• <strong>Más números:</strong> Puedes jugar 10, 12 o más números</li>
                    <li>• <strong>Garantías:</strong> Aseguras premios con ciertos aciertos</li>
                    <li>• <strong>Optimizado:</strong> Matemáticamente eficiente</li>
                </ul>
            </div>
            <div class="bg-red-50 p-4 rounded-lg">
                <h4 class="font-semibold text-red-900 mb-3">⚠️ Desventajas</h4>
                <ul class="text-sm text-red-800 space-y-2">
                    <li>• <strong>No todas las combinaciones:</strong> Pierdes cobertura total</li>
                    <li>• <strong>Puede que no ganes el bote:</strong> Aunque aciertes los 6</li>
                    <li>• <strong>Complejidad:</strong> Difícil de hacer manualmente</li>
                    <li>• <strong>No siempre disponible:</strong> Depende de la administración</li>
                </ul>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Ejemplo Práctico: 10 Números</h3>
        <div class="bg-slate-100 p-4 rounded-lg mb-6">
            <p class="text-slate-700 mb-3"><strong>Números elegidos:</strong> 3, 7, 12, 18, 23, 29, 34, 38, 42, 47</p>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <h5 class="font-semibold text-slate-800 mb-2">Apuesta Múltiple Completa</h5>
                    <ul class="text-sm text-slate-600">
                        <li>• 210 combinaciones</li>
                        <li>• Coste: {{ $juego->slug === 'bonoloto' ? '105€' : ($juego->slug === 'euromillones' ? '525€' : '210€') }}</li>
                        <li>• 100% de cobertura</li>
                    </ul>
                </div>
                <div class="bg-white p-3 rounded">
                    <h5 class="font-semibold text-slate-800 mb-2">Sistema Reducido (Garantía 3 si 5)</h5>
                    <ul class="text-sm text-slate-600">
                        <li>• 35-50 combinaciones</li>
                        <li>• Coste: {{ $juego->slug === 'bonoloto' ? '17,50-25€' : ($juego->slug === 'euromillones' ? '87,50-125€' : '35-50€') }}</li>
                        <li>• Garantía matemática</li>
                    </ul>
                </div>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">¿Dónde Se Pueden Hacer?</h3>
        <div class="space-y-3 mb-6">
            <div class="flex items-start gap-3">
                <span class="text-2xl">🏪</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Administraciones de Loterías</h4>
                    <p class="text-sm text-slate-600">Algunas administraciones ofrecen sistemas reducidos predefinidos. Pregunta en tu administración habitual.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">💻</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Plataformas Online</h4>
                    <p class="text-sm text-slate-600">Algunas webs de apuestas online ofrecen sistemas reducidos como opción de juego.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">📊</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Software Especializado</h4>
                    <p class="text-sm text-slate-600">Existen programas que generan sistemas reducidos personalizados, pero requieren conocimientos técnicos.</p>
                </div>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">¿Cuándo Conviene un Sistema Reducido?</h3>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <p class="text-blue-900 text-sm mb-3">
                <strong>Es ideal si:</strong>
            </p>
            <ul class="text-sm text-blue-800 space-y-1 ml-4">
                <li>• Tienes 8-12 números "favoritos" que quieres jugar</li>
                <li>• No puedes permitirte una múltiple completa</li>
                <li>• Entiendes que reduces probabilidades pero ahorras dinero</li>
                <li>• Juegas regularmente y quieres optimizar tu inversión</li>
            </ul>
        </div>

        <div class="bg-red-50 border-l-4 border-red-500 p-4">
            <p class="text-red-900 text-sm">
                <strong>Advertencia:</strong> Los sistemas reducidos NO aumentan tus probabilidades de ganar el bote. Solo optimizan el coste si decides jugar muchos números. Juega con responsabilidad.
            </p>
        </div>
    </div>
</section>

<section class="bg-slate-50 rounded-xl p-6 mb-8">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Enlaces Relacionados</h2>
    <div class="grid md:grid-cols-2 gap-3">
        <a href="{{ route('juego.apuestas-multiples', $juego->slug) }}" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-1">🎯 Apuestas Múltiples</h3>
            <p class="text-sm text-slate-600">Juega todas las combinaciones posibles</p>
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
