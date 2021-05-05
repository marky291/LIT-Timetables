const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                dark: {
                    header: '#232626',
                    panel: '#232626',
                    input: '#3a3b3c',
                    background: '#191a1b',
                    border: '#3d4042',
                    button: '#393c3c',
                    icon: '#b0b3b8',
                    text: '#e3e6ea',
                    red: '#f02848',
                    green: '#43be62',
                    yellow: '#f7ba27',
                    blue: '#4499ff',
                },
                'coolgray': '#f7f8fc',
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            display: ['dark'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
