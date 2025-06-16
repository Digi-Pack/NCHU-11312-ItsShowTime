import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { resolve } from 'node:path';
import { defineConfig } from 'vite';
import AutoImport from 'unplugin-auto-import/vite';
import Components from 'unplugin-vue-components/vite';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
          dirs: ['resources/js/Components'],
        }),
        AutoImport({
          imports: ['vue'],
          dirs: ['resources/js/Store/**'],
          vueTemplate: true,
          eslintrc: {
            enabled: true,
          },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            '/images': path.resolve(__dirname, './resources/images'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
            '/css': path.resolve(__dirname, './resources/css'),
        },
    },
    css: {
        postcss: {
            plugins: [tailwindcss, autoprefixer],
        },
    },
});
