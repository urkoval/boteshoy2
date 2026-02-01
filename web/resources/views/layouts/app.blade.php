<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resultados Loterías España') | Boteshoy</title>
    <meta name="description" content="@yield('description', 'Resultados de loterías españolas: Euromillones, Bonoloto, La Primitiva y El Gordo. Consulta los últimos sorteos y premios.')">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'euro': { 500: '#1e3a8a', 600: '#1e40af' },
                        'bono': { 500: '#dc2626', 600: '#b91c1c' },
                        'primi': { 500: '#059669', 600: '#047857' },
                        'gordo': { 500: '#7c3aed', 600: '#6d28d9' },
                    }
                }
            }
        }
    </script>
    <style>
        .ball { 
            box-shadow: inset -2px -2px 4px rgba(0,0,0,0.3), inset 2px 2px 4px rgba(255,255,255,0.3);
        }
    </style>
    @stack('head')
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen flex flex-col">
    <header class="bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-lg">
        <div class="container mx-auto px-4 py-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-baseline gap-2">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                        <span class="text-yellow-400">Botes</span>Hoy
                    </a>
                    <span class="text-slate-400 text-sm hidden sm:inline">Resultados de loterías</span>
                </div>

                @if(!empty($botesHeader))
                    <div class="flex gap-2 overflow-x-auto md:overflow-visible pb-1">
                        @foreach($botesHeader as $b)
                            <a href="{{ route('juego', $b['slug']) }}" class="shrink-0 rounded-full {{ $b['classes']['bg'] }} border {{ $b['classes']['border'] }} px-3 py-2 hover:opacity-90 transition">
                                <div class="text-[11px] text-white/70">{{ $b['nombre'] }}</div>
                                <div class="text-sm font-extrabold">{{ number_format($b['bote_eur'], 0, ',', '.') }} €</div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </header>

    <nav class="bg-slate-700 text-white shadow">
        <div class="container mx-auto px-4 py-3 flex gap-2 sm:gap-4 overflow-x-auto">
            <a href="{{ route('juego', 'euromillones') }}" class="px-3 py-1.5 rounded-full bg-euro-500 hover:bg-euro-600 text-sm font-medium whitespace-nowrap transition">Euromillones</a>
            <a href="{{ route('juego', 'bonoloto') }}" class="px-3 py-1.5 rounded-full bg-bono-500 hover:bg-bono-600 text-sm font-medium whitespace-nowrap transition">Bonoloto</a>
            <a href="{{ route('juego', 'la-primitiva') }}" class="px-3 py-1.5 rounded-full bg-primi-500 hover:bg-primi-600 text-sm font-medium whitespace-nowrap transition">La Primitiva</a>
            <a href="{{ route('juego', 'el-gordo') }}" class="px-3 py-1.5 rounded-full bg-gordo-500 hover:bg-gordo-600 text-sm font-medium whitespace-nowrap transition">El Gordo</a>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-slate-900 text-slate-500 text-center py-6 mt-auto">
        <p class="text-sm">&copy; {{ date('Y') }} BotesHoy.com - Resultados de loterías españolas</p>
    </footer>
</body>
</html>
