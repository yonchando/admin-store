<script setup lang="ts">
import { computed } from "vue";

const props = withDefaults(
    defineProps<{
        size?: "sm" | "default" | "md" | "lg" | "xl";
        severity?: "primary" | "secondary" | "info" | "warning" | "error" | "success";
        type?: "outline" | "fill";
    }>(),
    {
        size: "sm",
        severity: "primary",
        type: "fill",
    },
);

const sizeClass = computed(() => {
    return {
        sm: "text-xs px-2 py-1.5",
        default: "text-sm px-2.5 py-1.5",
        md: "text-base px-3 py-1.5",
        lg: "text-xl px-3.5 py-1.5",
        xl: "text-2xl px-4 py-1.5",
    }[props.size];
});

const className = computed(() => {
    return {
        primary: props.type == "fill" ? "bg-primary text-white" : "border border-primary",
        secondary: props.type == "fill" ? "bg-secondary" : "border border-secondary",
        info: props.type == "fill" ? "bg-info text-white" : "border border-info",
        warning: props.type == "fill" ? "bg-warning text-white" : "border border-warning",
        error: props.type == "fill" ? "bg-error text-white" : "border border-error",
        success: props.type == "fill" ? "bg-success" : "border border-success",
    }[props.severity];
});
</script>

<template>
    <span :class="[sizeClass, className]" class="rounded">
        <slot />
    </span>
</template>

<style scoped></style>
