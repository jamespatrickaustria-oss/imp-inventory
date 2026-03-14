<div class="p-2 sm:p-4 lg:p-6 space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Reports</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Review weekly inventory and sales performance.</p>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 dark:bg-dark-surface-secondary dark:border-dark-700">
        <form wire:submit.prevent="generateReports" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- Start Date -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-300 mb-2">
                        Start Date <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        wire:model.live="startDate"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-dark-surface-tertiary dark:border-dark-600 dark:text-gray-100"
                        required
                    >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['startDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-300 mb-2">
                        End Date <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        wire:model.live="endDate"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-dark-surface-tertiary dark:border-dark-600 dark:text-gray-100"
                        required
                    >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['endDate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Sort By -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-300 mb-2">
                        Sort By
                    </label>
                    <select
                        wire:model.live="sortBy"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-dark-surface-tertiary dark:border-dark-600 dark:text-gray-100"
                    >
                        <option value="report_date">Report Date</option>
                        <option value="total_inventory_value">Inventory Value</option>
                        <option value="low_stock_count">Low Stock</option>
                    </select>
                </div>

                <!-- Sort Order -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-300 mb-2">
                        Order
                    </label>
                    <select
                        wire:model.live="sortOrder"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-dark-surface-tertiary dark:border-dark-600 dark:text-gray-100"
                    >
                        <option value="desc">Newest First</option>
                        <option value="asc">Oldest First</option>
                    </select>
                </div>

                <!-- Generate Button -->
                <div class="flex items-end">
                    <button
                        type="submit"
                        class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 transition-colors"
                    >
                        Filter Reports
                    </button>
                </div>
            </div>
        </form>

        <!-- Reset Button -->
        <div class="flex gap-2 mt-4">
            <button
                wire:click="resetFilters"
                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors"
            >
                Reset Filters
            </button>
            <button
                wire:click="exportAsCSV"
                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 transition-colors"
                title="Export reports from <?php echo e($startDate); ?> to <?php echo e($endDate); ?> as CSV"
            >
                📥 Export as CSV
            </button>
        </div>
        
        <!-- Export Info - Real-time Update -->
        <div wire:key="export-info-<?php echo e($startDate); ?>-<?php echo e($endDate); ?>" class="transition-all duration-300">
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 flex items-center gap-2">
                <span>📋 Export will include all reports from</span>
                <span class="font-semibold text-blue-600 dark:text-blue-400"><?php echo e(\Carbon\Carbon::parse($startDate)->format('M d, Y')); ?></span>
                <span>to</span>
                <span class="font-semibold text-blue-600 dark:text-blue-400"><?php echo e(\Carbon\Carbon::parse($endDate)->format('M d, Y')); ?></span>
            </p>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($latestReport): ?>
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400">Latest report</p>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        <?php echo e(optional($latestReport->week_start)->format('M d, Y')); ?> - <?php echo e(optional($latestReport->week_end)->format('M d, Y')); ?>

                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Generated <?php echo e(optional($latestReport->report_date)->format('M d, Y')); ?></p>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($latestReport->sent_at): ?>
                        Sent <?php echo e($latestReport->sent_at->format('M d, Y H:i')); ?>

                    <?php else: ?>
                        Not sent
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mt-4">
                <div class="bg-gray-50 rounded-lg p-4 dark:bg-dark-surface-tertiary">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Products</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100"><?php echo e($latestReport->total_products); ?></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 dark:bg-dark-surface-tertiary">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Inventory Value</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">$<?php echo e(number_format($latestReport->total_inventory_value, 2)); ?></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 dark:bg-dark-surface-tertiary">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Low Stock</p>
                    <p class="text-lg font-semibold text-yellow-700 dark:text-yellow-300"><?php echo e($latestReport->low_stock_count); ?></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 dark:bg-dark-surface-tertiary">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Out of Stock</p>
                    <p class="text-lg font-semibold text-red-600 dark:text-red-400"><?php echo e($latestReport->out_of_stock_count); ?></p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white border border-dashed border-gray-200 rounded-xl p-6 text-center text-sm text-gray-500 dark:bg-dark-surface-secondary dark:border-dark-700 dark:text-gray-400">
            No weekly reports yet. Run <span class="font-semibold">php artisan report:weekly</span> to generate one.
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-dark-700">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">All Reports</h3>
        </div>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
            <thead class="bg-gray-50 dark:bg-dark-surface-tertiary">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Week</th>
                    <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Report Date</th>
                    <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Products</th>
                    <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Low Stock</th>
                    <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Out of Stock</th>
                    <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Inventory Value</th>
                    <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Sent</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-dark-700">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface-tertiary transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-100">
                            <?php echo e(optional($report->week_start)->format('M d')); ?> - <?php echo e(optional($report->week_end)->format('M d, Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                            <?php echo e(optional($report->report_date)->format('M d, Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-100"><?php echo e($report->total_products); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 dark:text-yellow-300"><?php echo e($report->low_stock_count); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 dark:text-red-400"><?php echo e($report->out_of_stock_count); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-100">$<?php echo e(number_format($report->total_inventory_value, 2)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($report->sent_at): ?>
                                <?php echo e($report->sent_at->format('M d, Y H:i')); ?>

                            <?php else: ?>
                                Not sent
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                            No reports found.
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200 flex justify-end dark:border-dark-700">
            <?php echo e($reports->links()); ?>

        </div>
    </div>
</div>
<?php /**PATH C:\Users\Dell\imp-inventory\resources\views/livewire/pages/admin/reports.blade.php ENDPATH**/ ?>