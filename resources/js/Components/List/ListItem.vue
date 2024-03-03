<script setup>
defineProps(['label', 'value'])
</script>

<template>
    <div class="tw-flex tw-gap-2">
        <div v-if="label">{{ label }}:</div>
        <div v-if="value" class="tw-font-medium">{{ value }}</div>
        <slot/>
    </div>
</template>

<style scoped>

</style>
