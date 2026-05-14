@extends('layouts.app')

@section('title', 'Política de Cookies')
@section('description', 'Política de cookies de BotesHoy. Información sobre el uso de cookies en nuestra web de resultados de loterías.')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Política de Cookies</h1>
    
    <div class="prose prose-slate max-w-none">
        <p class="text-slate-600 mb-6">Última actualización: {{ date('d/m/Y') }}</p>

        <h2 class="text-xl font-bold text-slate-800 mt-8 mb-4">¿Qué son las cookies?</h2>
        <p class="text-slate-700 mb-4">
            Las cookies son pequeños archivos de texto que los sitios web almacenan en tu dispositivo cuando los visitas. 
            Se utilizan para recordar tus preferencias, mejorar tu experiencia de navegación y analizar el uso del sitio.
        </p>

        <h2 class="text-xl font-bold text-slate-800 mt-8 mb-4">¿Qué cookies utilizamos?</h2>
        
        <h3 class="text-lg font-semibold text-slate-800 mt-6 mb-3">Cookies técnicas (necesarias)</h3>
        <p class="text-slate-700 mb-4">
            Son esenciales para el funcionamiento del sitio web. Incluyen cookies de sesión que permiten navegar por la web.
        </p>
        <ul class="list-disc list-inside text-slate-700 mb-4 space-y-1">
            <li><strong>laravel_session:</strong> Gestiona tu sesión de navegación</li>
            <li><strong>XSRF-TOKEN:</strong> Protección contra ataques CSRF</li>
        </ul>

        <h3 class="text-lg font-semibold text-slate-800 mt-6 mb-3">Cookies analíticas</h3>
        <p class="text-slate-700 mb-4">
            Utilizamos Google Analytics para comprender cómo los visitantes interactúan con nuestro sitio web. 
            Estas cookies recopilan información de forma anónima.
        </p>
        <ul class="list-disc list-inside text-slate-700 mb-4 space-y-1">
            <li><strong>_ga:</strong> Distingue usuarios únicos (2 años)</li>
            <li><strong>_ga_*:</strong> Mantiene el estado de la sesión (2 años)</li>
        </ul>

        <h2 class="text-xl font-bold text-slate-800 mt-8 mb-4">¿Cómo gestionar las cookies?</h2>
        <p class="text-slate-700 mb-4">
            Puedes configurar tu navegador para rechazar cookies o para que te avise cuando se envíen. 
            Ten en cuenta que si desactivas las cookies, algunas funciones del sitio podrían no funcionar correctamente.
        </p>
        <p class="text-slate-700 mb-4">
            Instrucciones para los navegadores más comunes:
        </p>
        <ul class="list-disc list-inside text-slate-700 mb-4 space-y-1">
            <li><a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener" class="text-blue-600 hover:underline">Google Chrome</a></li>
            <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank" rel="noopener" class="text-blue-600 hover:underline">Mozilla Firefox</a></li>
            <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener" class="text-blue-600 hover:underline">Safari</a></li>
            <li><a href="https://support.microsoft.com/es-es/microsoft-edge/eliminar-cookies-en-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09" target="_blank" rel="noopener" class="text-blue-600 hover:underline">Microsoft Edge</a></li>
        </ul>

        <h2 class="text-xl font-bold text-slate-800 mt-8 mb-4">Más información</h2>
        <p class="text-slate-700 mb-4">
            Si tienes alguna pregunta sobre nuestra política de cookies, puedes contactarnos a través de nuestros canales habituales.
        </p>

        <div class="mt-8 pt-6 border-t border-slate-200">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">← Volver al inicio</a>
        </div>
    </div>
</div>
@endsection
