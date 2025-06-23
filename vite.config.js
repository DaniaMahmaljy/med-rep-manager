import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

export default defineConfig({
    define: {
        __BASE_URL__: JSON.stringify(process.env.NODE_ENV === 'production' ? '/dania_mah/public' : ''),
    },
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/themes/dark/app-dark.scss',
                'resources/scss/pages/datatables.scss',
                'resources/scss/iconly.scss',
                'resources/scss/pages/auth.scss',
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/static/js/initTheme.js',
                'resources/static/js/components/dark.js',
                'resources/js/dashboard.js',
                'resources/static/js/pages/user-form.js',
                'resources/static/js/pages/ui-map-leaflet.js',
                'resources/static/js/pages/datatables.js',
                'resources/static/js/pages/visitsTable.js',
                'resources/static/js/pages/viewRepMap.js',
                'resources/static/js/pages/doctorsTable.js',
                'resources/static/js/pages/doctorStatistics.js',
                'resources/static/js/pages/repAllVisits.js',
                'resources/static/js/pages/representativesTable.js',
                'resources/static/js/pages/repStatistics.js',
                'resources/static/js/pages/doctorSamples.js',
                'resources/static/js/pages/ticketsTable.js',
                'resources/static/js/pages/doctorAllVisits.js',
                'resources/static/js/pages/adminsTable.js',
                'resources/static/js/pages/supervisorTable.js',
                'resources/static/js/pages/sampleTable.js',
            ],

            refresh: true,
        }),

     viteStaticCopy({
        targets: [
            {
           src: 'node_modules/@fontsource/nunito/files/*.woff*',
           dest: 'assets/fonts'
            },
            {
            src: 'node_modules/bootstrap-icons/font/fonts/*.woff*',
             dest: 'assets/fonts'
            }
        ]
        })
            ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '~': '/resources/scss',
            '~themes': '/resources/scss/themes',
            '~bootstrap-icons': 'bootstrap-icons',
            '~@fontsource': '/node_modules/@fontsource',
            'jquery': 'jquery/dist/jquery.min.js',
        }
    },
    build: {
        manifest: 'manifest.json',
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            output: {
               assetFileNames: (assetInfo) => {
                if (/\.(woff2?|ttf|eot|otf)$/.test(assetInfo.name)) {
                    return 'assets/fonts/[name][extname]';
                }
                return 'assets/[name]-[hash][extname]';
                }
            }
        }
    },
     css: {
        preprocessorOptions: {
            scss: {
                additionalData: `
                    @use "sass:math";
                    $bootstrap-icons-font-src: url('~bootstrap-icons/font/fonts/bootstrap-icons.woff2') format("woff2"),
                                              url('~bootstrap-icons/font/fonts/bootstrap-icons.woff') format("woff");
                `
            }
        }
    }
});
