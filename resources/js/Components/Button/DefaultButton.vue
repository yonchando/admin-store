<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    icon: String,
    text: String,
});
</script>

<template>
    <Link v-if="$attrs.href" v-bind="$attrs" class="btn">
        <slot>
            <i :class="icon"></i>
            <span>{{ text }}</span>
        </slot>
    </Link>

    <button v-else v-bind="$attrs" type="button" class="btn">
        <slot>
            <i :class="icon"></i>
            <span>{{ text }}</span>
        </slot>
    </button>
</template>

<style scoped></style>
