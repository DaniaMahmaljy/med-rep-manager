import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [

              'resources/sass/app.scss',

              'resources/js/app.js',

              'resources/static/js/pages/user-form.js'
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
        }
      },

});
