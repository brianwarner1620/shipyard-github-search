import '../css/app.css';
import './bootstrap';
import '@mdi/font/css/materialdesignicons.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Vuetify
import { createVuetify } from 'vuetify';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import { createPinia } from 'pinia';

const vuetify = createVuetify({
  icons: {
    defaultSet: 'mdi', // Sets MDI as the default icon set
    aliases,
    sets: {
      mdi,
    },
  },
  // other Vuetify options
});
const pinia = createPinia();
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(vuetify)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
