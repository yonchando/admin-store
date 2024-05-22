<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
    icon: String,
    text: String,
});
</script>

<template>
    <Link v-if="href" :href="href" class="btn btn-warning btn-sm tw-space-x-2">
        <slot>
            <i :class="icon"></i>
            <span>{{ text }}</span>
        </slot>
    </Link>

    <button type="button" v-else class="btn btn-warning btn-sm tw-space-x-2">
        <slot>
            <i :class="icon"></i>
            <span>{{ text }}</span>
        </slot>
    </button>
</template>

<style scoped></style>
