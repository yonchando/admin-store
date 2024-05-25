<script setup>
defineProps({
    icon: [String, Object],
});
</script>

<template>
    <template v-if="icon">
        <i v-if="typeof icon === 'string'" :class="icon" v-bind="$attrs" />
        <fa-icon v-else :icon="icon" v-bind="$attrs" />
    </template>
</template>
