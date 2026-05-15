<?php $__env->startSection('title'); ?>
Resultado <?php echo e($juego->nombre); ?> <?php echo e($sorteo->fecha->format('d M Y')); ?> | Números y Premios
<?php $__env->stopSection(); ?>

<?php $__env->startSection('description'); ?>
Resultado del sorteo de <?php echo e($juego->nombre); ?> del <?php echo e($sorteo->fecha->format('d/m/Y')); ?>. Números ganadores, acertantes y premios.
<?php $__env->stopSection(); ?>

<?php
$caduca = $sorteo->fecha->copy()->addMonthsNoOverflow(3);
$diasCad = now()->startOfDay()->diffInDays($caduca->copy()->startOfDay(), false);

$numsText = implode(', ', $sorteo->numeros ?? []);
$compText = '';
if (!empty($sorteo->complementarios)) {
    $parts = [];
    foreach (($sorteo->complementarios ?? []) as $k => $v) {
        if (is_array($v)) {
            $parts[] = ucfirst((string)$k) . ': ' . implode(', ', $v);
        } else {
            $parts[] = ucfirst((string)$k) . ': ' . $v;
        }
    }
    if (!empty($parts)) {
        $compText = ' (' . implode(' | ', $parts) . ')';
    }
}

$faqSorteo = [
    [
        '@type' => 'Question',
        'name' => "¿Cuál fue la combinación ganadora de {$juego->nombre} el {$sorteo->fecha->format('d/m/Y')}?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $numsText ? ("La combinación ganadora fue: {$numsText}{$compText}.") : 'Consulta la combinación ganadora en esta página.',
        ],
    ],
    [
        '@type' => 'Question',
        'name' => "¿Cuándo caducan los premios de {$juego->nombre} de este sorteo?",
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => "Por norma general, los premios caducan a los 3 meses desde la fecha del sorteo. Para este sorteo, la fecha de caducidad es {$caduca->format('d/m/Y')}.",
        ],
    ],
    [
        '@type' => 'Question',
        'name' => '¿Por qué algunos premios aparecen como pendientes?',
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => 'Si el reparto de premios aún no está publicado, el importe puede aparecer como pendiente hasta que la fuente lo actualice.',
        ],
    ],
];

$faqSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqSorteo,
];
?>

<?php $__env->startPush('head'); ?>
<script type="application/ld+json"><?php echo json_encode($faqSchema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES, 512) ?></script>
<?php $__env->stopPush(); ?>

<?php
$colores = [
    'euromillones' => ['bg' => 'bg-euro-500', 'ball' => 'bg-blue-600', 'text' => 'text-euro-500'],
    'bonoloto' => ['bg' => 'bg-bono-500', 'ball' => 'bg-red-600', 'text' => 'text-bono-500'],
    'la-primitiva' => ['bg' => 'bg-primi-500', 'ball' => 'bg-emerald-600', 'text' => 'text-primi-500'],
    'el-gordo' => ['bg' => 'bg-gordo-500', 'ball' => 'bg-purple-600', 'text' => 'text-gordo-500'],
    'eurodreams' => ['bg' => 'bg-dream-500', 'ball' => 'bg-cyan-600', 'text' => 'text-dream-500'],
];
$color = $colores[$juego->slug] ?? ['bg' => 'bg-gray-500', 'ball' => 'bg-gray-600', 'text' => 'text-gray-500'];
?>

<?php $__env->startSection('content'); ?>
<div class="<?php echo e($color['bg']); ?> -mx-4 -mt-8 px-4 py-8 mb-8 text-white">
    <div class="container mx-auto">
        <nav class="text-sm text-white/60 mb-4">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-white">Inicio</a>
            <span class="mx-2">›</span>
            <a href="<?php echo e(route('juego', $juego->slug)); ?>" class="hover:text-white"><?php echo e($juego->nombre); ?></a>
            <span class="mx-2">›</span>
            <span class="text-white"><?php echo e($sorteo->fecha->format('d/m/Y')); ?></span>
        </nav>
        <div class="text-3xl font-bold mb-1"><?php echo e($juego->nombre); ?></div>
        <h1 class="text-white/80 text-lg capitalize">Resultados de <?php echo e($juego->nombre); ?> del <?php echo e($sorteo->fecha->translatedFormat('l, d \d\e F \d\e Y')); ?></h1>
        <p class="text-white/70 mt-2">
            Resultado de <?php echo e($juego->nombre); ?> hoy: último sorteo disponible del <?php echo e($sorteo->fecha->format('d/m/Y')); ?>. Consulta combinación ganadora, premios y acertantes.
        </p>
        <p class="text-white/70 mt-1 text-sm">
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
</div>

<!-- Selector de calendario -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <label for="fecha-selector" class="text-sm font-medium text-slate-700">Ver resultados de otra fecha:</label>
            <div class="flex items-center gap-2">
                <input 
                    type="date" 
                    id="fecha-selector" 
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    value="<?php echo e($sorteo->fecha->format('Y-m-d')); ?>"
                    min="<?php echo e($sorteo->fecha->copy()->subYears(2)->format('Y-m-d')); ?>"
                    max="<?php echo e(now()->format('Y-m-d')); ?>"
                >
                <button 
                    onclick="verResultadosFecha()" 
                    class="px-4 py-2 <?php echo e($color['bg']); ?> text-white rounded-lg hover:opacity-90 transition-opacity text-sm font-medium whitespace-nowrap"
                >
                    Ver resultados
                </button>
            </div>
        </div>
        <div class="text-xs text-slate-500 sm:text-right">
            Fechas disponibles hasta <?php echo e(now()->format('d/m/Y')); ?>

        </div>
    </div>
</div>

<script>
// Fechas disponibles para validación
const fechasDisponibles = <?php echo json_encode($fechasDisponibles, 15, 512) ?>;

function verResultadosFecha() {
    const fechaSeleccionada = document.getElementById('fecha-selector').value;
    if (!fechaSeleccionada) {
        alert('Por favor, selecciona una fecha');
        return;
    }
    
    // Validar si la fecha tiene resultados disponibles
    if (!fechasDisponibles.includes(fechaSeleccionada)) {
        alert('No hay resultados disponibles para la fecha seleccionada. Por favor, elige otra fecha.');
        return;
    }
    
    // Construir URL para la fecha seleccionada
    const url = `<?php echo e(route('juego', $juego->slug)); ?>/${fechaSeleccionada}`;
    
    // Redirigir a la página de resultados de esa fecha
    window.location.href = url;
}

// Manejar tecla Enter en el input de fecha
document.getElementById('fecha-selector').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        verResultadosFecha();
    }
});
</script>

<div class="bg-white rounded-xl shadow-lg p-8 mb-6">
    <h2 class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-4">Combinación Ganadora</h2>
    
    <div class="flex flex-wrap gap-3 mb-6 justify-center">
        <?php $__currentLoopData = $sorteo->numeros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $numero): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="ball w-14 h-14 <?php echo e($color['ball']); ?> text-white rounded-full flex items-center justify-center font-bold text-xl">
                <?php echo e($numero); ?>

            </span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <?php if($sorteo->complementarios): ?>
            <span class="flex items-center text-gray-300 mx-2 text-2xl">+</span>
            <?php $__currentLoopData = $sorteo->complementarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_array($valor)): ?>
                    <?php $__currentLoopData = $valor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="ball w-14 h-14 bg-amber-500 text-white rounded-full flex items-center justify-center font-bold text-xl" title="<?php echo e(ucfirst($key)); ?>">
                            <?php echo e($v); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <span class="ball w-14 h-14 bg-slate-400 text-white rounded-full flex items-center justify-center font-bold text-lg" title="<?php echo e(ucfirst($key)); ?>">
                        <?php echo e($valor); ?>

                    </span>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
    
    <?php if($sorteo->complementarios): ?>
        <div class="flex flex-wrap gap-4 justify-center text-sm text-slate-500">
            <?php $__currentLoopData = $sorteo->complementarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span>
                    <strong class="capitalize"><?php echo e($key); ?>:</strong>
                    <?php if(is_array($valor)): ?>
                        <?php echo e(implode(', ', $valor)); ?>

                    <?php else: ?>
                        <?php echo e($valor); ?>

                    <?php endif; ?>
                </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<?php if($sorteo->bote): ?>
<div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 mb-6 text-white text-center">
    <p class="text-sm uppercase tracking-wide opacity-80 mb-1">Bote</p>
    <p class="text-4xl font-bold"><?php echo e(number_format($sorteo->bote, 0, ',', '.')); ?> €</p>
</div>
<?php endif; ?>

<?php if($sorteo->premios && count($sorteo->premios) > 0): ?>
<div class="bg-white rounded-xl shadow-lg p-6 mb-6 overflow-hidden">
    <h2 class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-4">Tabla de Premios</h2>
    
    <?php if($juego->slug === 'euromillones'): ?>
    <!-- Tabla especial para Euromillones -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[500px]">
            <thead class="<?php echo e($color['bg']); ?> text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-center">Aciertos</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes Europa</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes España</th>
                    <th class="px-6 py-3 font-medium text-right">Premio (€)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $sorteo->premios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $premio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700"><?php echo e($premio['categoria'] ?? '-'); ?></td>
                    <td class="px-6 py-3 text-center text-slate-600 font-medium"><?php echo e($premio['aciertos'] ?? '-'); ?></td>
                    <td class="px-6 py-3 text-right text-slate-600"><?php echo e(number_format($premio['acertantes_europa'] ?? 0, 0, ',', '.')); ?></td>
                    <td class="px-6 py-3 text-right text-slate-600"><?php echo e(number_format($premio['acertantes_espana'] ?? 0, 0, ',', '.')); ?></td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        <?php if(array_key_exists('premio', $premio) && $premio['premio'] === null): ?>
                            <span class="text-slate-500">Pendiente</span>
                        <?php else: ?>
                            <?php echo e(number_format($premio['premio'] ?? 0, 2, ',', '.')); ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php elseif($juego->slug === 'bonoloto'): ?>
    <!-- Tabla especial para Bonoloto con Aciertos como dato fijo -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[450px]">
            <thead class="<?php echo e($color['bg']); ?> text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-center">Aciertos</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes</th>
                    <th class="px-6 py-3 font-medium text-right">Premio (€)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php
                    // Aciertos fijos para Bonoloto según categoría (compatible con ambos formatos)
                    $aciertosFijos = [
                        '1ª' => '6', '1a' => '6',
                        '2ª' => '5+C', '2a' => '5+C',
                        '3ª' => '5', '3a' => '5',
                        '4ª' => '4', '4a' => '4',
                        '5ª' => '3', '5a' => '3',
                    ];
                ?>
                <?php $__currentLoopData = $sorteo->premios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $premio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Normalizar categoría a formato estándar para visualización
                    $categoriaMostrar = $premio['categoria'] ?? '-';
                    if ($categoriaMostrar === '1a') $categoriaMostrar = '1ª';
                    elseif ($categoriaMostrar === '2a') $categoriaMostrar = '2ª';
                    elseif ($categoriaMostrar === '3a') $categoriaMostrar = '3ª';
                    elseif ($categoriaMostrar === '4a') $categoriaMostrar = '4ª';
                    elseif ($categoriaMostrar === '5a') $categoriaMostrar = '5ª';
                    elseif ($categoriaMostrar === '6a') $categoriaMostrar = '6ª';
                    elseif ($categoriaMostrar === '7a') $categoriaMostrar = '7ª';
                    elseif ($categoriaMostrar === '8a') $categoriaMostrar = '8ª';
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700"><?php echo e($categoriaMostrar); ?></td>
                    <td class="px-6 py-3 text-center text-slate-600 font-medium">
                        <?php echo e($aciertosFijos[$premio['categoria']] ?? '-'); ?>

                    </td>
                    <td class="px-6 py-3 text-right text-slate-600"><?php echo e(number_format($premio['acertantes'] ?? 0, 0, ',', '.')); ?></td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        <?php if(array_key_exists('premio', $premio) && $premio['premio'] === null): ?>
                            <span class="text-slate-500">Pendiente</span>
                        <?php else: ?>
                            <?php echo e(number_format($premio['premio'] ?? 0, 2, ',', '.')); ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php elseif($juego->slug === 'la-primitiva'): ?>
    <!-- Tabla especial para La Primitiva con Aciertos como dato fijo -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[450px]">
            <thead class="<?php echo e($color['bg']); ?> text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-center">Aciertos</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes</th>
                    <th class="px-6 py-3 font-medium text-right">Premio (€)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php
                    // Aciertos fijos para La Primitiva según categoría (compatible con ambos formatos)
                    $aciertosFijos = [
                        'Especial' => '6+R',
                        '1ª' => '6', '1a' => '6',
                        '2ª' => '5+C', '2a' => '5+C',
                        '3ª' => '5', '3a' => '5',
                        '4ª' => '4', '4a' => '4',
                        '5ª' => '3', '5a' => '3',
                        '6ª' => 'Reintegro', '6a' => 'Reintegro',
                    ];
                ?>
                <?php $__currentLoopData = $sorteo->premios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $premio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Normalizar categoría a formato estándar para visualización
                    $categoriaMostrar = $premio['categoria'] ?? '-';
                    if ($categoriaMostrar === '1a') $categoriaMostrar = '1ª';
                    elseif ($categoriaMostrar === '2a') $categoriaMostrar = '2ª';
                    elseif ($categoriaMostrar === '3a') $categoriaMostrar = '3ª';
                    elseif ($categoriaMostrar === '4a') $categoriaMostrar = '4ª';
                    elseif ($categoriaMostrar === '5a') $categoriaMostrar = '5ª';
                    elseif ($categoriaMostrar === '6a') $categoriaMostrar = '6ª';
                    elseif ($categoriaMostrar === '7a') $categoriaMostrar = '7ª';
                    elseif ($categoriaMostrar === '8a') $categoriaMostrar = '8ª';
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700"><?php echo e($categoriaMostrar); ?></td>
                    <td class="px-6 py-3 text-center text-slate-600 font-medium">
                        <?php echo e($aciertosFijos[$premio['categoria']] ?? '-'); ?>

                    </td>
                    <td class="px-6 py-3 text-right text-slate-600"><?php echo e(number_format($premio['acertantes'] ?? 0, 0, ',', '.')); ?></td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        <?php if(array_key_exists('premio', $premio) && $premio['premio'] === null): ?>
                            <span class="text-slate-500">Pendiente</span>
                        <?php else: ?>
                            <?php echo e(number_format($premio['premio'] ?? 0, 2, ',', '.')); ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php elseif($juego->slug === 'el-gordo'): ?>
    <!-- Tabla especial para El Gordo con Aciertos como dato fijo -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[450px]">
            <thead class="<?php echo e($color['bg']); ?> text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-center">Aciertos</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes</th>
                    <th class="px-6 py-3 font-medium text-right">Premio (€)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php
                    // Aciertos fijos para El Gordo según categoría (compatible con ambos formatos)
                    $aciertosFijos = [
                        '1ª' => '5+1', '1a' => '5+1',
                        '2ª' => '5+0', '2a' => '5+0',
                        '3ª' => '4+1', '3a' => '4+1',
                        '4ª' => '4+0', '4a' => '4+0',
                        '5ª' => '3+1', '5a' => '3+1',
                        '6ª' => '3+0', '6a' => '3+0',
                        '7ª' => '2+1', '7a' => '2+1',
                        '8ª' => '2+0', '8a' => '2+0',
                        'Reintegro' => '0+1',
                    ];
                ?>
                <?php $__currentLoopData = $sorteo->premios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $premio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Normalizar categoría a formato estándar para visualización
                    $categoriaMostrar = $premio['categoria'] ?? '-';
                    if ($categoriaMostrar === '1a') $categoriaMostrar = '1ª';
                    elseif ($categoriaMostrar === '2a') $categoriaMostrar = '2ª';
                    elseif ($categoriaMostrar === '3a') $categoriaMostrar = '3ª';
                    elseif ($categoriaMostrar === '4a') $categoriaMostrar = '4ª';
                    elseif ($categoriaMostrar === '5a') $categoriaMostrar = '5ª';
                    elseif ($categoriaMostrar === '6a') $categoriaMostrar = '6ª';
                    elseif ($categoriaMostrar === '7a') $categoriaMostrar = '7ª';
                    elseif ($categoriaMostrar === '8a') $categoriaMostrar = '8ª';
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700"><?php echo e($categoriaMostrar); ?></td>
                    <td class="px-6 py-3 text-center text-slate-600 font-medium">
                        <?php echo e($aciertosFijos[$premio['categoria']] ?? '-'); ?>

                    </td>
                    <td class="px-6 py-3 text-right text-slate-600"><?php echo e(number_format($premio['acertantes'] ?? 0, 0, ',', '.')); ?></td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        <?php if(array_key_exists('premio', $premio) && $premio['premio'] === null): ?>
                            <span class="text-slate-500">Pendiente</span>
                        <?php else: ?>
                            <?php echo e(number_format($premio['premio'] ?? 0, 2, ',', '.')); ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <!-- Tabla normal para otros juegos -->
    <div class="overflow-x-auto -mx-6">
        <table class="w-full text-left min-w-[400px]">
            <thead class="<?php echo e($color['bg']); ?> text-white">
                <tr>
                    <th class="px-6 py-3 font-medium">Categoría</th>
                    <th class="px-6 py-3 font-medium text-right">Acertantes</th>
                    <th class="px-6 py-3 font-medium text-right">Premio</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $sorteo->premios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $premio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-slate-700"><?php echo e($premio['categoria'] ?? '-'); ?></td>
                    <td class="px-6 py-3 text-right text-slate-600"><?php echo e(number_format($premio['acertantes'] ?? 0, 0, ',', '.')); ?></td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800">
                        <?php if(array_key_exists('premio', $premio) && $premio['premio'] === null): ?>
                            <span class="text-slate-500">Pendiente</span>
                        <?php else: ?>
                            <?php echo e(number_format($premio['premio'] ?? 0, 2, ',', '.')); ?> €
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if($sorteo->localidades && count($sorteo->localidades) > 0): ?>
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <h2 class="text-sm font-medium text-slate-500 uppercase tracking-wide mb-4">Localidades Premiadas</h2>
    <ul class="space-y-2 text-slate-600">
        <?php $__currentLoopData = $sorteo->localidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="flex items-center gap-2">
                <span class="w-2 h-2 <?php echo e($color['ball']); ?> rounded-full"></span>
                <?php echo e($localidad); ?>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<div class="mt-8">
    <a href="<?php echo e(route('juego', $juego->slug)); ?>" class="<?php echo e($color['text']); ?> font-medium hover:underline inline-flex items-center gap-1">
        <span>←</span> Volver a <?php echo e($juego->nombre); ?>

    </a>
</div>

<!-- Enlaces estratégicos adicionales -->
<div class="mt-6 bg-gradient-to-r from-slate-50 to-blue-50 rounded-xl p-6 border border-slate-200">
    <h3 class="text-lg font-bold text-slate-800 mb-4">Explora más contenido</h3>
    
    <div class="grid gap-4 md:grid-cols-2">
        <!-- Enlaces a guía del juego -->
        <div>
            <h4 class="font-semibold text-slate-700 mb-2">Guía de <?php echo e($juego->nombre); ?></h4>
            <a href="<?php echo e(route('juego.guia', $juego->slug)); ?>" class="text-blue-600 hover:underline text-sm">
                → Cómo jugar, premios y probabilidades
            </a>
        </div>
        
        <!-- Enlaces a conceptos según juego -->
        <div>
            <h4 class="font-semibold text-slate-700 mb-2">Conceptos básicos</h4>
            <?php switch($juego->slug):
                case ('euromillones'): ?>
                    <a href="/#que-son-estrellas" class="text-blue-600 hover:underline text-sm block">
                        → Qué son las estrellas
                    </a>
                    <?php break; ?>
                <?php case ('bonoloto'): ?>
                    <a href="/#que-es-reintegro" class="text-blue-600 hover:underline text-sm block">
                        → Qué es el reintegro
                    </a>
                    <?php break; ?>
                <?php case ('la-primitiva'): ?>
                <?php case ('el-gordo'): ?>
                    <a href="/#numero-clave" class="text-blue-600 hover:underline text-sm block">
                        → Número Clave explicado
                    </a>
                    <?php break; ?>
            <?php endswitch; ?>
        </div>
        
        <!-- Enlaces a otros juegos -->
        <div>
            <h4 class="font-semibold text-slate-700 mb-2">Otros sorteos</h4>
            <div class="space-y-1">
                <?php if($juego->slug !== 'euromillones'): ?>
                    <a href="<?php echo e(route('juego', 'euromillones')); ?>" class="text-blue-600 hover:underline text-sm block">
                        → Euromillones
                    </a>
                <?php endif; ?>
                <?php if($juego->slug !== 'bonoloto'): ?>
                    <a href="<?php echo e(route('juego', 'bonoloto')); ?>" class="text-blue-600 hover:underline text-sm block">
                        → Bonoloto
                    </a>
                <?php endif; ?>
                <?php if($juego->slug !== 'la-primitiva'): ?>
                    <a href="<?php echo e(route('juego', 'la-primitiva')); ?>" class="text-blue-600 hover:underline text-sm block">
                        → La Primitiva
                    </a>
                <?php endif; ?>
                <?php if($juego->slug !== 'el-gordo'): ?>
                    <a href="<?php echo e(route('juego', 'el-gordo')); ?>" class="text-blue-600 hover:underline text-sm block">
                        → El Gordo
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Enlaces a información general -->
        <div>
            <h4 class="font-semibold text-slate-700 mb-2">Información útil</h4>
            <div class="space-y-1">
                <a href="/#como-jugar" class="text-blue-600 hover:underline text-sm block">
                    → Cómo reclamar premios
                </a>
                <a href="/#caducidad-premios" class="text-blue-600 hover:underline text-sm block">
                    → Caducidad de premios
                </a>
                <a href="/#impuestos-premios" class="text-blue-600 hover:underline text-sm block">
                    → Impuestos en premios
                </a>
            </div>
        </div>
    </div>
</div>

<section class="mt-10 bg-white rounded-xl shadow-lg p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Preguntas frecuentes sobre el sorteo</h2>

    <div class="space-y-3">
        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuál fue la combinación ganadora de <?php echo e($juego->nombre); ?> el <?php echo e($sorteo->fecha->format('d/m/Y')); ?>?</summary>
            <div class="mt-2 text-slate-600">
                <?php if(!empty($numsText)): ?>
                    La combinación ganadora fue: <?php echo e($numsText); ?><?php echo e($compText); ?>.
                <?php else: ?>
                    Consulta la combinación ganadora en esta página.
                <?php endif; ?>
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Cuándo caducan los premios de <?php echo e($juego->nombre); ?> de este sorteo?</summary>
            <div class="mt-2 text-slate-600">
                Por norma general, los premios caducan a los 3 meses desde la fecha del sorteo. Para este sorteo, la fecha de caducidad es <?php echo e($caduca->format('d/m/Y')); ?>.
            </div>
        </details>

        <details class="rounded-lg border border-slate-200 p-4">
            <summary class="font-semibold text-slate-800 cursor-pointer">¿Por qué algunos premios aparecen como pendientes?</summary>
            <div class="mt-2 text-slate-600">
                Si el reparto de premios aún no está publicado, el importe puede aparecer como pendiente hasta que la fuente lo actualice.
            </div>
        </details>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Nire unitatea\python\boteshoy2\web\resources\views/sorteo.blade.php ENDPATH**/ ?>