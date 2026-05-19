@extends('layouts.app')

@section('title')
Guía Lotería Nacional {{ date('Y') }}: Cómo Funciona, Premios y Décimos
@endsection

@section('description')
Aprende cómo funciona la Lotería Nacional: tipos de sorteo (jueves y sábado), estructura de premios, terminaciones, reintegros y cómo comprobar si tu décimo está premiado.
@endsection

@section('content')
<div class="mb-6">
    <a href="{{ route('juego', 'loteria-nacional') }}" class="text-loteria-500 font-medium hover:underline inline-flex items-center gap-1">
        <span>←</span> Ver últimos resultados
    </a>
</div>

<div class="bg-loteria-500 rounded-xl shadow-lg p-6 mb-8">
    <h1 class="text-3xl font-bold text-white">Guía de Lotería Nacional</h1>
    <p class="text-white/90 mt-2">Todo sobre el sorteo más tradicional de España</p>
</div>

<section class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">¿Qué es la Lotería Nacional?</h2>
    <p class="text-slate-600 mb-4">
        La Lotería Nacional es el sorteo más antiguo de España. A diferencia de Euromillones o La Primitiva, 
        <strong>no eliges números</strong>: compras un décimo con un número ya asignado de 5 cifras.
    </p>
    <div class="bg-amber-50 border-l-4 border-amber-500 p-4">
        <p class="text-amber-800">
            <strong>Importante:</strong> No hay combinaciones ni apuestas múltiples. Compras un décimo y esperas el sorteo.
        </p>
    </div>
</section>

<section class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Tipos de Sorteo</h2>
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-amber-50 rounded-lg p-5 border border-amber-200">
            <h3 class="font-bold text-amber-800 text-lg mb-3">Sorteo del Jueves</h3>
            <ul class="text-slate-600 space-y-1 text-sm">
                <li><strong>Décimo:</strong> 3€</li>
                <li><strong>1º Premio:</strong> 30.000€/décimo</li>
                <li><strong>2º Premio:</strong> 6.000€/décimo</li>
            </ul>
            <a href="{{ route('loteria.jueves') }}" class="inline-block mt-3 text-amber-700 font-medium hover:underline text-sm">Ver resultados →</a>
        </div>
        <div class="bg-amber-100 rounded-lg p-5 border border-amber-300">
            <h3 class="font-bold text-amber-900 text-lg mb-3">Sorteo del Sábado</h3>
            <ul class="text-slate-600 space-y-1 text-sm">
                <li><strong>Décimo:</strong> 6€</li>
                <li><strong>1º Premio:</strong> 60.000€/décimo</li>
                <li><strong>2º Premio:</strong> 12.000€/décimo</li>
            </ul>
            <a href="{{ route('loteria.sabado') }}" class="inline-block mt-3 text-amber-800 font-medium hover:underline text-sm">Ver resultados →</a>
        </div>
    </div>
</section>

<section class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Décimo vs Billete</h2>
    <p class="text-slate-600 mb-4">
        Cada número se divide en <strong>billetes</strong>, y cada billete en <strong>10 décimos</strong>. 
        Los premios oficiales son por billete; divide entre 10 para saber tu premio por décimo.
    </p>
</section>

<section class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Premios por Terminaciones</h2>
    <p class="text-slate-600 mb-4">Además de los premios principales, hay premios por terminaciones:</p>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-100">
                <tr>
                    <th class="text-left p-3">Categoría</th>
                    <th class="text-right p-3">Sábado (décimo)</th>
                    <th class="text-right p-3">Jueves (décimo)</th>
                </tr>
            </thead>
            <tbody class="text-slate-600">
                <tr class="border-b"><td class="p-3">Terminación 4 cifras</td><td class="text-right p-3">150€</td><td class="text-right p-3">75€</td></tr>
                <tr class="border-b"><td class="p-3">Terminación 3 cifras</td><td class="text-right p-3">30€</td><td class="text-right p-3">15€</td></tr>
                <tr class="border-b"><td class="p-3">Terminación 2 cifras</td><td class="text-right p-3">12€</td><td class="text-right p-3">6€</td></tr>
                <tr><td class="p-3">Reintegro (1 cifra)</td><td class="text-right p-3">6€</td><td class="text-right p-3">3€</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Comprobar tu Décimo</h2>
    <p class="text-slate-600 mb-4">¿Quieres saber si tu décimo tiene premio?</p>
    <a href="{{ route('loteria.decimo-premiado') }}" class="inline-block bg-loteria-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-loteria-600 transition">
        Comprobar décimo premiado →
    </a>
</section>

<section class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold text-slate-800 mb-4">Cómo Cobrar Premios</h2>
    <ul class="text-slate-600 space-y-2">
        <li><strong>Hasta 2.000€:</strong> En cualquier administración de lotería</li>
        <li><strong>De 2.000€ a 40.000€:</strong> En entidades bancarias colaboradoras</li>
        <li><strong>Más de 40.000€:</strong> En oficinas de Loterías y Apuestas del Estado</li>
    </ul>
    <p class="text-sm text-slate-500 mt-4">Los premios caducan a los 3 meses desde el sorteo.</p>
</section>

<section class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes</h2>
    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué días se sortea la Lotería Nacional?</summary>
            <div class="mt-2 text-slate-600">Jueves (décimo 3€) y sábados (décimo 6€). Además hay sorteos extraordinarios.</div>
        </details>
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Puedo elegir mi número?</summary>
            <div class="mt-2 text-slate-600">Sí, puedes buscar un número concreto en administraciones o comprar online el número que prefieras si está disponible.</div>
        </details>
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué son las series?</summary>
            <div class="mt-2 text-slate-600">Cada número se emite en varias series (normalmente 10). Puede haber varios ganadores del mismo número en diferentes series.</div>
        </details>
    </div>
</section>
@endsection
