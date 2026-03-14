<div x-data="{ open: false, imagePreview: false }" class="p-2 sm:p-4 lg:p-6">
    <div class="mb-5">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Product Inventory</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Manage your SKU, pricing, and stock levels.</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
                    
                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-dark-700">
                        <div class="relative max-w-xs">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" 
                                   name="search" 
                                   wire:model.live.debounce.300ms="search" 
                                   id="search" 
                                   class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400" 
                                   placeholder="Search products...">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            </div>
                        </div>

                        <div class="inline-flex gap-x-2">
                            <button 
                                wire:click="toggleArchived"
                                class="py-2 px-5 inline-flex items-center text-sm font-semibold rounded-xl border <?php echo e($showArchived ? 'bg-orange-100 border-orange-300 text-orange-800 dark:bg-orange-900 dark:border-orange-700 dark:text-orange-100' : 'border-gray-200 bg-white text-gray-700 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-300'); ?> hover:shadow-md transition-all duration-200">
                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showArchived): ?> View Active <?php else: ?> View Archived <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </button>
                            <button 
                                wire:click="resetForm"
                                @click="open = true"  
                                class="py-2 px-5 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                Add Product
                            </button>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                        <thead class="bg-gray-50 dark:bg-dark-surface-tertiary">
                            <tr>
                                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Product</th>
                                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">SKU</th>
                                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Category</th>
                                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Stock (Qty)</th>
                                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Price</th>
                                <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Status</th>
                                <th class="px-6 py-4 text-end text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-dark-700">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface-tertiary transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-x-3">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image_path): ?>
                                                <img 
                                                    src="<?php echo e(asset('storage/' . $product->image_path)); ?>" 
                                                    alt="<?php echo e($product->name); ?>"
                                                    class="size-10 rounded-lg object-cover border border-gray-200 dark:border-dark-600">
                                            <?php else: ?>
                                                <div class="size-10 flex justify-center items-center bg-gray-200 rounded-lg text-xs font-medium text-gray-800 dark:bg-dark-surface-tertiary dark:text-gray-200">
                                                    <?php echo e(strtoupper(substr($product->name, 0, 2))); ?>

                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100"><?php echo e($product->name); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-xs font-mono text-gray-600 dark:text-gray-400"><?php echo e($product->sku); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-100"><?php echo e($product->category->name ?? 'N/A'); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-100"><?php echo e($product->quantity); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-100">₱<?php echo e(number_format($product->price, 2)); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->isLowStock()): ?>
                                            <span class="py-1 px-2 inline-flex items-center text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full dark:bg-yellow-900 dark:text-yellow-100">Low Stock</span>
                                        <?php else: ?>
                                            <span class="py-1 px-2 inline-flex items-center text-xs font-medium bg-green-100 text-green-800 rounded-full dark:bg-green-900 dark:text-green-100">In Stock</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showArchived): ?>
                                            <button 
                                                wire:click="restoreProduct(<?php echo e($product->id); ?>)"
                                                class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-semibold px-2">
                                                Restore
                                            </button>
                                            <button 
                                                wire:click="permanentDeleteProduct(<?php echo e($product->id); ?>)"
                                                wire:confirm="Are you sure you want to permanently delete this product? This action cannot be undone!"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold px-2 inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                Delete
                                            </button>
                                        <?php else: ?>
                                            <button 
                                                wire:click="editProduct(<?php echo e($product->id); ?>)"
                                                @click="open = true"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold px-2">
                                                Edit
                                            </button>
                                            <button 
                                                wire:click="deleteProduct(<?php echo e($product->id); ?>)"
                                                wire:confirm="Are you sure you want to delete this product?"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold px-2 inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                Delete
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center">
                                        <p class="text-gray-500 dark:text-gray-400">No products found</p>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center dark:border-dark-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Showing <?php echo e($products->count()); ?> of <?php echo e($products->total()); ?> results
                        </span>
                        <div class="flex gap-x-2">
                            <?php echo e($products->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="open" 
         class="fixed inset-0 z-[80] overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4" 
         style="display: none;"
         x-transition>
        
        <div @click.away="open = false" class="bg-white border shadow-sm rounded-xl w-full max-w-2xl transform transition-all dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-dark-700">
                <h3 class="font-bold text-gray-800 dark:text-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingId): ?>
                        Edit Product
                    <?php else: ?>
                        Create New Product
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </h3>
                <button @click="open = false; window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('resetForm')" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit="store" class="space-y-5 p-6 overflow-y-auto max-h-[70vh]">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Product Name <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            wire:model="name"
                            class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-blue-400 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">SKU <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            wire:model="sku"
                            class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400 <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            placeholder="PRD-001">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Category <span class="text-red-500">*</span></label>
                    <select 
                        wire:model="category_id"
                        class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Select a Category</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category['id']); ?>"><?php echo e($category['name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Price (₱) <span class="text-red-500">*</span></label>
                        <input 
                            type="number" 
                            step="0.01" 
                            wire:model="price"
                            class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Quantity <span class="text-red-500">*</span></label>
                        <input 
                            type="number" 
                            wire:model="quantity"
                            class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Min Stock <span class="text-red-500">*</span></label>
                        <input 
                            type="number" 
                            wire:model="min_stock"
                            class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 <?php $__errorArgs = ['min_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['min_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Product Image</label>
                    <input 
                        type="file" 
                        wire:model="image"
                        accept="image/*"
                        class="block w-full text-sm text-gray-900 border border-gray-200 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-dark-surface-tertiary dark:border-dark-600 dark:placeholder-gray-400">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($image): ?>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Click image to view fullscreen</p>
                            <div class="relative inline-block">
                                <img 
                                    src="<?php echo e($image->temporaryUrl()); ?>" 
                                    @click="imagePreview = true" 
                                    class="h-20 w-20 rounded-lg object-cover cursor-pointer hover:opacity-80 transition-opacity" 
                                    alt="Preview">
                                <button 
                                    type="button"
                                    wire:click="removeImage"
                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    <?php elseif($existingImage): ?>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Click image to view fullscreen</p>
                            <div class="relative inline-block">
                                <img 
                                    src="<?php echo e(asset('storage/' . $existingImage)); ?>" 
                                    @click="imagePreview = true" 
                                    class="h-20 w-20 rounded-lg object-cover cursor-pointer hover:opacity-80 transition-opacity" 
                                    alt="Current image">
                                <button 
                                    type="button"
                                    wire:click="removeImage"
                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </form>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-dark-700">
                <button 
                    @click="open = false; window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('resetForm')" 
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:hover:bg-dark-surface-secondary">
                    Discard
                </button>
                <button 
                    wire:click="store"
                    type="button" 
                    class="py-2.5 px-6 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingId): ?>
                        Update Product
                    <?php else: ?>
                        Save Product
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </button>
            </div>
        </div>
    </div>

    <!-- Fullscreen Image Preview Modal -->
    <div x-show="imagePreview" 
         x-cloak
         @click="imagePreview = false"
         class="fixed inset-0 z-[100] bg-black/90 flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <button @click="imagePreview = false" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <div class="max-w-7xl max-h-[90vh] w-full h-full flex items-center justify-center" @click.stop>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($image): ?>
                <img src="<?php echo e($image->temporaryUrl()); ?>" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl" alt="Fullscreen preview">
            <?php elseif($existingImage): ?>
                <img src="<?php echo e(asset('storage/' . $existingImage)); ?>" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl" alt="Fullscreen image">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm">
            Click anywhere to close
        </div>
    </div>
</div><?php /**PATH C:\Users\Dell\imp-inventory\resources\views/livewire/pages/admin/product-index.blade.php ENDPATH**/ ?>