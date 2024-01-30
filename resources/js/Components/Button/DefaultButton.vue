<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
    icon: String,
    text: String,
});
</script>

<template>
    <Link v-if="href" class="btn">
        <slot>
            <i :class="icon"></i>
            <span>{{ text }}</span>
        </slot>
    </Link>

    <button v-else type="button" class="btn">
        <slot>
            <i :class="icon"></i>
            <span>{{ text }}</span>
        </slot>
    </button>
</template>

<style scoped></style>
