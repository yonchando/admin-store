<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    title: String,
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="dropdown-item"
    >
        <slot>{{ title }}</slot>
    </Link>
</template>
