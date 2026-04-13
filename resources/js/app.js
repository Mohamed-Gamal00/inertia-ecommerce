import "./bootstrap";
import "../css/app.css"; // Import CSS into JS
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
        messages: { ar, en }, // 👈 ربط اللغة العربية والانجليزية الجاهزين من Vuetify
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
