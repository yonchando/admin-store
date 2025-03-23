<script setup lang="ts">
import InputLabel from "@/Components/Forms/InputLabel.vue";
import { computed, onMounted, ref, watchEffect } from "vue";
import { Datepicker, DatepickerOptions, initFlowbite } from "flowbite";

const props = withDefaults(
    defineProps<{
        label?: string;
        direction?: "horizontal" | "vertical";
        root?: any;
        required?: boolean;
        type?: "text" | "password" | "number" | "email" | "time";
        maxDate?: string;
        minDate?: string;
        autohide?: boolean;
        buttons?: boolean;
    }>(),
    {
        direction: "vertical",
        required: false,
        type: "text",
        autohide: true,
        buttons: true,
    },
);
const model = defineModel();
const $input = ref();

const directionClass = computed(() => {
    return {
        vertical: "flex gap-2 flex-col",
        horizontal: "flex gap-4 flex-row items-center",
    }[props.direction];
});

const datepicker = ref();
const options: DatepickerOptions = {
    autohide: props.autohide,
    format: "yyyy-mm-dd",
    maxDate: props.maxDate,
    minDate: props.minDate,
    orientation: "bottom",
    buttons: props.buttons,
    autoSelectToday: 1,
};

onMounted(() => {
    datepicker.value = new Datepicker($input.value, options);
});
</script>

<template>
    <div :class="[directionClass]" v-bind="root">
        <slot name="label" v-if="$slots.label || label">
            <InputLabel :required="required" :value="label" :for="$input?.getAttribute('id')" />
        </slot>
        <div class="relative max-w-sm">
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                <svg
                    class="h-4 w-4 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                </svg>
            </div>
            <input ref="$input" type="text" class="form-input ps-10" placeholder="Select date" />
        </div>
    </div>
</template>

<style scoped></style>
