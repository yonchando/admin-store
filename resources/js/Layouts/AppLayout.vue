<script setup>
import HeaderTop from "@/Layouts/Partials/HeaderTop.vue";

defineProps({
    showSidebar: {
        type: Boolean,
        default: true,
    },
    showHeaderTop: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <HeaderTop v-if="showHeaderTop" />
</template>
