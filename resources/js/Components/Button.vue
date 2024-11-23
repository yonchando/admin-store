<script setup lang="ts">
import { computed } from "vue";
import { IconDefinition } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { Link } from "@inertiajs/vue3";

const props = withDefaults(
    defineProps<{
        size?: "xs" | "sm" | "default" | "md" | "lg" | "xl";
        severity?: "primary" | "secondary" | "info" | "warning" | "error" | "success";
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
        xs: "px-2.5 py-1.5 text-xxs",
        sm: "px-3 py-2 text-xs",
        default: "px-4 py-2.5 text-sm",
        md: "px-5 py-3 text-md",
        lg: "px-6 py-4 text-lg",
        xl: "px-7 py-5 text-xl",
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
            "focus:ring-2",
            "focus:ring-sky-600",
            "active:bg-info/85",
        ],
        warning: [
            "bg-warning",
            "disabled:bg-warning/85",
            "border-transparent",
            "text-white",
            "hover:bg-warning/85",
            "focus:bg-warning/85",
            "focus:ring-2",
            "focus:ring-amber-600",
            "active:bg-warning/85",
        ],
        error: [
            "bg-error",
            "border-transparent",
            "disabled:bg-error/85",
            "text-white",
            "hover:bg-error/85",
            "focus:bg-error/85",
            "focus:ring-2",
            "focus:ring-error",
            "active:bg-error/85",
        ],
        success: [
            "bg-success",
            "disabled:bg-success/85",
            "border-transparent",
            "text-gray-300",
            "hover:bg-success/85",
            "focus:bg-success/85",
            "focus:ring-2",
            "focus:ring-success",
            "active:bg-success/85",
        ],
    }[props.severity];
});
</script>
<template>
    <button
        v-if="!href"
        :tabindex="tabindex"
        :class="[sizeClass, ...severityClass]"
        :disabled="disabled"
        class="inline-block rounded border font-semibold tracking-widest transition duration-150 ease-in-out disabled:opacity-25">
        <template v-if="icon">
            <fa-icon class="pr-1.5" :icon="icon" :size="size as any" />
        </template>
        <slot />
    </button>
    <Link
        v-else
        :href="href"
        :class="[sizeClass, ...severityClass]"
        :tabindex="tabindex"
        :disabled="disabled"
        class="inline-block rounded border font-semibold tracking-widest transition duration-150 ease-in-out disabled:opacity-25">
        <template v-if="icon">
            <fa-icon class="pr-1.5" :icon="icon" :size="size as any" />
        </template>
        <slot />
    </Link>
</template>
