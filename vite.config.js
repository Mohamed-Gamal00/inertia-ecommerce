import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vuetify from "vite-plugin-vuetify";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
            refresh: true,
        }),
        vue(),
        vuetify({ autoImport: true }), // Will be removed after migration
    ],
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "bootstrap/scss/functions"; @import "bootstrap/scss/variables";`
            }
        }
    }
});
