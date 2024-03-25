import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import { buttons } from './resources/js/tailwindcss/plugins/components/button';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
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
                dark: '#323232',
                gray_accent: '#C1C1C1'
            },

            screens: {
                'v-large': '2100px'
            },
        },
    },

    plugins: [forms, typography, buttons],
};
