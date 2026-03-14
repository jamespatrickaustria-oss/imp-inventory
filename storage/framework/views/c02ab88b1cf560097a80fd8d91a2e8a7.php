<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <!-- Initialize theme immediately to prevent flash -->
        <script>
            (function() {
                const theme = localStorage.getItem('theme');
                const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                const activeTheme = theme || systemTheme;
                if (activeTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased dark:text-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-sky-50 to-blue-100 dark:bg-dark-surface relative">
            <!-- Header Section -->
            <header class="w-full bg-sky-100 dark:bg-dark-surface-secondary border-b border-sky-200 dark:border-dark-700 sticky top-0 z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <!-- Logo/Image on the left -->
                    <div class="flex items-center gap-3">
                        <img src="/images/imp.png" alt="Company Logo" class="h-12 w-auto sm:h-14 md:h-16 object-contain responsive-logo" loading="lazy">
                    </div>
                    
                    <!-- Theme Toggle on the right -->
                    <button
                        type="button"
                        data-theme-toggle
                        class="inline-flex items-center justify-center w-9 h-9 rounded-md text-gray-600 hover:text-blue-700 hover:bg-white dark:text-gray-300 dark:hover:text-white dark:hover:bg-dark-surface-tertiary transition tap-feedback"
                        aria-label="Toggle theme"
                    >
                        <svg data-theme-icon="dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                        <svg data-theme-icon="light" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m14.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414m12.728 0l-1.414-1.414M6.05 6.05L4.636 4.636M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Main Content -->
            <div class="w-full flex flex-col sm:justify-center items-center flex-1 sm:pt-0 px-4">
                <div class="w-full sm:max-w-md mt-8 sm:mt-12 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-xl dark:bg-dark-surface-secondary border border-sky-200 dark:border-dark-700">
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold text-sky-900 dark:text-blue-200">Welcome Back</h1>
                        <p class="text-sm text-sky-700 dark:text-sky-300 mt-1">Sign in to your account</p>
                    </div>
                    <?php echo e($slot); ?>

                </div>
            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\Users\Dell\imp-inventory\resources\views/layouts/guest.blade.php ENDPATH**/ ?>