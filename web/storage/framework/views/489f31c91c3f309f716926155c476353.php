<?php
$esJueves = $diaSemana === 'jueves';
$nombreDia = $esJueves ? 'Jueves' : 'Sábado';
$precioDecimo = $esJueves ? 3 : 6;
$primerPremio = $esJueves ? '30.000€' : '60.000€';
?>

<?php $__env->startSection('title'); ?>
Resultado Lotería Nacional <?php echo e($nombreDia); ?> <?php echo e(date('Y')); ?> | Números Premiados
<?php $__env->stopSection(); ?>

<?php $__env->startSection('description'); ?>
Resultados de Lotería Nacional del <?php echo e($nombreDia); ?>. Consulta el primer premio, segundo premio, terminaciones y reintegros. Décimo a <?php echo e($precioDecimo); ?>€, primer premio <?php echo e($primerPremio); ?> por décimo.
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-loteria-500 -mx-4 -mt-8 px-4 py-8 mb-8 text-white">
    <div class="container mx-auto">
        <nav class="text-sm text-white/60 mb-4">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-white">Inicio</a>
            <span class="mx-2">›</span>
            <a href="<?php echo e(route('juego', 'loteria-nacional')); ?>" class="hover:text-white">Lotería Nacional</a>
            <span class="mx-2">›</span>
            <span class="text-white"><?php echo e($nombreDia); ?></span>
        </nav>
        <h1 class="text-3xl font-bold mb-2">Lotería Nacional <?php echo e($nombreDia); ?></h1>
        <p class="text-white/80 text-lg">Resultados de todos los sorteos del <?php echo e($nombreDia); ?></p>
    </div>
</div>

<!-- Info del sorteo -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="text-center p-4 bg-amber-50 rounded-lg">
            <div class="text-sm text-slate-500 uppercase">Precio del décimo</div>
            <div class="text-3xl font-bold text-amber-700"><?php echo e($precioDecimo); ?>€</div>
        </div>
        <div class="text-center p-4 bg-amber-50 rounded-lg">
            <div class="text-sm text-slate-500 uppercase">Primer premio</div>
            <div class="text-3xl font-bold text-amber-700"><?php echo e($primerPremio); ?></div>
            <div class="text-xs text-slate-500">por décimo</div>
        </div>
        <div class="text-center p-4 bg-amber-50 rounded-lg">
            <div class="text-sm text-slate-500 uppercase">Día del sorteo</div>
            <div class="text-3xl font-bold text-amber-700"><?php echo e($nombreDia); ?></div>
        </div>
    </div>
</div>

<!-- Navegación entre días -->
<div class="flex gap-4 mb-6">
    <a href="<?php echo e(route('loteria.jueves')); ?>" 
       class="flex-1 text-center py-3 rounded-lg font-semibold transition-colors <?php echo e($esJueves ? 'bg-loteria-500 text-white' : 'bg-white text-slate-700 hover:bg-slate-100'); ?>">
        Jueves
    </a>
    <a href="<?php echo e(route('loteria.sabado')); ?>" 
       class="flex-1 text-center py-3 rounded-lg font-semibold transition-colors <?php echo e(!$esJueves ? 'bg-loteria-500 text-white' : 'bg-white text-slate-700 hover:bg-slate-100'); ?>">
        Sábado
    </a>
</div>

<!-- Lista de sorteos -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-bold text-slate-800">Últimos resultados - <?php echo e($nombreDia); ?></h2>
    </div>
    
    <?php if($sorteos->isEmpty()): ?>
        <div class="p-8 text-center text-slate-500">
            No hay sorteos disponibles para este día.
        </div>
    <?php else: ?>
        <div class="divide-y divide-slate-100">
            <?php $__currentLoopData = $sorteos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sorteo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $comp = $sorteo->complementarios ?? [];
                    $primerPremioNum = $comp['primer_premio'] ?? null;
                    $segundoPremioNum = $comp['segundo_premio'] ?? null;
                    $reintegros = $comp['reintegros'] ?? [];
                ?>
                <a href="<?php echo e(route('sorteo', ['slug' => $juego->slug, 'fecha' => $sorteo->fecha->format('Y-m-d')])); ?>" 
                   class="block p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="text-center min-w-[80px]">
                                <div class="text-sm text-slate-500"><?php echo e($sorteo->fecha->translatedFormat('D')); ?></div>
                                <div class="text-lg font-bold text-slate-800"><?php echo e($sorteo->fecha->format('d/m/Y')); ?></div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-4">
                            <?php if($primerPremioNum): ?>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500">1º</span>
                                <span class="px-3 py-1.5 bg-amber-700 text-white rounded-lg font-bold text-lg tracking-wider">
                                    <?php echo e($primerPremioNum); ?>

                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($segundoPremioNum): ?>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500">2º</span>
                                <span class="px-3 py-1.5 bg-amber-600 text-white rounded-lg font-bold text-lg tracking-wider">
                                    <?php echo e($segundoPremioNum); ?>

                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if(!empty($reintegros)): ?>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500">R</span>
                                <div class="flex gap-1">
                                    <?php $__currentLoopData = $reintegros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                        <?php echo e($r); ?>

                                    </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="text-amber-600 font-medium text-sm">
                            Ver detalles →
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="p-4 border-t border-slate-200">
            <?php echo e($sorteos->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Info SEO -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Lotería Nacional del <?php echo e($nombreDia); ?></h2>
    
    <?php if($esJueves): ?>
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
    <?php else: ?>
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
    <?php endif; ?>
</div>

<!-- FAQs -->
<section class="bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes</h2>

    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto cuesta un décimo de Lotería Nacional del <?php echo e($nombreDia); ?>?</summary>
            <div class="mt-2 text-slate-600">
                El décimo de Lotería Nacional del <?php echo e($nombreDia); ?> cuesta <?php echo e($precioDecimo); ?>€. Un billete completo (10 décimos) cuesta <?php echo e($precioDecimo * 10); ?>€.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto es el primer premio del <?php echo e($nombreDia); ?>?</summary>
            <div class="mt-2 text-slate-600">
                El primer premio de Lotería Nacional del <?php echo e($nombreDia); ?> es de <?php echo e($primerPremio); ?> por décimo, lo que equivale a <?php echo e($esJueves ? '300.000€' : '600.000€'); ?> por billete completo.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿A qué hora es el sorteo del <?php echo e($nombreDia); ?>?</summary>
            <div class="mt-2 text-slate-600">
                El sorteo de Lotería Nacional del <?php echo e($nombreDia); ?> se celebra a las <?php echo e($esJueves ? '21:30h' : '13:00h'); ?>.
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Nire unitatea\python\boteshoy2\web\resources\views/juego-loteria-dia.blade.php ENDPATH**/ ?>