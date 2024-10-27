<script setup lang="ts">
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
    href: string;
    active?: boolean;
}>();

const classes = computed(() => {
    if (props.active) {
        return [
            "inline-flex",
            "items-center",
            "px-3",
            "py-2.5",
            "border-b-2",
            "border-gray-400",
            "dark:border-gray-600",
            "text-sm",
            "font-medium",
            "leading-5",
            "text-gray-800",
            "focus:outline-none",
            "focus:border-indigo-700",
            "transition",
            "duration-150",
            "ease-in-out",
            "dark:text-gray-100",
        ];
    } else {
        return [
            "inline-flex",
            "w-full",
            "items-center",
            "px-3",
            "py-2.5",
            "text-sm",
            "font-medium",
            "leading-5",
            "transition",
            "duration-150",
            "ease-in-out",
            "text-gray-800",
            "hover:border-gray-300",
            "hover:bg-gray-300",
            "focus:outline-none",
            "focus:text-gray-700",
            "focus:border-gray-300",
            "dark:text-gray-200",
            "dark:hover:text-gray-200",
            "dark:hover:bg-gray-900",
            "dark:focus:text-gray-300",
            "dark:hover:border-gray-700",
            "dark:focus:border-gray-700",
        ];
    }
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
