<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    href: String,
});

</script>
<template>
    <Link v-if="href"
          :href="href" class="btn btn-danger btn-sm tw-space-x-4">
        <slot/>
    </Link>

    <button v-else class="btn btn-danger btn-sm tw-space-x-4">
        <slot/>
    </button>
</template>
