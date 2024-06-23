<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-xs text-red-600 dark:text-red-400 pt-2">
            {{ message }}
        </p>
    </div>
</template>
