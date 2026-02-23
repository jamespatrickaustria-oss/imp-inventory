<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight dark:text-gray-100">
                <?php echo e(__('Settings')); ?>

            </h2>
            <p class="text-sm text-gray-500 mt-1 dark:text-gray-400">Manage your account information and security settings.</p>
        </div>
    </div>

    <div class="space-y-6">
        
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="p-6 bg-gray-50/50 border-b md:border-b-0 md:border-r border-gray-100 dark:bg-dark-surface-tertiary/60 dark:border-dark-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100"><?php echo e(__('Public Profile')); ?></h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update your email and basic account info.</p>
                </div>
                <div class="p-6 md:col-span-2">
                    <div class="max-w-xl">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.update-profile-information-form', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2539840447-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="p-6 bg-gray-50/50 border-b md:border-b-0 md:border-r border-gray-100 dark:bg-dark-surface-tertiary/60 dark:border-dark-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100"><?php echo e(__('Security')); ?></h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Change your password and secure your account.</p>
                </div>
                <div class="p-6 md:col-span-2">
                    <div class="max-w-xl">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.update-password-form', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2539840447-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-red-50 shadow-sm rounded-2xl overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="p-6 bg-red-50/30 border-b md:border-b-0 md:border-r border-red-50 dark:bg-red-500/10 dark:border-red-500/20">
                    <h3 class="text-base font-bold text-red-900 dark:text-red-200"><?php echo e(__('Danger Zone')); ?></h3>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-300">Delete all your data and close your account permanently.</p>
                </div>
                <div class="p-6 md:col-span-2">
                    <div class="max-w-xl">
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('profile.delete-user-form', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2539840447-2', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    </div>
                </div>
            </div>
        </div>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\Users\Dell\StockMaster-Pro\resources\views/profile.blade.php ENDPATH**/ ?>