<script setup lang="ts">
import { ref } from "vue";

const props = withDefaults(
    defineProps<{
        options: Array<any>;
        optionValue?: any;
        optionLabel?: any;
        placeholder?: string;
    }>(),
    {
        optionValue: "id",
        optionLabel: "name",
    },
);

const open = ref(false);
</script>

<template>
    <div class="relative">
        <div @click="open = !open">
            <div class="border">
                {{ placeholder }}
            </div>
        </div>

        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95">
            <div
                v-show="open"
                class="absolute z-50 mt-2 rounded-md shadow-lg"
                style="display: none"
                @click="open = false">
                <div class="rounded-md ring-1 ring-black ring-opacity-5">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped></style>
