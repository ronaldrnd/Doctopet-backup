import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    /*
    server: {
        host: '0.0.0.0', // Permet l'accès depuis n'importe quelle adresse IP
        port: 5173,      // Port utilisé par Vite (par défaut)
        hmr: {
            host: '10.56.37.48', // Remplacez par l'adresse IP de votre machine
        },
    },

     */
});
