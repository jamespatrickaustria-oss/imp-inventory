<div x-data="{ open: false, imagePreview: false }" class="p-2 sm:p-4 lg:p-6">
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="border rounded-xl shadow-sm overflow-hidden bg-white border-gray-200 dark:bg-dark-surface-secondary dark:border-dark-700">
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-dark-700">
            <div>
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Product Categories</h2>
              <p class="text-sm text-gray-600 dark:text-gray-400">Manage and organize your products into logical groups.</p>
            </div>

            <div class="inline-flex items-center gap-x-2">
              <button 
                wire:click="toggleArchived"
                class="py-2 px-5 inline-flex items-center text-sm font-semibold rounded-xl border {{ $showArchived ? 'bg-orange-100 border-orange-300 text-orange-800 dark:bg-orange-900 dark:border-orange-700 dark:text-orange-100' : 'border-gray-200 bg-white text-gray-700 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-300' }} hover:shadow-md transition-all duration-200">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                @if ($showArchived) View Active @else View Archived @endif
              </button>
              <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                  <svg class="size-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <input 
                  type="text" 
                  wire:model.live.debounce.300ms="search" 
                  class="py-2 ps-10 pe-3 block w-full md:w-64 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none bg-white border dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400" 
                  placeholder="Search categories..."
                >
              </div>
              <button 
                wire:click="resetForm"
                @click="open = true"  
                class="py-2 px-5 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Add Category
              </button>
            </div>
          </div>

          @if (session('success'))
            <div class="px-6 py-3 bg-green-100 text-green-700 text-sm">
              {{ session('success') }}
            </div>
          @endif

          <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
            <thead class="bg-gray-50 dark:bg-dark-surface-tertiary">
              <tr>
                <th scope="col" class="px-6 py-3 text-start"><span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">Category Name</span></th>
                <th scope="col" class="px-6 py-3 text-start"><span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">Slug</span></th>
                <th scope="col" class="px-6 py-3 text-start"><span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">Products</span></th>
                <th scope="col" class="px-6 py-4 text-end"><span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">Actions</span></th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-dark-700">
              @forelse ($categories as $category)
                <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface-tertiary transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-x-2">
                      @if($category['image_path'])
                        <img src="{{ asset('storage/' . $category['image_path']) }}" alt="{{ $category['name'] }}" class="size-7 rounded-md object-cover">
                      @else
                        <div class="size-7 flex justify-center items-center bg-gray-100 rounded-md dark:bg-dark-surface-tertiary">
                          <svg class="size-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/></svg>
                        </div>
                      @endif
                      <span class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $category['name'] }} </span>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap"><span class="text-xs font-mono text-gray-500 dark:text-gray-400">{{ $category['slug'] }}</span></td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="py-1 px-2 inline-flex items-center text-xs font-medium bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-100">
                      {{ $category['products_count'] ?? 0 }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                    @if ($showArchived)
                      <button 
                        wire:click="restoreCategory({{ $category['id'] }})"
                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-semibold px-2">
                        Restore
                      </button>
                      <button 
                        wire:click="permanentDeleteCategory({{ $category['id'] }})"
                        wire:confirm="Are you sure you want to permanently delete this category? This action cannot be undone!"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold px-2">
                        Delete
                      </button>
                    @else
                      <button 
                        wire:click="viewCategory({{ $category['id'] }})"
                        class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 font-semibold px-2">
                        View
                      </button>
                      <button 
                        wire:click="editCategory({{ $category['id'] }})"
                        @click="open = true"
                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold px-2">
                        Edit
                      </button>
                      <button 
                        wire:click="deleteCategory({{ $category['id'] }})"
                        wire:confirm="Are you sure you want to delete this category?"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold px-2">
                        Delete
                      </button>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">No categories found</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center dark:border-dark-700">
            <span class="text-sm text-gray-600 dark:text-gray-400">{{ count($categories) }} categories total</span>
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
    
    <div @click.away="open = false" class="bg-white border shadow-sm rounded-xl w-full max-w-lg overflow-hidden transition-all dark:bg-dark-surface-secondary dark:border-dark-700">
      <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 bg-gray-50 dark:border-dark-700 dark:bg-dark-surface-tertiary">
        <h3 class="font-bold text-gray-800 dark:text-gray-100">
          @if ($editingId)
            Edit Category
          @else
            Create New Category
          @endif
        </h3>
        <button @click="open = false; @this.call('resetForm')" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
          <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>

      <form wire:submit="store" class="p-4 sm:p-6 overflow-y-auto">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Category Name <span class="text-red-500">*</span></label>
            <input 
              type="text" 
              wire:model="name"
              class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400 @error('name') border-red-500 @enderror" 
              placeholder="e.g. Home Appliances">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">URL Slug <span class="text-red-500">*</span></label>
            <div class="flex rounded-lg shadow-sm">
              <span class="px-4 inline-flex items-center min-w-fit rounded-s-md border border-e-0 border-gray-200 bg-gray-50 text-sm text-gray-500 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-400">/</span>
              <input 
                type="text" 
                wire:model="slug"
                class="py-2.5 px-4 block w-full border-gray-200 shadow-sm rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400 @error('slug') border-red-500 @enderror" 
                placeholder="home-appliances">
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">The "slug" is the URL-friendly version of the name.</p>
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Description <span class="text-gray-400 font-normal dark:text-gray-500">(Optional)</span></label>
            <textarea 
              wire:model="description"
              class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm dark:border-dark-600 dark:bg-dark-surface-tertiary dark:text-gray-100 dark:placeholder-gray-500 dark:focus:border-blue-400" 
              rows="3" 
              placeholder="Briefly describe the category..."></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-gray-200">Category Image <span class="text-gray-400 font-normal dark:text-gray-500">(Optional)</span></label>
            <input 
              type="file" 
              wire:model="image"
              accept="image/*"
              class="block w-full text-sm text-gray-900 border border-gray-200 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-dark-surface-tertiary dark:border-dark-600 dark:placeholder-gray-400">
            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            
            @if ($image)
              <div class="mt-2">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Click image to view fullscreen</p>
                <div class="relative inline-block">
                  <img 
                    src="{{ $image->temporaryUrl() }}" 
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
            @elseif ($existingImage)
              <div class="mt-2">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Click image to view fullscreen</p>
                <div class="relative inline-block">
                  <img 
                    src="{{ asset('storage/' . $existingImage) }}" 
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
            @endif
          </div>
        </div>
      </form>

      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 bg-gray-50 dark:border-dark-700 dark:bg-dark-surface-tertiary">
        <button 
          @click="open = false; @this.call('resetForm')" 
          class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:border-dark-600 dark:bg-dark-surface-secondary dark:text-gray-100 dark:hover:bg-dark-surface-tertiary">
          Cancel
        </button>
        <button 
          wire:click="store"
          type="button" 
          class="py-2 px-5 inline-flex items-center text-sm font-bold rounded-xl border border-transparent bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-none transition-all duration-200 transform active:scale-95">
          @if ($editingId)
            Update Category
          @else
            Save Category
          @endif
        </button>
      </div>
    </div>
  </div>

  <!-- View Category Products Modal -->
  @if ($viewingCategoryId)
    <div class="fixed inset-0 z-[90] overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
      <div class="bg-white border shadow-sm rounded-xl w-full max-w-4xl overflow-hidden transition-all dark:bg-dark-surface-secondary dark:border-dark-700">
        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 bg-gray-50 dark:border-dark-700 dark:bg-dark-surface-tertiary">
          <h3 class="font-bold text-gray-800 dark:text-gray-100">
            Category Products
          </h3>
          <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>

        <div class="p-4 sm:p-6 overflow-y-auto max-h-[70vh]">
          @if (count($viewingCategoryProducts) > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-dark-700">
                <thead class="bg-gray-50 dark:bg-dark-surface-tertiary">
                  <tr>
                    <th class="px-4 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Product Name</th>
                    <th class="px-4 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">SKU</th>
                    <th class="px-4 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Price</th>
                    <th class="px-4 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Quantity</th>
                    <th class="px-4 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Status</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-dark-700">
                  @foreach ($viewingCategoryProducts as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-dark-surface-tertiary">
                      <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-x-2">
                          @if($product['image_path'])
                            <img src="{{ asset('storage/' . $product['image_path']) }}" alt="{{ $product['name'] }}" class="h-8 w-8 rounded object-cover">
                          @endif
                          <span class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $product['name'] }}</span>
                        </div>
                      </td>
                      <td class="px-4 py-3 whitespace-nowrap">
                        <span class="text-xs font-mono text-gray-600 dark:text-gray-400">{{ $product['sku'] }}</span>
                      </td>
                      <td class="px-4 py-3 whitespace-nowrap">
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-100">₱{{ number_format($product['price'], 2) }}</span>
                      </td>
                      <td class="px-4 py-3 whitespace-nowrap">
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $product['quantity'] }}</span>
                      </td>
                      <td class="px-4 py-3 whitespace-nowrap">
                        @if ($product['quantity'] <= $product['min_stock'])
                          <span class="py-1 px-2 inline-flex items-center text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full dark:bg-yellow-900 dark:text-yellow-100">Low Stock</span>
                        @else
                          <span class="py-1 px-2 inline-flex items-center text-xs font-medium bg-green-100 text-green-800 rounded-full dark:bg-green-900 dark:text-green-100">In Stock</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-8">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No products</h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This category doesn't have any products yet.</p>
            </div>
          @endif
        </div>

        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 bg-gray-50 dark:border-dark-700 dark:bg-dark-surface-tertiary">
          <button 
            wire:click="closeViewModal"
            class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:border-dark-600 dark:bg-dark-surface-secondary dark:text-gray-100 dark:hover:bg-dark-surface-tertiary">
            Close
          </button>
        </div>
      </div>
    </div>
  @endif

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
      @if ($image)
        <img src="{{ $image->temporaryUrl() }}" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl" alt="Fullscreen preview">
      @elseif ($existingImage)
        <img src="{{ asset('storage/' . $existingImage) }}" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl" alt="Fullscreen image">
      @endif
    </div>
    
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm">
      Click anywhere to close
    </div>
  </div>
</div>