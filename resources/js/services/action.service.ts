import { Action, ButtonActions } from "@/types/button";
import {
    faEye,
    faFloppyDisk,
    faPenToSquare,
    faPlus,
    faRefresh,
    faTimes,
    faTrash,
    faUpload,
} from "@fortawesome/free-solid-svg-icons";
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
        cancel: {
            label: "Cancel",
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
                severity: "dark",
            },
        },
        edit: {
            label: "Edit",
            icon: faPenToSquare,
            component: Button,
            props: {
                severity: "warning",
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
        upload: {
            label: "Upload",
            icon: faUpload,
            component: Button,
            props: {
                severity: "info",
            },
        },
    };

    return actions;
}
