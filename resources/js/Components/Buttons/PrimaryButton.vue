<script setup lang="ts">
import { computed } from "vue";

const props = withDefaults(
    defineProps<{
        size: "sm" | "md" | "lg" | "xl";
    }>(),
    {
        size: "sm",
    },
);

const sizeClass = computed(() => {
    return {
        sm: "px-3 py-2",
        md: "px-4 py-2",
        lg: "",
        xl: "",
    }[props.size];
});
</script>
<template>
    <button
        :class="[sizeClass]"
        class="inline-flex items-center rounded-md border border-transparent bg-gray-800 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300">
        <slot />
    </button>
</template>
