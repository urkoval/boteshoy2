<?php if($contenido && $contenido->head_extra): ?>
<?php $__env->startPush('head'); ?>
<?php echo $contenido->head_extra; ?>

<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php $__env->startSection('title'); ?>
<?php if($juego->slug === 'euromillones'): ?>
    <?php echo e($contenido?->seo_title ?? "Combinación Ganadora Euromillones | Cómo Comprobar y Qué Hacer si Ganas"); ?>

<?php elseif($juego->slug === 'la-primitiva'): ?>
    <?php echo e($contenido?->seo_title ?? "Combinación Ganadora Primitiva con Reintegro | Cómo Saber si He Ganado"); ?>

<?php else: ?>
    <?php echo e($contenido?->seo_title ?? "Combinación Ganadora {$juego->nombre} | Cómo Saber si Has Ganado"); ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('description'); ?>
<?php if($juego->slug === 'euromillones'): ?>
    <?php echo e($contenido?->meta_description ?? "Aprende cómo comprobar la combinación ganadora de Euromillones: qué números y estrellas buscar, dónde verificar resultados, impuestos y qué hacer si tienes premio."); ?>

<?php elseif($juego->slug === 'la-primitiva'): ?>
    <?php echo e($contenido?->meta_description ?? "Descubre cómo funciona la combinación ganadora de La Primitiva: 6 números, complementario y reintegro. Dónde comprobar, cómo cobrar premios y fiscalidad."); ?>

<?php else: ?>
    <?php echo e($contenido?->meta_description ?? "Aprende cómo comprobar la combinación ganadora de {$juego->nombre}: qué números buscar, dónde verificar y qué hacer si tienes premio."); ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php
$structuredData = [
    "@context" => "https://schema.org",
    "@type" => "HowTo",
    "name" => $juego->slug === 'euromillones' ? "Cómo comprobar la combinación ganadora de Euromillones" : 
            ($juego->slug === 'la-primitiva' ? "Cómo comprobar la combinación ganadora de La Primitiva" : 
            "Cómo comprobar la combinación ganadora de " . $juego->nombre),
    "description" => $juego->slug === 'euromillones' ? 
        "Guía paso a paso para comprobar si has ganado en Euromillones, incluyendo cómo verificar números y estrellas, y qué hacer si tienes premio" :
        ($juego->slug === 'la-primitiva' ? 
        "Aprende a comprobar la combinación ganadora de La Primitiva, incluyendo reintegro, complementario y cómo cobrar premios" :
        "Guía completa para comprobar la combinación ganadora de " . $juego->nombre . " y cobrar premios"),
    "image" => url("images/{$juego->slug}-combinacion-ganadora.jpg"),
    "totalTime" => "PT5M",
    "supply" => [
        [
            "@type" => "HowToSupply",
            "name" => "Boleto de " . $juego->nombre
        ]
    ],
    "tool" => [
        [
            "@type" => "HowToTool",
            "name" => "Resultados oficiales de " . $juego->nombre
        ]
    ],
    "step" => [
        [
            "@type" => "HowToStep",
            "name" => "Busca resultados oficiales",
            "text" => "Consulta la combinación ganadora oficial en fuentes fiables"
        ],
        [
            "@type" => "HowToStep", 
            "name" => "Compara tus números",
            "text" => $juego->slug === 'euromillones' ? 
                "Compara tus 5 números y 2 estrellas con los premiados" :
                "Compara tus 6 números con los premiados"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Verifica complementarios",
            "text" => $juego->slug === 'euromillones' ? 
                "No hay complementarios en Euromillones" :
                "Comprueba complementario y reintegro si aplica"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Consulta tabla de premios",
            "text" => "Verifica qué categoría de premio has ganado según tus aciertos"
        ],
        [
            "@type" => "HowToStep",
            "name" => "Cobra tu premio",
            "text" => "Sigue los pasos para cobrar tu premio según el importe"
        ]
    ]
];
?>

<?php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'border' => 'border-euro-500', 'text' => 'text-euro-500', 'ball' => 'bg-blue-600'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'border' => 'border-bono-500', 'text' => 'text-bono-500', 'ball' => 'bg-red-600'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'border' => 'border-primi-500', 'text' => 'text-primi-500', 'ball' => 'bg-emerald-600'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'border' => 'border-gordo-500', 'text' => 'text-gordo-500', 'ball' => 'bg-purple-600'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'border' => 'border-gray-500', 'text' => 'text-gray-500', 'ball' => 'bg-gray-600'];
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
            Combinación Ganadora Euromillones
        <?php elseif($juego->slug === 'la-primitiva'): ?>
            Combinación Ganadora Primitiva
        <?php else: ?>
            Combinación Ganadora de <?php echo e($juego->nombre); ?>

        <?php endif; ?>
    </h1>
    <p class="text-white/90 mt-2">
        <?php if($juego->slug === 'euromillones'): ?>
            Aprende qué es y cómo comprobar si has ganado en Euromillones
        <?php elseif($juego->slug === 'la-primitiva'): ?>
            Guía para comprobar la combinación ganadora con reintegro
        <?php else: ?>
            Aprende qué es y cómo comprobar si has ganado
        <?php endif; ?>
    </p>
</div>

<?php if($ultimoSorteo): ?>
<section class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl shadow-lg p-6 mb-8 border-2 border-amber-200">
    <div class="flex items-center gap-2 mb-4">
        <span class="text-2xl">🏆</span>
        <h2 class="text-xl font-bold text-amber-900">Última Combinación Ganadora</h2>
    </div>
    <p class="text-sm text-amber-800 mb-4">Sorteo del <?php echo e($ultimoSorteo->fecha->format('d/m/Y')); ?></p>
    
    <div class="bg-white rounded-lg p-4 mb-4">
        <div class="flex flex-wrap gap-2 justify-center">
            <?php $__currentLoopData = $ultimoSorteo->numeros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $numero): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="<?php echo e($color['ball']); ?> text-white font-bold rounded-full w-12 h-12 flex items-center justify-center text-lg">
                    <?php echo e($numero); ?>

                </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <?php if($juego->slug === 'euromillones' && isset($ultimoSorteo->complementarios['estrellas'])): ?>
            <div class="mt-4 pt-4 border-t border-slate-200">
                <p class="text-xs text-slate-600 mb-2 text-center">Estrellas</p>
                <div class="flex gap-2 justify-center">
                    <?php $__currentLoopData = $ultimoSorteo->complementarios['estrellas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estrella): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="bg-yellow-400 text-yellow-900 font-bold rounded-full w-10 h-10 flex items-center justify-center">
                            ⭐<?php echo e($estrella); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if(in_array($juego->slug, ['bonoloto', 'la-primitiva', 'el-gordo'])): ?>
            <div class="mt-4 pt-4 border-t border-slate-200 grid grid-cols-2 gap-4 text-sm">
                <?php if(isset($ultimoSorteo->complementarios['complementario'])): ?>
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Complementario</p>
                        <span class="bg-slate-200 text-slate-800 font-bold rounded-full w-10 h-10 inline-flex items-center justify-center">
                            <?php echo e($ultimoSorteo->complementarios['complementario']); ?>

                        </span>
                    </div>
                <?php endif; ?>
                <?php if(isset($ultimoSorteo->complementarios['reintegro'])): ?>
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Reintegro</p>
                        <span class="bg-slate-200 text-slate-800 font-bold rounded-full w-10 h-10 inline-flex items-center justify-center">
                            <?php echo e($ultimoSorteo->complementarios['reintegro']); ?>

                        </span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="text-center">
        <a href="<?php echo e(route('juego', $juego->slug)); ?>" class="<?php echo e($color['bg']); ?> text-white px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-opacity inline-block">
            Ver Todos los Resultados →
        </a>
    </div>
</section>
<?php endif; ?>

<section class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-slate-800 mb-6">¿Qué es la Combinación Ganadora de <?php echo e($juego->nombre); ?>?</h2>
    
    <div class="prose max-w-none">
        <p class="text-slate-700 mb-4">
            <?php if($juego->slug === 'euromillones'): ?>
                La combinación ganadora de Euromillones consiste en 5 números principales (del 1 al 50) y 2 estrellas (del 1 al 12) que se extraen en cada sorteo. Para ganar el premio mayor (bote), debes acertar los 7 números: los 5 principales + las 2 estrellas.
            <?php elseif($juego->slug === 'la-primitiva'): ?>
                La combinación ganadora de La Primitiva está formada por 6 números principales (del 1 al 49), un número complementario y un reintegro (del 0 al 9). Para ganar el bote necesitas acertar los 6 números principales, pero hay muchas categorías de premios.
            <?php else: ?>
                La combinación ganadora es el conjunto de números que resultan del sorteo oficial de <?php echo e($juego->nombre); ?>. Para ganar el premio mayor, debes acertar todos estos números.
            <?php endif; ?>
        </p>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Componentes de la Combinación</h3>
        
        <?php if($juego->slug === 'euromillones'): ?>
            <div class="space-y-3 mb-6">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                    <h4 class="font-semibold text-blue-900 mb-2">5 Números Principales (1-50)</h4>
                    <p class="text-sm text-blue-800">Los 5 números principales que se extraen en el sorteo. Debes acertar estos 5 para optar al premio mayor.</p>
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                    <h4 class="font-semibold text-yellow-900 mb-2">2 Estrellas (1-12)</h4>
                    <p class="text-sm text-yellow-800">Dos números adicionales que se extraen de un bombo separado. Necesitas acertar ambas estrellas además de los 5 números para ganar el bote.</p>
                </div>
            </div>
        <?php elseif(in_array($juego->slug, ['bonoloto', 'la-primitiva', 'el-gordo'])): ?>
            <div class="space-y-3 mb-6">
                <div class="<?php echo e($color['bg']); ?>/10 border-l-4 <?php echo e($color['border']); ?> p-4">
                    <h4 class="font-semibold text-slate-900 mb-2">6 Números Principales (1-49)</h4>
                    <p class="text-sm text-slate-700">Los 6 números que se extraen en el sorteo. Debes acertar estos 6 para ganar el premio mayor.</p>
                </div>
                <div class="bg-slate-50 border-l-4 border-slate-400 p-4">
                    <h4 class="font-semibold text-slate-900 mb-2">Complementario</h4>
                    <p class="text-sm text-slate-700">Un séptimo número que se extrae. Solo se usa para la categoría de 5 aciertos + complementario.</p>
                </div>
                <div class="bg-slate-50 border-l-4 border-slate-400 p-4">
                    <h4 class="font-semibold text-slate-900 mb-2">Reintegro (0-9)</h4>
                    <p class="text-sm text-slate-700">Un número del 0 al 9. Si aciertas solo el reintegro, recuperas el importe de la apuesta.</p>
                </div>
            </div>
        <?php endif; ?>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Cómo Comprobar tu Boleto</h3>
        <ol class="list-decimal list-inside space-y-3 text-slate-700 mb-6">
            <li>
                <strong>Consulta la combinación ganadora oficial</strong>
                <p class="ml-6 text-sm text-slate-600 mt-1">Puedes verla en esta web, en la web oficial de Loterías y Apuestas del Estado, o en medios de comunicación.</p>
            </li>
            <li>
                <strong>Compara tus números con los premiados</strong>
                <p class="ml-6 text-sm text-slate-600 mt-1">Marca en tu boleto los números que coinciden con la combinación ganadora.</p>
            </li>
            <li>
                <strong>Cuenta tus aciertos</strong>
                <p class="ml-6 text-sm text-slate-600 mt-1">Suma cuántos números principales has acertado. También comprueba números complementarios.</p>
            </li>
            <li>
                <strong>Consulta la tabla de premios</strong>
                <p class="ml-6 text-sm text-slate-600 mt-1">Según tus aciertos, verifica en qué categoría de premio estás y cuánto has ganado.</p>
            </li>
        </ol>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">¿Dónde Ver la Combinación Ganadora Oficial?</h3>
        <div class="space-y-3 mb-6">
            <div class="flex items-start gap-3">
                <span class="text-2xl">🌐</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Web Oficial LAE</h4>
                    <p class="text-sm text-slate-600">Loterías y Apuestas del Estado publica los resultados oficiales inmediatamente tras cada sorteo.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">📱</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Esta Web</h4>
                    <p class="text-sm text-slate-600">Actualizamos los resultados poco después de cada sorteo. <a href="<?php echo e(route('juego', $juego->slug)); ?>" class="<?php echo e($color['text']); ?> hover:underline">Ver resultados</a></p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">📺</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Emisión en Directo</h4>
                    <p class="text-sm text-slate-600">Los sorteos se emiten en directo por la web de RTVE y el canal 24h.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-2xl">🏪</span>
                <div>
                    <h4 class="font-semibold text-slate-800">Administraciones de Loterías</h4>
                    <p class="text-sm text-slate-600">Puedes llevar tu boleto a cualquier administración para que lo comprueben.</p>
                </div>
            </div>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">¿Qué Hacer Si Has Acertado?</h3>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <h4 class="font-semibold text-green-900 mb-3">Pasos a seguir:</h4>
            <ol class="list-decimal list-inside space-y-2 text-sm text-green-800">
                <li><strong>Firma el boleto</strong> por la parte de atrás para que nadie más pueda cobrarlo</li>
                <li><strong>Guarda el boleto en lugar seguro</strong> hasta que lo cobres</li>
                <li><strong>Premios hasta 2.000€:</strong> Se cobran en cualquier administración de loterías</li>
                <li><strong>Premios superiores a 2.000€:</strong> Debes cobrarlos en una entidad bancaria autorizada</li>
                <li><strong>Tienes 3 meses</strong> desde el día siguiente al sorteo para cobrar el premio</li>
            </ol>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Impuestos en Premios</h3>
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6">
            <p class="text-sm text-amber-900 mb-2">
                <strong>Premios hasta 40.000€:</strong> Exentos de impuestos (pagas 0€ a Hacienda)
            </p>
            <p class="text-sm text-amber-900">
                <strong>Premios superiores a 40.000€:</strong> Se aplica un 20% de retención sobre la cantidad que exceda los 40.000€. La retención se descuenta automáticamente al cobrar.
            </p>
        </div>

        <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Diferencia: Combinación Ganadora vs Premios Menores</h3>
        <p class="text-slate-700 mb-4">
            No hace falta acertar toda la combinación ganadora para ganar un premio. <?php echo e($juego->nombre); ?> tiene múltiples categorías de premios:
        </p>

        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border border-slate-200 text-sm">
                <thead class="<?php echo e($color['bg']); ?> text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Categoría</th>
                        <th class="px-4 py-2 text-left">Aciertos necesarios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($juego->slug === 'euromillones'): ?>
                        <tr class="border-t border-slate-200 bg-yellow-50">
                            <td class="px-4 py-2 font-semibold">1ª Categoría (Bote)</td>
                            <td class="px-4 py-2">5 números + 2 estrellas</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">2ª Categoría</td>
                            <td class="px-4 py-2">5 números + 1 estrella</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">3ª Categoría</td>
                            <td class="px-4 py-2">5 números</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">...</td>
                            <td class="px-4 py-2">Y así hasta 13 categorías</td>
                        </tr>
                    <?php else: ?>
                        <tr class="border-t border-slate-200 bg-yellow-50">
                            <td class="px-4 py-2 font-semibold">1ª Categoría (Bote)</td>
                            <td class="px-4 py-2">6 números</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">2ª Categoría</td>
                            <td class="px-4 py-2">5 números + complementario</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">3ª Categoría</td>
                            <td class="px-4 py-2">5 números</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">...</td>
                            <td class="px-4 py-2">Y así hasta reintegro</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="<?php echo e($color['bg']); ?> rounded-xl p-8 mb-8 text-center">
    <h2 class="text-2xl font-bold text-white mb-4">¿Quieres Comprobar tus Boletos?</h2>
    <p class="text-white/90 mb-6">Consulta todos los resultados y premios de <?php echo e($juego->nombre); ?></p>
    <a href="<?php echo e(route('juego', $juego->slug)); ?>" class="bg-white <?php echo e($color['text']); ?> px-8 py-4 rounded-lg font-bold hover:shadow-lg transition-shadow inline-block text-lg">
        Ver Últimos Resultados de <?php echo e($juego->nombre); ?> →
    </a>
</section>

<section class="bg-slate-50 rounded-xl p-6 mb-8">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Más Información</h2>
    <div class="grid md:grid-cols-2 gap-3">
        <a href="<?php echo e(route('juego.guia', $juego->slug)); ?>" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-1">📖 Guía Completa</h3>
            <p class="text-sm text-slate-600">Aprende cómo se juega a <?php echo e($juego->nombre); ?></p>
        </a>
        <a href="<?php echo e(route('juego.apuestas-multiples', $juego->slug)); ?>" class="bg-white p-4 rounded-lg hover:shadow-md transition-shadow">
            <h3 class="font-bold text-slate-800 mb-1">🎯 Apuestas Múltiples</h3>
            <p class="text-sm text-slate-600">Aumenta tus probabilidades</p>
        </a>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Nire unitatea\python\boteshoy2\web\resources\views/juego-combinacion-ganadora.blade.php ENDPATH**/ ?>