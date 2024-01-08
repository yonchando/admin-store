<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    href: String,
});
</script>
<template>
    <Link v-if="href" class="btn btn-primary btn-sm">
        <slot/>
    </Link>

    <button v-else class="btn btn-primary btn-sm">
        <slot/>
    </button>
</template>
