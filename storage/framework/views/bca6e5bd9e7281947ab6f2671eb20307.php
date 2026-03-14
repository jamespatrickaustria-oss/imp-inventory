<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
  
  <div class="group flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md transition-all duration-300 dark:bg-dark-surface-secondary dark:border-dark-700">
    <div class="p-5">
      <div class="flex items-center justify-between">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-400">Total Products</p>
        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 dark:bg-blue-500/20 dark:text-blue-300 dark:group-hover:bg-blue-500 dark:group-hover:text-white">
          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
        </div>
      </div>
      <div class="mt-3 flex items-end justify-between">
        <div>
          <h3 class="text-2xl font-bold text-gray-900 leading-none dark:text-gray-100"><?php echo e($totoalProducts); ?></h3>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Items in stock</p>
        </div>
        <span class="flex items-center gap-x-1 py-1 px-2 rounded-lg bg-green-50 text-green-600 font-medium text-xs dark:bg-emerald-500/20 dark:text-emerald-200">
          <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
          <?php echo e($PercentageItemstock); ?>%
        </span>
      </div>
    </div>
  </div>

  <div class="group flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md transition-all duration-300 dark:bg-dark-surface-secondary dark:border-dark-700">
    <div class="p-5">
      <div class="flex items-center justify-between">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-400">Categories</p>
        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 dark:bg-indigo-500/20 dark:text-indigo-300 dark:group-hover:bg-indigo-500 dark:group-hover:text-white">
          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
        </div>
      </div>
      <div class="mt-3">
        <h3 class="text-2xl font-bold text-gray-900 leading-none dark:text-gray-100"><?php echo e($totalCategories); ?></h3>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Live segments</p>
      </div>
    </div>
  </div>

  <div class="group flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md transition-all duration-300 dark:bg-dark-surface-secondary dark:border-dark-700">
    <div class="p-5">
      <div class="flex items-center justify-between">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-400">Out of Stock</p>
        <div class="p-2 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition-colors duration-300 dark:bg-red-500/20 dark:text-red-300 dark:group-hover:bg-red-500 dark:group-hover:text-white">
          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        </div>
      </div>
      <div class="mt-3 flex items-end justify-between">
        <div>
          <h3 class="text-2xl font-bold text-gray-900 leading-none dark:text-gray-100"><?php echo e($totalLowstock); ?></h3>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Needs attention</p>
        </div>
        <span class="py-1 px-2 rounded-lg bg-red-100 text-red-700 font-bold text-[10px] uppercase dark:bg-red-500/20 dark:text-red-200">
          Critical
        </span>
      </div>
    </div>
  </div>

  <div class="group flex flex-col bg-white border border-gray-100 shadow-sm rounded-2xl hover:shadow-md transition-all duration-300 dark:bg-dark-surface-secondary dark:border-dark-700">
    <div class="p-5">
      <div class="flex items-center justify-between">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 dark:text-gray-400">Total of All Items</p>
        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 dark:bg-emerald-500/20 dark:text-emerald-300 dark:group-hover:bg-emerald-500 dark:group-hover:text-white">
          <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
      </div>
      <div class="mt-3">
        <h3 class="text-2xl font-bold text-gray-900 leading-none dark:text-gray-100">₱<?php echo e(number_format($getRevenue, 2)); ?></h3>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Total amount of all items</p>
      </div>
    </div>
  </div>

</div><?php /**PATH C:\Users\Dell\imp-inventory\resources\views/livewire/pages/admin/partials/kpis.blade.php ENDPATH**/ ?>