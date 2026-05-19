@extends('layouts.app')

@section('title')
Décimo Premiado Lotería Nacional {{ date('Y') }} | Comprobar Números
@endsection

@section('description')
Consulta si tu décimo de Lotería Nacional está premiado. Últimos resultados del sorteo del Jueves y Sábado con primer premio, segundo premio, terminaciones y reintegros.
@endsection

@php
$faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
        [
            '@type' => 'Question',
            'name' => '¿Cómo sé si mi décimo de Lotería Nacional tiene premio?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Tu décimo tiene premio si: 1) Tu número coincide exactamente con el primer o segundo premio, 2) Las últimas cifras de tu número coinciden con alguna terminación premiada, o 3) La última cifra coincide con algún reintegro.',
            ],
        ],
        [
            '@type' => 'Question',
            'name' => '¿Qué es un reintegro en Lotería Nacional?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'El reintegro es un premio que recupera el importe del décimo. Se obtiene cuando la última cifra de tu número coincide con alguno de los reintegros del sorteo.',
            ],
        ],
        [
            '@type' => 'Question',
            'name' => '¿Cuánto tiempo tengo para cobrar un décimo premiado?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Los premios de Lotería Nacional caducan a los 3 meses desde la fecha del sorteo. Pasado ese plazo, el premio prescribe.',
            ],
        ],
    ],
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
            <a href="{{ route('juego', 'loteria-nacional') }}" class="hover:text-white">Lotería Nacional</a>
            <span class="mx-2">›</span>
            <span class="text-white">Décimo Premiado</span>
        </nav>
        <h1 class="text-3xl font-bold mb-2">Décimo Premiado Lotería Nacional</h1>
        <p class="text-white/80 text-lg">Comprueba si tu décimo tiene premio con los últimos resultados</p>
    </div>
</div>

<!-- Últimos resultados -->
<div class="grid md:grid-cols-2 gap-6 mb-8">
    <!-- Último Jueves -->
    @if($ultimoJueves)
    @php
        $compJ = $ultimoJueves->complementarios ?? [];
        $primerJ = $compJ['primer_premio'] ?? null;
        $segundoJ = $compJ['segundo_premio'] ?? null;
        $reintegrosJ = $compJ['reintegros'] ?? [];
    @endphp
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-amber-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Sorteo del Jueves</h2>
                <span class="text-white/80">{{ $ultimoJueves->fecha->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @if($primerJ)
                <div class="flex justify-between items-center p-3 bg-amber-50 rounded-lg">
                    <span class="text-slate-600 font-medium">1º Premio</span>
                    <span class="text-2xl font-bold text-amber-700 tracking-widest">{{ $primerJ }}</span>
                </div>
                @endif
                @if($segundoJ)
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg">
                    <span class="text-slate-600 font-medium">2º Premio</span>
                    <span class="text-xl font-bold text-slate-700 tracking-widest">{{ $segundoJ }}</span>
                </div>
                @endif
                @if(!empty($reintegrosJ))
                <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-lg">
                    <span class="text-slate-600 font-medium">Reintegros</span>
                    <div class="flex gap-2">
                        @foreach($reintegrosJ as $r)
                        <span class="w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold">{{ $r }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <a href="{{ route('sorteo', ['slug' => 'loteria-nacional', 'fecha' => $ultimoJueves->fecha->format('Y-m-d')]) }}" 
               class="block mt-4 text-center text-amber-600 font-medium hover:underline">
                Ver terminaciones y detalles →
            </a>
        </div>
    </div>
    @endif

    <!-- Último Sábado -->
    @if($ultimoSabado)
    @php
        $compS = $ultimoSabado->complementarios ?? [];
        $primerS = $compS['primer_premio'] ?? null;
        $segundoS = $compS['segundo_premio'] ?? null;
        $reintegrosS = $compS['reintegros'] ?? [];
    @endphp
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-amber-700 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Sorteo del Sábado</h2>
                <span class="text-white/80">{{ $ultimoSabado->fecha->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @if($primerS)
                <div class="flex justify-between items-center p-3 bg-amber-50 rounded-lg">
                    <span class="text-slate-600 font-medium">1º Premio</span>
                    <span class="text-2xl font-bold text-amber-800 tracking-widest">{{ $primerS }}</span>
                </div>
                @endif
                @if($segundoS)
                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg">
                    <span class="text-slate-600 font-medium">2º Premio</span>
                    <span class="text-xl font-bold text-slate-700 tracking-widest">{{ $segundoS }}</span>
                </div>
                @endif
                @if(!empty($reintegrosS))
                <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-lg">
                    <span class="text-slate-600 font-medium">Reintegros</span>
                    <div class="flex gap-2">
                        @foreach($reintegrosS as $r)
                        <span class="w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold">{{ $r }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <a href="{{ route('sorteo', ['slug' => 'loteria-nacional', 'fecha' => $ultimoSabado->fecha->format('Y-m-d')]) }}" 
               class="block mt-4 text-center text-amber-700 font-medium hover:underline">
                Ver terminaciones y detalles →
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Cómo comprobar tu décimo -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">¿Cómo saber si tu décimo está premiado?</h2>
    
    <div class="grid md:grid-cols-3 gap-6">
        <div class="p-4 bg-amber-50 rounded-lg border-l-4 border-amber-500">
            <h3 class="font-bold text-amber-800 mb-2">1º y 2º Premio</h3>
            <p class="text-slate-600 text-sm">Tu número de 5 cifras debe coincidir exactamente con el número premiado.</p>
        </div>
        
        <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
            <h3 class="font-bold text-blue-800 mb-2">Terminaciones</h3>
            <p class="text-slate-600 text-sm">Si las últimas cifras de tu número coinciden con una terminación premiada, tienes premio.</p>
        </div>
        
        <div class="p-4 bg-emerald-50 rounded-lg border-l-4 border-emerald-500">
            <h3 class="font-bold text-emerald-800 mb-2">Reintegros</h3>
            <p class="text-slate-600 text-sm">Si la última cifra de tu número coincide con un reintegro, recuperas el precio del décimo.</p>
        </div>
    </div>
</div>

<!-- Ejemplo práctico con tabla de premios -->
<div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 mb-6 border border-amber-200">
    <h3 class="text-lg font-bold text-slate-800 mb-4">Ejemplo práctico (Sorteo ordinario del Sábado)</h3>
    <div class="grid md:grid-cols-2 gap-6">
        <div class="text-slate-600 space-y-3">
            <p>Supongamos que tu décimo tiene el número <strong class="text-amber-700">45203</strong> y los resultados son:</p>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li>Primer premio: 59203 → <strong class="text-red-600">No coincide</strong> (tu número es diferente)</li>
                <li>Terminación "03" (2 cifras): 12€ → <strong class="text-emerald-600">¡Premiado!</strong> (tu número termina en 03)</li>
                <li>Reintegro "3": 6€ → <strong class="text-emerald-600">¡Premiado!</strong> (tu número termina en 3)</li>
            </ul>
            <p class="text-sm text-slate-500 mt-2">Nota: Los premios de terminaciones de diferentes cifras se acumulan. Sin embargo, la terminación de 1 cifra y el reintegro son el mismo premio (6€), no se cobran ambos. En este ejemplo, cobrarías 12€ + 6€ = 18€ por décimo.</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <h4 class="font-bold text-slate-700 mb-3 text-sm">Tabla de premios Sábado (por décimo)</h4>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-1 text-slate-500 font-medium">Categoría</th>
                        <th class="text-right py-1 text-slate-500 font-medium">Premio</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5">1º Premio</td>
                        <td class="text-right font-semibold text-amber-700">60.000€</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5">2º Premio</td>
                        <td class="text-right">12.000€</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5">Terminación 4 cifras</td>
                        <td class="text-right">150€</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5">Terminación 3 cifras</td>
                        <td class="text-right">30€</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 bg-emerald-50">Terminación 2 cifras</td>
                        <td class="text-right bg-emerald-50 font-semibold text-emerald-600">12€</td>
                    </tr>
                    <tr>
                        <td class="py-1.5 bg-emerald-50">Reintegro (1 cifra)</td>
                        <td class="text-right bg-emerald-50 font-semibold text-emerald-600">6€</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Enlaces a sorteos -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Ver todos los resultados</h2>
    <div class="grid md:grid-cols-2 gap-4">
        <a href="{{ route('loteria.jueves') }}" class="flex items-center justify-between p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
            <div>
                <div class="font-bold text-amber-700">Sorteos del Jueves</div>
                <div class="text-sm text-slate-600">Décimo a 3€ · Primer premio 30.000€</div>
            </div>
            <span class="text-amber-600">→</span>
        </a>
        <a href="{{ route('loteria.sabado') }}" class="flex items-center justify-between p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
            <div>
                <div class="font-bold text-amber-800">Sorteos del Sábado</div>
                <div class="text-sm text-slate-600">Décimo a 6€ · Primer premio 60.000€</div>
            </div>
            <span class="text-amber-700">→</span>
        </a>
    </div>
</div>

<!-- FAQs -->
<section class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes</h2>

    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cómo sé si mi décimo de Lotería Nacional tiene premio?</summary>
            <div class="mt-2 text-slate-600">
                Tu décimo tiene premio si: 1) Tu número coincide exactamente con el primer o segundo premio, 2) Las últimas cifras de tu número coinciden con alguna terminación premiada, o 3) La última cifra coincide con algún reintegro.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué es un reintegro en Lotería Nacional?</summary>
            <div class="mt-2 text-slate-600">
                El reintegro es un premio que recupera el importe del décimo. Se obtiene cuando la última cifra de tu número coincide con alguno de los reintegros del sorteo. En el sorteo del jueves son 3€ y en el del sábado 6€.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto tiempo tengo para cobrar un décimo premiado?</summary>
            <div class="mt-2 text-slate-600">
                Los premios de Lotería Nacional caducan a los 3 meses desde la fecha del sorteo. Pasado ese plazo, el premio prescribe y no podrás cobrarlo.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Dónde puedo cobrar un décimo premiado?</summary>
            <div class="mt-2 text-slate-600">
                Los premios hasta 2.000€ se pueden cobrar en cualquier administración de lotería. Los premios superiores deben cobrarse en entidades bancarias autorizadas o en las oficinas de Loterías y Apuestas del Estado.
            </div>
        </details>
    </div>
</section>
@endsection
