import { IconDefinition } from "@fortawesome/fontawesome-svg-core";
import Button from "@/Components/Button.vue";
import { Link } from "@inertiajs/vue3";

export interface ButtonActions<Type> {
    view: Action;
    add: Action;
    save: Action;
    refresh: Action;
    close: Action;
    cancel: Action;
    edit: Action;
    remove: Action;
}

export interface Action {
    component: Button | Link;
    label: string;
    icon?: string | IconDefinition;
    props: {
        onClick?: (e: Event, ...arg) => void;
        disabled?: boolean;
        size?: "sm" | "md" | "lg" | "xl";
        severity?: "primary" | "secondary" | "info" | "warning" | "error" | "success";
        href?: string;
    };
}
