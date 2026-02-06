import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './app/**/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
    ],
    safelist: [
        'border-emerald-200',
        'bg-emerald-50',
        'text-emerald-700',
        'border-indigo-400',
        'bg-indigo-50',
        'text-indigo-700',
        'border-gray-200',
        'bg-gray-100',
        'text-gray-600',
        'border-amber-200',
        'bg-amber-50',
        'text-amber-700',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
