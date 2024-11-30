<script setup lang="ts">
import { computed } from "vue";
import { IconDefinition } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { Link } from "@inertiajs/vue3";

defineOptions({
    inheritAttrs: false,
});

const props = withDefaults(
    defineProps<{
        size?: "xs" | "sm" | "md" | "lg" | "xl";
        severity?: "primary" | "secondary" | "info" | "warning" | "error" | "success" | "dark";
        icon?: IconDefinition;
        href?: string;
        disabled?: boolean;
        tabindex?: string;
    }>(),
    {
        size: "sm",
        severity: "primary",
    },
);

const sizeClass = computed(() => {
    return {
        xs: "px-1.5 py-1.5 text-xs",
        sm: "px-4 py-2 text-sm",
        md: "px-5 py-2 text-base",
        lg: "px-6 py-2.5 text-lg",
        xl: "px-7 py-4 text-xl",
    }[props.size];
});

const severityClass = computed(() => {
    return {
        primary: [
            "bg-gray-800",
            "disabled:bg-gray-800",
            "border-transparent",
            "text-white",
            "text-base",
            "hover:bg-gray-700",
            "focus:bg-gray-700",
            "focus:ring-indigo-500",
            "active:bg-gray-900",
            "dark:bg-gray-100",
            "dark:disabled:bg-gray-100",
            "dark:hover:bg-gray-300",
            "dark:border-gray-300",
            "dark:text-gray-900",
            "dark:focus:bg-gray-300",
            "dark:focus:ring-offset-gray-300",
            "dark:focus:ring-gray-300",
            "dark:active:bg-gray-300",
        ],
        secondary: [
            "bg-white",
            "disabled:bg-white/25",
            "border-gray-300",
            "text-gray-700",
            "shadow-sm",
            "hover:bg-gray-200",
            "focus:outline-none",
            "focus:ring-gray-500",
            "active:bg-gray-300",
            "dark:border-gray-500",
            "dark:bg-gray-800",
            "dark:disabled:bg-gray-800",
            "dark:text-gray-300",
            "dark:hover:bg-gray-700",
            "dark:active:bg-gray-800",
            "dark:focus:ring-offset-gray-100",
            "dark:focus:ring-gray-500",
        ],
        info: [
            "bg-info",
            "disabled:bg-info/85",
            "border-transparent",
            "text-white",
            "hover:bg-info/85",
            "focus:bg-info/85",
            "focus-visible:outline-0",
            "active:bg-info/85",
        ],
        warning: [
            "bg-warning",
            "disabled:bg-warning/85",
            "border-transparent",
            "text-white",
            "hover:bg-warning/85",
            "focus:bg-warning/85",
            "active:bg-warning/85",
            "focus-visible:outline-0",
        ],
        error: [
            "bg-error",
            "border-transparent",
            "disabled:bg-error/85",
            "text-white",
            "hover:bg-error/85",
            "focus:bg-error/85",
            "active:bg-error/85",
            "focus-visible:outline-0",
        ],
        success: [
            "bg-success",
            "disabled:bg-success/85",
            "border-transparent",
            "text-gray-300",
            "hover:bg-success/85",
            "focus:bg-success/85",
            "active:bg-success/85",
            "focus-visible:outline-0",
        ],
        dark: [
            "bg-dark",
            "disabled:bg-dark/85",
            "border-transparent",
            "text-gray-300",
            "hover:bg-dark/85",
            "focus:bg-dark/85",
            "active:bg-dark/85",
            "focus-visible:outline-0",
        ],
    }[props.severity];
});
</script>
<template>
    <button
        v-bind="$attrs"
        v-if="!href"
        :tabindex="tabindex"
        :class="[sizeClass, ...severityClass]"
        :disabled="disabled"
        class="btn">
        <template v-if="icon">
            <fa-icon class="pr-2" :icon="icon" />
        </template>
        <slot />
    </button>
    <Link
        v-else
        v-bind="$attrs"
        :href="href"
        :tabindex="tabindex"
        :disabled="disabled"
        class="btn border-0 text-blue-400">
        <template v-if="icon">
            <fa-icon class="pr-1.5" :icon="icon" />
        </template>
        <slot />
    </Link>
</template>
