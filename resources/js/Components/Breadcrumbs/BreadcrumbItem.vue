<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    title: String,
    icon: {
        type: String,
        default: null,
    },
    href: String,
});
</script>

<template>
    <Link v-if="href" :href="href" class="breadcrumb-item">
        <i v-if="icon" class="tw-mr-2" :class="icon" />
        <slot>{{ title }}</slot>
    </Link>

    <span v-else class="breadcrumb-item active">
        <i v-if="icon" class="tw-mr-2" :class="icon" />
        <slot>{{ title }}</slot>
    </span>
</template>

<style scoped></style>
