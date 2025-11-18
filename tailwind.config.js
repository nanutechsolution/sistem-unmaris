import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'unmaris-yellow': '#f7c000', // Eyedrop dari logo
                'unmaris-blue': '#3a2a6a',   // Eyedrop dari logo
                'unmaris-green': '#4caf50',  // Eyedrop dari logo
                'unmaris-orange': '#f57c00', // Eyedrop dari logo
            }
        },
    },

    plugins: [
        forms,
        require('@tailwindcss/typography'),
    ],
};
