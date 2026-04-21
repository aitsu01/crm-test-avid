import 'notivue/animations.css';
import 'notivue/notification-progress.css';
import 'notivue/notifications.css';
import 'primeicons/primeicons.css';
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { renderApp } from '@inertiaui/modal-vue';
import Aura from '@primeuix/themes/aura';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { i18nVue } from 'laravel-vue-i18n';
import { createNotivue } from 'notivue';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import Tooltip from 'primevue/tooltip';
import type { DefineComponent } from 'vue';
import { createApp } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './avid/composables/useAppearance';
import { notifications } from './avid/plugins/notifications';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const notivue = createNotivue({
    position: 'top-right',
    limit: 4,
    notifications: {
        global: {
            duration: 6000,
        },
    },
});

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: renderApp(App, props) })
            .use(i18nVue, {
                shared: false,
                resolve: async (lang: string) => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                },
            })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                ripple: true,
                theme: {
                    preset: Aura,
                    options: {
                        darkModeSelector: '.dark',
                        cssLayer: {
                            name: 'primevue',
                            order: 'theme, base, primevue',
                        },
                    },
                },
            })

            .use(notivue)
            .use(notifications)
            .use(ConfirmationService)
            .directive('tooltip', Tooltip)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
