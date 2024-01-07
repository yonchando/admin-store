<script setup>

import {Link} from "@inertiajs/vue3";

defineProps({
    href: String,
})
</script>

<template>
    <Link v-if="href" class="btn">
        <slot/>
    </Link>

    <button v-else type="button" class="btn">
        <slot/>
    </button>
</template>

<style scoped>

</style>
