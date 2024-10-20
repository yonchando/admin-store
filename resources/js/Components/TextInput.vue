<script setup lang="ts">
import { onMounted, ref } from "vue";

const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <input
        class="focus:border-light-300 focus:ring-light-300 dark:focus:border-dark-700 dark:focus:ring-dark-700 w-full rounded-md border-gray-300 placeholder-gray-100 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
        v-model="model"
        ref="input" />
</template>
