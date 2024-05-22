<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="tw-text-xs tw-text-red-600 dark:tw-text-red-400 tw-pt-2">
            {{ message }}
        </p>
    </div>
</template>
