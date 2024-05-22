<script setup>
import {ref} from "vue";

const props = defineProps({
    title: String,
    show: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <a data-toggle="dropdown" class="tw-cursor-pointer">
        <slot>{{ title }}</slot>
    </a>
</template>

<style scoped>

</style>
