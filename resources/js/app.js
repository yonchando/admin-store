import "./bootstrap";
import "./asset.js";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import Sweetalert2 from "./sweetalert2.js";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import TextInput from "@/Components/Forms/TextInput.vue";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Icon from "@/Components/Icons/Icon.vue";
import PrimeVue from "primevue/config";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Badge from "primevue/badge";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SelectInput from "@/Components/Forms/SelectInput.vue";
import FormGroup from "@/Components/Forms/FormGroup.vue";
import FileInput from "@/Components/Forms/FileInput.vue";
import CKEditor from "@ckeditor/ckeditor5-vue";
import Editor from "@/Components/Forms/Editor.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        return resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        );
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(CKEditor)
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue)
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

        app.component("PrimaryButton", PrimaryButton);
        app.component("Checkbox", Checkbox);
        app.component("TextInput", TextInput);
        app.component("InputError", InputError);
        app.component("InputLabel", InputLabel);
        app.component("SelectInput", SelectInput);
        app.component("FormGroup", FormGroup);
        app.component("FileInput", FileInput);
        app.component("Editor", Editor);
        app.component("fa-icon", FontAwesomeIcon);
        app.component("Icon", Icon);
        app.component("DataTable", DataTable);
        app.component("Column", Column);
        app.component("Badge", Badge);

        app.config.globalProperties.$lang = props.initialPage.props.lang;
        app.mount(el);
    },
    progress: {
        color: "#368dff",
    },
}).then((r) => r);
