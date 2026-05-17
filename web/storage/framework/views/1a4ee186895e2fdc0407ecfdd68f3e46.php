<?php $__env->startSection('title'); ?>
Resultados <?php echo e($juego->nombre); ?> Hoy | Último Sorteo y Premios
<?php $__env->stopSection(); ?>

<?php $__env->startSection('description'); ?>
Consulta los últimos resultados de <?php echo e($juego->nombre); ?>. Números ganadores, premios y histórico de sorteos.
<?php $__env->stopSection(); ?>

<?php
$latestSorteo = $sorteos->first();
$latestFechaHuman = $latestSorteo ? $latestSorteo->fecha->format('d/m/Y') : null;

$faqJuego = [
    [
        '@type' => 'Question',
        'name' => "¿Cuál es el último sorteo de {$juego->nombre}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $latestSorteo
                ? "El último sorteo disponible de {$juego->nombre} es el {$latestFechaHuman}."
                : "Aún no hay sorteos disponibles para {$juego->nombre}.",
        ],
    ],
    [
        '@type' => 'Question',
        'name' => "¿Qué días se sortea {$juego->nombre}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Días de sorteo: ' . str_replace(',', ', ', $juego->dias_sorteo) . '.',
        ],
    ],
    [
        '@type' => 'Question',
        'name' => "¿Cuándo caducan los premios de {$juego->nombre}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => "Por norma general, los premios caducan a los 3 meses desde la fecha del sorteo. En cada sorteo mostramos la fecha de caducidad y cuánto falta.",
        ],
    ],
];

$faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqJuego,
];
?>

<?php $__env->startPush('head'); ?>
<script type="application/ld+json"><?php echo json_encode($faqSchema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES, 512) ?></script>
<?php $__env->stopPush(); ?>

<?php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'ball' => 'bg-blue-600'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'ball' => 'bg-red-600'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'ball' => 'bg-emerald-600'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'ball' => 'bg-purple-600'],
    'eurodreams' => ['bg' => 'bg-dream-500', 'ball' => 'bg-cyan-600'],
    'loteria-nacional' => ['bg' => 'bg-loteria-500', 'ball' => 'bg-amber-700'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'ball' => 'bg-gray-600'];
?>

<?php $__env->startSection('content'); ?>
<div class="<?php echo e($color['bg']); ?> -mx-4 -mt-8 px-4 py-8 mb-8 text-white">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-2">Últimos resultados de <?php echo e($juego->nombre); ?></h1>
        <p class="text-white/70">Sorteos: <?php echo e(str_replace(',', ', ', $juego->dias_sorteo)); ?></p>
        <p class="text-white/70 mt-2">
            <?php if($latestSorteo): ?>
                Último sorteo disponible <?php echo e($latestFechaHuman); ?>. Consulta números ganadores, premios y el histórico por fechas.
            <?php else: ?>
                Consulta el histórico por fechas cuando estén disponibles los sorteos.
            <?php endif; ?>
        </p>
    </div>
</div>

<?php if($sorteos->count() > 0): ?>
    <div class="container mx-auto mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Historial de sorteos</h2>
    </div>
    <div class="space-y-3">
        <?php $__currentLoopData = $sorteos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sorteo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('sorteo', [$juego->slug, $sorteo->fecha->format('Y-m-d')])); ?>" 
           class="block bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition border-l-4 <?php echo e(str_replace('bg-', 'border-', $color['ball'])); ?>">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="min-w-[120px]">
                    <p class="font-bold text-slate-800"><?php echo e($sorteo->fecha->format('d/m/Y')); ?></p>
                    <p class="text-sm text-slate-500 capitalize"><?php echo e($sorteo->fecha->translatedFormat('l')); ?></p>
                    <?php
                        $caduca = $sorteo->fecha->copy()->addMonthsNoOverflow(3);
                        $diasCad = now()->startOfDay()->diffInDays($caduca->copy()->startOfDay(), false);
                    ?>
                    <p class="text-xs text-slate-500 mt-1">
                        <?php if($diasCad > 1): ?>
                            Caduca en <?php echo e($diasCad); ?> días (<?php echo e($caduca->format('d/m/Y')); ?>)
                        <?php elseif($diasCad === 1): ?>
                            Caduca en 1 día (<?php echo e($caduca->format('d/m/Y')); ?>)
                        <?php elseif($diasCad === 0): ?>
                            Caduca hoy (<?php echo e($caduca->format('d/m/Y')); ?>)
                        <?php else: ?>
                            Caducado (<?php echo e($caduca->format('d/m/Y')); ?>)
                        <?php endif; ?>
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-1.5 flex-1 justify-center">
                    <?php $__currentLoopData = $sorteo->numeros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $numero): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="ball w-9 h-9 <?php echo e($color['ball']); ?> text-white rounded-full flex items-center justify-center font-bold text-sm">
                            <?php echo e($numero); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if($sorteo->complementarios): ?>
                        <span class="text-gray-300 mx-1">+</span>
                        <?php $__currentLoopData = $sorteo->complementarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(is_array($valor)): ?>
                                <?php $__currentLoopData = $valor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="ball w-9 h-9 bg-amber-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                        <?php echo e($v); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="ball w-9 h-9 bg-slate-400 text-white rounded-full flex items-center justify-center font-bold text-xs">
                                    <?php echo e($valor); ?>

                                </span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                
                <?php if($sorteo->bote): ?>
                    <p class="text-emerald-600 font-bold text-right min-w-[100px]">
                        <?php echo e(number_format($sorteo->bote, 0, ',', '.')); ?> €
                    </p>
                <?php endif; ?>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <div class="mt-8">
        <?php echo e($sorteos->links()); ?>

    </div>
<?php else: ?>
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <p class="text-gray-400 italic">No hay sorteos disponibles todavía.</p>
    </div>
<?php endif; ?>

<!-- CTA a Guía -->
<div class="mt-8 bg-gradient-to-r from-slate-50 to-blue-50 rounded-xl p-6 border border-slate-200">
    <h3 class="text-lg font-bold text-slate-800 mb-2">¿No sabes cómo jugar a <?php echo e($juego->nombre); ?>?</h3>
    <p class="text-slate-600 mb-4">Aprende las reglas, premios, probabilidades y todo lo que necesitas saber.</p>
    <a href="<?php echo e(route('juego.guia', $juego->slug)); ?>" class="<?php echo e($color['bg']); ?> text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 inline-block">
        Ver guía completa de <?php echo e($juego->nombre); ?> →
    </a>
</div>

<section class="mt-10 bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes sobre <?php echo e($juego->nombre); ?></h2>

    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuál es el último sorteo de <?php echo e($juego->nombre); ?>?</summary>
            <div class="mt-2 text-slate-600">
                <?php if($latestSorteo): ?>
                    El último sorteo disponible de <?php echo e($juego->nombre); ?> es el <?php echo e($latestFechaHuman); ?>.
                <?php else: ?>
                    Aún no hay sorteos disponibles para <?php echo e($juego->nombre); ?>.
                <?php endif; ?>
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué días se sortea <?php echo e($juego->nombre); ?>?</summary>
            <div class="mt-2 text-slate-600">
                Días de sorteo: <?php echo e(str_replace(',', ', ', $juego->dias_sorteo)); ?>.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuándo caducan los premios de <?php echo e($juego->nombre); ?>?</summary>
            <div class="mt-2 text-slate-600">
                Por norma general, los premios caducan a los 3 meses desde la fecha del sorteo. En cada sorteo mostramos la fecha de caducidad y cuánto falta.
            </div>
        </details>

        <?php switch($juego->slug):
            case ('euromillones'): ?>
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué son las estrellas en Euromillones?</summary>
                    <div class="mt-2 text-slate-600">
                        Las estrellas son 2 números adicionales (del 1 al 12) que debes acertar además de los 5 números principales para ganar el premio mayor. También dan acceso a categorías de premios intermedias.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto cuesta jugar a Euromillones?</summary>
                    <div class="mt-2 text-slate-600">
                        Cada apuesta simple de Euromillones cuesta 2,50€. Puedes hacer múltiples apuestas y combinaciones aumentando el coste proporcionalmente.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué impuestos se aplican a los premios de Euromillones?</summary>
                    <div class="mt-2 text-slate-600">
                        En España, los premios hasta 20.000€ están exentos de impuestos. A partir de esa cantidad, se aplica un 20% de retención en la fuente.
                    </div>
                </details>
                <?php break; ?>

            <?php case ('bonoloto'): ?>
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué es el reintegro en Bonoloto?</summary>
                    <div class="mt-2 text-slate-600">
                        El reintegro es un número del 0 al 9 que, si aciertas, te devuelve el importe de tu apuesta. Es una forma de recuperar tu inversión aunque no ganes otros premios.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto cuesta jugar a Bonoloto?</summary>
                    <div class="mt-2 text-slate-600">
                        La apuesta mínima de Bonoloto cuesta 0,50€. El reintegro añade 0,50€ adicionales, haciendo un total de 1€ por apuesta completa.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Desde qué cantidad hay premios en Bonoloto?</summary>
                    <div class="mt-2 text-slate-600">
                        Con 3 aciertos ya tienes premio (aproximadamente 6€). Los premios aumentan con más aciertos hasta el bote con 6 números acertados.
                    </div>
                </details>
                <?php break; ?>

            <?php case ('la-primitiva'): ?>
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué es "El Millón" en La Primitiva?</summary>
                    <div class="mt-2 text-slate-600">
                        "El Millón" es un sorteo adicional que se realiza los jueves con un premio garantizado de 1 millón de euros para un único número de 8 cifras.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cómo funciona el Número Clave en La Primitiva?</summary>
                    <div class="mt-2 text-slate-600">
                        El Número Clave es un número del 0 al 9 que te da acceso a un bote adicional si aciertas los 6 números principales. Solo aplica para la categoría máxima.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuál es la diferencia entre La Primitiva y El Gordo?</summary>
                    <div class="mt-2 text-slate-600">
                        Aunque ambos usan 6 números del 1-49, El Gordo tiene un coste mayor (1,50€ vs 1€), botes más altos (5M€ vs 3M€ mínimo) y se sortea solo los domingos.
                    </div>
                </details>
                <?php break; ?>

            <?php case ('el-gordo'): ?>
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Por qué se llama "El Gordo" si es de La Primitiva?</summary>
                    <div class="mt-2 text-slate-600">
                        Aunque es parte de la familia La Primitiva, se llama "El Gordo" porque tradicionalmente ofrece los botes más grandes y atractivos de los sorteos semanales.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿El Número Clave de El Gordo funciona igual que en La Primitiva?</summary>
                    <div class="mt-2 text-slate-600">
                        Sí, funciona igual: es un número del 0 al 9 que da acceso a un bote adicional si aciertas los 6 números principales. La diferencia es que en El Gordo el bote base es mayor.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuánto cuesta jugar a El Gordo?</summary>
                    <div class="mt-2 text-slate-600">
                        Cada apuesta de El Gordo cuesta 1,50€. Incluye el reintegro que te devuelve el importe completo si aciertas el número del 0 al 9.
                    </div>
                </details>
                <?php break; ?>

            <?php case ('loteria-nacional'): ?>
                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué es un décimo en Lotería Nacional?</summary>
                    <div class="mt-2 text-slate-600">
                        Un décimo es una fracción de un billete completo. Cada billete se divide en 10 décimos, y cada décimo cuesta el precio establecido para ese sorteo (normalmente entre 3€ y 20€ según el tipo de sorteo).
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuántos números tiene Lotería Nacional?</summary>
                    <div class="mt-2 text-slate-600">
                        Cada sorteo de Lotería Nacional emite 100.000 números diferentes (del 00000 al 99999), divididos en series. El primer premio se extrae entre estos números.
                    </div>
                </details>

                <details class="rounded-lg border border-slate-200 p-4">
                    <summary class="font-semibold text-slate-800 cursor-pointer">¿Qué son los reintegros en Lotería Nacional?</summary>
                    <div class="mt-2 text-slate-600">
                        Los reintegros son las últimas cifras del número premiado. Si tu décimo termina en una de esas cifras, recuperas el importe jugado. Normalmente hay 3 reintegros por sorteo.
                    </div>
                </details>
                <?php break; ?>
        <?php endswitch; ?>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cómo se reclaman los premios?</summary>
            <div class="mt-2 text-slate-600">
                Premios hasta 2.000€: en administraciones de loterías. Entre 2.000€ y 40.000€: en entidades bancarias colaboradoras. Más de 40.000€: en las oficinas de Loterías y Apuestas del Estado.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Dónde puedo consultar los resultados oficiales?</summary>
            <div class="mt-2 text-slate-600">
                Los resultados oficiales los publica Loterías y Apuestas del Estado en su web y en las administraciones. En esta web mostramos la misma información de forma actualizada.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Puedo jugar online?</summary>
            <div class="mt-2 text-slate-600">
                Sí, puedes jugar online a través de la web oficial de Loterías y Apuestas del Estado o aplicaciones autorizadas. Recuerda jugar siempre en canales oficiales.
            </div>
        </details>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Nire unitatea\python\boteshoy2\web\resources\views/juego.blade.php ENDPATH**/ ?>