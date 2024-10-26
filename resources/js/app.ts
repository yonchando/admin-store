import "toastify-js/src/toastify.css";
import "../css/app.css";
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { createApp, DefineComponent, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import AppLayout from "@/Layouts/AppLayout.vue";
import colors from "tailwindcss/colors";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import InfoButton from "@/Components/Buttons/InfoButton.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>("./Pages/**/*.vue")),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        app.component("AppLayout", AppLayout);
        app.component("FaIcon", FontAwesomeIcon);

        app.component("PrimaryButton", PrimaryButton);
        app.component("SecondaryButton", SecondaryButton);
        app.component("DangerButton", DangerButton);
        app.component("InfoButton", InfoButton);

        app.mount(el);
    },
    progress: {
        color: localStorage.getItem("theme") == "light" ? colors.gray["900"] : colors.gray["300"],
        showSpinner: true,
    },
}).then((r) => {});
