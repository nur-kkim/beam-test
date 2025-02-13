import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    server: {
        host: '0.0.0.0', // Allow access from outside the container
        port: 5173,      // Vite dev server port
        hmr: {
            host: 'localhost', // Hot Module Replacement host
        },
    },
});