<script setup>
import { ref } from "vue";
import SlideDown from "@/Components/Transition/SlideDown.vue";

defineOptions({
    inheritAttrs: false,
});

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    toggle: {
        type: Boolean,
        default: false,
    },
    pt: {
        type: Object,
        default: {
            root: "",
        },
        validator(value) {
            return ["root", "button"].includes(value);
        },
    },
});

const open = ref(false);
</script>

<template>
    <div class="relative" :class="pt.root">
        <template v-if="$slots.button">
            <button
                class="w-full pr-6"
                :class="pt.button"
                @click="open = !open"
            >
                <div class="flex w-full items-center justify-between">
                    <slot name="button" />
                    <i v-if="toggle" class="fa fa-chevron-down"></i>
                </div>
            </button>
        </template>

        <SlideDown>
            <div
                class="relative right-0 top-full flex min-w-44 flex-col rounded border shadow sm:absolute text-sm"
                v-bind="$attrs"
                v-if="open || show"
            >
                <slot />
            </div>
        </SlideDown>
    </div>
</template>
