import 'bootstrap';
import 'boxicons';
import '@/assets/frontend/scss/style.scss';
import { Fancybox } from "@fancyapps/ui";


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import mixins from "@/mixins";
import vueI18n from "@/vueI18n";

Fancybox.bind('[data-fancybox="video-gallery"]');

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'School';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Views/${name}.vue`, import.meta.glob('./Views/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(vueI18n)
            .mixin(mixins)
            .mount(el);
    },
    progress: {
        color: '#65A30D',
    },
});
