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
    "elect-none",
    "text-sm",
    "leading-6",
    "text-center",
    "align-middle",
    "transition-colors",
    "ease-in-out",
    "duration-150",
    "relative",
    "border",
    "border-transparent",
];
</script>

<template>
    <Link :class="className" v-if="$attrs.href" v-bind="$attrs">
        <template v-if="icon">
            <i v-if="typeof icon === 'string'" :class="icon"></i>
            <fa v-else :icon="icon" />
        </template>
        <slot>{{ title }}</slot>
    </Link>

    <button class="" :class="className" v-else v-bind="$attrs">
        <template v-if="icon">
            <i v-if="typeof icon === 'string'" :class="icon"></i>
            <fa v-else :icon="icon" />
        </template>
        <slot>{{ title }}</slot>
    </button>
</template>
