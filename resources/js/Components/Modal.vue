<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref, watch } from "vue";
import { Action } from "@/types/button";

defineOptions({
    inheritAttrs: false,
});

const props = withDefaults(
    defineProps<{
        maxWidth?: "sm" | "md" | "lg" | "xl" | "2xl" | "3xl" | "4xl" | "5xl";
        closeable?: boolean;
        title?: string;
        position?: "center" | "top" | "bottom" | "left-top" | "left-bottom" | "right-top" | "right-bottom";
        actions?: Array<Action>;
    }>(),
    {
        maxWidth: "3xl",
        closeable: true,
        position: "top",
    },
);

const emit = defineEmits(["close"]);

const show = defineModel("show");

watch(show, (newValue) => {
    if (newValue) {
        document.body.style.overflow = "hidden";
    } else {
        document.body.style.overflow = "visible";
    }
});

const close = () => {
    if (props.closeable) {
        emit("close");
    }
};

const closeOnEscape = (e: KeyboardEvent) => {
    if (e.key === "Escape" && show.value) {
        close();
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
    document.body.style.overflow = "visible";
});

const maxWidthClass = computed(() => {
    return {
        sm: "sm:max-w-sm",
        md: "sm:max-w-md",
        lg: "sm:max-w-lg",
        xl: "sm:max-w-xl",
        "2xl": "sm:max-w-2xl",
        "3xl": "sm:max-w-3xl",
        "4xl": "sm:max-w-4xl",
        "5xl": "sm:max-w-5xl",
    }[props.maxWidth];
});

const positionClass = computed(() => {
    return {
        center: "m-auto",
        top: "insert-x-0 top-4 sm:mx-auto",
        bottom: "insert-x-0 bottom-4",
        "left-top": "ml-6",
        "left-bottom": "ml-6 mt-auto",
        "right-top": "ml-auto mr-6",
        "right-bottom": "ml-auto mt-auto mr-6",
    }[props.position];
});
</script>

<template>
    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div
                v-show="show"
                class="fixed inset-0 z-10 flex overflow-y-auto px-4 py-6 sm:px-0"
                v-bind="$attrs"
                scroll-region>
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900" />
                    </div>
                </Transition>

                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        v-show="show"
                        class="h-fit transform rounded-lg bg-white shadow-xl transition-all sm:w-full dark:bg-gray-800"
                        :class="[maxWidthClass, positionClass]">
                        <div
                            class="mb-4 w-full border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-center px-4 py-3">
                                <slot name="title">
                                    <h3 class="text-lg font-semibold leading-5">
                                        {{ title }}
                                    </h3>
                                </slot>

                                <div class="ml-auto flex gap-2">
                                    <template v-if="actions && actions.length">
                                        <template v-for="action in actions">
                                            <component :is="action.component" v-bind="action.props">
                                                {{ action.label }}
                                            </component>
                                        </template>
                                    </template>
                                    <slot name="actions" />
                                    <Button @click="show = false" severity="secondary">Close</Button>
                                </div>
                            </div>
                        </div>
                        <div class="max-h-[85vh] overflow-auto px-4 pb-6">
                            <slot />
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
