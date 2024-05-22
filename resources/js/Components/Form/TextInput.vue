<script setup>
import { computed } from "vue";

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

const position = computed(() => {
    return {
        right: "right-3",
        left: "left-3",
    }[props.position];
});

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
        <span
            v-if="icon"
            :class="position"
            class="absolute top-1/2 -translate-y-1/2 text-gray-400/50"
        >
            <fa-icon v-if="typeof icon === 'object'" :icon="icon" />
            <i v-else :class="icon"></i>
        </span>
    </div>
</template>
