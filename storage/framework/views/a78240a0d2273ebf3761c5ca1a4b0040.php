<div x-data="{ open: false }" class="p-2 sm:p-4 lg:p-6">
    <div class="mb-5">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Product Inventory</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Manage your SKU, pricing, and stock levels.</p>
    </div>

    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-dark-surface-secondary dark:border-dark-700">
                    
                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-dark-700">
                        <div class="relative max-w-xs">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" name="search" wire:model.live.debounce.300ms="search" id="search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400" placeholder="Search products...">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            </div>
                        </div>

                        <div class="inline-flex gap-x-2">
                            <button @click="open = true"  class="py-2 px-5 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
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
                                <th class="px-6 py-4 text-end"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-dark-700">
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface-tertiary">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 dark:bg-dark-surface-tertiary dark:text-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-100"><?php echo e($product->name); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300"><?php echo e($product->sku); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300"><?php echo e($product->category->name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300"><?php echo e($product->stock); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300"><?php echo e($product->price); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="py-1 px-2 inline-flex items-center text-xs font-medium bg-green-100 text-green-800 rounded-full dark:bg-emerald-500/20 dark:text-emerald-200">In Stock</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Edit</button>
                                </td>
                            </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center dark:border-dark-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Showing 2 results</span>
                        <div class="inline-flex gap-x-2">
                            <button class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:hover:bg-dark-surface-secondary">Previous</button>
                            <button class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:hover:bg-dark-surface-secondary">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="open" 
         class="fixed inset-0 z-[80] overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4" 
         style="display: none;"
         x-transition>
        
        <div @click.away="open = false" class="bg-white border shadow-sm rounded-xl w-full max-w-2xl transform transition-all dark:bg-dark-surface-secondary dark:border-dark-700">
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-dark-700">
                <h3 class="font-bold text-gray-800 dark:text-gray-100">Create New Product</h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Product Name</label>
                            <input type="text" class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:focus:border-blue-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">SKU</label>
                            <input type="text" class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400" placeholder="PRD-001">
                        </div>
                    </div>

                    <div x-data="{ selectOpen: false, search: '', selected: 'Select Category' }">
                        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Category</label>
                        <div class="relative">
                            <button type="button" @click="selectOpen = !selectOpen" class="relative w-full text-start py-2.5 px-4 inline-flex justify-between items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:hover:bg-dark-surface-secondary">
                                <span x-text="selected"></span>
                                <svg class="flex-shrink-0 w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </button>

                            <div x-show="selectOpen" @click.away="selectOpen = false" x-transition class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-dark-surface-secondary dark:border-dark-700">
                                <div class="p-2 border-b border-gray-200 dark:border-dark-700">
                                    <div class="relative">
                                        <input type="text" x-model="search" class="py-2 px-3 ps-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400" placeholder="Search categories...">
                                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                            <svg class="h-3.5 w-3.5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1 max-h-44 overflow-y-auto scrollbar-thin">
                                    <template x-if="search === '' || 'electronics'.includes(search.toLowerCase())">
                                        <button type="button" @click="selected = 'Electronics'; selectOpen = false" class="w-full flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none dark:text-gray-100 dark:hover:bg-dark-surface-tertiary">
                                            Electronics
                                        </button>
                                    </template>
                                    <template x-if="search === '' || 'accessories'.includes(search.toLowerCase())">
                                        <button type="button" @click="selected = 'Accessories'; selectOpen = false" class="w-full flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none dark:text-gray-100 dark:hover:bg-dark-surface-tertiary">
                                            Accessories
                                        </button>
                                    </template>
                                    <template x-if="search === '' || 'furniture'.includes(search.toLowerCase())">
                                        <button type="button" @click="selected = 'Furniture'; selectOpen = false" class="w-full flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none dark:text-gray-100 dark:hover:bg-dark-surface-tertiary">
                                            Furniture
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Price ($)</label>
                            <input type="number" step="0.01" class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Quantity</label>
                            <input type="number" class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Min Stock</label>
                            <input type="number" class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100" value="5">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Product Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl dark:border-dark-600">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label class="relative cursor-pointer font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                                        <span>Upload a file</span>
                                        <input type="file" class="sr-only">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-dark-700">
                <button @click="open = false" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:hover:bg-dark-surface-secondary">
                    Discard
                </button>
                <button type="button"  class="py-2.5 px-6 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
                    Save Product
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\Dell\StockMaster-Pro\StockMaster-Pro\resources\views/livewire/pages/admin/product-index.blade.php ENDPATH**/ ?>