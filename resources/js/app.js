import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Veneno Auto Care';

import { t, setLocale, detectInitialLocale } from './i18n';

createInertiaApp({
    title: (title) => title ? `${title} - ${appName}` : appName,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // Always prioritise the user's saved locale (localStorage) over the
        // server-sent prop. The server defaults to 'en' for every URL, which
        // would otherwise overwrite the user's Arabic preference on every
        // page load or Inertia navigation.
        const savedLocale = typeof window !== 'undefined'
            ? localStorage.getItem('veneno_locale')
            : null;
        const initialLang = savedLocale || props.initialPage.props.locale || detectInitialLocale();
        setLocale(initialLang);

        const app = createApp({ render: () => h(App, props) });
        app.config.globalProperties.$t = t;

        return app
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#dc2626',
        showSpinner: true,
    },
});
