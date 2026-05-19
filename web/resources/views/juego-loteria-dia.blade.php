@extends('layouts.app')

@php
$esJueves = $diaSemana === 'jueves';
$nombreDia = $esJueves ? 'Jueves' : 'Sábado';
$precioDecimo = $esJueves ? 3 : 6;
$primerPremio = $esJueves ? '30.000€' : '60.000€';
@endphp

@section('title')
Resultado Lotería Nacional {{ $nombreDia }} {{ date('Y') }} | Números Premiados
@endsection

@section('description')
Resultados de Lotería Nacional del {{ $nombreDia }}. Consulta el primer premio, segundo premio, terminaciones y reintegros. Décimo a {{ $precioDecimo }}€, primer premio {{ $primerPremio }} por décimo.
@endsection

@section('content')
<div class="bg-loteria-500 -mx-4 -mt-8 px-4 py-8 mb-8 text-white">
    <div class="container mx-auto">
        <nav class="text-sm text-white/60 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Inicio</a>
            <span class="mx-2">›</span>
            <a href="{{ route('juego', 'loteria-nacional') }}" class="hover:text-white">Lotería Nacional</a>
            <span class="mx-2">›</span>
            <span class="text-white">{{ $nombreDia }}</span>
        </nav>
        <h1 class="text-3xl font-bold mb-2">Lotería Nacional {{ $nombreDia }}</h1>
        <p class="text-white/80 text-lg">Resultados de todos los sorteos del {{ $nombreDia }}</p>
    </div>
</div>

<!-- Info del sorteo -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="text-center p-4 bg-amber-50 rounded-lg">
            <div class="text-sm text-slate-500 uppercase">Precio del décimo</div>
            <div class="text-3xl font-bold text-amber-700">{{ $precioDecimo }}€</div>
        </div>
        <div class="text-center p-4 bg-amber-50 rounded-lg">
            <div class="text-sm text-slate-500 uppercase">Primer premio</div>
            <div class="text-3xl font-bold text-amber-700">{{ $primerPremio }}</div>
            <div class="text-xs text-slate-500">por décimo</div>
        </div>
        <div class="text-center p-4 bg-amber-50 rounded-lg">
            <div class="text-sm text-slate-500 uppercase">Día del sorteo</div>
            <div class="text-3xl font-bold text-amber-700">{{ $nombreDia }}</div>
        </div>
    </div>
</div>

<!-- Navegación entre días -->
<div class="flex gap-4 mb-6">
    <a href="{{ route('loteria.jueves') }}" 
       class="flex-1 text-center py-3 rounded-lg font-semibold transition-colors {{ $esJueves ? 'bg-loteria-500 text-white' : 'bg-white text-slate-700 hover:bg-slate-100' }}">
        Jueves
    </a>
    <a href="{{ route('loteria.sabado') }}" 
       class="flex-1 text-center py-3 rounded-lg font-semibold transition-colors {{ !$esJueves ? 'bg-loteria-500 text-white' : 'bg-white text-slate-700 hover:bg-slate-100' }}">
        Sábado
    </a>
</div>

<!-- Lista de sorteos -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-bold text-slate-800">Últimos resultados - {{ $nombreDia }}</h2>
    </div>
    
    @if($sorteos->isEmpty())
        <div class="p-8 text-center text-slate-500">
            No hay sorteos disponibles para este día.
        </div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach($sorteos as $sorteo)
                @php
                    $comp = $sorteo->complementarios ?? [];
                    $primerPremioNum = $comp['primer_premio'] ?? null;
                    $segundoPremioNum = $comp['segundo_premio'] ?? null;
                    $reintegros = $comp['reintegros'] ?? [];
                @endphp
                <a href="{{ route('sorteo', ['slug' => $juego->slug, 'fecha' => $sorteo->fecha->format('Y-m-d')]) }}" 
                   class="block p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="text-center min-w-[80px]">
                                <div class="text-sm text-slate-500">{{ $sorteo->fecha->translatedFormat('D') }}</div>
                                <div class="text-lg font-bold text-slate-800">{{ $sorteo->fecha->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-4">
                            @if($primerPremioNum)
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500">1º</span>
                                <span class="px-3 py-1.5 bg-amber-700 text-white rounded-lg font-bold text-lg tracking-wider">
                                    {{ $primerPremioNum }}
                                </span>
                            </div>
                            @endif
                            
                            @if($segundoPremioNum)
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500">2º</span>
                                <span class="px-3 py-1.5 bg-amber-600 text-white rounded-lg font-bold text-lg tracking-wider">
                                    {{ $segundoPremioNum }}
                                </span>
                            </div>
                            @endif
                            
                            @if(!empty($reintegros))
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500">R</span>
                                <div class="flex gap-1">
                                    @foreach($reintegros as $r)
                                    <span class="w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                        {{ $r }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="text-amber-600 font-medium text-sm">
                            Ver detalles →
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="p-4 border-t border-slate-200">
            {{ $sorteos->links() }}
        </div>
    @endif
</div>

<!-- Info SEO -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Lotería Nacional del {{ $nombreDia }}</h2>
    
    @if($esJueves)
    <div class="prose prose-slate max-w-none">
        <p>El sorteo de <strong>Lotería Nacional del Jueves</strong> es uno de los sorteos semanales de Loterías y Apuestas del Estado. Con un precio de <strong>3€ por décimo</strong>, ofrece un primer premio de <strong>30.000€ por décimo</strong>.</p>
        
        <h3>Características del sorteo del Jueves</h3>
        <ul>
            <li><strong>Precio del décimo:</strong> 3€</li>
            <li><strong>Primer premio:</strong> 30.000€ por décimo (300.000€ por billete)</li>
            <li><strong>Segundo premio:</strong> 12.000€ por décimo</li>
            <li><strong>Reintegros:</strong> 3€ (recuperas el precio del décimo)</li>
        </ul>
        
        <p>El sorteo se celebra todos los jueves a las 21:30h y los resultados están disponibles inmediatamente después del sorteo.</p>
    </div>
    @else
    <div class="prose prose-slate max-w-none">
        <p>El sorteo de <strong>Lotería Nacional del Sábado</strong> es el sorteo principal de la semana. Con un precio de <strong>6€ por décimo</strong>, ofrece un primer premio de <strong>60.000€ por décimo</strong>.</p>
        
        <h3>Características del sorteo del Sábado</h3>
        <ul>
            <li><strong>Precio del décimo:</strong> 6€</li>
            <li><strong>Primer premio:</strong> 60.000€ por décimo (600.000€ por billete)</li>
            <li><strong>Segundo premio:</strong> 12.000€ por décimo</li>
            <li><strong>Reintegros:</strong> 6€ (recuperas el precio del décimo)</li>
        </ul>
        
        <p>El sorteo se celebra todos los sábados a las 13:00h y los resultados están disponibles inmediatamente después del sorteo.</p>
        
        <h3>Sorteos Extraordinarios</h3>
        <p>Algunos sábados se celebran <strong>sorteos extraordinarios</strong> con premios mayores y precios diferentes. Estos sorteos especiales incluyen ocasiones como San Valentín, Día del Padre, Día de la Madre, y otros.</p>
    </div>
    @endif
</div>

<!-- FAQs -->
<section class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes</h2>

    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto cuesta un décimo de Lotería Nacional del {{ $nombreDia }}?</summary>
            <div class="mt-2 text-slate-600">
                El décimo de Lotería Nacional del {{ $nombreDia }} cuesta {{ $precioDecimo }}€. Un billete completo (10 décimos) cuesta {{ $precioDecimo * 10 }}€.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto es el primer premio del {{ $nombreDia }}?</summary>
            <div class="mt-2 text-slate-600">
                El primer premio de Lotería Nacional del {{ $nombreDia }} es de {{ $primerPremio }} por décimo, lo que equivale a {{ $esJueves ? '300.000€' : '600.000€' }} por billete completo.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿A qué hora es el sorteo del {{ $nombreDia }}?</summary>
            <div class="mt-2 text-slate-600">
                El sorteo de Lotería Nacional del {{ $nombreDia }} se celebra a las {{ $esJueves ? '21:30h' : '13:00h' }}.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuál es la diferencia entre el sorteo del Jueves y el del Sábado?</summary>
            <div class="mt-2 text-slate-600">
                La principal diferencia es el precio y los premios. El sorteo del Jueves tiene décimos a 3€ con primer premio de 30.000€, mientras que el del Sábado tiene décimos a 6€ con primer premio de 60.000€. Además, los sorteos extraordinarios suelen celebrarse en sábado.
            </div>
        </details>
    </div>
</section>
@endsection
