<div>
    <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" 
        class="fixed inset-0 z-20 bg-gray-900/50 backdrop-blur-sm lg:hidden transition-opacity dark:bg-dark-surface/80">
    </div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
        class="fixed z-30 inset-y-0 left-0 w-72 h-screen transition-all duration-300 transform bg-white border-r border-gray-200 lg:translate-x-0 lg:static flex flex-col shadow-sm dark:bg-dark-surface-secondary dark:border-dark-700">
        
        <div class="h-16 flex-none flex items-center justify-between px-6 border-b border-gray-100 dark:border-dark-700">
            <a class="flex items-center gap-2 tracking-tight tap-feedback" href="<?php echo e(route('admin.dashboard')); ?>">
                <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold shadow-blue-200 shadow-lg">
                    I
                </div>
                <span class="text-lg font-bold text-gray-900 dark:text-gray-100">Imperial<span class="text-blue-600"> Stock</span></span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden p-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 tap-feedback">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 mt-4 px-4 space-y-6 overflow-y-auto custom-scrollbar">
            <div>
                <p class="px-4 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Main Menu</p>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 group tap-feedback <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-dark-surface-tertiary dark:text-blue-400' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-dark-surface-tertiary dark:hover:text-white'); ?>">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Dashboard
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Inventory</p>
                
                
                <div class="space-y-1">

                    <a href="<?php echo e(route('admin.categories')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 group tap-feedback <?php echo e(request()->routeIs('admin.categories') ? 'bg-blue-50 text-blue-700 dark:bg-dark-surface-tertiary dark:text-blue-400' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-dark-surface-tertiary dark:hover:text-white'); ?>">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        Categories
                    </a>

                    <a href="<?php echo e(route('admin.products')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 group tap-feedback <?php echo e(request()->routeIs('admin.products') ? 'bg-blue-50 text-blue-700 dark:bg-dark-surface-tertiary dark:text-blue-400' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-dark-surface-tertiary dark:hover:text-white'); ?>">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        Products
                    </a>

                    

                    <a href="<?php echo e(route('admin.reports')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 group tap-feedback <?php echo e(request()->routeIs('admin.reports') ? 'bg-blue-50 text-blue-700 dark:bg-dark-surface-tertiary dark:text-blue-400' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-dark-surface-tertiary dark:hover:text-white'); ?>">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10V9m-9 8h10a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        Reports
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Users</p>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.users')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 group tap-feedback <?php echo e(request()->routeIs('admin.users') ? 'bg-blue-50 text-blue-700 dark:bg-dark-surface-tertiary dark:text-blue-400' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-dark-surface-tertiary dark:hover:text-white'); ?>">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        User List
                    </a>

                    <a href="<?php echo e(route('admin.users.register')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 group tap-feedback <?php echo e(request()->routeIs('admin.users.register') ? 'bg-blue-50 text-blue-700 dark:bg-dark-surface-tertiary dark:text-blue-400' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-dark-surface-tertiary dark:hover:text-white'); ?>">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        Register User
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">System</p>
                <div class="space-y-1">
                    <a href="<?php echo e(route('profile')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 group tap-feedback <?php echo e(request()->routeIs('profile') ? 'bg-blue-50 text-blue-700 dark:bg-dark-surface-tertiary dark:text-blue-400' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-dark-surface-tertiary dark:hover:text-white'); ?>">
                        <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Profile Settings
                    </a>
                </div>
            </div>
        </nav>

        <div class="flex-none p-4 border-t border-gray-100 bg-gray-50/50 dark:border-dark-700 dark:bg-dark-surface-tertiary/30">
            <div class="flex items-center gap-3 px-2">
                <div class="h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                    <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-gray-900 dark:text-gray-100 truncate"><?php echo e(Auth::user()->name); ?></p>
                    <p class="text-[10px] font-medium text-gray-500 dark:text-gray-400 truncate uppercase tracking-tight">Administrator</p>
                </div>
            </div>
        </div>
    </aside>
</div><?php /**PATH C:\Users\Dell\imp-inventory\resources\views/livewire/pages/admin/partials/sidebar.blade.php ENDPATH**/ ?>