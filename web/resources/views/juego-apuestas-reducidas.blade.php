@extends('layouts.app')

@if($contenido && $contenido->head_extra)
@push('head')
{!! $contenido->head_extra !!}
@endpush
@endif

@section('title')
@if($juego->slug === 'euromillones')
    {{ $contenido?->seo_title ?? "Apuestas Reducidas Euromillones | Sistemas Reducidos y Garantías 2024" }}
@elseif($juego->slug === 'bonoloto')
    {{ $contenido?->seo_title ?? "Apuestas Reducidas Bonoloto Baratas | Sistemas 3 si 5 y Ejemplos" }}
@else
    {{ $contenido?->seo_title ?? "Apuestas Reducidas en {$juego->nombre} | Sistemas Optimizados para Ahorrar" }}
@endif
@endsection

@section('description')
@if($juego->slug === 'euromillones')
    {{ $contenido?->meta_description ?? "Descubre cómo funcionan las apuestas reducidas en Euromillones: sistemas reducidos, garantías matemáticas, costes y dónde hacer apuestas reducidas baratas." }}
@elseif($juego->slug === 'bonoloto')
    {{ $contenido?->meta_description ?? "Aprende sobre apuestas reducidas en Bonoloto: qué son, cómo funcionan, sistemas 3 si 5, ejemplos prácticos y dónde hacerlas económicamente." }}
@else
    {{ $contenido?->meta_description ?? "Aprende cómo funcionan las apuestas reducidas en {$juego->nombre}: qué son, garantías, costes y dónde hacerlas." }}
@endif
@endsection

@php
$structuredData = [
    "@context" => "https://schema.org",
    "@type" => "HowTo",
    "name" => $juego->slug === 'euromillones' ? "Cómo hacer apuestas reducidas en Euromillones" : 
            ($juego->slug === 'bonoloto' ? "Cómo hacer apuestas reducidas en Bonoloto" : 
            "Cómo hacer apuestas reducidas en " . $juego->nombre),
    "description" => $juego->slug === 'euromillones' ? 
        "Guía completa para entender y hacer apuestas reducidas en Euromillones, incluyendo sistemas, garantías y costes" :
        ($juego->slug === 'bonoloto' ? 
        "Aprende a hacer apuestas reducidas económicas en Bonoloto con sistemas 3 si 5 y ejemplos prácticos" :
        "Guía para hacer apuestas reducidas en " . $juego->nombre . " con sistemas optimizados"),
    "image" => url("images/{$juego->slug}-apuestas-reducidas.jpg"),
    "totalTime" => "PT15M",
    "supply" => [
        [
            "@type" => "HowToSupply",
            "name" => "Boleto oficial de " . $juego->nombre
        ],
        [
            "@type" => "HowToSupply", 
            "name" => "Lista de números favoritos (8-12 números)"
        ]
    ],
    "tool" => [
        [
            "@type" => "HowToTool",
            "name" => "Calculadora de sistemas reducidos"
        ]
    ],
    "step" => [
        [
            "@type" => "HowToStep",
            "name" => "Elige tus números",
            "text" => "Selecciona entre 8 y 12 números que quieres jugar"
        ],
        [
            "@type" => "HowToStep", 
            "name" => "Consulta sistemas disponibles",
            "text" => "Busca sistemas reducidos con las garantías que necesites (3 si 5, 4 si 4, etc.)"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Genera combinaciones",
            "text" => "Usa el sistema reducido para generar las combinaciones optimizadas"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Juega las combinaciones",
            "text" => "Rellena los boletos con las combinaciones generadas por el sistema"
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
            Apuestas Reducidas Euromillones
        @elseif($juego->slug === 'bonoloto')
            Apuestas Reducidas Bonoloto Baratas
        @else
            Apuestas Reducidas en {{ $juego->nombre }}
        @endif
    </h1>
    <p class="text-white/90 mt-2">
        @if($juego->slug === 'euromillones')
            Sistemas reducidos para jugar más números y estrellas con menor coste
        @elseif($juego->slug === 'bonoloto')
            Sistemas económicos para jugar 10-12 números con garantías
        @else
            Sistemas optimizados para jugar más números con menor coste
        @endif
    </p>
</div>

<section class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-slate-800 mb-6">¿Qué es un Sistema Reducido en {{ $juego->nombre }}?</h2>
    
    <div class="prose max-w-none">
        <p class="text-slate-700 mb-4">
            @if($juego->slug === 'euromillones')
                Un sistema reducido en Euromillones es un método matemático que te permite jugar más números y estrellas (por ejemplo, 8 números + 3 estrellas) pero generando menos combinaciones que una apuesta múltiple completa, reduciendo drásticamente el coste manteniendo buenas probabilidades.
            @elseif($juego->slug === 'bonoloto')
                Un sistema reducido en Bonoloto es un método matemático que te permite jugar más números (10, 11 o 12) pero generando menos combinaciones que una apuesta múltiple completa, reduciendo así el coste desde 105€ a solo 15-30€.
            @else
                Un sistema reducido es un método matemático que te permite jugar más números (por ejemplo, 10 o 12) pero generando menos combinaciones que una apuesta múltiple completa, reduciendo así el coste.
            @endif
        </p>
        
        <div class="bg-purple-50 border-l-4 border-purple-500 p-4 mb-6">
            <p class="text-purple-800">
                @if($juego->slug === 'euromillones')
                    <strong>Ejemplo Euromillones:</strong> Si juegas 8 números + 3 estrellas en múltiple completo, generarías más de 100 combinaciones costando más de 250€. Con un sistema reducido, puedes jugar esos mismos números con solo 15-20 combinaciones por 37,50-50€.
                @elseif($juego->slug === 'bonoloto')
                    <strong>Ejemplo Bonoloto:</strong> Si juegas 10 números en múltiple completo, generas 210 combinaciones por 105€. Con un sistema reducido, puedes jugar esos 10 números con solo 30-40 combinaciones por 15-20€, con garantía de premio si aciertas ciertos números.
                @else
                    <strong>Ejemplo:</strong> Si juegas 10 números en múltiple completo, generas 210 combinaciones. Con un sistema reducido, puedes jugar esos 10 números con solo 30-40 combinaciones, con garantía de premio si aciertas ciertos números.
                @endif
            </p>
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
