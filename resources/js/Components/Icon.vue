<script setup>
import { computed } from "vue";

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

const position = computed(() => {
    return {
        right: "right-3",
        left: "left-3",
    }[props.position];
});
</script>

<template>
    <span
        v-if="icon"
        :class="position"
        class="absolute top-1/2 -translate-y-1/2 text-gray-400/50"
    >
        <fa-icon v-bind="$attrs" v-if="typeof icon === 'object'" :icon="icon" />
        <i v-bind="$attrs" v-else :class="icon"></i>
    </span>
</template>
