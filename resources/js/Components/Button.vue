<script setup lang="ts">
import { computed } from "vue";

const props = withDefaults(
    defineProps<{
        size?: "sm" | "md" | "lg" | "xl";
        severity?: "primary" | "secondary" | "info" | "warning" | "error" | "success";
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
            "hover:bg-gray-700",
            "focus:bg-gray-700",
            "focus:ring-indigo-500",
            "active:bg-gray-900",
            "dark:bg-gray-900",
            "dark:hover:bg-gray-800",
            "dark:border-gray-700",
            "dark:text-gray-300",
            "dark:focus:bg-gray-800",
            "dark:focus:ring-offset-gray-100",
            "dark:focus:ring-gray-800",
            "dark:active:bg-gray-700",
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
            "bg-indigo-800",
            "border-transparent",
            "text-white",
            "hover:bg-indigo-700",
            "focus:bg-indigo-700",
            "focus:outline-none",
            "focus:ring-2",
            "focus:ring-indigo-500",
            "focus:ring-offset-2",
            "active:bg-indigo-900",
            "dark:bg-fuchsia-700",
            "dark:text-gray-200",
            "dark:hover:bg-fuchsia-500",
            "dark:focus:bg-white",
            "dark:focus:ring-offset-gray-800",
            "dark:active:bg-gray-300",
        ],
        warning: [
            "dark:bg-gray-800",
            "dark:text-white",
            "dark:border-gray-400",
            "dark:bg-gray-500",
            "dark:focus:ring-gray-300",
            "dark:focus:ring-offset-gray-200",
        ],
        error: [
            "inline-flex",
            "items-center",
            "rounded-md",
            "border",
            "border-transparent",
            "bg-red-600",
            "px-4",
            "py-2",
            "font-semibold",
            "uppercase",
            "tracking-widest",
            "text-white",
            "transition",
            "duration-150",
            "ease-in-out",
            "hover:bg-red-500",
            "focus:outline-none",
            "focus:ring-2",
            "focus:ring-red-500",
            "focus:ring-offset-2",
            "active:bg-red-700",
            "dark:focus:ring-offset-gray-800",
        ],
        success: "",
    }[props.severity];
});
</script>
<template>
    <button
        :class="[sizeClass, ...severityClass]"
        class="inline-flex items-center rounded-md border font-semibold tracking-widest transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-0 disabled:opacity-25">
        <slot />
    </button>
</template>
