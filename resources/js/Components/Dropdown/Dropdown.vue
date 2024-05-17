<script setup>
import { ref } from "vue";
import SlideDown from "@/Components/Transition/SlideDown.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    toggle: {
        type: Boolean,
        default: false,
    }
});

const open = ref(false);
</script>

<template>
    <div>
        <template v-if="$slots.button">
            <button class="w-full pr-6" @click="open = !open">
                <div class="flex justify-between items-center w-full">
                    <slot name="button"/>
                    <i v-if="toggle" class="fa fa-chevron-down"></i>
                </div>
            </button>
        </template>

        <SlideDown>
            <div
                class="relative sm:absolute inset-x-0 flex top-full pt-3 flex-col rounded bg-dark mt-2"
                v-if="open || show"
            >
                <slot />
            </div>
        </SlideDown>
    </div>
</template>
