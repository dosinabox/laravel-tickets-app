import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/common.css',
                'resources/css/login.css',
                'resources/css/rejected.css',
                'resources/css/search.css',
                'resources/css/vip.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
