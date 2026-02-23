<div x-data="{ open: false }" class="p-2 sm:p-4 lg:p-6">
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="border rounded-xl shadow-sm overflow-hidden bg-white border-gray-200">
<div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
  <div>
    <h2 class="text-xl font-semibold text-gray-800">Product Categories</h2>
    <p class="text-sm text-gray-600">Manage and organize your products into logical groups.</p>
  </div>

  <div class="inline-flex items-center gap-x-2">
    <div class="relative">
      <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
        <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
      </div>
      <input 
        type="text" 
        wire:model.live.debounce.300ms="search" 
        class="py-2 ps-10 pe-3 block w-full md:w-64 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none bg-white border" 
        placeholder="Search categories..."
      >
    </div>
<button @click="open = true"  class="py-2 px-5 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
      <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      Add Category
    </button>
  </div>
</div>

          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-start"><span class="text-xs font-semibold uppercase tracking-wide text-gray-800">Category Name</span></th>
                <th scope="col" class="px-6 py-3 text-start"><span class="text-xs font-semibold uppercase tracking-wide text-gray-800">Slug</span></th>
                <th scope="col" class="px-6 py-3 text-start"><span class="text-xs font-semibold uppercase tracking-wide text-gray-800">Visibility</span></th>
                <th scope="col" class="px-6 py-4 text-end"></th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center gap-x-2">
                    <div class="size-7 flex justify-center items-center bg-gray-100 rounded-md">
                      <svg class="size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($category->name); ?> </span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap"><span class="text-xs font-mono text-gray-500"><?php echo e($category->slug); ?></span></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Published</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                  <button type="button" class="text-blue-600 hover:text-blue-800 font-semibold px-2">Edit</button>
                  <button type="button" class="text-red-600 hover:text-red-800 font-semibold px-2">Delete</button>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
          </table>

          <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
            <span class="text-sm text-gray-600">12 categories total</span>
            <nav class="flex items-center -space-x-px">
              <button class="py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm font-medium rounded-s-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">Previous</button>
              <button class="py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm font-medium rounded-e-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">Next</button>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div x-show="open" 
       class="fixed inset-0 z-[80] overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4" 
       style="display: none;"
       x-transition>
    
    <div @click.away="open = false" class="bg-white border shadow-sm rounded-xl w-full max-w-lg overflow-hidden transition-all">
      <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 bg-gray-50">
        <h3 class="font-bold text-gray-800">Create New Category</h3>
        <button @click="open = false" class="text-gray-400 hover:text-gray-600">
          <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>

      <div class="p-4 sm:p-6 overflow-y-auto">
        <form class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-2 text-gray-800">Category Name</label>
            <input type="text" 
                   class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" 
                   placeholder="e.g. Home Appliances"
                   @input="slug = $event.target.value.toLowerCase().replace(/ /g, '-')">
          </div>

          <div>
            <label class="block text-sm font-medium mb-2 text-gray-800">URL Slug</label>
            <div class="flex rounded-lg shadow-sm">
              <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500">/</span>
              <input type="text" class="py-2.5 px-4 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="home-appliances">
            </div>
            <p class="mt-2 text-xs text-gray-500">The "slug" is the URL-friendly version of the name.</p>
          </div>

          <div>
            <label class="block text-sm font-medium mb-2 text-gray-800">Visibility</label>
            <div class="flex gap-x-6">
              <div class="flex">
                <input type="radio" name="visibility" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500" id="v-pub" checked>
                <label for="v-pub" class="text-sm text-gray-500 ms-2">Published</label>
              </div>
              <div class="flex">
                <input type="radio" name="visibility" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500" id="v-hid">
                <label for="v-hid" class="text-sm text-gray-500 ms-2">Hidden</label>
              </div>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium mb-2 text-gray-800">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
            <textarea class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" rows="3" placeholder="Briefly describe the category..."></textarea>
          </div>
        </form>
      </div>

      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 bg-gray-50">
        <button @click="open = false" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50">
          Cancel
        </button>
        <button type="submit" class="py-2 px-5 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
          Save Category
        </button>
      </div>
    </div>
  </div>
</div><?php /**PATH C:\Users\Dell\StockMaster-Pro\StockMaster-Pro\resources\views\livewire\pages\admin\category-index.blade.php ENDPATH**/ ?>