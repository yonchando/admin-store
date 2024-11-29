<script setup lang="ts">
import { FontAwesomeIcon as FaIcon } from "@fortawesome/vue-fontawesome";
import { faCheck, faExclamation, faInfo, faQuestion, faTimes } from "@fortawesome/free-solid-svg-icons";
import Button from "@/Components/Button.vue";
import { computed } from "vue";
import { useAlertStore } from "@/services/helper.service";

const alertStore = useAlertStore();

const icon = computed(() => {
    return {
        success: faCheck,
        info: faInfo,
        warning: faExclamation,
        error: faTimes,
        question: faQuestion,
    }[alertStore.type];
});

const iconClass = computed(() => {
    return {
        success: "text-success border-success",
        info: "text-info border-info",
        warning: "text-warning border-warning",
        error: "text-error border-error",
        question: "text-warning border-warning",
    }[alertStore.type];
});
</script>

<template>
    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div
                v-show="alertStore.show"
                class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-0"
                scroll-region>
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div
                        v-show="alertStore.show"
                        class="fixed inset-0 transform transition-all"
                        @click="alertStore.close()">
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
                        v-show="alertStore.show"
                        class="w-full max-w-md transform overflow-hidden rounded-lg bg-white p-8 shadow-xl transition-all dark:bg-gray-800">
                        <div class="flex flex-col items-center gap-6 text-white">
                            <span
                                :class="[iconClass]"
                                class="inline-flex size-20 items-center justify-center rounded-full border-4">
                                <FaIcon :icon="icon" size="3x"></FaIcon>
                            </span>
                            <div class="flex flex-col gap-2 text-center">
                                <h1 class="text-3xl font-semibold">{{ alertStore.title }}</h1>
                                <p class="text-base font-medium text-gray-400">{{ alertStore.text }}</p>
                            </div>
                            <div class="flex gap-4">
                                <Button @click="alertStore.confirm()" :severity="alertStore.confirmType">
                                    <i class="fa fa-check mr-2"></i>
                                    {{ alertStore.confirmButtonText }}
                                </Button>
                                <Button @click="alertStore.close()" :severity="alertStore.cancelBtn">
                                    <i class="fa fa-times mr-2"></i>
                                    {{ alertStore.cancelButtonText }}
                                </Button>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
