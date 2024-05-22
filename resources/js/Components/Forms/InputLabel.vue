<script setup>
defineProps({
    value: {
        type: String,
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <label class="tw-font-medium">
        <slot>
            {{ value }}
            <span v-if="required" class="text-danger">*</span>
        </slot>
    </label>
</template>
