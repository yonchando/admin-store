<script setup lang="ts">
import { computed, onMounted, ref } from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";

defineOptions({
    inheritAttrs: false,
});

const props = withDefaults(
    defineProps<{
        label?: string;
        direction?: "horizontal" | "vertical";
        root?: any;
        required?: boolean;
    }>(),
    {
        direction: "vertical",
        required: false,
    },
);
const model = defineModel<any>({ required: true });

const input = ref<HTMLInputElement | null>(null);

const directionClass = computed(() => {
    return {
        vertical: "flex gap-2 flex-col",
        horizontal: "flex gap-4 flex-row items-center",
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
    <div :class="[directionClass]" v-bind="root">
        <slot name="label" v-if="$slots.label || label">
            <InputLabel :required="required" :value="label" :for="input?.getAttribute('id')" />
        </slot>
        <textarea
            class="w-full rounded-md border-gray-300 text-sm placeholder-gray-100 shadow-sm focus:border-gray-300 focus:ring-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-gray-700 dark:focus:ring-gray-700"
            v-model="model"
            v-bind="$attrs"
            ref="input"></textarea>
    </div>
</template>
