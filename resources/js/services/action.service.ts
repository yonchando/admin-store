import { Action, ButtonActions } from "@/types/button";
import { faEye, faFloppyDisk, faPenAlt, faPlus, faRefresh, faTimes, faTrash } from "@fortawesome/free-solid-svg-icons";
import Button from "@/Components/Button.vue";

export default function useAction() {
    const actions: ButtonActions<Action> = {
        view: {
            label: "View",
            icon: faEye,
            component: Button,
            props: {
                severity: "info",
            },
        },
        add: {
            label: "New",
            icon: faPlus,
            component: Button,
            props: {
                severity: "primary",
            },
        },
        save: {
            label: "Save",
            icon: faFloppyDisk,
            component: Button,
            props: {
                severity: "primary",
            },
        },
        close: {
            label: "Close",
            icon: faTimes,
            component: Button,
            props: {
                severity: "secondary",
            },
        },
        refresh: {
            label: "Refresh",
            icon: faRefresh,
            component: Button,
            props: {
                severity: "secondary",
            },
        },
        edit: {
            label: "Edit",
            icon: faPenAlt,
            component: Button,
            props: {
                severity: "info",
            },
        },
        remove: {
            label: "Remove",
            icon: faTrash,
            component: Button,
            props: {
                severity: "error",
            },
        },
    };

    return actions;
}
