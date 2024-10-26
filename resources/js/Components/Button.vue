<script setup lang="ts">
import { computed } from "vue";
import { IconDefinition } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";

const props = withDefaults(
    defineProps<{
        size?: "sm" | "md" | "lg" | "xl";
        severity?: "primary" | "secondary" | "info" | "warning" | "error" | "success";
        icon?: IconDefinition;
    }>(),
    {
        size: "sm",
        severity: "primary",
    },
);

const sizeClass = computed(() => {
    return {
        sm: "px-4 py-2 text-xs",
        md: "px-5 py-3 text-md",
        lg: "px-6 py-4 text-lg",
        xl: "px-7 py-5 text-xl",
    }[props.size];
});

const severityClass = computed(() => {
    return {
        primary: [
            "bg-gray-800",
            "border-transparent",
            "text-white",
            "text-base",
            "hover:bg-gray-700",
            "focus:bg-gray-700",
            "focus:ring-indigo-500",
            "active:bg-gray-900",
            "dark:bg-gray-100",
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
            "border-gray-300",
            "text-gray-700",
            "shadow-sm",
            "hover:bg-gray-200",
            "focus:outline-none",
            "focus:ring-gray-500",
            "active:bg-gray-300",
            "dark:border-gray-500",
            "dark:bg-gray-800",
            "dark:text-gray-300",
            "dark:hover:bg-gray-700",
            "dark:active:bg-gray-800",
            "dark:focus:ring-offset-gray-100",
            "dark:focus:ring-gray-500",
        ],
        info: [
            "bg-sky-600",
            "border-transparent",
            "text-white",
            "hover:bg-sky-700",
            "focus:bg-sky-700",
            "focus:ring-2",
            "focus:ring-sky-600",
            "active:bg-sky-700",
        ],
        warning: [
            "bg-amber-600",
            "border-transparent",
            "text-white",
            "hover:bg-amber-700",
            "focus:bg-amber-700",
            "focus:ring-2",
            "focus:ring-amber-600",
            "active:bg-amber-700",
        ],
        error: [
            "border-transparent",
            "bg-rose-600",
            "text-white",
            "hover:bg-rose-700",
            "focus:bg-rose-700",
            "focus:ring-2",
            "focus:ring-rose-600",
            "active:bg-rose-700",
        ],
        success: [
            "bg-teal-600",
            "border-transparent",
            "text-gray-300",
            "hover:bg-teal-700",
            "focus:bg-teal-700",
            "focus:ring-2",
            "focus:ring-teal-600",
            "active:bg-teal-700",
        ],
    }[props.severity];
});
</script>
<template>
    <button
        :class="[sizeClass, ...severityClass]"
        class="inline-flex items-center gap-1.5 rounded-md border font-semibold tracking-widest transition duration-150 ease-in-out disabled:opacity-25">
        <template v-if="icon">
            <fa-icon :icon="icon" :size="size as any" />
        </template>
        <slot />
    </button>
</template>
