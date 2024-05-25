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

let src = ref("/assets/images/placeholders/placeholder.jpg");

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
    <div class="relative">
        <img
            :src="src"
            class="w-full rounded-md shadow"
            alt="product feature"
        />
        <span
            v-if="src == '/assets/images/placeholders/placeholder.jpg'"
            class="absolute inset-0 flex items-center justify-center rounded-md bg-black/30 text-lg font-medium text-white"
        >
            {{ lang.browse_image }}
        </span>
        <input
            type="file"
            @input="modelChange($event)"
            accept="image/*"
            class="absolute inset-0 flex h-full w-full cursor-pointer items-center justify-center rounded-md bg-red-50 opacity-0"
        />
    </div>
</template>
