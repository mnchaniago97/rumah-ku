import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/template/css/style.css',
                'resources/js/admin.js',
                'resources/js/agent.js',
                // Frontend assets
                'resources/css/frontend.css',
                'resources/js/frontend.js',
                'resources/js/bootstrap.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@frontend': path.resolve(__dirname, 'resources/css/frontend'),
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
