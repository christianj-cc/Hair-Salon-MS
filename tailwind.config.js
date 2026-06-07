import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#ae2810',
                gradient: '#a02812',
                secondary: '#6e0104', // keep goldenrod or adjust
                accent: '#800020', // burgundy (optional)
                // Add a darker shade for hover states
                'primary-dark': '#dedede',
            },
        },
    },

    plugins: [forms],
};