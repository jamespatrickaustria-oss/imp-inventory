import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "node_modules/preline/dist/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dark: {
                    50: '#f9f9f9',
                    100: '#f3f3f3',
                    200: '#e8e8e8',
                    300: '#d1d1d1',
                    400: '#b0b0b0',
                    500: '#888888',
                    600: '#666666',
                    700: '#444444',
                    800: '#2d2d2d',
                    900: '#1a1a1a',
                    950: '#0f0f0f',
                },
            },
            backgroundColor: {
                'dark-surface': '#1a1a1a',
                'dark-surface-secondary': '#2d2d2d',
                'dark-surface-tertiary': '#3f3f3f',
            },
        },
    },

    plugins: [forms],
};
