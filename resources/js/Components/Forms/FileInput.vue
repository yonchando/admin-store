<script setup>
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const { multiple } = defineProps({
    modelValue: {
        type: Object,
        default: null,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
});

const lang = usePage().props.lang;

let src = ref("/images/placeholders/placeholder.jpg");

const $emit = defineEmits(["update:modelValue"]);

const modelChange = ($event) => {
    if (multiple) {
        $emit("update:modelValue", $event.target.files);
    } else {
        const reader = new FileReader();

        reader.onload = function (result) {
            src.value = result.target.result;
        };

        reader.readAsDataURL($event.target.files[0]);

        $emit("update:modelValue", $event.target.files[0]);
    }
};
</script>
<template>
    <div class="tw-relative">
        <img
            :src="src"
            class="tw-w-full tw-rounded-md tw-shadow"
            alt="place holder image"
        />
        <span
            v-if="src == '/images/placeholders/placeholder.jpg'"
            class="tw-absolute tw-inset-0 tw-flex tw-items-center tw-justify-center tw-rounded-md tw-bg-black/30 tw-text-lg tw-font-medium tw-text-white"
        >
            {{ lang.browse_image }}
        </span>
        <input
            type="file"
            @input="modelChange($event)"
            accept="image/*"
            class="tw-absolute tw-inset-0 tw-flex tw-h-full tw-w-full tw-cursor-pointer tw-items-center tw-justify-center tw-rounded-md tw-bg-red-50 tw-opacity-0"
        />
    </div>
</template>
