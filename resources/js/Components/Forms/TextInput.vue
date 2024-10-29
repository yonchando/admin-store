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
        root?: any;
        required: boolean;
    }>(),
    {
        direction: "vertical",
        required: false,
    },
);
const model = defineModel({ required: true });

const input = ref<HTMLInputElement | null>(null);

const directionClass = computed(() => {
    return {
        vertical: "flex gap-2 flex-col",
        horizontal: "flex gap-4 flex-row items-center",
    }[props.direction];
});

const inputClass = [
    "w-full",
    "px-4",
    "py-2.5",
    "rounded-md",
    "border-gray-200",
    "focus:border-gray-200",
    "focus:ring-gray-200",
    "text-sm",
    "placeholder-gray-400",
    "dark:border-gray-700",
    "dark:bg-gray-900",
    "dark:text-gray-300",
    "dark:focus:border-gray-700",
    "dark:focus:ring-gray-700",
];

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
        <input :class="[inputClass]" v-model="model" v-bind="$attrs" ref="input" />
    </div>
</template>
