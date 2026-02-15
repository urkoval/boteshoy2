<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Resultados Loterías España'); ?> | Boteshoy</title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Resultados de loterías españolas: Euromillones, Bonoloto, La Primitiva y El Gordo. Consulta los últimos sorteos y premios.'); ?>">
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
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="icon" href="/favicon.ico">
    
    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen flex flex-col">
    <header class="bg-gradient-to-r from-slate-800 to-slate-900 text-white shadow-lg">
        <div class="container mx-auto px-4 py-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-baseline gap-2">
                    <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold tracking-tight">
                        <span class="text-yellow-400">Botes</span>Hoy
                    </a>
                    <span class="text-slate-400 text-sm hidden sm:inline">Resultados de loterías</span>
                </div>

                <?php if(!empty($botesHeader)): ?>
                    <div class="flex gap-2 overflow-x-auto md:overflow-visible pb-1">
                        <?php $__currentLoopData = $botesHeader; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('juego', $b['slug'])); ?>" class="shrink-0 rounded-full <?php echo e($b['classes']['bg']); ?> border <?php echo e($b['classes']['border']); ?> px-3 py-2 hover:opacity-90 transition">
                                <div class="text-[11px] text-white/70"><?php echo e($b['nombre']); ?></div>
                                <div class="text-sm font-extrabold"><?php echo e(number_format($b['bote_eur'], 0, ',', '.')); ?> €</div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <nav class="bg-slate-700 text-white shadow">
        <div class="container mx-auto px-4 py-3 flex gap-2 sm:gap-4 overflow-x-auto">
            <a href="<?php echo e(route('juego', 'euromillones')); ?>" class="px-3 py-1.5 rounded-full bg-euro-500 hover:bg-euro-600 text-sm font-medium whitespace-nowrap transition">Euromillones</a>
            <a href="<?php echo e(route('juego', 'bonoloto')); ?>" class="px-3 py-1.5 rounded-full bg-bono-500 hover:bg-bono-600 text-sm font-medium whitespace-nowrap transition">Bonoloto</a>
            <a href="<?php echo e(route('juego', 'la-primitiva')); ?>" class="px-3 py-1.5 rounded-full bg-primi-500 hover:bg-primi-600 text-sm font-medium whitespace-nowrap transition">La Primitiva</a>
            <a href="<?php echo e(route('juego', 'el-gordo')); ?>" class="px-3 py-1.5 rounded-full bg-gordo-500 hover:bg-gordo-600 text-sm font-medium whitespace-nowrap transition">El Gordo</a>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 flex-grow">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-slate-900 text-slate-500 text-center py-6 mt-auto">
        <p class="text-sm">&copy; <?php echo e(date('Y')); ?> BotesHoy.com - Resultados de loterías españolas</p>
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
    <?php if(request()->is('admin/*')): ?>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <?php endif; ?>
</body>
</html>
<?php /**PATH G:\Nire unitatea\python\boteshoy2\web\resources\views/layouts/app.blade.php ENDPATH**/ ?>