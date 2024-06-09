<script setup>
import Button from "@/Components/Buttons/Button.vue";

const className = [
    "bg-warning",
    "hover:bg-warning/90",
    "hover:ring-warning",
    "text-white",
    "hover:outline-0",
];
</script>

<template>
    <Button :class="className">
        <slot />
    </Button>
</template>

<style scoped></style>
