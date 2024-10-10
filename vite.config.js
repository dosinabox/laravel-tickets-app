import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/visitors/common.css',
                'resources/css/visitors/employee.css',
                'resources/css/visitors/login.css',
                'resources/css/visitors/manage.css',
                'resources/css/visitors/rejected.css',
                'resources/css/visitors/search.css',
                'resources/css/visitors/vip.css',
                'resources/js/app.js',
                'resources/js/visitors/manage.js',
            ],
            refresh: true,
        }),
    ],
});
