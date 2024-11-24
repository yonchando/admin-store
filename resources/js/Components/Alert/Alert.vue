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
        question: "text-gray-700 border-gray-700",
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
                        class="w-full max-w-sm transform overflow-hidden rounded-lg bg-white p-4 shadow-xl transition-all dark:bg-gray-800">
                        <div class="flex flex-col items-center text-white">
                            <span
                                :class="[iconClass]"
                                class="inline-flex size-20 items-center justify-center rounded-full border-4">
                                <FaIcon :icon="icon" size="4x"></FaIcon>
                            </span>
                            <h1 class="mt-4 text-2xl">{{ alertStore.title }}</h1>
                            <p class="mt-2 text-gray-400">{{ alertStore.text }}</p>

                            <div class="mt-6 flex gap-4">
                                <Button @click="alertStore.confirm()" :severity="alertStore.confirmType">Yes</Button>
                                <Button @click="alertStore.close()" :severity="alertStore.cancelBtn">Close</Button>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
