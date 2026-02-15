<?php $__env->startSection('title'); ?>
Editar Contenido
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center">
                <a href="<?php echo e(route('admin.contenido.index')); ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Volver a Contenido
                </a>
            </div>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Editar Contenido</h1>
            <p class="mt-2 text-gray-600">
                <?php echo e($contenido->juego->nombre); ?> - <?php echo e($contenido->tipo_contenido_label); ?>

            </p>
        </div>

        <!-- Form -->
        <?php echo $__env->make('admin.contenido.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Nire unitatea\python\boteshoy2\web\resources\views/admin/contenido/edit.blade.php ENDPATH**/ ?>