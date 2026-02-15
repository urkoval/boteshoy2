@extends('layouts.app')

@section('title')
Cómo se juega a {{ $juego->nombre }} | Guía Completa 2026
@endsection

@section('description')
Aprende cómo se juega a {{ $juego->nombre }}: reglas, premios, probabilidades y consejos. Guía completa paso a paso actualizada.
@endsection

@php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'border' => 'border-euro-500', 'text' => 'text-euro-500', 'ball' => 'bg-blue-600'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'border' => 'border-bono-500', 'text' => 'text-bono-500', 'ball' => 'bg-red-600'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'border' => 'border-primi-500', 'text' => 'text-primi-500', 'ball' => 'bg-emerald-600'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'border' => 'border-gordo-500', 'text' => 'text-gordo-500', 'ball' => 'bg-purple-600'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'border' => 'border-gray-500', 'text' => 'text-gray-500', 'ball' => 'bg-gray-600'];
@endphp

@section('content')
<div class="mb-6">
    <a href="{{ route('juego', $juego->slug) }}" class="{{ $color['text'] }} font-medium hover:underline inline-flex items-center gap-1">
        <span>←</span> Ver últimos resultados de {{ $juego->nombre }}
    </a>
</div>

<div class="{{ $color['bg'] }} rounded-xl shadow-lg p-6 mb-8">
    <h1 class="text-3xl font-bold text-white">Cómo se juega a {{ $juego->nombre }}</h1>
    <p class="text-white/90 mt-2">Guía completa con reglas, premios y probabilidades</p>
</div>

<section class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-slate-800 mb-6">Guía de {{ $juego->nombre }}</h2>
    
    @switch($juego->slug)
        @case('euromillones')
            <div class="space-y-6">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                    <h3 class="font-bold text-blue-800 mb-2">¿Cómo se juega a Euromillones?</h3>
                    <p class="text-blue-700">Selecciona 5 números del 1 al 50 y 2 estrellas del 1 al 12. El coste de cada apuesta es de 2,50€.</p>
                </div>
                
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Premios principales</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li>• 5 números + 2 estrellas: Bote mayor</li>
                            <li>• 5 números + 1 estrella: Aprox. 300.000€</li>
                            <li>• 5 números: Aprox. 30.000€</li>
                            <li>• 4 números + 2 estrellas: Aprox. 2.000€</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Probabilidades</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li>• Bote mayor: 1 entre 139.838.160</li>
                            <li>• 5 números + 1 estrella: 1 entre 6.991.908</li>
                            <li>• 5 números: 1 entre 3.107.515</li>
                            <li>• Cualquier premio: 1 entre 13</li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4">
                    <h4 class="font-semibold text-amber-800 mb-2">Datos importantes</h4>
                    <ul class="text-sm text-amber-700 space-y-1">
                        <li>• Días de sorteo: Martes y Viernes a las 21:30h</li>
                        <li>• Bote mínimo: 17 millones de euros</li>
                        <li>• Países participantes: 9 países europeos</li>
                        <li>• Impuestos: Exento hasta 20.000€ en España</li>
                    </ul>
                </div>
            </div>
            @break
            
        @case('bonoloto')
            <div class="space-y-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-4">
                    <h3 class="font-bold text-red-800 mb-2">¿Cómo se juega a Bonoloto?</h3>
                    <p class="text-red-700">Selecciona 6 números del 1 al 49. El coste de cada apuesta es de 0,50€. Puedes añadir complementario y reintegro.</p>
                </div>
                
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Premios principales</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li>• 6 números: Bote (mínimo 400.000€)</li>
                            <li>• 5 números + complementario: Aprox. 50.000€</li>
                            <li>• 5 números: Aprox. 2.000€</li>
                            <li>• 4 números: Aprox. 35€</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Complementarios</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li>• <strong>Complementario:</strong> 1 número extra (1-49)</li>
                            <li>• <strong>Reintegro:</strong> 1 número (0-9)</li>
                            <li>• Reintegro devuelve el importe apostado</li>
                            <li>• Se puede jugar con reintegro fijo</li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-green-50 border-l-4 border-green-500 p-4">
                    <h4 class="font-semibold text-green-800 mb-2">Datos importantes</h4>
                    <ul class="text-sm text-green-700 space-y-1">
                        <li>• Días de sorteo: Lunes a Sábado a las 21:30h</li>
                        <li>• Bote mínimo: 400.000€</li>
                        <li>• Sorteo con más frecuencia</li>
                        <li>• Premios desde 6€ (3 aciertos)</li>
                    </ul>
                </div>
            </div>
            @break
            
        @case('la-primitiva')
            <div class="space-y-6">
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4">
                    <h3 class="font-bold text-emerald-800 mb-2">¿Cómo se juega a La Primitiva?</h3>
                    <p class="text-emerald-700">Selecciona 6 números del 1 al 49. El coste es de 1€ por apuesta. Incluye complementario y reintegro.</p>
                </div>
                
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Sistema de jackpots</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li>• <strong>Jumbo:</strong> Bote principal</li>
                            <li>• <strong>El Millón:</strong> Sorteo semanal extra</li>
                            <li>• <strong>Número Clave:</strong> Para bote adicional</li>
                            <li>• Acumulado si no hay ganadores</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Complementarios</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li>• <strong>Complementario:</strong> 1 número (1-49)</li>
                            <li>• <strong>Reintegro:</strong> 1 número (0-9)</li>
                            <li>• <strong>Número Clave:</strong> 1 número (0-9)</li>
                            <li>• Reintegro devuelve la apuesta</li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-purple-50 border-l-4 border-purple-500 p-4">
                    <h4 class="font-semibold text-purple-800 mb-2">Datos importantes</h4>
                    <ul class="text-sm text-purple-700 space-y-1">
                        <li>• Días de sorteo: Lunes, Jueves y Sábado a las 21:30h</li>
                        <li>• Bote mínimo: 3 millones de euros</li>
                        <li>• El Millón: 1 millón garantizado los jueves</li>
                        <li>• Uno de los sorteos más antiguos</li>
                    </ul>
                </div>
            </div>
            @break
            
        @case('el-gordo')
            <div class="space-y-6">
                <div class="bg-purple-50 border-l-4 border-purple-500 p-4">
                    <h3 class="font-bold text-purple-800 mb-2">¿Cómo se juega a El Gordo de la Primitiva?</h3>
                    <p class="text-purple-700">Selecciona 6 números del 1 al 49. El coste es de 1,50€ por apuesta. Incluye Número Clave y reintegro.</p>
                </div>
                
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Número Clave</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li>• Número del 0 al 9 generado aleatoriamente</li>
                            <li>• Solo para premios de 6 aciertos</li>
                            <li>• Si aciertas 6 + Número Clave: bote extra</li>
                            <li>• Sin acertar Número Clave: bote normal</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-2">Premios principales</h4>
                        <ul class="text-sm text-slate-600 space-y-1">
                            <li>• 6 números + Número Clave: Bote mayor</li>
                            <li>• 6 números: Aprox. 1 millón de euros</li>
                            <li>• 5 números + Número Clave: Aprox. 50.000€</li>
                            <li>• 5 números: Aprox. 2.000€</li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4">
                    <h4 class="font-semibold text-indigo-800 mb-2">Datos importantes</h4>
                    <ul class="text-sm text-indigo-700 space-y-1">
                        <li>• Días de sorteo: Domingos a las 21:30h</li>
                        <li>• Bote mínimo: 5 millones de euros</li>
                        <li>• Sorteo semanal más reciente</li>
                        <li>• Reintegro devuelve 1,50€</li>
                    </ul>
                </div>
            </div>
            @break
    @endswitch
    
    <div class="mt-6 p-4 bg-slate-50 rounded-lg">
        <p class="text-sm text-slate-600">
            <strong>Nota:</strong> Los premios indicados son aproximados y pueden variar según el número de acertantes y el bote acumulado. 
            Consulta siempre los resultados oficiales para información actualizada.
        </p>
    </div>
</section>

<div class="mt-8 bg-gradient-to-r from-slate-50 to-blue-50 rounded-xl p-6 border border-slate-200">
    <h3 class="text-lg font-bold text-slate-800 mb-4">¿Quieres ver los resultados?</h3>
    <a href="{{ route('juego', $juego->slug) }}" class="{{ $color['bg'] }} text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 inline-block">
        Ver últimos resultados de {{ $juego->nombre }} →
    </a>
</div>

<section class="mt-8 bg-slate-50 rounded-xl p-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Información Avanzada</h2>
    <div class="grid md:grid-cols-3 gap-4">
        <a href="{{ route('juego.apuestas-multiples', $juego->slug) }}" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-2">🎯 Apuestas Múltiples</h3>
            <p class="text-sm text-slate-600">Juega más números y aumenta probabilidades</p>
        </a>
        
        <a href="{{ route('juego.apuestas-reducidas', $juego->slug) }}" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-2">📊 Apuestas Reducidas</h3>
            <p class="text-sm text-slate-600">Sistemas optimizados para ahorrar</p>
        </a>
        
        <a href="{{ route('juego.combinacion-ganadora', $juego->slug) }}" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-2">🏆 Combinación Ganadora</h3>
            <p class="text-sm text-slate-600">Cómo comprobar tu boleto</p>
        </a>
    </div>
</section>

<section class="mt-10 bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes sobre {{ $juego->nombre }}</h2>

    <div class="space-y-3">
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
