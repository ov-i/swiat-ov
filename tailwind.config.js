import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import { buttons } from './resources/js/tailwindcss/plugins/components/buttons';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: ['selector', '[data-theme="dark"]'],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                primary: 'Nunito Sans',
                secondary: 'Open Sans'
            },

            colors: {
                asideMenu: '#1e293b',
                darkAsideMenu: '#1c2637',
                dark: '#323232',
                gray_accent: '#C1C1C1',
            },

            screens: {
                'v-large': '2100px'
            },
        },
    },

    plugins: [forms, typography, buttons],
};
