<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    title: String,
    href: String,
});
</script>

<template>
    <Link
        :href="href"
        v-if="href"
        class="dropdown-item"
    >
        <slot>{{ title }}</slot>
    </Link>

    <button
        v-else
        type="button"
        class="dropdown-item"
    >
        <slot>{{ title }}</slot>
    </button>

</template>
