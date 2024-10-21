<script setup lang="ts">
import { computed, onMounted, ref } from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";

defineOptions({
    inheritAttrs: false,
});

const props = withDefaults(
    defineProps<{
        label?: string;
        direction: "horizontal" | "vertical";
    }>(),
    {
        direction: "vertical",
    },
);
const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

const directionClass = computed(() => {
    return {
        vertical: "flex gap-2 flex-col",
        horizontal: "flex gap-4 flex-row",
    }[props.direction];
});

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <div :class="[directionClass]">
        <slot name="label" v-if="$slots.label || label">
            <InputLabel :value="label" :for="input?.getAttribute('id')" />
        </slot>
        <input
            class="w-full rounded-md border-gray-300 placeholder-gray-100 shadow-sm focus:border-light-300 focus:ring-light-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-dark-700 dark:focus:ring-dark-700"
            v-model="model"
            v-bind="$attrs"
            ref="input" />
    </div>
</template>
