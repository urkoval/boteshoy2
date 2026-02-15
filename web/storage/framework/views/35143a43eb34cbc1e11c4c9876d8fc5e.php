<?php $__env->startSection('title', 'Resultados Loterías España Hoy'); ?>
<?php $__env->startSection('description', 'Consulta los últimos resultados de Euromillones, Bonoloto, La Primitiva y El Gordo de la Primitiva. Números ganadores y premios actualizados.'); ?>

<?php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'border' => 'border-euro-500', 'text' => 'text-euro-500', 'ball' => 'bg-blue-600'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'border' => 'border-bono-500', 'text' => 'text-bono-500', 'ball' => 'bg-red-600'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'border' => 'border-primi-500', 'text' => 'text-primi-500', 'ball' => 'bg-emerald-600'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'border' => 'border-gordo-500', 'text' => 'text-gordo-500', 'ball' => 'bg-purple-600'],
];
?>

<?php $__env->startSection('content'); ?>
<?php if(!empty($boteDestacado)): ?>
<section class="mb-8">
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-6 py-5 text-white">
            <div class="text-xs text-white/70">Bote destacado</div>
            <div class="mt-1 flex items-end justify-between gap-4">
                <div>
                    <div class="text-2xl font-extrabold"><?php echo e($boteDestacado['nombre']); ?></div>
                    <div class="text-sm text-white/80">Próximo sorteo: <?php echo e($boteDestacado['fecha_sorteo']); ?></div>
                </div>
                <div class="text-right">
                    <div class="text-3xl md:text-4xl font-extrabold"><?php echo e(number_format($boteDestacado['bote_eur'], 0, ',', '.')); ?> €</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Juegos Principales -->
<div class="grid gap-6 md:grid-cols-2 mb-8">
    <?php $__currentLoopData = $juegos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $juego): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'border' => 'border-gray-500', 'text' => 'text-gray-500', 'ball' => 'bg-gray-600'];
    ?>
    <div class="rounded-xl bg-white shadow-lg overflow-hidden border-t-4 <?php echo e($color['border']); ?>">
        <div class="<?php echo e($color['bg']); ?> px-6 py-4">
            <h2 class="text-xl font-bold text-white"><?php echo e($juego->nombre); ?></h2>
            <?php if($juego->ultimoSorteo): ?>
                <div class="text-sm text-white/80 mt-1">
                    Último sorteo: <?php echo e($juego->ultimoSorteo->fecha->format('d/m/Y')); ?>

                </div>
            <?php endif; ?>
        </div>
        
        <div class="p-6">
            <?php if($juego->ultimoSorteo): ?>
                <div class="flex flex-wrap justify-center gap-2 mb-4">
                    <?php $__currentLoopData = $juego->ultimoSorteo->numeros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($valor !== null && $valor !== ''): ?>
                            <?php if($juego->slug === 'euromillones' && $key >= 5): ?>
                                <span class="ball w-11 h-11 <?php echo e($color['ball']); ?> text-white rounded-full flex items-center justify-center font-bold text-sm" title="Estrella">
                                    <?php echo e($valor); ?>

                                </span>
                            <?php else: ?>
                                <span class="ball w-11 h-11 bg-slate-400 text-white rounded-full flex items-center justify-center font-bold text-sm" title="<?php echo e(ucfirst($key)); ?>">
                                    <?php echo e($valor); ?>

                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($juego->ultimoSorteo->bote): ?>
                    <div class="text-center mb-4">
                        <span class="text-sm text-gray-500">Bote</span>
                        <p class="text-2xl font-bold text-emerald-600">
                            <?php echo e(number_format($juego->ultimoSorteo->bote, 0, ',', '.')); ?> €
                        </p>
                    </div>
                <?php endif; ?>

                <a href="<?php echo e(route('sorteo', [$juego->slug, $juego->ultimoSorteo->fecha->format('Y-m-d')])); ?>" 
                   class="block text-center <?php echo e($color['text']); ?> font-medium hover:underline">
                    Ver detalles →
                </a>
            <?php else: ?>
                <p class="text-gray-400 italic text-center py-8">Sin sorteos disponibles</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Sección Educativa -->
<section class="mt-12">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Guías por Juego</h2>

    <div class="grid gap-6 md:grid-cols-2">
        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-euro-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Euromillones</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="<?php echo e(route('juego.guia', 'euromillones')); ?>" class="text-blue-600 hover:underline">Como se juega a Euromillones</a></li>
                <li><a href="<?php echo e(route('juego.guia', 'euromillones')); ?>" class="text-blue-600 hover:underline">Premios y probabilidades de Euromillones</a></li>
                <li><a href="<?php echo e(route('juego.guia', 'euromillones')); ?>" class="text-blue-600 hover:underline">Que son las estrellas en Euromillones</a></li>
                <li><a href="<?php echo e(route('juego', 'euromillones')); ?>" class="text-blue-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>

        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-bono-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Bonoloto</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="<?php echo e(route('juego.guia', 'bonoloto')); ?>" class="text-red-600 hover:underline">Como se juega a Bonoloto</a></li>
                <li><a href="<?php echo e(route('juego.guia', 'bonoloto')); ?>" class="text-red-600 hover:underline">Premios y probabilidades de Bonoloto</a></li>
                <li><a href="<?php echo e(route('juego.guia', 'bonoloto')); ?>" class="text-red-600 hover:underline">Reintegro y complementario en Bonoloto</a></li>
                <li><a href="<?php echo e(route('juego', 'bonoloto')); ?>" class="text-red-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>

        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-primi-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">La Primitiva</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="<?php echo e(route('juego.guia', 'la-primitiva')); ?>" class="text-emerald-600 hover:underline">Como se juega a La Primitiva</a></li>
                <li><a href="<?php echo e(route('juego.guia', 'la-primitiva')); ?>" class="text-emerald-600 hover:underline">Premios y probabilidades de La Primitiva</a></li>
                <li><a href="<?php echo e(route('juego.guia', 'la-primitiva')); ?>" class="text-emerald-600 hover:underline">Reintegro y complementario en La Primitiva</a></li>
                <li><a href="<?php echo e(route('juego', 'la-primitiva')); ?>" class="text-emerald-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>

        <article class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-gordo-500">
            <h3 class="text-lg font-bold text-slate-800 mb-4">El Gordo de la Primitiva</h3>
            <ul class="space-y-2 text-sm text-slate-700">
                <li><a href="<?php echo e(route('juego.guia', 'el-gordo')); ?>" class="text-purple-600 hover:underline">Como se juega a El Gordo de la Primitiva</a></li>
                <li><a href="<?php echo e(route('juego.guia', 'el-gordo')); ?>" class="text-purple-600 hover:underline">Premios y probabilidades de El Gordo</a></li>
                <li><a href="<?php echo e(route('juego.guia', 'el-gordo')); ?>" class="text-purple-600 hover:underline">Como funciona el Numero Clave</a></li>
                <li><a href="<?php echo e(route('juego', 'el-gordo')); ?>" class="text-purple-600 hover:underline">Ver ultimos resultados</a></li>
            </ul>
        </article>
    </div>
</section>

<!-- Enlaces internos estratégicos -->
<div class="bg-gradient-to-r from-slate-50 to-blue-50 rounded-xl p-6 border border-slate-200">
    <h3 class="text-lg font-bold text-slate-800 mb-3">Explora por Juego</h3>
    <div class="grid gap-3 md:grid-cols-2">
        <a href="<?php echo e(route('juego', 'euromillones')); ?>" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-blue-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">Euromillones</div>
                <div class="text-sm text-slate-600">Resultados y guía completa</div>
            </div>
        </a>
        <a href="<?php echo e(route('juego', 'bonoloto')); ?>" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-red-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">Bonoloto</div>
                <div class="text-sm text-slate-600">Sorteos diarios y premios</div>
            </div>
        </a>
        <a href="<?php echo e(route('juego', 'la-primitiva')); ?>" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-emerald-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">La Primitiva</div>
                <div class="text-sm text-slate-600">Historial y jackpots</div>
            </div>
        </a>
        <a href="<?php echo e(route('juego', 'el-gordo')); ?>" class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-shadow">
            <span class="w-3 h-3 bg-purple-600 rounded-full mr-3"></span>
            <div>
                <div class="font-medium text-slate-800">El Gordo</div>
                <div class="text-sm text-slate-600">Números clave y premios</div>
            </div>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Nire unitatea\python\boteshoy2\web\resources\views/home.blade.php ENDPATH**/ ?>