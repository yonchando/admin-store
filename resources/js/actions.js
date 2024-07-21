import { usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import WarningButton from "@/Components/Button/WarningButton.vue";
import { computed } from "vue";

export default function useActions(actions, disabled = {}) {
    const pages = usePage();
    const lang = pages.props.lang;
    return computed(() =>
        [
            {
                code: "create",
                component: PrimaryButton,
                props: {
                    label: lang.new,
                    icon: "icon-plus2",
                    disabled: disabled.create,
                    onClick: (e) => {
                        actions.create(e);
                    },
                },
            },
            {
                code: "save",
                component: PrimaryButton,
                props: {
                    label: lang.save,
                    icon: "icon-floppy-disk",
                    disabled: disabled.save,
                    onClick: (e) => {
                        actions.save(e);
                    },
                },
            },
            {
                code: "filter",
                component: WarningButton,
                props: {
                    label: lang.filter,
                    icon: "icon-filter3",
                    disabled: disabled.filter,
                    onClick: (e) => {
                        actions.filter(e);
                    },
                },
            },
        ].filter((item) => Object.keys(actions).includes(item.code)),
    );
}
