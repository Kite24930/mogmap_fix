import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        https: true,
    },
    build: {
        manifest: true,
        rollupOptions: {
            input: {
                welcome: 'resources/js/welcome.js',
                welcomeCss: 'resources/css/welcome.css',
                index: 'resources/js/index.js',
                indexCss: 'resources/css/index.css',
            }
        }
    }
});
