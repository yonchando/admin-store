<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    title: String,
    icon: [String, Object],
});

const className = [
    "px-3",
    "py-1.5",
    "rounded",
    "inline-block",
    "font-normal",
    "select-none",
    "text-sm",
    "leading-6",
    "text-center",
    "align-middle",
    "transition-colors",
    "ease-in-out",
    "duration-150",
    "relative",
    "border",
];
</script>

<template>
    <Link :class="className" v-if="$attrs.href" v-bind="$attrs">
        <Icon :icon="icon" />
        <slot>{{ title }}</slot>
    </Link>

    <button :class="className" v-else v-bind="$attrs">
        <Icon :icon="icon" />
        <slot>{{ title }}</slot>
    </button>
</template>
