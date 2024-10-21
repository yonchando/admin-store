import { IconDefinition } from "@fortawesome/fontawesome-svg-core";
import Button from "@/Components/Button.vue";

export interface ButtonActions<Type> {
    view: Action;
    add: Action;
    save: Action;
    refresh: Action;
    close: Action;
}

export interface Action {
    component: Button;
    label: string;
    icon?: string | IconDefinition;
    props: {
        onClick?: (e: Event) => void;
        disabled?: boolean;
        size?: "sm" | "md" | "lg" | "xl";
        severity?: "primary" | "secondary" | "info" | "warning" | "error" | "success";
    };
}
