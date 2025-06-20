import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {



        extend: {


            spacing: {
                'dashboard-spacing': '7rem', // Correspond à 76px (entre mt-16 et mt-20)
            },

            width: {
                'fill-available': '-webkit-fill-available',
            },

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                shake: {
                    '0%, 100%': { transform: 'translateX(0)' },
                    '25%': { transform: 'translateX(-5px)' },
                    '50%': { transform: 'translateX(5px)' },
                    '75%': { transform: 'translateX(-5px)' },
                },
            },
            animation: {
                shake: 'shake 0.5s ease-in-out',
            },
        },
    },
    plugins: [],
};
