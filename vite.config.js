import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
     watch: {
        usePolling: true,
        origin: 'tiranossaurorex.com.br/admin'
    },
    server: {
        hmr: {
            host: 'tiranossaurorex.com.br/admin/'
        }
    }
});
