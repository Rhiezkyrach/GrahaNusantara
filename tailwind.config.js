import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    daisyui: {
        themes: ['light'],
    },
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                'sans': ["Figtree", "sans-serif"],
            },
            fontSize: {
                'xxs': ["11px", "13px"],
                'xxxs': ["9px", "11px"],
            },
        },
    },
    
    plugins: [forms, typography, require('daisyui')],
};
