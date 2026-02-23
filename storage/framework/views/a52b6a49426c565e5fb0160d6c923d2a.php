<section class="space-y-6">
    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="py-2.5 px-6 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-red-600 text-white shadow-lg shadow-red-200 hover:bg-red-700 hover:shadow-none transition-all transform active:scale-95">
        <?php echo e(__('Delete Account')); ?>

    </button>

    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'confirm-user-deletion','show' => $errors->isNotEmpty(),'focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'confirm-user-deletion','show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->isNotEmpty()),'focusable' => true]); ?>
        <form wire:submit="deleteUser" class="p-8">
            <h2 class="text-xl font-bold text-gray-900 tracking-tight dark:text-gray-100">
                <?php echo e(__('Are you sure?')); ?>

            </h2>

            <p class="mt-2 text-sm text-gray-500 leading-relaxed dark:text-gray-400">
                <?php echo e(__('Once your account is deleted, all data will be permanently removed. Please enter your password to confirm.')); ?>

            </p>

            <div class="mt-6">
                <input wire:model="password" type="password" 
                    class="py-2.5 px-4 block w-3/4 border-gray-200 rounded-xl text-sm focus:border-red-500 focus:ring-red-500/10 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-red-400" 
                    placeholder="<?php echo e(__('Enter Password')); ?>" />
                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" 
                    class="py-2.5 px-5 text-sm font-semibold rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-200 dark:hover:bg-dark-surface-secondary">
                    <?php echo e(__('Cancel')); ?>

                </button>

                <button type="submit" 
                    class="py-2.5 px-6 text-sm font-bold rounded-xl bg-red-600 text-white shadow-lg shadow-red-200 hover:bg-red-700 transition-all transform active:scale-95">
                    <?php echo e(__('Permanently Delete')); ?>

                </button>
            </div>
        </form>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
</section><?php /**PATH C:\Users\Dell\StockMaster-Pro\resources\views\livewire/profile/delete-user-form.blade.php ENDPATH**/ ?>