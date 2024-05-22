<script setup>
import Button from "@/Components/Button/Button.vue";

const className = ["bg-primary", "hover:bg-primary/90", "hover:ring-primary", 'text-white' ,'hover:outline-0'];
</script>
<template>
    <Button :class="className">
        <slot />
    </Button>
</template>
