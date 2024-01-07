<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    title: String,
    icon: {
        type: String,
        default: null
    },
})
</script>

<template>
    <Link class="breadcrumb-item">
        <i v-if="icon" class="mr-2" :class="icon"/>
        <slot>{{ title }}</slot>
    </Link>
</template>

<style scoped>

</style>
