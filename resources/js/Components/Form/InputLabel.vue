<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label>
        <slot>{{ value }}</slot>
    </label>
</template>
