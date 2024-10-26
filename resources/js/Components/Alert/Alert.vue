<script setup lang="ts">
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { faCheck, faExclamation, faInfo, faQuestion, faTimes } from "@fortawesome/free-solid-svg-icons";
import Button from "@/Components/Button.vue";
import { computed } from "vue";
import { Action, ButtonActions } from "@/types/button";

const props = withDefaults(
    defineProps<{
        title: string;
        text?: string;
        type: "success" | "info" | "warning" | "error";
        confirmButtonType?: "primary" | "secondary" | "info" | "warning" | "error" | "success";
    }>(),
    {
        type: "success",
    },
);

const show = defineModel("show");

const emit = defineEmits(["close", "confirmed"]);

const icon = computed(() => {
    return {
        success: faCheck,
        info: faInfo,
        warning: faExclamation,
        error: faTimes,
        question: faQuestion,
    }[props.type];
});

const iconClass = computed(() => {
    return {
        success: "text-success border-success",
        info: "text-info border-info",
        warning: "text-warning border-warning",
        error: "text-error border-error",
        question: "text-gray-700 border-gray-700",
    }[props.type];
});

const btnSeverity = computed(() => {
    return {
        success: { confirm: { severity: "success" }, cancel: { severity: "secondary" } },
        info: { confirm: { severity: "info" }, cancel: { severity: "secondary" } },
        warning: { confirm: { severity: "warning" }, cancel: { severity: "secondary" } },
        error: { confirm: { severity: "danger" }, cancel: { severity: "secondary" } },
        question: { confirm: { severity: "info" }, cancel: { severity: "secondary" } },
    }[props.type];
});

function close() {
    show.value = false;
    emit("close");
}
</script>

<template>
    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div
                v-show="show"
                class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-0"
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
                        class="w-full max-w-sm transform overflow-hidden rounded-lg bg-white p-4 shadow-xl transition-all dark:bg-gray-800">
                        <div class="flex flex-col items-center text-white">
                            <span
                                :class="[iconClass]"
                                class="inline-flex size-20 items-center justify-center rounded-full border-4">
                                <FaIcon :icon="icon" size="4x"></FaIcon>
                            </span>
                            <h1 class="mt-4 text-2xl">{{ title }}</h1>
                            <p class="mt-2 text-gray-400">{{ text }}</p>

                            <div class="mt-6 flex gap-4">
                                <Button
                                    @click="emit('confirmed')"
                                    :severity="confirmButtonType ?? (btnSeverity.confirm.severity as any)">
                                    Yes
                                </Button>
                                <Button @click="close" :severity="btnSeverity.cancel.severity as any">Close</Button>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
