import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import { router } from "@inertiajs/vue3";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import Toaster from '@meforma/vue-toaster';


createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Toaster)
            .mount(el);
    },
});
