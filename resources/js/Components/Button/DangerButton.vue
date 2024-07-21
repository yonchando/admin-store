<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    icon: String,
    label: String,
});
</script>
<template>
    <Link
        v-if="$attrs.href"
        v-bind="$attrs"
        class="btn btn-danger btn-sm tw-space-x-2"
    >
        <slot>
            <i :class="icon"></i>
            <span>{{ label }}</span>
        </slot>
    </Link>

    <button
        v-else
        v-bind="$attrs"
        type="button"
        class="btn btn-danger btn-sm tw-space-x-2"
    >
        <slot>
            <i :class="icon"></i>
            <span>{{ label }}</span>
        </slot>
    </button>
</template>
