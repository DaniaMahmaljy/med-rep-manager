// vite.config.js
import { defineConfig } from "file:///C:/xampp/htdocs/MedRepManager/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/xampp/htdocs/MedRepManager/node_modules/laravel-vite-plugin/dist/index.js";
import { viteStaticCopy } from "file:///C:/xampp/htdocs/MedRepManager/node_modules/vite-plugin-static-copy/dist/index.js";
var vite_config_default = defineConfig({
  define: {
    __BASE_URL__: JSON.stringify(process.env.NODE_ENV === "production" ? "/dania_mah/public" : "")
  },
  plugins: [
    laravel({
      input: [
        "resources/scss/app.scss",
        "resources/scss/themes/dark/app-dark.scss",
        "resources/scss/pages/datatables.scss",
        "resources/scss/iconly.scss",
        "resources/scss/pages/auth.scss",
        "resources/js/app.js",
        "resources/css/app.css",
        "resources/static/js/initTheme.js",
        "resources/static/js/components/dark.js",
        "resources/js/dashboard.js",
        "resources/static/js/pages/user-form.js",
        "resources/static/js/pages/ui-map-leaflet.js",
        "resources/static/js/pages/datatables.js",
        "resources/static/js/pages/visitsTable.js",
        "resources/static/js/pages/viewRepMap.js",
        "resources/static/js/pages/doctorsTable.js",
        "resources/static/js/pages/doctorStatistics.js",
        "resources/static/js/pages/repAllVisits.js",
        "resources/static/js/pages/representativesTable.js",
        "resources/static/js/pages/repStatistics.js",
        "resources/static/js/pages/doctorSamples.js",
        "resources/static/js/pages/ticketsTable.js",
        "resources/static/js/pages/doctorAllVisits.js",
        "resources/static/js/pages/adminsTable.js",
        "resources/static/js/pages/supervisorTable.js",
        "resources/static/js/pages/sampleTable.js"
      ],
      define: {
        "process.env": process.env
      },
      refresh: true
    }),
    viteStaticCopy({
      targets: [
        {
          src: "node_modules/@fontsource/nunito/files/*.woff*",
          dest: "assets/fonts"
        }
      ]
    })
  ],
  resolve: {
    alias: {
      "@": "/resources/js",
      "~": "/resources/scss",
      "~themes": "/resources/scss/themes",
      "~bootstrap-icons": "bootstrap-icons",
      "~@fontsource": "/node_modules/@fontsource",
      "jquery": "jquery/dist/jquery.min.js"
    }
  },
  build: {
    manifest: "manifest.json",
    outDir: "public/build",
    emptyOutDir: true,
    rollupOptions: {
      output: {
        assetFileNames: (assetInfo) => {
          if (/\.(woff2?|ttf|eot|otf)$/.test(assetInfo.name)) {
            return "assets/fonts/[name][extname]";
          }
          return "assets/[name]-[hash][extname]";
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
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFx4YW1wcFxcXFxodGRvY3NcXFxcTWVkUmVwTWFuYWdlclwiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiQzpcXFxceGFtcHBcXFxcaHRkb2NzXFxcXE1lZFJlcE1hbmFnZXJcXFxcdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0M6L3hhbXBwL2h0ZG9jcy9NZWRSZXBNYW5hZ2VyL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB7IHZpdGVTdGF0aWNDb3B5IH0gZnJvbSAndml0ZS1wbHVnaW4tc3RhdGljLWNvcHknO1xuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIGRlZmluZToge1xuICAgICAgICBfX0JBU0VfVVJMX186IEpTT04uc3RyaW5naWZ5KHByb2Nlc3MuZW52Lk5PREVfRU5WID09PSAncHJvZHVjdGlvbicgPyAnL2RhbmlhX21haC9wdWJsaWMnIDogJycpLFxuICAgIH0sXG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zY3NzL2FwcC5zY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3Njc3MvdGhlbWVzL2RhcmsvYXBwLWRhcmsuc2NzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zY3NzL3BhZ2VzL2RhdGF0YWJsZXMuc2NzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zY3NzL2ljb25seS5zY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3Njc3MvcGFnZXMvYXV0aC5zY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zdGF0aWMvanMvaW5pdFRoZW1lLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9jb21wb25lbnRzL2RhcmsuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvZGFzaGJvYXJkLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9wYWdlcy91c2VyLWZvcm0uanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc3RhdGljL2pzL3BhZ2VzL3VpLW1hcC1sZWFmbGV0LmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9wYWdlcy9kYXRhdGFibGVzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9wYWdlcy92aXNpdHNUYWJsZS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zdGF0aWMvanMvcGFnZXMvdmlld1JlcE1hcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zdGF0aWMvanMvcGFnZXMvZG9jdG9yc1RhYmxlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9wYWdlcy9kb2N0b3JTdGF0aXN0aWNzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9wYWdlcy9yZXBBbGxWaXNpdHMuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc3RhdGljL2pzL3BhZ2VzL3JlcHJlc2VudGF0aXZlc1RhYmxlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9wYWdlcy9yZXBTdGF0aXN0aWNzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9wYWdlcy9kb2N0b3JTYW1wbGVzLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3N0YXRpYy9qcy9wYWdlcy90aWNrZXRzVGFibGUuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc3RhdGljL2pzL3BhZ2VzL2RvY3RvckFsbFZpc2l0cy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zdGF0aWMvanMvcGFnZXMvYWRtaW5zVGFibGUuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc3RhdGljL2pzL3BhZ2VzL3N1cGVydmlzb3JUYWJsZS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zdGF0aWMvanMvcGFnZXMvc2FtcGxlVGFibGUuanMnLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgICBkZWZpbmU6IHtcbiAgICAgICAgICAgICAgICAncHJvY2Vzcy5lbnYnOiBwcm9jZXNzLmVudlxuICAgICAgICAgICAgfSxcblxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG5cblxuICAgICB2aXRlU3RhdGljQ29weSh7XG4gICAgICAgIHRhcmdldHM6IFtcbiAgICAgICAgICAgIHtcbiAgICAgICAgICAgIHNyYzogJ25vZGVfbW9kdWxlcy9AZm9udHNvdXJjZS9udW5pdG8vZmlsZXMvKi53b2ZmKicsXG4gICAgICAgICAgICBkZXN0OiAnYXNzZXRzL2ZvbnRzJ1xuICAgICAgICAgICAgfVxuICAgICAgICBdXG4gICAgICAgIH0pXG4gICAgICAgICAgICBdLFxuICAgIHJlc29sdmU6IHtcbiAgICAgICAgYWxpYXM6IHtcbiAgICAgICAgICAgICdAJzogJy9yZXNvdXJjZXMvanMnLFxuICAgICAgICAgICAgJ34nOiAnL3Jlc291cmNlcy9zY3NzJyxcbiAgICAgICAgICAgICd+dGhlbWVzJzogJy9yZXNvdXJjZXMvc2Nzcy90aGVtZXMnLFxuICAgICAgICAgICAgJ35ib290c3RyYXAtaWNvbnMnOiAnYm9vdHN0cmFwLWljb25zJyxcbiAgICAgICAgICAgICd+QGZvbnRzb3VyY2UnOiAnL25vZGVfbW9kdWxlcy9AZm9udHNvdXJjZScsXG4gICAgICAgICAgICAnanF1ZXJ5JzogJ2pxdWVyeS9kaXN0L2pxdWVyeS5taW4uanMnLFxuICAgICAgICB9XG4gICAgfSxcbiAgICBidWlsZDoge1xuICAgICAgICBtYW5pZmVzdDogJ21hbmlmZXN0Lmpzb24nLFxuICAgICAgICBvdXREaXI6ICdwdWJsaWMvYnVpbGQnLFxuICAgICAgICBlbXB0eU91dERpcjogdHJ1ZSxcbiAgICAgICAgcm9sbHVwT3B0aW9uczoge1xuICAgICAgICAgICAgb3V0cHV0OiB7XG4gICAgICAgICAgICAgICBhc3NldEZpbGVOYW1lczogKGFzc2V0SW5mbykgPT4ge1xuICAgICAgICAgICAgICAgIGlmICgvXFwuKHdvZmYyP3x0dGZ8ZW90fG90ZikkLy50ZXN0KGFzc2V0SW5mby5uYW1lKSkge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gJ2Fzc2V0cy9mb250cy9bbmFtZV1bZXh0bmFtZV0nO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICByZXR1cm4gJ2Fzc2V0cy9bbmFtZV0tW2hhc2hdW2V4dG5hbWVdJztcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICB9LFxuICAgICBjc3M6IHtcbiAgICAgICAgcHJlcHJvY2Vzc29yT3B0aW9uczoge1xuICAgICAgICAgICAgc2Nzczoge1xuICAgICAgICAgICAgICAgIGFkZGl0aW9uYWxEYXRhOiBgXG4gICAgICAgICAgICAgICAgICAgIEB1c2UgXCJzYXNzOm1hdGhcIjtcbiAgICAgICAgICAgICAgICAgICAgJGJvb3RzdHJhcC1pY29ucy1mb250LXNyYzogdXJsKCd+Ym9vdHN0cmFwLWljb25zL2ZvbnQvZm9udHMvYm9vdHN0cmFwLWljb25zLndvZmYyJykgZm9ybWF0KFwid29mZjJcIiksXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsKCd+Ym9vdHN0cmFwLWljb25zL2ZvbnQvZm9udHMvYm9vdHN0cmFwLWljb25zLndvZmYnKSBmb3JtYXQoXCJ3b2ZmXCIpO1xuICAgICAgICAgICAgICAgIGBcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgIH1cbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUFpUixTQUFTLG9CQUFvQjtBQUM5UyxPQUFPLGFBQWE7QUFDcEIsU0FBUyxzQkFBc0I7QUFFL0IsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsUUFBUTtBQUFBLElBQ0osY0FBYyxLQUFLLFVBQVUsUUFBUSxJQUFJLGFBQWEsZUFBZSxzQkFBc0IsRUFBRTtBQUFBLEVBQ2pHO0FBQUEsRUFDQSxTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsUUFDSDtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxNQUNKO0FBQUEsTUFDQyxRQUFRO0FBQUEsUUFDTCxlQUFlLFFBQVE7QUFBQSxNQUMzQjtBQUFBLE1BRUEsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBR0osZUFBZTtBQUFBLE1BQ1osU0FBUztBQUFBLFFBQ0w7QUFBQSxVQUNBLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNOO0FBQUEsTUFDSjtBQUFBLElBQ0EsQ0FBQztBQUFBLEVBQ0c7QUFBQSxFQUNSLFNBQVM7QUFBQSxJQUNMLE9BQU87QUFBQSxNQUNILEtBQUs7QUFBQSxNQUNMLEtBQUs7QUFBQSxNQUNMLFdBQVc7QUFBQSxNQUNYLG9CQUFvQjtBQUFBLE1BQ3BCLGdCQUFnQjtBQUFBLE1BQ2hCLFVBQVU7QUFBQSxJQUNkO0FBQUEsRUFDSjtBQUFBLEVBQ0EsT0FBTztBQUFBLElBQ0gsVUFBVTtBQUFBLElBQ1YsUUFBUTtBQUFBLElBQ1IsYUFBYTtBQUFBLElBQ2IsZUFBZTtBQUFBLE1BQ1gsUUFBUTtBQUFBLFFBQ0wsZ0JBQWdCLENBQUMsY0FBYztBQUM5QixjQUFJLDBCQUEwQixLQUFLLFVBQVUsSUFBSSxHQUFHO0FBQ2hELG1CQUFPO0FBQUEsVUFDWDtBQUNBLGlCQUFPO0FBQUEsUUFDUDtBQUFBLE1BQ0o7QUFBQSxJQUNKO0FBQUEsRUFDSjtBQUFBLEVBQ0MsS0FBSztBQUFBLElBQ0YscUJBQXFCO0FBQUEsTUFDakIsTUFBTTtBQUFBLFFBQ0YsZ0JBQWdCO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQSxNQUtwQjtBQUFBLElBQ0o7QUFBQSxFQUNKO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
