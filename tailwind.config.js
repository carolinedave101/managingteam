import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Filament/**/*.php',
    ],

    safelist: [
        'border-red-400', 'bg-red-50', 'focus:border-red-500', 'focus:ring-red-500',
        'border-green-400', 'bg-green-50', 'focus:border-green-500', 'focus:ring-green-500',
        'text-green-600', 'text-red-500',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', 'ui-serif', 'Georgia', 'serif'],
            },
            colors: {
                brand: {
                    50: '#fdf2f8',
                    100: '#fce7f3',
                    200: '#fbcfe8',
                    300: '#f9a8d4',
                    400: '#f472b6',
                    500: '#ec4899',
                    600: '#db2777',
                    700: '#be185d',
                    800: '#9d174d',
                    900: '#831843',
                },
            },
            boxShadow: {
                glow: '0 10px 40px -10px rgba(236, 72, 153, 0.35)',
            },
            keyframes: {
                'fade-in': {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
            },
            animation: {
                'fade-in': 'fade-in .4s ease-out',
            },
        },
    },

    plugins: [forms],
};
