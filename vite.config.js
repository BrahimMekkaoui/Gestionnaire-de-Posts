import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fullReload from 'vite-plugin-full-reload';

// Configuration minimale
export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 3000,
        hmr: {
            host: 'localhost',
        },
    },
    build: {
        outDir: 'public/build',
        manifest: true,
    },

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        fullReload(['resources/views/**/*.blade.php']),
    ],

});
