import "./bootstrap";
import "./asset.js";

import {createApp, h} from "vue";
import {createInertiaApp, Head} from "@inertiajs/vue3";
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import {ZiggyVue} from "../../vendor/tightenco/ziggy/dist/vue.m";
import Sweetalert2 from "./sweetalert2.js";

import AppLayout from "@/Layouts/AppLayout.vue";
import Table from "@/Components/Table/Table.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";


const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        return resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        );
    },
    setup({el, App, props, plugin}) {
        const app = createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .use(Sweetalert2, {
                confirmButtonText: props.initialPage.props.lang.yes,
                showCancelButton: true,
                cancelButtonText: props.initialPage.props.lang.no,
                buttonsStyling: false,
                customClass: {
                    cancelButton: ["btn", "btn-light"],
                    confirmButton: ["btn", "btn-primary"],
                    closeButton: ["btn"],
                },
            });

        app.component('AppLayout', AppLayout);
        app.component("Head", Head);
        app.component("Table", Table);
        app.component("Tr", Tr);
        app.component("Td", Td);
        app.component('PrimaryButton', PrimaryButton);

        app.config.globalProperties.$lang = props.initialPage.props.lang;
        app.directive("lang", function (el, binding) {
            $(el).text(props.initialPage.props.lang[binding.arg]);
        });
        app.mount(el);
    },
    progress: {
        color: "#368dff",
    },
}).then((r) => r);
