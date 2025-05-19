import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
              'resources/sass/app.scss',
              'resources/scss/pages/datatables.scss',
              'resources/js/app.js',
              'resources/static/js/pages/user-form.js',
              'resources/js/pages/ui-map-leaflet.js',
              'resources/static/js/pages/datatables.js',
              'resources/static/js/pages/visitsTable.js',
              'resources/static/js/pages/viewRepMap.js',
              'resoursces/static/js/pages/repAllVisits.js',
              'resources/static/js/pages/repStatistics.js',
              'resources/static/js/pages/doctorSamples.js',
              'resources/static/js/pages/ticketsTable.js',
              'resoursces/static/js/pages/doctorAllVisits.js',
              'resources/static/js/pages/adminsTable.js',
              'resources/static/js/pages/supervisorTable.js',
            ],

            refresh: true,
        }),
    ],




    resolve: {
        alias: {
          '@': '/resources/js',
          '~': '/resources/scss',
          '~themes': '/resources/scss/themes',
          '~bootstrap-icons': 'bootstrap-icons',
          '~@fontsource': '/node_modules/@fontsource',
          '/assets/static/js':'/public/static/js',
          'jquery': 'jquery/dist/jquery.min.js',
        }
      },

});
