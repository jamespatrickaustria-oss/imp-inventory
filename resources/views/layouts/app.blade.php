<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
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
<body class="bg-gray-50 text-gray-900 dark:bg-dark-surface dark:text-gray-100">

    <div class="w-full lg:ps-64">
        
        <main class="p-4 sm:p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
