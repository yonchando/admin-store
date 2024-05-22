<script setup>
import Icon from "@/Components/Icon.vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    icon: [String, Object],
    position: {
        type: String,
        default: "right",
        validator(value) {
            return ["left", "right"].includes(value);
        },
    },
});

const model = defineModel();

const className = [
    "block",
    "h-9",
    "w-full",
    "rounded",
    "bg-clip-border",
    "px-3",
    "py-1.5",
    "bg-white",
    "border",
    "border-gray-300",
    "font-normal",
    "text-sm",
    "text-dark",
    "focus:ring-0",
    "focus:outline-0",
    "shadow",
    "shadow-transparent",
    "focus:shadow",
    "focus:border-gray-200",
    "placeholder:text-gray-400/50",
];
</script>

<template>
    <div class="relative">
        <input
            v-bind="$attrs"
            :class="className"
            class=""
            v-model="model"
            ref="input"
        />
        <Icon :icon="icon" />
    </div>
</template>
