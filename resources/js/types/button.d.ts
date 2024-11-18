import { IconDefinition } from "@fortawesome/fontawesome-svg-core";
import Button from "@/Components/Button.vue";
import { Link } from "@inertiajs/vue3";

export interface ButtonActions<Type> {
    view: Type;
    add: Type;
    save: Type;
    refresh: Type;
    close: Type;
    cancel: Type;
    edit: Type;
    remove: Type;
    upload: Type;
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
        tabindex?: string;
        class?: string[] | string;
    };
}
