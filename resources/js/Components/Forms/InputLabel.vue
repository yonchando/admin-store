<script setup lang="ts">
defineProps<{
    value?: string;
    required?: boolean;
}>();
</script>

<template>
    <label class="block text-base font-medium text-gray-700 dark:text-gray-300">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <span v-if="required" class="ml-1 text-error">*</span>
    </label>
</template>
