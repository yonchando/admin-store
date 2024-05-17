<script setup>
import { Link } from "@inertiajs/vue3";
import Button from "@/Components/Button/Button.vue";

const className = [
    'bg-primary',
    'hover:bg-primary/90',
    'hover:ring-primary'
];
</script>
<template>
    <Button :class="className">
        <slot />
    </Button>
</template>
