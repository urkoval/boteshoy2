<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resultados Loterías España') | Boteshoy</title>
    <meta name="description" content="@yield('description', 'Resultados de loterías españolas: Euromillones, Bonoloto, La Primitiva y El Gordo. Consulta los últimos sorteos y premios.')">
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'euro': { 500: '#1e3a8a', 600: '#1e40af' },
                        'bono': { 500: '#dc2626', 600: '#b91c1c' },
                        'primi': { 500: '#059669', 600: '#047857' },
                        'gordo': { 500: '#7c3aed', 600: '#6d28d9' },
                        'dream': { 500: '#0891b2', 600: '#0e7490' },
                    }
                }
            }
        }
    </script>
    <style>
        .ball { 
            box-shadow: inset -2px -2px 4px rgba(0,0,0,0.3), inset 2px 2px 4px rgba(255,255,255,0.3);
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="icon" href="/favicon.ico">
    
    @stack('head')
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen flex flex-col overflow-x-hidden">
    <header class="bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-lg overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-baseline gap-2">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                        <span class="text-yellow-400">Botes</span>Hoy
                    </a>
                    <span class="text-slate-400 text-sm hidden sm:inline">Resultados de loterías</span>
                </div>

                @if(!empty($botesHeader))
                    <div class="grid grid-cols-2 gap-2 sm:flex sm:gap-3">
                        @foreach($botesHeader as $b)
                            <a href="{{ route('juego', $b['slug']) }}" class="rounded-lg {{ $b['classes']['bg'] }} border {{ $b['classes']['border'] }} px-4 py-3 hover:opacity-90 transition text-center sm:text-left">
                                <div class="text-xs text-white/80">{{ $b['nombre'] }}</div>
                                <div class="text-base sm:text-lg font-extrabold">{{ number_format($b['bote_eur'], 0, ',', '.') }} €</div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </header>

    <nav class="bg-slate-700 text-white shadow overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <!-- Main Games Navigation -->
            <div class="flex flex-wrap gap-2 mb-2">
                <a href="{{ route('juego', 'euromillones') }}" class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-euro-500 hover:bg-euro-600 text-sm sm:text-base font-medium transition">Euromillones</a>
                <a href="{{ route('juego', 'bonoloto') }}" class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-bono-500 hover:bg-bono-600 text-sm sm:text-base font-medium transition">Bonoloto</a>
                <a href="{{ route('juego', 'la-primitiva') }}" class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-primi-500 hover:bg-primi-600 text-sm sm:text-base font-medium transition">Primitiva</a>
                <a href="{{ route('juego', 'el-gordo') }}" class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-gordo-500 hover:bg-gordo-600 text-sm sm:text-base font-medium transition">El Gordo</a>
                <a href="{{ route('juego', 'eurodreams') }}" class="px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-dream-500 hover:bg-dream-600 text-sm sm:text-base font-medium transition">Eurodreams</a>
            </div>
            
            <!-- SEO Content Sections -->
            <div class="flex gap-2 sm:gap-4">
                    <div class="relative group">
                        <button class="px-3 py-1.5 rounded-full bg-slate-600 hover:bg-slate-500 text-sm font-medium whitespace-nowrap transition flex items-center gap-1">
                            Guías <span class="text-xs">▼</span>
                        </button>
                        <div class="absolute top-full left-0 mt-1 bg-slate-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10 min-w-[200px]">
                            <a href="{{ route('juego.guia', 'euromillones') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Guía Euromillones</a>
                            <a href="{{ route('juego.guia', 'bonoloto') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Guía Bonoloto</a>
                            <a href="{{ route('juego.guia', 'la-primitiva') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Guía Primitiva</a>
                            <a href="{{ route('juego.guia', 'el-gordo') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Guía El Gordo</a>
                            <a href="{{ route('juego.guia', 'eurodreams') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Guía Eurodreams</a>
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <button class="px-3 py-1.5 rounded-full bg-slate-600 hover:bg-slate-500 text-sm font-medium whitespace-nowrap transition flex items-center gap-1">
                            Estrategias <span class="text-xs">▼</span>
                        </button>
                        <div class="absolute top-full left-0 mt-1 bg-slate-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10 min-w-[250px]">
                            <div class="px-4 py-2 text-xs font-semibold text-slate-400 border-b border-slate-700">APUESTAS MÚLTIPLES</div>
                            <a href="{{ route('juego.apuestas-multiples', 'euromillones') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Euromillones Múltiples</a>
                            <a href="{{ route('juego.apuestas-multiples', 'bonoloto') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Bonoloto Múltiples</a>
                            <a href="{{ route('juego.apuestas-multiples', 'la-primitiva') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Primitiva Múltiples</a>
                            <a href="{{ route('juego.apuestas-multiples', 'el-gordo') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">El Gordo Múltiples</a>
                            
                            <div class="px-4 py-2 text-xs font-semibold text-slate-400 border-b border-slate-700 mt-2">APUESTAS REDUCIDAS</div>
                            <a href="{{ route('juego.apuestas-reducidas', 'euromillones') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Euromillones Reducidas</a>
                            <a href="{{ route('juego.apuestas-reducidas', 'bonoloto') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Bonoloto Reducidas</a>
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <button class="px-3 py-1.5 rounded-full bg-slate-600 hover:bg-slate-500 text-sm font-medium whitespace-nowrap transition flex items-center gap-1">
                            Comprobar <span class="text-xs">▼</span>
                        </button>
                        <div class="absolute top-full left-0 mt-1 bg-slate-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10 min-w-[200px]">
                            <a href="{{ route('juego.combinacion-ganadora', 'euromillones') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Euromillones</a>
                            <a href="{{ route('juego.combinacion-ganadora', 'bonoloto') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Bonoloto</a>
                            <a href="{{ route('juego.combinacion-ganadora', 'la-primitiva') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Primitiva</a>
                            <a href="{{ route('juego.combinacion-ganadora', 'el-gordo') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">El Gordo</a>
                            <a href="{{ route('juego.combinacion-ganadora', 'eurodreams') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 transition">Eurodreams</a>
                        </div>
                    </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 flex-grow overflow-x-hidden">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-500 text-center py-6 mt-auto">
        <p class="text-sm">&copy; {{ date('Y') }} BotesHoy.com - Resultados de loterías españolas</p>
        <p class="text-xs mt-2"><a href="{{ route('politica-cookies') }}" class="hover:text-slate-300 transition">Política de Cookies</a></p>
    </footer>
    
    <!-- Banner de cookies -->
    <div id="cookie-banner" class="fixed bottom-0 left-0 right-0 bg-gray-800 text-white p-4 z-50 hidden">
        <div class="container mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm">Usamos cookies para mejorar tu experiencia y analizar el tráfico. Al navegar aceptas nuestra política.</p>
            <div class="flex gap-2">
                <button onclick="acceptCookies()" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-sm font-medium transition">
                    Aceptar
                </button>
                <a href="/politica-cookies" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded text-sm font-medium transition">
                    Política
                </a>
            </div>
        </div>
    </div>

    <script>
    if(!localStorage.getItem('cookies-accepted')) {
        document.getElementById('cookie-banner').classList.remove('hidden');
    }

    function acceptCookies() {
        localStorage.setItem('cookies-accepted', 'true');
        document.getElementById('cookie-banner').classList.add('hidden');
        
        // Activar Google Analytics solo después de aceptar
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-BKHX0L9HGY');
        
        // Cargar el script de Google Analytics
        var script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=G-BKHX0L9HGY';
        document.head.appendChild(script);
    }
    </script>
    
    <!-- TinyMCE para admin -->
    @if(request()->is('admin/*'))
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @endif
</body>
</html>
