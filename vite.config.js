import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';


export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',  // Pastikan ini file utama Vue Anda
            refresh: true,  // Auto-refresh ketika ada perubahan di file Vue
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js' // Alias untuk folder js di resources Pages
        },
        
    },
    server: {
        assetsInclude: ['**/*.vue'],
    },
});
