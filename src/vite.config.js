import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',  // Nosso SCSS com Bootstrap
                'resources/js/app.js',       // Nosso JavaScript
            ],
            refresh: true,
        }),
    ],
    // Configuração para o Docker funcionar corretamente
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
    },
});