import "./bootstrap";
import "../css/app.css"; // Dabbarha brand styles
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import Layout from "./layouts/AppLayout.vue";

import { ZiggyVue } from "ziggy-js";

// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { ar, en } from "vuetify/locale"; // 👈 استورد الترجمة الجاهزة
import "@mdi/font/css/materialdesignicons.css";

// vue-i18n (لو عايز تضيف ترجمات خاصة بيك)
import { createI18n } from "vue-i18n";
const i18n = createI18n({
    legacy: false,
    locale: "ar",
    fallbackLocale: "en",
    messages: {
        ar: { hello: "مرحبا" },
        en: { hello: "Hello" },
    },
});

const vuetify = createVuetify({
    components,
    directives,
    locale: {
        locale: "ar",
        fallback: "en",
        messages: { ar, en },
    },
    theme: {
        defaultTheme: "dabbarhaTheme",
        themes: {
            dabbarhaTheme: {
                dark: false,
                colors: {
                    primary: "#245447",      // Deep Green
                    secondary: "#E4B45D",    // Warm Gold
                    background: "#F5F0E7",   // Warm Cream
                    surface: "#FFFFFF",      // White
                    error: "#ef4444",
                    info: "#245447",
                    success: "#16a34a",
                    warning: "#E4B45D",
                    // Custom brand colors
                    "brand-text": "#302F2B",       // Deep Charcoal
                    "brand-text-muted": "#77736B", // Muted Gray
                    "brand-border": "#D7CDBD",     // Warm Beige
                },
            },
        },
    },
});

// mitt (Event Bus)
import mitt from "mitt";
const Emitter = mitt();

// Swiper
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.use(i18n);
        app.use(vuetify);
        app.use(ZiggyVue);
        app.provide("Emitter", Emitter);

        app.mount(el);
    },
});
