<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    label: String,
    icon: {
        type: String,
        default: null,
    },
    active: Boolean,
});

const itemClass = [
    "inline-block",
    "transition-opacity",
    "duration-150",
    "ease-in-out",
    "color-transparent",
    "py-2.5",
    "px-0",
];
</script>

<template>
    <Link v-bind="$attrs" v-if="$attrs.href" :class="itemClass">
        <Icon class="mr-2" :icon="icon" />
        <slot>{{ label }}</slot>
    </Link>

    <div v-bind="$attrs" v-else :class="itemClass">
        <Icon class="mr-2" :icon="icon" />
        <slot>{{ label }}</slot>
    </div>
</template>
