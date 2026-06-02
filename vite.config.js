import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament/rashad/theme.css',
                'resources/css/filament/viewer/dashboard.css',
                'resources/js/filament/viewer/dashboard.js',
                'resources/css/viewer/app.css',
                'resources/js/viewer/app.js',
                'resources/css/viewer/hub.css',
                'resources/js/viewer/hub.js',
                'resources/css/viewer/reports.css',
                'resources/js/viewer/reports.js',
                'resources/css/viewer-new/app.css',
                'resources/css/viewer-new/properties-report.css',
                'resources/css/viewer-new/property-show.css',
                'resources/js/viewer-new/app.js',
                'resources/js/viewer-new/properties-report.js',
                'resources/js/viewer-new/property-show.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
