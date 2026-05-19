<?php if($contenido && $contenido->head_extra): ?>
<?php $__env->startPush('head'); ?>
<?php echo $contenido->head_extra; ?>

<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startSection('title'); ?>
<?php if($juego->slug === 'euromillones'): ?>
    <?php echo e($contenido?->seo_title ?? "Apuestas Múltiples Euromillones: Cómo Jugar, Costes y Ejemplos 2026"); ?>

<?php elseif($juego->slug === 'bonoloto'): ?>
    <?php echo e($contenido?->seo_title ?? "Apuestas Múltiples Bonoloto Baratas: Coste Real y Cómo Hacerlas"); ?>

<?php elseif($juego->slug === 'la-primitiva'): ?>
    <?php echo e($contenido?->seo_title ?? "Apuestas Múltiples Primitiva: Sistemas, Costes y Estrategias 2026"); ?>

<?php elseif($juego->slug === 'el-gordo'): ?>
    <?php echo e($contenido?->seo_title ?? "Apuestas Múltiples El Gordo: Cómo Funcionan y Cuánto Cuestan"); ?>

<?php elseif($juego->slug === 'eurodreams'): ?>
    <?php echo e($contenido?->seo_title ?? "Apuestas Múltiples Eurodreams: Guía Completa y Costes 2026"); ?>

<?php else: ?>
    <?php echo e($contenido?->seo_title ?? "Apuestas Múltiples en {$juego->nombre} | Cómo Funcionan y Cuánto Cuestan"); ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('description'); ?>
<?php if($juego->slug === 'euromillones'): ?>
    <?php echo e($contenido?->meta_description ?? "Aprende cómo hacer apuestas múltiples en Euromillones paso a paso. Tabla de costes actualizada, ejemplos prácticos de 6 a 11 números y calculadora de combinaciones."); ?>

<?php elseif($juego->slug === 'bonoloto'): ?>
    <?php echo e($contenido?->meta_description ?? "Apuestas múltiples en Bonoloto explicadas: tabla de costes desde 3,50€, ejemplos de 7 a 11 números y cómo rellenar el boleto múltiple paso a paso."); ?>

<?php elseif($juego->slug === 'la-primitiva'): ?>
    <?php echo e($contenido?->meta_description ?? "Guía completa de apuestas múltiples en La Primitiva: costes reales por número (7€ a 693€), sistemas múltiples y estrategias para maximizar probabilidades."); ?>

<?php elseif($juego->slug === 'el-gordo'): ?>
    <?php echo e($contenido?->meta_description ?? "Cómo hacer apuestas múltiples en El Gordo de la Primitiva: tabla de costes, combinaciones posibles y ejemplos prácticos para jugar más números."); ?>

<?php elseif($juego->slug === 'eurodreams'): ?>
    <?php echo e($contenido?->meta_description ?? "Apuestas múltiples en Eurodreams: cómo jugar más números y Número Dream, tabla de costes y ejemplos para aumentar tus probabilidades."); ?>

<?php else: ?>
    <?php echo e($contenido?->meta_description ?? "Aprende cómo hacer apuestas múltiples en {$juego->nombre}: qué son, ventajas, coste y cómo rellenar el boleto."); ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php
$structuredData = [
    "@context" => "https://schema.org",
    "@type" => "HowTo",
    "name" => $juego->slug === 'euromillones' ? "Cómo hacer apuestas múltiples en Euromillones" : 
            ($juego->slug === 'bonoloto' ? "Cómo hacer apuestas múltiples en Bonoloto" : 
            "Cómo hacer apuestas múltiples en " . $juego->nombre),
    "description" => $juego->slug === 'euromillones' ? 
        "Guía paso a paso para hacer apuestas múltiples en Euromillones, incluyendo costes, ejemplos y estrategias" :
        ($juego->slug === 'bonoloto' ? 
        "Aprende a hacer apuestas múltiples en Bonoloto con ejemplos prácticos y tablas de costes" :
        "Guía completa para hacer apuestas múltiples en " . $juego->nombre),
    "image" => url("images/{$juego->slug}-apuestas-multiples.jpg"),
    "totalTime" => "PT10M",
    "supply" => [
        [
            "@type" => "HowToSupply",
            "name" => "Boleto oficial de " . $juego->nombre
        ],
        [
            "@type" => "HowToSupply", 
            "name" => "Bolígrafo o marcador"
        ]
    ],
    "tool" => [
        [
            "@type" => "HowToTool",
            "name" => "Calculadora de apuestas múltiples"
        ]
    ],
    "step" => [
        [
            "@type" => "HowToStep",
            "name" => "Selecciona más números",
            "text" => $juego->slug === 'euromillones' ? 
                "Marca más de 5 números y más de 2 estrellas en el boleto" :
                ($juego->slug === 'el-gordo' ? 
                "Marca más de 5 números en el boleto (6, 7, 8, 9 o 10)" :
                "Marca más de 6 números en el boleto (7, 8, 9, 10 u 11)")
        ],
        [
            "@type" => "HowToStep", 
            "name" => "Marca apuesta múltiple",
            "text" => "Activa la casilla de apuesta múltiple en tu boleto"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Verifica el coste",
            "text" => "El sistema mostrará el coste total según las combinaciones generadas"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Paga y conserva",
            "text" => "Paga el importe y guarda tu boleto para el sorteo"
        ]
    ]
];
?>

<?php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'border' => 'border-euro-500', 'text' => 'text-euro-500'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'border' => 'border-bono-500', 'text' => 'text-bono-500'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'border' => 'border-primi-500', 'text' => 'text-primi-500'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'border' => 'border-gordo-500', 'text' => 'text-gordo-500'],
    'eurodreams' => ['bg' => 'bg-dream-500', 'border' => 'border-dream-500', 'text' => 'text-dream-500'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'border' => 'border-gray-500', 'text' => 'text-gray-500'];
?>

<?php $__env->startSection('content'); ?>
<script type="application/ld+json">
<?php echo json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>

</script>
<div class="mb-6">
    <a href="<?php echo e(route('juego.guia', $juego->slug)); ?>" class="<?php echo e($color['text']); ?> font-medium hover:underline inline-flex items-center gap-1">
        <span>←</span> Volver a la guía de <?php echo e($juego->nombre); ?>

    </a>
</div>

<div class="<?php echo e($color['bg']); ?> rounded-xl shadow-lg p-6 mb-8">
    <h1 class="text-3xl font-bold text-white">
        <?php if($juego->slug === 'euromillones'): ?>
            <?php echo e($contenido?->h1_principal ?? "Cómo Hacer Apuestas Múltiples en Euromillones"); ?>

        <?php elseif($juego->slug === 'bonoloto'): ?>
            <?php echo e($contenido?->h1_principal ?? "Apuestas Múltiples Bonoloto: Guía Completa"); ?>

        <?php elseif($juego->slug === 'la-primitiva'): ?>
            <?php echo e($contenido?->h1_principal ?? "Apuestas Múltiples en La Primitiva"); ?>

        <?php elseif($juego->slug === 'el-gordo'): ?>
            <?php echo e($contenido?->h1_principal ?? "Apuestas Múltiples en el Gordo"); ?>

        <?php else: ?>
            <?php echo e($contenido?->h1_principal ?? "Apuestas Múltiples en {$juego->nombre}"); ?>

        <?php endif; ?>
    </h1>
    <p class="text-white/90 mt-2">
        <?php if($juego->slug === 'euromillones'): ?>
            Juega más números y estrellas para aumentar tus probabilidades en Euromillones
        <?php elseif($juego->slug === 'bonoloto'): ?>
            Sistema económico para jugar más combinaciones en Bonoloto
        <?php elseif($juego->slug === 'la-primitiva'): ?>
            Aumenta tus posibilidades de acertar con múltiples combinaciones
        <?php elseif($juego->slug === 'el-gordo'): ?>
            Juega más números y optimiza tus apuestas en el Gordo
        <?php else: ?>
            Juega más números y aumenta tus probabilidades de ganar
        <?php endif; ?>
    </p>
</div>

<?php if($contenido && $contenido->contenido_html): ?>
    <section class="bg-white rounded-xl shadow-md p-6 mb-8">
        <?php echo $contenido->contenido_html; ?>

    </section>
<?php else: ?>
    <!-- Contenido fallback -->
    <section class="bg-white rounded-xl shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">¿Qué es una Apuesta Múltiple en <?php echo e($juego->nombre); ?>?</h2>
        
        <div class="prose max-w-none">
            <p class="text-slate-700 mb-4">
                <?php if($juego->slug === 'euromillones'): ?>
                    Una apuesta múltiple en Euromillones te permite seleccionar más de 5 números principales y más de 2 estrellas, generando automáticamente todas las combinaciones posibles. Esto aumenta significativamente tus probabilidades de ganar cualquier premio.
                <?php elseif($juego->slug === 'bonoloto'): ?>
                    Una apuesta múltiple en Bonoloto te permite jugar más de 6 números en un mismo boleto, generando automáticamente todas las combinaciones posibles de 6 números. Es la forma más económica de jugar múltiples combinaciones.
                <?php elseif($juego->slug === 'la-primitiva'): ?>
                    Una apuesta múltiple en La Primitiva te permite seleccionar más de 6 números, generando todas las combinaciones posibles de 6 números. Con el reintegro, tienes más oportunidades de recuperar tu inversión.
                <?php elseif($juego->slug === 'el-gordo'): ?>
                    Una apuesta múltiple en el Gordo de la Primitiva te permite jugar más de 5 números, generando todas las combinaciones posibles de 5 números. Aumenta tus probabilidades de ganar el bote semanal.
                <?php else: ?>
                    Una apuesta múltiple te permite jugar más de 6 números en un mismo boleto, generando automáticamente todas las combinaciones posibles de 6 números.
                <?php endif; ?>
            </p>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-800">
                    <?php if($juego->slug === 'euromillones'): ?>
                        <strong>Ejemplo Euromillones:</strong> Si juegas 6 números + 3 estrellas, se generan 6 combinaciones diferentes. Si juegas 7 números + 2 estrellas, se generan 14 combinaciones.
                    <?php elseif($juego->slug === 'bonoloto'): ?>
                        <strong>Ejemplo Bonoloto:</strong> Si juegas 7 números en múltiple, se generan 7 combinaciones diferentes de 6 números. Si juegas 8 números, se generan 28 combinaciones.
                    <?php elseif($juego->slug === 'la-primitiva'): ?>
                        <strong>Ejemplo Primitiva:</strong> Si juegas 7 números en múltiple, se generan 7 combinaciones. Con 8 números son 28 combinaciones, y con 9 números son 84 combinaciones.
                    <?php elseif($juego->slug === 'el-gordo'): ?>
                        <strong>Ejemplo Gordo:</strong> Si juegas 6 números, se generan 6 combinaciones. Con 8 números son 56 combinaciones, y con 10 números llegarías a 252 combinaciones.
                    <?php else: ?>
                        <strong>Ejemplo:</strong> Si juegas 7 números en múltiple, se generan 7 combinaciones diferentes de 6 números. Si juegas 8 números, se generan 28 combinaciones.
                    <?php endif; ?>
                </p>
            </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Diferencia con la Apuesta Simple</h3>
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="bg-slate-50 p-4 rounded-lg">
                <h4 class="font-semibold text-slate-800 mb-2">Apuesta Simple</h4>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li>• Seleccionas exactamente <?php echo e($juego->slug === 'el-gordo' ? '5' : '6'); ?> números</li>
                    <li>• Juegas 1 combinación</li>
                    <li>• Coste: <?php echo e($juego->slug === 'bonoloto' ? '0,50€' : ($juego->slug === 'euromillones' ? '2,50€' : '1,50€')); ?></li>
                </ul>
            </div>
            <div class="<?php echo e($color['bg']); ?>/10 p-4 rounded-lg <?php echo e($color['border']); ?> border-l-4">
                <h4 class="font-semibold text-slate-800 mb-2">Apuesta Múltiple</h4>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li>• Seleccionas <?php echo e($juego->slug === 'el-gordo' ? '6' : '7'); ?> o más números</li>
                    <li>• Juegas múltiples combinaciones</li>
                    <li>• Coste: según números seleccionados</li>
                </ul>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Tabla de Costes</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border border-slate-200">
                <thead class="<?php echo e($color['bg']); ?> text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Números jugados</th>
                        <th class="px-4 py-2 text-center">Combinaciones</th>
                        <th class="px-4 py-2 text-right">Coste total</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php
                    $costeBase = $juego->slug === 'bonoloto' ? 0.50 : ($juego->slug === 'euromillones' ? 2.50 : 1.50);
                    // El Gordo tiene combinación base de 5 números, los demás de 6
                    if ($juego->slug === 'el-gordo') {
                        // Combinaciones C(n,5) para El Gordo
                        $combinaciones = [
                            6 => 6,      // C(6,5) = 6
                            7 => 21,     // C(7,5) = 21
                            8 => 56,     // C(8,5) = 56
                            9 => 126,    // C(9,5) = 126
                            10 => 252,   // C(10,5) = 252
                            11 => 462,   // C(11,5) = 462
                        ];
                    } else {
                        // Combinaciones C(n,6) para Bonoloto, Primitiva, etc.
                        $combinaciones = [
                            7 => 7,      // C(7,6) = 7
                            8 => 28,     // C(8,6) = 28
                            9 => 84,     // C(9,6) = 84
                            10 => 210,   // C(10,6) = 210
                            11 => 462,   // C(11,6) = 462
                        ];
                    }
                    ?>
                    <?php $__currentLoopData = $combinaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nums => $combs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-t border-slate-200">
                        <td class="px-4 py-2 font-medium"><?php echo e($nums); ?> números</td>
                        <td class="px-4 py-2 text-center"><?php echo e($combs); ?></td>
                        <td class="px-4 py-2 text-right font-semibold"><?php echo e(number_format($combs * $costeBase, 2)); ?>€</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Ventajas de Jugar en Múltiple</h3>
        <div class="space-y-3 mb-6">
            <div class="flex items-start gap-3">
                <span class="text-2xl">✅</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Más probabilidades</h4>
                    <p class="text-sm text-slate-600">Al jugar más combinaciones, aumentas tus probabilidades de acertar premios.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">🎯</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Comodidad</h4>
                    <p class="text-sm text-slate-600">Marcas los números una sola vez y el sistema genera todas las combinaciones.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">💰</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Premios múltiples</h4>
                    <p class="text-sm text-slate-600">Puedes ganar varios premios en el mismo sorteo si varias combinaciones resultan premiadas.</p>
                </div>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Cómo Rellenar el Boleto</h3>
        <ol class="list-decimal list-inside space-y-2 text-slate-700 mb-6">
            <?php if($juego->slug === 'el-gordo'): ?>
            <li>Marca más de 5 números en el boleto (6, 7, 8, 9 o 10)</li>
            <?php else: ?>
            <li>Marca más de 6 números en el boleto (7, 8, 9, 10 o 11)</li>
            <?php endif; ?>
            <li>Marca la casilla "Múltiple" o "Apuesta Múltiple"</li>
            <li>El sistema calculará automáticamente el coste total</li>
            <li>Paga y conserva tu boleto</li>
        </ol>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">¿Cuándo Conviene Jugar en Múltiple?</h3>
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6">
            <p class="text-amber-900 text-sm">
                <strong>Recomendación:</strong> Las apuestas múltiples son ideales si tienes varios números "favoritos" y quieres asegurarte de jugarlos todos. 
                Ten en cuenta que el coste aumenta rápidamente, así que juega con responsabilidad.
            </p>
        </div>
    </div>
<?php endif; ?>
</section>

<section class="bg-slate-50 rounded-xl p-6 mb-8">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Enlaces Relacionados</h2>
    <div class="grid md:grid-cols-2 gap-3">
        <a href="<?php echo e(route('juego.apuestas-reducidas', $juego->slug)); ?>" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-1">📊 Apuestas Reducidas</h3>
            <p class="text-sm text-slate-600">Juega más números con menor coste</p>
        </a>
        <a href="<?php echo e(route('juego.guia', $juego->slug)); ?>" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-1">📖 Guía Completa</h3>
            <p class="text-sm text-slate-600">Volver a la guía de <?php echo e($juego->nombre); ?></p>
        </a>
        <a href="<?php echo e(route('juego', $juego->slug)); ?>" class="<?php echo e($color['bg']); ?> text-white p-4 rounded-lg hover:opacity-90 transition-opacity">
            <h3 class="font-bold mb-1">🏆 Ver Últimos Resultados</h3>
            <p class="text-sm text-white/90">Resultados y premios recientes</p>
        </a>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Nire unitatea\python\boteshoy2\web\resources\views/juego-apuestas-multiples.blade.php ENDPATH**/ ?>