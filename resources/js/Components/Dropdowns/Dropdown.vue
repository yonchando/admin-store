<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from "vue";

const props = withDefaults(
    defineProps<{
        contentWidth?: number | undefined | string;
        contentClasses?: string;
        position?: {
            top?: number;
            left?: number;
        };
    }>(),
    {
        contentClasses: "py-1 bg-white dark:bg-gray-700",
    },
);

function close() {
    return (show.value = false);
}

const closeOnEscape = (e: KeyboardEvent) => {
    if (show.value && e.key === "Escape") {
        close();
    }
};

const show = ref<boolean>(false);

const content = ref<HTMLElement>();
const minWidth = computed(() => {
    return props.contentWidth ?? content.value?.clientWidth;
});
const position = computed(() => {
    const bound = content.value?.getBoundingClientRect();

    let top = bound?.top ?? 0;

    if (bound?.height) {
        top += bound.height;
    }

    if (props.position?.top) {
        top += props.position.top;
    } else {
        top += 6;
    }

    let left = bound?.left ?? 0;
    if (props.position?.left) {
        left += props.position.left;
    }

    return {
        top: top,
        left: left,
    };
});

const contentStyle = computed(() => {
    return {
        "min-width": `${minWidth.value}px`,
        "max-width": `${minWidth.value}px`,
        top: `${position.value.top}px`,
        left: `${position.value.left}px`,
    };
});
onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));
</script>

<template>
    <div class="relative">
        <div class="" @click="show = !show" ref="content">
            <slot name="trigger" :active="show" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="show" class="fixed inset-0 z-40" @click="show = false"></div>

        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95">
            <div
                v-show="show"
                class="fixed z-50 rounded-md bg-slate-50 shadow-lg"
                :class="[contentClasses]"
                :style="contentStyle">
                <slot name="content" :active="show" :close="close" />
            </div>
        </Transition>
    </div>
</template>
